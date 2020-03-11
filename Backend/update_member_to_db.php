<?php
require_once("classes/DBhandler.php");
require_once("classes/Student.php");

session_start();
$id = $_POST['id'];
$firstname = $_POST['Firstname'];
$lastname = $_POST['Lastname'];

if(empty($firstname) || empty($lastname)){
	$_SESSION["UpdateMemberError"] = "Fields cannot be empty";
	header("Location: ../GroupManagement/EditMember.php?id=".$id);
}
else{
	if(DBHandler::UpdateMemberInfo($id, $firstname, $lastname)){
		$stud = DBHandler::GetStudent($id);
		header("Location: ../GroupManagement/GroupDetails.php?id=".$stud->groupid);
	}else{
		echo "Error Updating to db";
	}
}
?>