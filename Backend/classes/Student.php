<?php

class Student{
	public $id;
	public $name;
	public $groupid;

	public function __construct(){
	}

	//Used if you're gonna add values to database
	public static function CreateTemplate($_name, $_groupid){
		$s = new Student();
		$s->name = $_name;
		$s->groupid = $_groupid;
		return $s;
	}

	//Used if you're gonna put student info from database
	public static function Create($_id, $_name, $_groupid){
		$s = new Student();
		$s->id = $_id;
		$s->name = $_name;
		$s->groupid = $_groupid;
		return $s;
	}
}
?>