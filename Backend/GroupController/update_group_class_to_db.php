<?php
require_once("../classes/DBHandler.php");
require_once("../classes/Account.php");
session_start();

$adviser = DBHandler::GetGroupFaculty($_POST["groupid"], 1);

if($adviser[0]->id == $_POST['profid']){
	$_SESSION["UpdateClassError"] = "Cannot Assign Professor (Already the adviser of this group)";
	header("Location: ../../GroupManagement/EditClassGroup.php?id=".$_POST['groupid']);
	exit();
}
if(empty($_POST['section'])){
	$_SESSION["UpdateClassError"] = "Please fill empty fields";
	header("Location: ../../GroupManagement/EditClassGroup.php?id=".$_POST['groupid']);
	exit();
}

if(DBHandler::UpdateGroupClass($_POST['groupid'], $_POST["profid"], $_POST["section"])){
	header("Location: ../../GroupManagement/GroupDetails.php?id=".$_POST['groupid']);
}

?>