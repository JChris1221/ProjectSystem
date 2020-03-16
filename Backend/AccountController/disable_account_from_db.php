<?php
require_once("../classes/DBHandler.php");
$id = $_POST["Id"];

if(DBHandler::ToggleAccount($id, true)){
    header("Location: ../../AccountManagement/ManageAccounts.php");
}
?>