<?php
require_once("Role.php");
require_once("Account.php");
require_once("Student.php");

class DBHandler
{
	static private $server = "localhost";
	static private $s_username = "root";
	static private $s_pass = "";
	static private $dbName = "thesis-grading-system-db";

	public function __construct(){
	}

	//Returns an account object if login credientials is correct
	public static function CheckLogin($username, $password){

		$connection = new mysqli(self::$server, self::$s_username, self::$s_pass, self::$dbName);

		if($connection->connect_error)
			die($connection->connect_error);

		$stmt = $connection->prepare("SELECT accounts.*, roles.name AS Role_Name FROM accounts INNER JOIN roles ON accounts.Role_Id = roles.Id WHERE username = ? AND password = ?");
		// prepare() can fail because of syntax errors, missing privileges, ....
		if ( false===$stmt ) {
		  // and since all the following operations need a valid/ready statement object
		  // it doesn't make sense to go on
		  // you might want to use a more sophisticated mechanism than die()
		  // but's it's only an example
		  die('prepare() failed: ' . htmlspecialchars($connection->error));
		}
		$hashPass = md5($password);
		$rc = $stmt->bind_param('ss', $username, $hashPass);
		// bind_param() can fail because the number of parameter doesn't match the placeholders in the statement
		// or there's a type conflict(?), or ....
		if ( false===$rc ) {
		  // again execute() is useless if you can't bind the parameters. Bail out somehow.
		  die('bind_param() failed: ' . htmlspecialchars($stmt->error));
		}

		$rc = $stmt->execute();
		// execute() can fail for various reasons. And may it be as stupid as someone tripping over the network cable
		// 2006 "server gone away" is always an option
		if ( false===$rc ) {
		  die('execute() failed: ' . htmlspecialchars($stmt->error));
		}

		$res = $stmt->get_result();

		if($res->num_rows > 0){
			$row = $res->fetch_assoc();
			$acc = Account::CreateAccountWithRoleName($row['Id'], $row['Firstname'], $row['Lastname'], $row['Username'], $row['Role_Id'], $row['Role_Name']);
			return $acc;
			
		}
		else{
			return NULL;
		}

		$stmt->close();
		$connection->close();
	}

	//Retrives Account info based on id
	public static function GetAccountInfo($id){

		$connection = new mysqli(self::$server, self::$s_username, self::$s_pass, self::$dbName);

		if($connection->connect_error)
			die($connection->connect_error);

		$stmt = $connection->prepare("SELECT accounts.*, roles.name AS Role_Name FROM accounts INNER JOIN roles ON accounts.Role_Id = roles.Id WHERE accounts.Id = ?");
		if ( false===$stmt ) {
		  die('prepare() failed: ' . htmlspecialchars($connection->error));
		}

		$rc = $stmt->bind_param('d', $id);

		if ( false===$rc ) {
		  die('bind_param() failed: ' . htmlspecialchars($stmt->error));
		}

		$rc = $stmt->execute();
		if ( false===$rc ) {
		  die('execute() failed: ' . htmlspecialchars($stmt->error));
		}

		$res = $stmt->get_result();

		if($res->num_rows > 0){
			$row = $res->fetch_assoc();
			$acc = Account::CreateAccountWithRoleName($row['Id'], $row['Firstname'], $row['Lastname'], $row['Username'], $row['Role_Id'], $row['Role_Name']);
			return $acc;
			
		}
		else{
			return NULL;
		}

		$stmt->close();
		$connection->close();
	}

	//Gets all the roles in the roles table
	public static function GetRoleName($id){
		$connection = new mysqli(self::$server, self::$s_username, self::$s_pass, self::$dbName);

		if($connection->connect_error)
			die($connection->connect_error);

		$stmt = $connection->prepare("SELECT Name FROM roles WHERE Id = ?");
		if ( false===$stmt ) {
		  
		  die('prepare() failed: ' . htmlspecialchars($connection->error));
		}
		$rc = $stmt->bind_param('d', $id);
		
		if ( false===$rc ) {
		  
		  die('bind_param() failed: ' . htmlspecialchars($stmt->error));
		}

		$rc = $stmt->execute();

		if ( false===$rc ) {
		  die('execute() failed: ' . htmlspecialchars($stmt->error));
		}

		$res = $stmt->get_result();

		if($res->num_rows > 0){
			$row = $res->fetch_assoc();
			return $row['Name'];
			
		}
		else{
			return "Unknown Account Role";
		}

		$stmt->close();
		$connection->close();
	}

	//Gets all accounts in database except the current account logged in
	public static function GetAccounts($id)
	{
		$connection = new mysqli(self::$server, self::$s_username, self::$s_pass, self::$dbName);

		if($connection->connect_error)
			die($connection->connect_error);

		$stmt = $connection->prepare("SELECT accounts.*, roles.Name AS Role_Name FROM accounts INNER JOIN roles ON accounts.Role_Id = roles.Id WHERE accounts.Id <> ?");
		if ( false===$stmt ) {
		  die('prepare() failed: ' . htmlspecialchars($connection->error));
		}

		$rc = $stmt->bind_param('d', $id);
		if ( false===$rc ) {
		  die('bind_param() failed: ' . htmlspecialchars($stmt->error));
		}

		$rc = $stmt->execute();
		if ( false===$rc ) {
		  die('execute() failed: ' . htmlspecialchars($stmt->error));
		}

		$res = $stmt->get_result();

		if($res->num_rows > 0){
			$accounts = array();
			while($row = $res->fetch_assoc()){
				$id = $row['Id'];
				$firstname = $row['Firstname'];
				$lastname = $row['Lastname'];
				$username = $row['Username'];
				$roleId = $row['Role_Id'];
				$roleName = $row['Role_Name'];

				array_push($accounts, Account::CreateAccountWithRoleName($id, $firstname, $lastname, $username, $roleId, $roleName));
			}
			return $accounts;
		}
		else{
			return NULL;
		}

		$stmt->close();
		$connection->close();	
	}

