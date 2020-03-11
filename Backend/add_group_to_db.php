<?php
require_once("classes/DBHandler.php");
require_once("classes/Student.php");
require_once("classes/Account.php");

$thesis_title = $_POST["Title"];
$panelist = $_POST["PanelId"];
$panel_chair = $_POST["PanelChairId"];
$adviser = $_POST["AdviserId"];
$stud_fname = $_POST["Firstname"];
$stud_lname = $_POST["Lastname"];

//Check if panelists have same ids;
if(false){

}
else{
	$students = array();
	foreach($stud_fname as $key=>$value){

		$s = Student::Create(NULL, $value, $stud_lname[$key], NULL);
		array_push($students, $s);
	}

	if(DBHandler::AddGroup($thesis_title, $panel_chair, $panelist, $adviser, $students))
		header("Location: ../GroupManagement/AddGroup.php");
	else
		die("Error Adding Group");
}
?>