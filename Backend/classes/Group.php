<?php
class Group{
	public $id;
	public $title;
	public $membersId;
	public $adviserId;
	public $panelsId;
	public $section;

	public function __construct(){

	}

	public static function Create($_id, $_title, $_section){
		$g = new Group();
		$g->id = $_id;
		$g->title = $_title;
		$g->section = $_section;
		return $g;	
	}
}
?>