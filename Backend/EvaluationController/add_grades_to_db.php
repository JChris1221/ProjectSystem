<?php
require_once("../classes/DBHandler.php");

$groupid = $_POST['groupid'];
$id = $_POST['id'];
$comment = $_POST['Comment'];

if(!in_array("", $_POST['Score']) && isset($_POST['groupid']) && isset($_POST['id'])){
	$scores = $_POST['Score'];

	if(DBHandler::AddGrades($id,$groupid, $scores, $comment)){
		header("Location: ../../GroupEvaluation/GroupEvaluation.php");
	}
	else{
		die("Error Adding Grades");
	}
}
else{
	echo "Empty Fields";
}


?>