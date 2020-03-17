<?php
require_once("../classes/DBHandler.php");
session_start();

$id = $_POST['id'];
$opass = $_POST['OPass'];
$password = $_POST['Password'];
$cpass = $_POST['CPass'];

if(empty($opass) || empty($cpass) || empty($password)){
	$_SESSION['ChangePassError'] = "Please Fill Empty Fields";
	header("Location: ../../AccountManagement/ChangePassword.php");
}
else if(DBHandler::CheckLogin($_SESSION['Account']->username, $opass) === NULL){
	$_SESSION['ChangePassError'] = "Incorrect Password";
	header("Location: ../../AccountManagement/ChangePassword.php");
}
else if($cpass !== $password){
	$_SESSION['ChangePassError'] = "Password Don't match";
	header("Location: ../../AccountManagement/ChangePassword.php");	
}else{
	if(DBHandler::ChangePassword($id, $password)){
		header("Location: ../../index.php");
	}
}
?>