<?php
function RelativeLink($link){
	$rootFolderName = "ProjectSystem";

	$suffix;
	if(basename(getcwd()) == $rootFolderName){
  	  $prefix = "";
	}
	else{
      $prefix = "../";
	}

	$relLink = $suffix.$link;
	return $relLink;
}

?>