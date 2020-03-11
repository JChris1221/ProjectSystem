<?php
//Redirects user if no account is logged in
class Account{
	public $id;
	public $firstname;
	public $lastname;
	public $username;
	public $roleid;
	public $rolename;

	private function __construct(){
	}

	public static function CreateAccountWithInfo($_id, $_firstname, $_lastname, $_username,$_roleId){
		$instance = new Account();
		$instance->id = $_id;
		$instance->firstname = $_firstname;
		$instance->lastname = $_lastname;
		$instance->username = $_username;
		$instance->roleid = $_roleId;

		return $instance;
	}

	public static function CreateAccountWithRoleName($_id, $_firstname, $_lastname, $_username,$_roleId,$_roleName){
		$instance = new Account();
		$instance->id = $_id;
		$instance->firstname = $_firstname;
		$instance->lastname = $_lastname;
		$instance->username = $_username;
		$instance->roleid = $_roleId;
		$instance->rolename = $_roleName;

		return $instance;
	}
}
?>