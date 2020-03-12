<?php
require_once("classes/DBHandler.php");

$id = $_POST['Id'];
if(DBHandler::DeleteAccount($id)){
	header("Location: ../AccountManagement/ManageAccounts.php");
}else{
	die("Error in deletion");
}

?>