<?php
require_once("classes/Student.php");
require_once("classes/DBHandler.php");

$groupid = $_POST['id'];
$firstnames = $_POST["Firstname"];
$lastnames = $_POST["Lastname"];
$students = array();
foreach($firstnames as $key=>$value){
	$s = Student::Create(null, $value, $lastnames[$key], $groupid);
	array_push($students, $s);
}

if(DBHandler::AddStudents($students)){
	header("Location: ../GroupManagement/GroupDetails.php?id=".$groupid);
}
else
	echo "Error Adding Students";

?>