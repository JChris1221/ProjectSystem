<?php
require_once("../Backend/classes/Account.php");
require_once("../Backend/classes/DBHandler.php");
require_once("../Backend/classes/Role.php");

session_start();
if(!isset($_SESSION["Account"])){
    header("Location: ../404.php");
}

if($_SESSION["Account"]->roleid !== 1){
    header("Location: ../401.php");
}

$faculty = DBHandler::GetAccountsWithRole(2); //get all faculty accounts

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
                         <div class="card my-4 mx-5 shadow border-success">
                            <div class="card-header bg-success"><i class="fas fa-users"></i> Add Group</div>
                            <div class="card-body">
                                <?php
                                    if(isset($_SESSION["AddGroupError"])){ 
                                        ?>
                                        <span class = "text-danger" ><?php echo $_SESSION["AddGroupError"]; ?></span>
                                        <?php
                                        unset($_SESSION["AddGroupError"]);
                                    }
                                ?>
                                <div>
                                    <form action ="../Backend/GroupController/add_group_to_db.php" method="POST">
                                        <?php
                                            if(isset($_SESSION["FormAccount"]))
                                                unset($_SESSION["FormAccount"]);
                                        ?>
                                        <!--TITLE-->
                                        <div class="form-group"><label class="small mb-1" for="inputTitle">Thesis Title</label><input class="form-control py-4" id="inputTitle" type="text" aria-describedby="emailHelp" placeholder="Enter Thesis Title" name='Title'/></div>
                                        <!--/TITLE-->
                                        <div class = 'form-row align-items-center'>
                                            <div class = 'col-md-6'>
                                                <div class="form-group">
                                                    <label class="small mb-1" for="inputUsername">Select Professor</label>
                                                    <select class = "form-control" name = "ProfessorId">
                                                        <option disabled selected >Choose Professor</option>
                                                        <?php
                                                            foreach($faculty as $adviser){
                                                                ?>
                                                                <option value="<?=$adviser->id?>">
                                                                    <?=$adviser->lastname.", ".$adviser->firstname?>
                                                                </option>
                                                                <?php
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class = 'col-md-3'>
                                                <div class="form-group"><label class="small mb-1" for="inputSection">Section</label><input class="form-control py-4" id="inputSection" type="text" placeholder="Enter Section" name='Section'/></div>
                                            </div>
                                        </div>
                                        <!--MEMBERS-->
                                        <div class="form-row mt-4">Members</div>
                                        <div class="border-top border-bottom border-primary" id="memberContainer">
                                            <div class = 'form-row align-items-center'>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputFirstName">First Name</label>
                                                        <input class="form-control py-4" id="inputFirstName" type="text" placeholder="Enter first name" name = "Firstname[]" value = ""/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputLastName">Last Name</label>
                                                        <input class="form-control py-4" id="inputLastName" name="Lastname[]" type="text" placeholder="Enter last name" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group pt-3">
                                                        <button type="button" class="btn btn-success" id = "addStudent">Add Student</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/MEMBERS-->

										<!--PANELIST-->
                                        
                                        <div class="form-row mt-4 border-bottom">Panelist</div>
                                       	<div class="border-top border-bottom border-primary">
                                       		 <div class="form-group"><label class="small mb-1" for="inputLastName">Panelist 1 (Panel Chair):</label>
                                        	 <select class = "form-control" name = "PanelChairId">
                                        	 	<option disabled selected>Choose Panelist</option>
                                                <?php
                                                    foreach($faculty as $panel){
                                                        ?>
                                                        <option value="<?=$panel->id?>"><?=$panel->lastname.", ".$panel->firstname?></option>
                                                        <?php
                                                    }
                                                ?>
                                             </select></div>

	                                        <div class="form-group"><label class="small mb-1" for="inputLastName">Panelist 2:</label>
	                                        <select class = "form-control" name = "PanelId[]">
	                                        	<option disabled selected>Choose Panelist</option>
                                                <?php
                                                    foreach($faculty as $panel){
                                                        ?>
                                                        <option value="<?=$panel->id?>"><?=$panel->lastname.", ".$panel->firstname?></option>
                                                        <?php
                                                    }
                                                ?>
	                                        </select></div>

	                                        <div class="form-group"><label class="small mb-1" for="inputLastName">Panelist 3:</label>
	                                        <select class = "form-control" name = "PanelId[]">
	                                        	<option disabled selected >Choose Panelist</option>
                                                <?php
                                                    foreach($faculty as $panel){
                                                        ?>
                                                        <option value="<?=$panel->id?>"><?=$panel->lastname.", ".$panel->firstname?></option>
                                                        <?php
                                                    }
                                                ?>
	                                        </select></div>
                                       	</div>

                                        <!--/PANELIST-->
                                        <!--ADVISER-->
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputUsername">Select Adviser</label>
                                            <select class = "form-control" name = "AdviserId">
                                                <option disabled selected >Choose Adviser</option>
                                                <?php
                                                    foreach($faculty as $adviser){
                                                        ?>
                                                        <option value="<?=$adviser->id?>">
                                                            <?=$adviser->lastname.", ".$adviser->firstname?>
                                                        </option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group mt-4 mb-0">
                                            <button class="btn btn-success" type = "submit">Add Group</button>
                                            <a class="btn btn-danger" role="button" href="ManageGroups.php">Cancel</a>
                                        </div>
                                        <!--/ADVISER-->
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
    </body>
</html>

?>