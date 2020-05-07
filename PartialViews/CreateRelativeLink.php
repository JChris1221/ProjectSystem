<?php
function RelativeLink($link){
	$rootFolderName = dirname(__DIR__);

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