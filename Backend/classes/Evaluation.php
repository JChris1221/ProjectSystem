<?php
class Evaluation{
	public $grades;
	public $comment;

	public function __construct($_grades, $_comment){
		$this->grades = $_grades;
		$this->comment = $_comment;
	}
}
?>