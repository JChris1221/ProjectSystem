<?php
require_once("../Backend/classes/Account.php");
require_once("../Backend/classes/DBHandler.php");
require_once("../Backend/classes/Group.php");

session_start();
if(!isset($_SESSION["Account"])){
    header("Location: ../404.php");
}

if($_SESSION["Account"]->roleid !== 1){
    header("Location: ../401.php");
}

if(!isset($_GET['id'])){
	header("Location: ../404.php");	
}

$group = DBHandler::GetGroup($_GET['id']);
$panelchair = DBHandler::GetGroupFaculty($_GET['id'], 2);
$panels = DBHandler::GetGroupFaculty($_GET['id'], 3);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Add Group</title>
        <link href="../css/styles.css" rel="stylesheet" />
        <link href="../css/bootstrap-sandstone.min.css" rel="stylesheet" />

        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed"> 
         <?php include("../PartialViews/Navbar.php")?>
        <div id="layoutSidenav">
            <?php include("../PartialViews/SideNav.php");?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Manage Groups</h1>
                        <!-- <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tables</li>
                        </ol> -->
                       <!--  <div class="card mb-4">
                            <div class="card-body">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net/">official DataTables documentation</a>.</div>
                        </div> -->
                         <div class="card my-4 mx-5 shadow border-info">
                            <div class="card-header bg-info"><i class="fas fa-users"></i> Edit Panels (<?=htmlspecialchars($group->title)?>)</div>
                            <div class="card-body">
                                 <?php
                                    if(isset($_SESSION["ChangePanelsError"])){ 
                                        ?>
                                        <span class = "text-danger" ><?php echo $_SESSION["ChangePanelsError"]; ?></span>
                                        <?php
                                        unset($_SESSION["ChangePanelsError"]);
                                    }
                                ?>
                                <div>
                                    <form action ="../Backend/GroupController/update_panels_to_db.php" method="POST">

										<!--PANELIST-->
                                        <?php
                                            $faculty = DBHandler::GetAccountsWithRole(2); //get all faculty accounts
                                        ?>
                                        <input type="hidden" name="id" value="<?=$_GET['id']?>">
                                        <div class="form-row mt-4 border-bottom">Panelist</div>
                                       	<div class="border-top border-bottom border-primary">
                                             <?php 
                                                $isEval = DBHandler::IsEvaluated($panelchair[0]->id, $_GET['id']);
                                                $disable = ($isEval)?"disabled":"";

                                             ?>
                                       		 <div class="form-group"><label class="small mb-1" for="inputLastName">Panelist 1 (Panel Chair):</label>
                                             <?php if($isEval) {?>
                                                    <span class='text-danger'>
                                                        <i class="fas fa-info-circle" data-toggle="tooltip" title="This panelist has already evaluated the group"></i>
                                                    </span>
                                                    <input type = "hidden" name = "PanelChairId" value = "<?=$panelchair[0]->id?>">
                                             <?php }?>
                                        	 <select class = "form-control" name = "PanelChairId" <?=$disable?>>
                                        	 	<option disabled selected>Choose Panelist</option>
                                                <?php
                                                    foreach($faculty as $p){
                                                    	$selected = ($p->id == $panelchair[0]->id)?"selected":"";
                                                        ?>
                                                        <option value="<?=$p->id?>" <?=$selected?>><?=$p->lastname.", ".$p->firstname?></option>
                                                        <?php
                                                    }
                                                ?>
                                             </select>
                                         </div>

                                            <?php 
                                                $isEval = DBHandler::IsEvaluated($panels[0]->id, $_GET['id']);
                                                $disable = ($isEval)?"disabled":""; 
                                            ?>

	                                        <div class="form-group"><label class="small mb-1" for="inputLastName">Panelist 2:</label>
                                            <?php if($isEval) {?>
                                                    <span class='text-danger'>
                                                        <i class="fas fa-info-circle" data-toggle="tooltip" title="This panelist has already evaluated the group"></i>
                                                    </span>
                                                    <input type = "hidden" name = "PanelId[]" value = "<?=$panels[0]->id?>">
                                            <?php }?>    
	                                        <select class = "form-control" name = "PanelId[]" <?=$disable?>>
	                                        	<option disabled selected>Choose Panelist</option>
                                                <?php

                                                    foreach($faculty as $p){
                                                    	$selected = ($p->id == $panels[0]->id)?"selected":"";
                                                        ?>
                                                        <option value="<?=$p->id?>" <?=$selected?>><?=$p->lastname.", ".$p->firstname?></option>
                                                        <?php
                                                    }
                                                ?>
	                                        </select>
                                        </div>

                                            <?php 
                                                $isEval = DBHandler::IsEvaluated($panels[1]->id, $_GET['id']);
                                                $disable = ($isEval)?"disabled":""; 
                                            ?>
	                                        <div class="form-group"><label class="small mb-1" for="inputLastName">Panelist 3:</label>
                                            <?php if($isEval) {?>
                                                    <span class='text-danger'>
                                                        <i class="fas fa-info-circle" data-toggle="tooltip" title="This panelist has already evaluated the group"></i>
                                                    </span>
                                                    <input type = "hidden" name = "PanelId[]" value = "<?=$panels[1]->id?>">
                                            <?php }?>
	                                        <select class = "form-control" name = "PanelId[]" <?=$disable?>>
	                                        	<option disabled selected >Choose Panelist</option>
                                                <?php
                                                    foreach($faculty as $p){
                                                    	$selected = ($p->id == $panels[1]->id)?"selected":"";
                                                        ?>
                                                        <option value="<?=$p->id?>" <?=$selected?>><?=$p->lastname.", ".$p->firstname?></option>
                                                        <?php
                                                    }
                                                ?>
	                                        </select>
                                            </div>
                                       	</div>

                                        <!--/PANELIST-->
                                        <div class="form-group mt-4 mb-0">
                                            <button class="btn btn-info" type = "submit">Save Changes</button>
                                            <a class="btn btn-danger" role="button" href="ManageGroups.php">Cancel</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <?php include("../PartialViews/Footer.php"); ?>
            </div>
        </div>
       
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="../js/AddGroup.js"></script>
        <script>
            $(document).ready(function(){
              $('[data-toggle="tooltip"]').tooltip();   
            });
    </script>
    </body>
</html>

?>
?>