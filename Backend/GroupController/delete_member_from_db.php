<?php 
require_once("../classes/DBHandler.php");

$id = $_POST['id'];
$student = DBHandler::GetStudent($id);

if(DBHandler::DeleteMember($id)){
	header("Location: ../../GroupManagement/GroupDetails.php?id=".$student->groupid);
}
else{
	echo "Error Deleting member from database";
}
?>