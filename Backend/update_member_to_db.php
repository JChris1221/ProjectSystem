<?php
require_once("classes/DBhandler.php");
require_once("classes/Student.php");
$id = $_POST['id'];
$firstname = $_POST['Firstname'];
$lastname = $_POST['Lastname'];


if(DBHandler::UpdateMemberInfo($id, $firstname, $lastname)){
	$stud = DBHandler::GetStudent($id);

	header("Location: ../GroupManagement/GroupDetails.php?id=".$stud->groupid);
}else{
	echo "Error Updating to db";
}
?>
