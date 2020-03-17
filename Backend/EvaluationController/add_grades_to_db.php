<?php
require_once("../classes/DBHandler.php");
session_start();

$groupid = $_POST['groupid'];
$id = $_POST['id'];
$comment = $_POST['Comment'];

if(!in_array("", $_POST['Score']) && isset($_POST['groupid']) && isset($_POST['id'])){
	$scores = $_POST['Score'];

	if(HasInvalidGrades($scores))
	{
		$_SESSION["AddGradeError"] = "Invalid Input (Only inputs 1-4 are accepted)";
		header("Location: ../../GroupEvaluation/EvaluateGroup.php?id=".$groupid);
		exit();
	}

	if(DBHandler::AddGrades($id,$groupid, $scores, $comment)){
		header("Location: ../../GroupEvaluation/GroupEvaluation.php");
	}
	else{
		die("Error Adding Grades");
	}
}
else{
	$_SESSION["AddGradeError"] = "Please Fill Empty Fields";
	header("Location: ../../GroupEvaluation/EvaluateGroup.php?id=".$groupid);
	exit();
}

function HasInvalidGrades($grades){
	foreach($grades as $g){
		if($g > 4 || $g < 1 || !is_numeric($g))
			return true;
	}
	return false;
}

?>