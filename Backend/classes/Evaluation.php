<?php
class Evaluation{
	public $grades;
	public $comment;
	public $date;

	public function __construct($_grades, $_comment, $_date){
		$this->grades = $_grades;
		$this->comment = $_comment;
		$this->date = $_date;
	}
}
?>