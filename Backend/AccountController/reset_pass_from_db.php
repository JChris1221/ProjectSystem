<?php
require_once("../classes/DBHandler.php");
$id = $_POST['Id'];

if(DBHandler::ResetPassword($id)){
	header("Location: ../../AccountManagement/ManageAccounts.php");
}
else{
	echo ("Error Resetting Password");
}

?>