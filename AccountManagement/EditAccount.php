<?php
require_once("../Backend/classes/Account.php");
require_once("../Backend/classes/DBHandler.php");
require_once("../Backend/classes/Role.php");

session_start();
if(!isset($_SESSION["Account"])){
    header("Location: ../login.php");
}
if(!isset($_GET["id"])){
    header("Location: ../404.php");
}

if($_SESSION["Account"]->roleid !== 1){
    header("Location: ../401.php");
}

if($_SESSION['Account']->id == $_GET['id']){
    header("Location: ../401.php");
}

$current_account = DBHandler::GetAccountInfo($_GET['id']);
if($current_account === NULL){
    header("Location: ../404.php");
}



?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Add Account</title>
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
                        <!-- <h1 class="mt-4">Modify Accounts</h1> -->
                        <!-- <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tables</li>
                        </ol> -->
                       <!--  <div class="card mb-4">
                            <div class="card-body">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net/">official DataTables documentation</a>.</div>
                        </div> -->
                        <div class="card my-5 mx-5 shadow border-info">
                            <div class="card-header bg-info"><i class="fas fa-user-edit"></i> Edit Account</div>
                            <div class="card-body">
                                <?php
                                    if(isset($_SESSION["EditUserError"])){ 
                                        ?>
                                        <span class = "text-danger" ><?php echo $_SESSION["EditUserError"]; ?></span>
                                        <?php
                                        unset($_SESSION["EditUserError"]);
                                    }
                                    if(isset($_SESSION["CurrentChanges"])){
                                        $current_account = $_SESSION["CurrentChanges"];
                                        unset($_SESSION["CurrentChanges"]);
                                    }
                                ?>
                                <div>
                                    <form action ="../Backend/AccountController/update_account_to_db.php" method="POST">
                                        <input type = "hidden" name = 'Id' value = <?=$_GET['id']?>>
                                        <?php
                                            if(isset($_SESSION["FormAccount"]))
                                                unset($_SESSION["FormAccount"]);
                                        ?>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="small mb-1" for="inputFirstName">First Name</label>
                                                    <input class="form-control py-4" id="inputFirstName" type="text" placeholder="Enter first name" name = "Firstname"/ value = "<?=$current_account->firstname?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group"><label class="small mb-1" for="inputLastName">Last Name</label>
                                                    <input class="form-control py-4" id="inputLastName" name="Lastname" type="text" placeholder="Enter last name" value = "<?=$current_account->lastname?>"/>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="small mb-1" for="inputUsername">Username</label><input class="form-control py-4" id="inputUsername" type="text" aria-describedby="emailHelp" placeholder="Enter Username" name='Username' value = "<?=$current_account->username?>"/></div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputUsername">Select Role</label>
                                            <select class = "form-control" name = "Role">
                                                <?php 
                                                    $dbh = new DBHandler();
                                                    $roles = $dbh->GetRoles();
                                                    foreach($roles as $r){
                                                        $selected = ($r->id == $current_account->roleid)?"selected":"";
                                                        ?>
                                                        <option value = "<?=$r->id?>" <?=$selected?>><?=$r->name?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group mt-4 mb-0">
                                            <button class="btn btn-success" type = "submit">Save Changes</button>
                                            <a class="btn btn-danger" role="button" href="ManageAccounts.php">Cancel</a>
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
    </body>
</html