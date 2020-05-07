<?php
function RelativeLink($link){
	$rootFolderName = "ProjectSystem";

	$prefix;
	if(basename(getcwd()) == $rootFolderName){
  	  $prefix = "";
	}
	else{
      $prefix = "../";
	}

	$relLink = $prefix.$link;
	return $relLink;
}

?>