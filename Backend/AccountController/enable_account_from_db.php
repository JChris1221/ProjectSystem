<?php
require_once("../classes/DBHandler.php");
$id = $_POST["Id"];

if(DBHandler::ToggleAccount($id, false)){
    header("Location: ../../AccountManagement/ManageAccounts.php");
}
?>