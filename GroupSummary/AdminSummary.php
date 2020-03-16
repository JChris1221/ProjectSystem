<?php
require_once("../Backend/classes/Group.php");
require_once("../Backend/classes/DBHandler.php");
require_once("../Backend/classes/Account.php");

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
        <title>Group Summary</title>
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
                        <h1 class="mt-4">Group Summary</h1>
                        <!-- <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tables</li>
                        </ol> -->
                       <!--  <div class="card mb-4">
                            <div class="card-body">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net/">official DataTables documentation</a>.</div>
                        </div> -->
                        <div class="card mb-4">
                            <div class="card-header"><i class="fas fa-user-friends"></i> Groups</div>
                            <div class="card-body">
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Theisis Title</th>
                                                <th>Section</th>
                                                <th>Professor</th>
                                                <th>Adviser</th>
                                                <th>View Summary</th>
                                                
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Theisis Title</th>
                                                <th>Section</th>
                                                <th>Professor</th>
                                                <th>Adviser</th>
                                                <th>View Summary</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                                $groups = DBHandler::GetGroups();

                                                if($groups !== NULL){
                                                    foreach($groups as $g){
                                                        $evaluated = (DBHandler::IsEvaluated($_SESSION['Account']->id, $g->id));
                                                        $adviser = DBHandler::GetGroupFaculty($g->id, 1);
                                                        $professor = DBHandler::GetGroupFaculty($g->id, 4);
                                                    ?>
                                                        <tr>
                                                            <td><?=$g->title?></td>
                                                            <td><?=$g->section?></td>
                                                            <td><?=$professor[0]->lastname.", ".$professor[0]->firstname?></td>
                                                            <td><?=$adviser[0]->lastname.", ".$adviser[0]->firstname?></td>
                                                            <td>
                                                               <a class='btn btn-secondary btn-block text-light' href="ViewGroupSummary.php?id=<?=$g->id?>">
                                                                    View More
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                }
                                                else{ ?>
                                                    <tr><th colspan="5" class = "text-center">No groups on database</th></tr>
                                                <?php } ?>

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
        <script>
            $(document).ready(function(){
              $('[data-toggle="tooltip"]').tooltip();   
            });
    </script>
    </body>
</html>
