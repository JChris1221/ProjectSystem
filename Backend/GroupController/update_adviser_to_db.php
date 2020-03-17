<?php
require_once("../classes/DBhandler.php");
require_once("../classes/Account.php");

session_start();

$groupid = $_POST['id'];
$adviserid = $_POST["AdviserId"];
$panels = DBHandler::GetGroupFaculty($groupid, 2);
$panelChair = DBhandler::GetGroupFaculty($groupid, 3);
$prof = DBHandler::GetGroupFaculty($groupid, 4);


if($adviserid == $prof[0]->id){
	$_SESSION["UpdateAdviserError"] = "Selected is already the professor of this group";
	header("Location: ../../GroupManagement/ChangeAdviser.php?id=".$groupid);
	exit();
}

if(InAccount($adviserid, $panels) || $adviserid == $panelChair[0]->id){
	$_SESSION["UpdateAdviserError"] = "Selected is one of the panelists";
	header("Location: ../../GroupManagement/ChangeAdviser.php?id=".$groupid);
	exit();
}




if(DBHandler::UpdateAdviser($groupid, $adviserid)){
	header("Location: ../../GroupManagement/GroupDetails.php?id=".$groupid);
}
else{
	echo "Error Updating Adviser";
}

function InAccount($id, $accounts){
	foreach($accounts as $a){
		if($a->id == $id)
			return true;
	}

	return false;
}

?>