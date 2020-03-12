<?php
if(isset($_GET["edit"]))
	header("Location: ../../AccountManagement/EditAccount.php?id=".$_GET['id']);
if(isset($_GET["del"]))
	header("Location: ../../AccountManagement/DeleteAccount.php?id=".$_GET['id']);
if(isset($_GET["reset"]))
	echo "reset";
?>