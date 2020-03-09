<?php
require_once("Backend/classes/Account.php");
require_once("Backend/classes/DBHandler.php");

session_start();
if(!isset($_SESSION["Account"])){
    header("Location: login.php");
}

?>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/bootstrap-sandstone.min.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <?php include("PartialViews/NavBar.php");?>
        <div id="layoutSidenav">
            <?php include("PartialViews/SideNav.php");?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Welcome, <?php echo $_SESSION['Account']->firstname;?></h1>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header"><i class="fas fa-table mr-1"></i>Schedules</div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header"><i class="fas fa-user-friends mr-1"></i>Groups</div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                        </div>
                        <?php
                            //IF AcCOUNT IS ADMIN PRINT ACCOUNT TABLE
                            if($_SESSION['Account']->roleid == 1){
                        ?>
                                <div class="card mb-4">
                                    <div class="card-header"><i class="fas fa-user mr-1"></i>Accounts</div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>First Name</th>
                                                        <th>Last Name</th>
                                                        <th>Username</th>
                                                        <th>Role</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <th>First Name</th>
                                                        <th>Last Name</th>
                                                        <th>Username</th>
                                                        <th>Role</th>
                                                </tfoot>
                                                <tbody>
                                                    <?php
                                                        $accounts = DBHandler::GetAccounts($_SESSION["Account"]->id);
                                                        if($accounts === NULL){
                                                            echo "<tr><td colspan = '4'>No accounts yet.</td></tr>";
                                                        }
                                                        else
                                                        {
                                                            foreach ($accounts as $a) {
                                                                echo "<tr>";
                                                                ?>
                                                                    <td><?=$a->firstname?></td>
                                                                    <td><?=$a->lastname?></td>
                                                                    <td><?=$a->username?></td>
                                                                    <td><?=$a->rolename?></td>
                                                                <?php
                                                                echo "</tr>";
                                                            }
                                                        }

                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                        <?php }//END IF ?>
                    </div>
                </main>
                <?php include("PartialViews/Footer.php"); ?>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-demo.js"></script>
    </body>
</html>
