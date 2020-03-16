<?php
require_once("../classes/DBHandler.php");
if(empty($_POST['section'])){
	die("Empty Section");
}
else{
	if(DBHandler::UpdateGroupClass($_POST['groupid'], $_POST["profid"], $_POST["section"])){
		header("Location: ../../GroupManagement/GroupDetails.php?id=".$_POST['groupid']);
	}
}
?>