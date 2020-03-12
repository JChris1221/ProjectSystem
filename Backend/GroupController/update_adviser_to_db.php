<?php
require_once("../classes/DBhandler.php");

$groupid = $_POST['id'];
$adviserid = $_POST["AdviserId"];
if(DBHandler::UpdateAdviser($groupid, $adviserid)){
	header("Location: ../../GroupManagement/GroupDetails.php?id=".$groupid);
}
else{
	echo "Error Updating Adviser";
}

?>