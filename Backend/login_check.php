<?php
require_once("classes/DBHandler.php");
require_once("classes/Account.php");
session_start();

if(Empty($_POST["username"]) || Empty($_POST["password"])){
	$_SESSION["InvalidLogin"] = "Please fill out empty fields";
	header("Location: ../login.php");
}
else
{
	$retrieved = DBHandler::CheckLogin($_POST['username'], $_POST['password']);

	if($retrieved !== NULL){
		$_SESSION['Account'] = $retrieved;
		header("Location: ../index.php");
	}
	else{
		$_SESSION["InvalidLogin"] = "Invalid Username or Password";
		header("Location: ../login.php");
	}
}
?>