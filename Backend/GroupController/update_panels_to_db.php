<?php
require_once("../classes/DBhandler.php");

session_start();

$groupid = $_POST['id'];
$panelchair = $_POST['PanelChairId'];
$panels = $_POST['PanelId'];

$adviser = DBHandler::GetGroupFaculty($groupid, 1);

if(count($panels) != 2){
	die("Aborted due to mismatch indeces");
}

if(in_array($adviser[0]->id, $panels) || $adviser[0]->id == $panelchair){
	$_SESSION["ChangePanelsError"] = "Cannot Update Panels (One of the panels is already the adviser of this group)";
	header("Location: ../../GroupManagement/ChangePanels.php?id=".$groupid);
	exit();
}

if(in_array($panelchair, $panels) || $panels[0] == $panels[1]){
	$_SESSION["ChangePanelsError"] = "Cannot Update Panels (Duplicate panels)";
	header("Location: ../../GroupManagement/ChangePanels.php?id=".$groupid);
	exit();	
}

if(DBHandler::UpdatePanels($panelchair, $panels, $groupid)){
	header("Location: ../../GroupManagement/GroupDetails.php?id=".$groupid);
}else
	echo "Error Updating panels";
?>