<?php
class Group{
	public $id;
	public $title;
	public $membersId;
	public $adviserId;
	public $panelsId;

	public function __construct(){

	}

	public static function Create($_id, $_title){
		$g = new Group();
		$g->id = $_id;
		$g->title = $_title;
		return $g;
	}
}
?>