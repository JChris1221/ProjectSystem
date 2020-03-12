<?php
session_start();

require_once("../classes/DBHandler.php");
require_once("../classes/Student.php");
require_once("../classes/Account.php");




//Check if panelists have same ids;
if(in_array("", $_POST["Firstname"]) || in_array("", $_POST["Lastname"]) || empty($_POST["Title"])){
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
	$stud_fname = $_POST["Firstname"];
	$stud_lname = $_POST["Lastname"];
	$thesis_title = $_POST["Title"];
	$panelist = $_POST["PanelId"];
	$panel_chair = $_POST["PanelChairId"];
	$adviser = $_POST["AdviserId"];

	$students = array();
	foreach($stud_fname as $key=>$value){

		$s = Student::Create(NULL, $value, $stud_lname[$key], NULL);
		array_push($students, $s);
	}

	if(DBHandler::AddGroup($thesis_title, $panel_chair, $panelist, $adviser, $students))
		header("Location: ../../GroupManagement/ManageGroups.php");
	else
		die("Error Adding Group");
}
?>