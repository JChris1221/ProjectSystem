<?php

class Student{
	public $id;
	public $firstname;
	public $lastname;
	public $groupid;

	public function __construct(){
	}

	//Used if you're gonna add values to database
	// public static function CreateTemplate($_firstname, $_lastname, $_groupid){
	// 	$s = new Student();
	// 	$s->firstname = $_firstname;
	// 	$s->lastname = $_lastname;
	// 	$s->groupid = $_groupid;
	// 	return $s;
	// }

	//Used if you're gonna put student info from database
	public static function Create($_id, $_firstname,$_lastname, $_groupid){
		$s = new Student();
		$s->id = $_id;
		$s->firstname = $_firstname;
		$s->lastname = $_lastname;
		$s->groupid = $_groupid;
		return $s;
	}
}
?>