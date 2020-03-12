<?php
require_once("classes/DBhandler.php");

$groupid = $_POST['id'];
$panelchair = $_POST['PanelChairId'];
$panels = $_POST['PanelId'];


if(DBHandler::UpdatePanels($panelchair, $panels, $groupid)){
	header("Location: ../GroupManagement/GroupDetails.php?id=".$groupid);
}else
	echo "Error Updating panels";
?>