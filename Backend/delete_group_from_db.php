<?php
require_once("classes/DBHandler.php");


$groupid = $_POST['id'];

if(DBHandler::DeleteGroup($groupid)){
	header("Location: ../GroupManagement/ManageGroups.php");
}
else{
	echo "Error deleteing to database";
}
?>