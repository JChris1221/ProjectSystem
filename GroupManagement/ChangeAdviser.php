<?php
require_once("../Backend/classes/DBHandler.php");
require_once("../Backend/classes/Group.php");

session_start();
if(!isset($_SESSION["Account"])){
    header("Location: ../404.php");
}

if($_SESSION["Account"]->roleid !== 1){
    header("Location: ../401.php");
}

$group = DBHandler::GetGroup($_GET['id']);
$adviser = DBHandler::GetGroupFaculty($_GET['id'], 1);
$faculty = DBHandler::GetAccountsWithRole(2);

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
                            <div class="card-header bg-info"><i class="fas fa-users"></i> Change Adviser (<?=$group->title?>)</div>
                            <div class="card-body">
                                <?php
                                    if(isset($_SESSION["AddUserError"])){ 
                                        ?>
                                        <span class = "text-danger" ><?php echo $_SESSION["AddUserError"]; ?></span>
                                        <?php
                                        unset($_SESSION["AddUserError"]);
                                    }
                                ?>
                                <div>
                                    <form action ="../Backend/update_adviser_to_db.php" method="POST">
                                        <?php
                                            if(isset($_SESSION["FormAccount"]))
                                                unset($_SESSION["FormAccount"]);
                                        ?>
                                        <input type = "hidden" name = "id" value = "<?=$_GET['id']?>">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputUsername">Select New Adviser</label>
                                            <select class = "form-control" name = "AdviserId">
                                                <?php
                                                    foreach($faculty as $a){
                                                        $selected = ($adviser[0]->id === $a->id)?"selected":"";
                                                        ?>
                                                        <option value="<?=$a->id?>" <?=$selected?>>
                                                            <?=$a->lastname.", ".$a->firstname?>
                                                        </option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group mt-4 mb-0">
                                            <button type = 'submit' class = 'btn btn-info'>Change Adviser</button>
                                            <a class="btn btn-secondary" role="button" href="GroupDetails.php?id=<?=$group->id?>">Cancel</a>
                                        </div>
                                        <!--/MEMBERS-->
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