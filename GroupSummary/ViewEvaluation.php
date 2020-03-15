<?php
require_once("../Backend/classes/Group.php");
require_once("../Backend/classes/DBHandler.php");
require_once("../Backend/classes/Account.php");
require_once("../Backend/classes/Criterion.php");
require_once("../Backend/classes/Evaluation.php");

session_start();
if(!isset($_SESSION["Account"])){
    header("Location: ../login.php");
}

if($_SESSION["Account"]->roleid !== 2){
    header("Location: ../401.php");
}

$groupid = $_GET['groupid'];
$panelid = $_GET['panelid'];
$group = DBHandler::GetGroup($groupid);
$students = DBHandler::GetGroupMembers($groupid);
$criteria = DBHandler::GetCriteria();
$eval = DBHandler::GetEvaluation($panelid, $groupid);
?>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Manage Groups</title>
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
                        <h1 class="mt-4"><i class="fas fa-chart-bar"></i> Evaluate Group</h1>
                        <!-- <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tables</li>
                        </ol> -->
                       <!--  <div class="card mb-4">
                            <div class="card-body">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net/">official DataTables documentation</a>.</div>
                        </div> -->
                        <div class="card mb-4">
                            <div class="card-header bg-info">
                               <div class = "container">
                                   <div class = "row">
                                       <div class = "col-sm text-center lead font-weight-bold"><?=$group->title?></div>
                                   </div>
                                   <div class = "row">
                                       <?php foreach($students as $member){ ?>
                                            <div class = "col-sm"><?=$member->firstname." ".$member->lastname?></div>
                                        <?php } ?>
                                   </div>
                               </div>
                            </div>
                            <div class="card-body">
                                
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered" id= "dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr align="center">
                                                <th>Criteria</th>
                                                <th>Beginner<br>1</th>
                                                <th>Acceptable<br>2</th>
                                                <th>Proficient<br>3</th>
                                                <th>Exemplary<br>4</th>
                                                <th>Score</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <form id ="EvaluationForm" action="../Backend/EvaluationController/print_evaluation.php" method="POST">
                                            <input type ="hidden" value = "<?=$_GET['groupid']?>" name="groupid">
                                            <input type ="hidden" value = "<?=$_GET['panelid']?>" name="panelid">
                                            <!--DOCUMENTS-->
                                            <tr align="center" class='table-primary'><th colspan="6">Document</th></tr>
                                            <?php for($x = 0; $x < 3; $x++){ ?>
                                                <tr>
                                                    <th class='align-middle text-center'><?=$criteria[$x]->title?></th>
                                                    <td><?=$criteria[$x]->descriptions[0]?></td>
                                                    <td><?=$criteria[$x]->descriptions[1]?></td>
                                                    <td><?=$criteria[$x]->descriptions[2]?></td>
                                                    <td><?=$criteria[$x]->descriptions[3]?></td>
                                                    <td class='align-middle'>
                                                        <input type="text" value="<?=$eval->grades[$x]?>" class = 'form-control text-center' name = "Score[]" disabled>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            <!--/DOCUMENTS-->

                                            <!--PRESENTATION-->
                                            <tr align="center" class='table-primary'><th colspan="6">Presentation</th></tr>
                                            <?php for($x = 3; $x < 5; $x++){ ?>
                                                <tr>
                                                    
                                                    <th class='align-middle text-center'><?=$criteria[$x]->title?></th>
                                                    <td><?=$criteria[$x]->descriptions[0]?></td>
                                                    <td><?=$criteria[$x]->descriptions[1]?></td>
                                                    <td><?=$criteria[$x]->descriptions[2]?></td>
                                                    <td><?=$criteria[$x]->descriptions[3]?></td>
                                                    <td class='align-middle'>
                                                        <input type="text" value="<?=$eval->grades[$x]?>" class = 'form-control text-center' name = "Score[]" disabled>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            <!--/PRESENTATION-->

                                            <!--INSTRUCTIONAL CONTENT-->
                                            <tr align="center" class='table-primary'><th colspan="6">Software</th></tr>
                                            <?php for($x = 5; $x < 10; $x++){ ?>
                                                <tr>
                                                    <?php if($x == 5){?>
                                                        <th class='align-middle text-center' rowspan ="5">Instructional Content</th>
                                                    <?php }?>
                                                    <td><?=$criteria[$x]->descriptions[0]?></td>
                                                    <td><?=$criteria[$x]->descriptions[1]?></td>
                                                    <td><?=$criteria[$x]->descriptions[2]?></td>
                                                    <td><?=$criteria[$x]->descriptions[3]?></td>
                                                    <td class='align-middle'>
                                                        <input type="text" value="<?=$eval->grades[$x]?>" class = 'form-control text-center' name = "Score[]" disabled>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            <!--/INSTRUCTIONAL CONTENT-->

                                            <!--LAYOUT-->
                                            <?php for($x = 10; $x < 14; $x++){ ?>
                                                <tr>
                                                    <?php if($x == 10){?>
                                                        <th class='align-middle text-center' rowspan ="4">Layout</th>
                                                    <?php }?>
                                                    <td><?=$criteria[$x]->descriptions[0]?></td>
                                                    <td><?=$criteria[$x]->descriptions[1]?></td>
                                                    <td><?=$criteria[$x]->descriptions[2]?></td>
                                                    <td><?=$criteria[$x]->descriptions[3]?></td>
                                                    <td class='align-middle'>
                                                        <input type="text" value="<?=$eval->grades[$x]?>" class = 'form-control text-center' name = "Score[]" disabled>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            <!--/LAYOUT-->
                                            <tr>
                                                <th class='align-middle text-center'>Complete</th>
                                                <td><?=$criteria[14]->descriptions[0]?></td>
                                                <td><?=$criteria[14]->descriptions[1]?></td>
                                                <td><?=$criteria[14]->descriptions[2]?></td>
                                                <td><?=$criteria[14]->descriptions[3]?></td>
                                                <td class='align-middle'>
                                                    <input type="text" value="<?=$eval->grades[$x]?>" class = 'form-control text-center' name = "Score[]" disabled>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th colspan="6" class ='table-primary text-center'>Other Comments/Observation</th>
                                            </tr>
                                            <tr>
                                                <th colspan="6">
                                                    <?php
                                                        $comment = (empty($eval->comment))?"No comments":$eval->comment;
                                                    ?>
                                                    <textarea name="Comment" class ="form-control" disabled><?=$comment?></textarea>
                                                </th>
                                            </tr>

                                            <tr><th colspan="6" class = 'text-center'>
                                                <button class = 'btn btn-block btn-danger' type="submit"><i class="fas fa-print"></i> Print Evaluation</button></th></tr>
                                        </form>
                                        
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
        <script src="../js/EvaluateGroup.js"></script>
    </body>
</html>
