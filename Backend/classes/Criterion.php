<?php
class Criterion{
	public $id;
	public $title;
	public $descriptions;

	public function __construct(){
		$this->descriptions = array();
	}

	public static function Create($_id, $_title, $_descs){
		$c = new Criterion();
		$c->id = $_id;
		$c->title = $_title;
		$c->descriptions = $_descs;

		return $c;
	}
}

?>