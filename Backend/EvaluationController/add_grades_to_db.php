<?php
require_once("../classes/DBHandler.php");

$groupid = $_POST['groupid'];
$id = $_POST['id'];

if(!in_array("", $_POST['Score']) || isset($_POST['Group_Id']) || isset($_POST['id'])){
	$scores = $_POST['Score'];

	if(DBHandler::AddGrades($id,$groupid, $scores)){
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