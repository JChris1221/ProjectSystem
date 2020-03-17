<?php
require_once("../Backend/classes/Account.php");
require_once("../Backend/classes/DBHandler.php");
require_once("../Backend/classes/Role.php");

session_start();
if(!isset($_SESSION["Account"])){
    header("Location: ../login.php");
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
                        <div class="card my-4 mx-5 shadow border-warning">
                            <div class="card-header bg-warning"><i class="fas fa-cog"></i> Change password</div>
                            <div class="card-body">
                                <?php
                                    if(isset($_SESSION["ChangePassError"])){ 
                                        ?>
                                        <span class = "text-danger" ><?php echo $_SESSION["ChangePassError"]; ?></span>
                                        <?php
                                        unset($_SESSION["ChangePassError"]);
                                    }
                                ?>
                                <div>
                                    <form action ="../Backend/AccountController/change_pass_from_db.php" method="POST">
                                        <input type ="hidden" value="<?=$_SESSION['Account']->id?>" name = "id">
                                        <div class="form-group"><label class="small mb-1" for="inputOPass">Old Password:</label><input class="form-control py-4" id="inputOPass" type="password" placeholder="Enter Old Password" name='OPass'/></div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group"><label class="small mb-1" for="inputPassword">Password</label><input class="form-control py-4" id="inputPassword" type="password" placeholder="Enter password" name = 'Password'/></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group"><label class="small mb-1" for="inputConfirmPassword">Confirm Password</label><input class="form-control py-4" id="inputConfirmPassword" type="password" placeholder="Confirm password" name = 'CPass'/></div>
                                            </div>
                                        </div>

                                        <div class="form-group mt-4 mb-0">
                                            <button class="btn btn-warning" type = "submit">Change Password</button>
                                            <a class="btn btn-danger" role="button" href="../index.php">Back to Home</a>

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
</html>
