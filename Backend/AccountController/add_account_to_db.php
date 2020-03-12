<?php
require_once("../classes/Account.php");
require_once("../classes/DBHandler.php");
session_start();

$firstname = $_POST['Firstname'];
$lastname = $_POST['Lastname'];
$username = $_POST['Username'];
$password = $_POST['Password'];
$cpass = $_POST['CPass'];
$role = $_POST['Role'];

if(Empty($firstname)||Empty($lastname)||Empty($username)||Empty($password)||Empty($cpass)||Empty($role)){
	$_SESSION["AddUserError"] = "Please Fill Out Empty Fields";
	$_SESSION["FormAccount"] = Account::CreateAccountWithInfo(NULL, $firstname, $lastname, $username, $role);
	header("Location: ../../AccountManagement/AddAccount.php");
}
else if($password !== $cpass){
	$_SESSION["AddUserError"] = "Passwords don't match";
	$_SESSION["FormAccount"] = Account::CreateAccountWithInfo(NULL, $firstname, $lastname, $username, $role);
	header("Location: ../../AccountManagement/AddAccount.php");
}
else{
	if(DBHandler::AddAccount($firstname, $lastname, $username, $password, $role)){
		header("Location: ../../AccountManagement/ManageAccounts.php");
	}
	else
		die("Error Inserting to Database");
}



?>