	//Gets all roles from roles table
	public static function GetRoles(){
		$connection = new mysqli(self::$server, self::$s_username, self::$s_pass, self::$dbName);

		if($connection->connect_error)
			die($connection->connect_error);

		$stmt = $connection->prepare("SELECT * FROM roles ORDER BY Name");
		
		if ( false===$stmt ) {
		  die('prepare() failed: ' . htmlspecialchars($connection->error));
		}

		$rc = $stmt->execute();
		if ( false===$rc ) {
		  die('execute() failed: ' . htmlspecialchars($stmt->error));
		}

		$res = $stmt->get_result();
		if($res->num_rows > 0){
			$roles = array();

			while($row = $res->fetch_assoc()){
				$id = $row['Id'];
				$role = $row['Name'];

				array_push($roles, new Role($id, $role));
			}
			return $roles;
		}
		else{
			return NULL;
		}

		$stmt->close();
		$connection->close();	
	}

	//Insert a new account in the accoutns table
	public static function AddAccount($firstname, $lastname,$username, $password, $roleId){
		$connection = new mysqli(self::$server, self::$s_username, self::$s_pass, self::$dbName);

		if($connection->connect_error)
			die($connection->connect_error);

		$stmt = $connection->prepare("INSERT INTO accounts (Firstname, Lastname, Username, Password, Role_Id) VALUES (?,?,?,?,?)");

		if ( false===$stmt ) {
		  die('prepare() failed: ' . htmlspecialchars($connection->error));
		}

		$hashPass = md5($password); //Convert password to hash

		$rc = $stmt->bind_param('ssssd', $firstname, $lastname, $username, $hashPass, $roleId);

		if ( false===$rc ) {
		  die('bind_param() failed: ' . htmlspecialchars($stmt->error));
		}

		$rc = $stmt->execute();

		if ( false===$rc ){
		  die('execute() failed: ' . htmlspecialchars($stmt->error));
		}

		if($stmt->affected_rows == 0){
			$stmt->close();
			$connection->close();	
			return false;
		}

		$stmt->close();
		$connection->close();	

		return true;
	}

	//returns false if update fails
	public static function UpdateAccount($id, $firstname,$lastname, $username, $roleId){
		$connection = new mysqli(self::$server, self::$s_username, self::$s_pass, self::$dbName);

		if($connection->connect_error)
			die($connection->connect_error);

		$stmt = $connection->prepare("UPDATE accounts SET Firstname = ?, Lastname=?, Username=?,Role_Id =? WHERE Id = ?");
		

		if ( false===$stmt ) {
		
		  die('prepare() failed: ' . htmlspecialchars($connection->error));
		}

		$rc = $stmt->bind_param('sssdd', $firstname, $lastname, $username, $roleId, $id);
		
		if ( false===$rc ) {
		  die('bind_param() failed: ' . htmlspecialchars($stmt->error));
		}

		$rc = $stmt->execute();
		
		if ( false===$rc ){
		  die('execute() failed: ' . htmlspecialchars($stmt->error));
		}

		if($stmt->affected_rows == 0){
			$stmt->close();
			$connection->close();	
			return false;
		}

		$stmt->close();
		$connection->close();	

		return true;
	}

	//returns false if deletion fails
	public static function DeleteAccount($id){
		$connection = new mysqli(self::$server, self::$s_username, self::$s_pass, self::$dbName);

		if($connection->connect_error)
			die($connection->connect_error);

		$stmt = $connection->prepare("DELETE FROM accounts WHERE Id = ?");
		if ( false===$stmt ) {
		
		  die('prepare() failed: ' . htmlspecialchars($connection->error));
		}

		$rc = $stmt->bind_param('d', $id);
		if ( false===$rc ) {
		  die('bind_param() failed: ' . htmlspecialchars($stmt->error));
		}

		$rc = $stmt->execute();
		
		if ( false===$rc ){
		  die('execute() failed: ' . htmlspecialchars($stmt->error));
		}

		if($stmt->affected_rows == 0){
			$stmt->close();
			$connection->close();	
			return false;
		}

		$stmt->close();
		$connection->close();	

		return true;
	}

	public static function AddGroup($title, $panelists, $adviser, $members){
		$connection = new mysqli(self::$server, self::$s_username, self::$s_pass, self::$dbName);

		if($connection->connect_error)
			die($connection->connect_error);

		$stmt = $connection->prepare("INSERT INTO groups (Firstname, Lastname, Username, Password, Role_Id) VALUES (?,?,?,?,?)");

		if ( false===$stmt ) {
		  die('prepare() failed: ' . htmlspecialchars($connection->error));
		}

		$hashPass = md5($password); //Convert password to hash

		$rc = $stmt->bind_param('ssssd', $firstname, $lastname, $username, $hashPass, $roleId);

		if ( false===$rc ) {
		  die('bind_param() failed: ' . htmlspecialchars($stmt->error));
		}

		$rc = $stmt->execute();

		if ( false===$rc ){
		  die('execute() failed: ' . htmlspecialchars($stmt->error));
		}

		if($stmt->affected_rows == 0){
			$stmt->close();
			$connection->close();	
			return false;
		}

		$stmt->close();
		$connection->close();	

		return true;
	}
}

?>