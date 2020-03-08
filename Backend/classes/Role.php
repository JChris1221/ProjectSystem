<?php

class Role{
	public $id;
	public $name;

	public function __construct($_id, $_name){
		$this->id = $_id;
		$this->name = $_name;
	}
}

?>