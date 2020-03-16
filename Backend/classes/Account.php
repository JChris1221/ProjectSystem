<?php
//Redirects user if no account is logged in
class Account{
	public $id;
	public $firstname;
	public $lastname;
	public $username;
	public $roleid;
	public $rolename;
	public $disabled;

	private function __construct(){
	}

	public static function CreateAccountWithInfo($_id, $_firstname, $_lastname, $_username,$_roleId, $_disabled){
		$instance = new Account();
		$instance->id = $_id;
		$instance->firstname = $_firstname;
		$instance->lastname = $_lastname;
		$instance->username = $_username;
		$instance->roleid = $_roleId;
		$instance->disabled = $_disabled;

		return $instance;
	}

	public static function CreateAccountWithRoleName($_id, $_firstname, $_lastname, $_username,$_roleId,$_roleName,$_disabled){
		$instance = new Account();
		$instance->id = $_id;
		$instance->firstname = $_firstname;
		$instance->lastname = $_lastname;
		$instance->username = $_username;
		$instance->roleid = $_roleId;
		$instance->rolename = $_roleName;
		$instance->disabled=$_disabled;

		return $instance;
	}
}
?>