<?php
require_once("../Backend/classes/Account.php");
require_once("../Backend/classes/DBHandler.php");
require_once("../Backend/classes/Group.php");
require_once("../Backend/classes/Student.php");

session_start();
if(!isset($_SESSION["Account"])){
    header("Location: ../404.php");
}

if($_SESSION["Account"]->roleid !== 1){
    header("Location: ../401.php");
}

$group = DBHandler::GetGroup($_GET['id']); // get group details
$panelChair = DBHandler::GetGroupFaculty($_GET['id'], 2);
$panels = DBHandler::GetGroupFaculty($_GET['id'], 3); // Get Panelist
$students = DBHandler::GetGroupMembers($_GET['id']);
$adviser = DBHandler::GetGroupFaculty($_GET['id'], 1);// Get Adviser

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Group Details</title>
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
                         <div class="card my-4 mx-5 shadow border-secondary">
                            <div class="card-header bg-secondary"><i class="fas fa-users"></i> Group Details</div>
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
                                    <form action ="../Backend/add_group_to_db.php" method="POST">

                                        <!--TITLE-->
                                        <div class="form-group"><label class="small mb-1">Theisis Title</label><input class="form-control py-4" type="text" value = "<?=htmlspecialchars($group->title)?>" disabled/></div>
                                        <!--/TITLE-->

                                        <!--MEMBERS-->
                                        <div class="form-row mt-4">Members</div>
                                        <div class="border-top border-bottom border-primary" id="memberContainer">
                                            <?php foreach($students as $s){ ?>
                                                <div class = 'form-row align-items-center'>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="small mb-1" for="inputFirstName">First Name</label>
                                                            <input class="form-control py-4" id="inputFirstName" type="text" value = "<?=htmlspecialchars($s->firstname)?>" disabled />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="small mb-1" for="inputLastName">Last Name</label>
                                                            <input class="form-control py-4" id="inputLastName" type="text" value="<?=htmlspecialchars($s->lastname)?>" disabled />
                                                        </div>
                                                    </div>
                                                    <div class = "col-md-3">                                                        
                                                            <a class="btn btn-secondary" href="EditMember.php?id=<?=$s->id?>">Edit Member</a>
                                                            <a class="btn btn-danger" href="DeleteMember.php?id=<?=$s->id?>">Remove Member</a>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class = "form-row py-3 pl-1">
                                                <a href = "AddMembers.php?groupid=<?=$_GET['id']?>" class = 'btn btn-success'>Add Members</a>
                                            </div>
                                        </div>
                                        <!--/MEMBERS-->

										<!--PANELIST-->
                                        <?php
                                            
                                        ?>
                                        <div class="form-row mt-4 border-bottom">Panelists</div>
                                       	<div class="border-top border-bottom border-primary">
                                            
                                            <div class="form-group pt-3">
                                                <label class = 'small mb-1'>Panel Chair</label>
                                                <input class="form-control py-4" id="inputFirstName" type="text" placeholder="Enter first name" value = "<?= $panelChair[0]->lastname.', '.$panelChair[0]->firstname?>" disabled />
                                            </div>
                                            
                                       		<?php foreach ($panels as $p){ ?>
                                                <div class="form-group pt-3">
                                                    <input class="form-control py-4" id="inputFirstName" type="text" placeholder="Enter first name" value = "<?= $p->lastname.', '.$p->firstname?>" disabled />
                                                </div>
                                            <?php } ?>
                                            <div class = 'form-row py-3 pl-1'>
                                                <a href = "ChangePanels.php?groupid=<?=$_GET['id']?>" class = "btn btn-info">Change Panelists</a>
                                            </div>
                                       	</div>

                                        <!--/PANELIST-->
                                        <!--ADVISER-->
                                        <div class="form-group">
                                            <div class = 'form-row align-items-center'>
                                                <div class = 'col-md-6'>
                                                    <label class="small mb-1" for="inputUsername">Adviser</label>
                                                    <input class="form-control py-4" id="inputFirstName" type="text" placeholder="Enter first name" value = "<?=$adviser[0]->lastname . ', '.$adviser[0]->firstname?>" disabled />
                                                </div>
                                                <div class = 'col-md-2 pt-3'>
                                                    <a class = "btn btn-secondary btn-info" href = "ChangeAdviser.php?id=<?=$group->$_GET['id']?>">Change Adviser</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mt-4 mb-0">
                                            <a class="btn btn-secondary" role="button" href="ManageGroups.php">Back to group list</a>
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
    </body>
</html>

?>