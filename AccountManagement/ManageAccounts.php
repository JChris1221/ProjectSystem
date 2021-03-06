<?php
require_once("../Backend/classes/Account.php");
require_once("../Backend/classes/DBHandler.php");
session_start();
if(!isset($_SESSION["Account"])){
    header("Location: ../login.php");
}

if($_SESSION["Account"]->roleid !== 1){
    header("Location: ../401.php");
}

?>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Manage Accounts</title>
        <link href="../css/styles.css" rel="stylesheet" />
        <link href="../css/bootstrap-sandstone.min.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <?php include("../PartialViews/Navbar.php")?>
        <div id="layoutSidenav">
            <?php include("../PartialViews/SideNav.php");?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Manage Accounts</h1>
                        <!-- <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tables</li>
                        </ol> -->
                       <!--  <div class="card mb-4">
                            <div class="card-body">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net/">official DataTables documentation</a>.</div>
                        </div> -->
                        <div class="card mb-4">
                            <div class="card-header"><i class="fas fa-user mr-1"></i>Accounts</div>
                            <div class="card-body">
                                <div class='mt-2 mb-2'>
                                    <a class = 'btn btn-success' href="AddAccount.php" role = "button">Add Account</a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Username</th>
                                                <th>Role</th>
                                                <th>Edit</th>
                                                <th>Enable/Disable</th>
                                                <th>Reset Password</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Username</th>
                                                <th>Role</th>
                                                <th>Edit</th>
                                                <th>Enable/Disable</th>
                                                <th>Reset Password</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                                
                                                $accounts = DBHandler::GetAccounts($_SESSION["Account"]->id);
                                                if($accounts !== NULL){
                                                    foreach($accounts as $a){
                                                    ?>
                                                        <tr>
                                                            <td><?=$a->firstname?></td>
                                                            <td><?=$a->lastname?></td>
                                                            <td><?=$a->username?></td>
                                                            <td><?=$a->rolename?></td>
                                                            <td>
                                                                <a class = 'btn btn-info btn-block' href = "EditAccount.php?id=<?=$a->id?>">Edit</a>
                                                            </td>
                                                            <?php if($a->disabled){?>
                                                                <td><a class = 'btn btn-warning btn-block' href = "EnableAccount.php?id=<?=$a->id?>">Enable</a></td>
                                                            <?php }else{ ?>
                                                                 <td><a class = 'btn btn-danger btn-block' href = "DisableAccount.php?id=<?=$a->id?>">Disable</a></td>
                                                            <?php } ?>

                                                            <td><a class = 'btn btn-warning btn-block' href = "ResetPassword.php?id=<?=$a->id?>">Reset Password</a></td>
                                                        </form></tr>
                                                    <?php
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
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
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="../js/datatables-demo.js"></script>
    </body>
</html>
