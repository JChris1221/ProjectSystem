<?php
session_start();

require_once("../classes/DBHandler.php");
require_once("../classes/Student.php");
require_once("../classes/Account.php");




//Check if panelists have same ids;
if(in_array("", $_POST["Firstname"]) || in_array("", $_POST["Lastname"]) || empty($_POST["Title"]) || empty($_POST["Section"])){
	$_SESSION["AddGroupError"]	= "Please Fill Empty Fields";
	header("Location: ../../GroupManagement/AddGroup.php");
}
else if(!isset($_POST["ProfessorId"])){
	$_SESSION["AddGroupError"]	= "Please Fill Empty Fields";
	header("Location: ../../GroupManagement/AddGroup.php");
}
else if(!isset($_POST["PanelChairId"])){
	$_SESSION["AddGroupError"]	= "Please Fill Empty Fields";
	header("Location: ../../GroupManagement/AddGroup.php");
}
else if(!isset($_POST["PanelId"])){
	$_SESSION["AddGroupError"]	= "Please Fill Empty Fields";
	header("Location: ../../GroupManagement/AddGroup.php");
}
else if(count($_POST["PanelId"]) < 2){
	$_SESSION["AddGroupError"]	= "Please Fill Empty Fields";
	header("Location: ../../GroupManagement/AddGroup.php");
}
else if(!isset($_POST["AdviserId"])){
	$_SESSION["AddGroupError"]	= "Please Fill Empty Fields";
	header("Location: ../../GroupManagement/AddGroup.php");
}
else{
	$section = $_POST["Section"];
	$profid = $_POST["ProfessorId"];
	$stud_fname = $_POST["Firstname"];
	$stud_lname = $_POST["Lastname"];
	$thesis_title = $_POST["Title"];
	$panelist = $_POST["PanelId"];
	$panel_chair = $_POST["PanelChairId"];
	$adviser = $_POST["AdviserId"];

	//if($profid == $adviser){
	//	$_SESSION["AddGroupError"]	= "Professor and Adviser cannot be the same person";
	//	header("Location: ../../GroupManagement/AddGroup.php");
	//	exit();
	//}

	if(in_array($adviser, $panelist) || $adviser == $panel_chair){
		$_SESSION["AddGroupError"]	= "The adviser cannot be one of the panelist";
		header("Location: ../../GroupManagement/AddGroup.php");
		exit();
	}

	if(in_array($panel_chair, $panelist) || HasDuplicates($panelist)){
		$_SESSION["AddGroupError"]	= "Same panels detected";
		header("Location: ../../GroupManagement/AddGroup.php");
		exit();
	}

	$students = array();
	foreach($stud_fname as $key=>$value){

		$s = Student::Create(NULL, $value, $stud_lname[$key], NULL);
		array_push($students, $s);
	}

	if(DBHandler::AddGroup($thesis_title, $panel_chair, $panelist, $adviser, $students, $profid, $section))
		header("Location: ../../GroupManagement/ManageGroups.php");
	else
		die("Error Adding Group");
}

function HasDuplicates($arr){
	if(count($arr) != count(array_unique($arr)))
		return true;
	else
		return false;
}
?>
