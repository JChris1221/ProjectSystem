<?php
function RelativeLink($link){
	$rootFolderName = "ThesisGradingSystem";

	$suffix;
	if(basename(getcwd()) == $rootFolderName){
  	  $suffix = "";
	}
	else
    	$suffix = "../";

	$relLink = $suffix.$link;
	return $relLink;
}

?>