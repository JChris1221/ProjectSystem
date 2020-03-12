<?php
require_once("../classes/DBhandler.php");

$groupid = $_POST["id"];
$title = $_POST["Title"];

if(DBHandler::UpdateTitle($groupid, $title)){
	header("Location: ../../GroupManagement/GroupDetails.php?id=".$groupid);
}else{
	echo "Error Updating Title";
}
?>