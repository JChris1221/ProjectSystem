<?php
require_once("classes/DBHandler.php");
require_once("classes/Account.php");
session_start();

$id = $_POST['Id'];
$firstname = $_POST['Firstname'];
$lastname = $_POST['Lastname'];
$username = $_POST['Username'];
$roleid = $_POST['Role'];

if(Empty($firstname)||Empty($lastname)||Empty($username)||Empty($roleid)){
	$_SESSION['EditUserError'] = "Please fill out empty fields";
	$_SESSION['CurrentChanges'] = Account::CreateAccountWithInfo($id, $firstname, $lastname, $username, $roleid);
	
	header("Location: ../,,.AccountManagement/EditAccount.php?id=".$id);
}
else{
	if(DBHandler::UpdateAccount($id, $firstname, $lastname, $username, $roleid)){
		header("Location: ../,,.AccountManagement/ManageAccounts.php");
	}
}

?>