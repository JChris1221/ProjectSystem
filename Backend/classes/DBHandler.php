<?php
require_once("Role.php");
require_once("Account.php");
require_once("Student.php");
require_once("Group.php");
require_once("Criterion.php");



class DBHandler
{
	static private $server = "localhost";
	static private $s_username = "root";
	static private $s_pass = "";
	static private $dbName = "thesis-grading-system-db";

	public function __construct(){
	}


	//-------------------------------------Accounts-----------------------------------------

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

	//Gets all accounts in database except the current account with the id in the argument
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

	//Gets all accounts with a certain role
	public static function GetAccountsWithRole($roleId)
	{
		$connection = new mysqli(self::$server, self::$s_username, self::$s_pass, self::$dbName);

		if($connection->connect_error)
			die($connection->connect_error);

		$stmt = $connection->prepare("SELECT * FROM accounts WHERE Role_Id =  ? ORDER BY Lastname");
		$stmt->bind_param('d', $roleId);
		$stmt->execute();

		$res = $stmt->get_result();

		if($res->num_rows > 0){
			$accounts = array();
			while($row = $res->fetch_assoc()){
				$id = $row['Id'];
				$firstname = $row['Firstname'];
				$username = $row['Username'];
				$lastname = $row['Lastname'];
				$roleId = $row['Role_Id'];


				array_push($accounts, Account::CreateAccountWithInfo($id, $firstname, $lastname, $username, $roleId));
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

	//-----------------------------------GROUPS-------------------------------------
	public static function AddGroup($title, $panel_chair_id, $panel_ids, $adviser_id, $members, $prof_id, $section){
		$connection = new mysqli(self::$server, self::$s_username, self::$s_pass, self::$dbName);

		if($connection->connect_error)
			die($connection->connect_error);

		$stmt = $connection->prepare("INSERT INTO Groups (Thesis_Title, Section) VALUES (?, ?)");

		if ( false===$stmt ) {
		  die('prepare() failed: ' . htmlspecialchars($connection->error));
		}

		$stmt->bind_param('ss', $title, $section);
		$stmt->execute();

		if($stmt->affected_rows == 0){
			$success = false;
		}
		else{
			$groupid = $stmt->insert_id; //GET GROUP ID FROM ADDED GROUP
			$stmt->close();

			//For panelist and adviser
			$faculty_stmt = $connection->prepare("INSERT INTO Faculty_Assignment (Group_Id, Account_Id, Faculty_Type_Id) VALUES (?,?,?)");

			// if($faculty_stmt === false)
			// 	die("Error preparing statement: ".$connection->error);
			$pc = 2; //Panel Chair Role
			$faculty_stmt->bind_param('ddd', $groupid, $panel_chair_id, $pc); //Panel Chair
			$faculty_stmt->execute();

			foreach($panel_ids as $pid){
				$p = 3;
				if($faculty_stmt->bind_param('ddd', $groupid, $pid, $p) === false)
					die("error binding params in panelist");
				$faculty_stmt->execute();
			}

			$a = 1; //Adviser Role
			
			if($faculty_stmt->bind_param('ddd', $groupid, $adviser_id, $a)===false)
				die("error binding params in adviser");


			$faculty_stmt->execute();

			$prof = 4; //Professor Role
			if($faculty_stmt->bind_param('ddd', $groupid, $prof_id, $prof)===false)
				die("error binding params in adviser");
			
			$faculty_stmt->execute();



			$faculty_stmt->close();

			//For group members
			$student_stmt = $connection->prepare("INSERT INTO Students (Firstname, Lastname, Group_Id) VALUES (?,?,?)");
			if($student_stmt === false)
				die("Error preparing statement: ".$connection->error);

			foreach($members as $student){
				if($student_stmt->bind_param('ssd', $student->firstname, $student->lastname, $groupid)===false)
					die("error binding params in students");
				$student_stmt->execute();
			}
			$student_stmt->close();

			$success = true;
		}
		
		
		$connection->close();	

		return $success;
	}

	

	public static function GetGroups(){
		$connection = new mysqli(self::$server, self::$s_username, self::$s_pass, self::$dbName);

		if($connection->connect_error)
			die($connection->connect_error);

		$stmt = $connection->prepare("SELECT *  FROM Groups");
		if ( false===$stmt ) {
		  die('prepare() failed: ' . htmlspecialchars($connection->error));
		}

		$rc = $stmt->execute();
		if ( false===$rc ) {
		  die('execute() failed: ' . htmlspecialchars($stmt->error));
		}

		$res = $stmt->get_result();

		if($res->num_rows > 0){
			$groups = array();
			while($row = $res->fetch_assoc()){
				$id = $row['Id'];
				$title = $row['Thesis_Title'];
				$section = $row['Section'];

				array_push($groups, Group::Create($id, $title, $section));
			}
			return $groups;
		}
		else{
			return NULL;
		}

		$stmt->close();
		$connection->close();	
	}

	//Return the groups of a faculty member with a specific faculty type
	public function GetGroupsOfFaculty($id, $faculty_type){
		$connection = new mysqli(self::$server, self::$s_username, self::$s_pass, self::$dbName);

		if($connection->connect_error)
			die($connection->connect_error);

		$stmt = $connection->prepare("SELECT *  FROM Faculty_Assignment WHERE Account_Id = ? AND Faculty_Type_Id = ?");
		if ( false===$stmt ) {
		  die('prepare() failed: ' . htmlspecialchars($connection->error));
		}

		$stmt->bind_param('dd', $id, $faculty_type);
		$stmt->execute();

		$res = $stmt->get_result();

		if($res->num_rows > 0){
			$groups = array();
			while($row = $res->fetch_assoc()){
				$g = self::GetGroup($row['Group_Id']);

				array_push($groups, $g);
			}
			return $groups;
		}
		else{
			return NULL;
		}

		$stmt->close();
		$connection->close();	
	}

	public static function GetGroup($id){
		$connection = new mysqli(self::$server, self::$s_username, self::$s_pass, self::$dbName);

		if($connection->connect_error)
			die($connection->connect_error);

		$stmt = $connection->prepare("SELECT *  FROM Groups WHERE Id = ?");
		if ( false===$stmt ) {
		  die('prepare() failed: ' . htmlspecialchars($connection->error));
		}

		$stmt->bind_param('d', $id);
		$stmt->execute();
		$res = $stmt->get_result();

		if($res->num_rows > 0){
			$row = $res->fetch_assoc();
			
			$id = $row['Id'];
			$title = $row['Thesis_Title'];
			$section = $row['Section'];

			$group = Group::Create($id, $title, $section);
			return $group;
		}
		else{
			return NULL;
		}

		$stmt->close();
		$connection->close();	
	}

	public static function GetGroupFaculty($groupId, $facultyId){
		$connection = new mysqli(self::$server, self::$s_username, self::$s_pass, self::$dbName);

		if($connection->connect_error)
			die($connection->connect_error);

		$stmt = $connection->prepare("SELECT Accounts.*  FROM Faculty_Assignment INNER JOIN Accounts ON Faculty_Assignment.Account_ID = Accounts.Id WHERE Group_Id = ? AND Faculty_Type_Id = ?");

		if ( false===$stmt ) {
		  die('prepare() failed: ' . htmlspecialchars($connection->error));
		}

		$stmt->bind_param("dd", $groupId, $facultyId);
		$stmt->execute();
		$res = $stmt->get_result();

		if($res->num_rows > 0){
			$faculty = array();
			while($row = $res->fetch_assoc()){
				$id = $row['Id'];
				$firstname = $row['Firstname'];
				$lastname = $row['Lastname'];
				$username = $row['Username'];
				$roleId = $row['Role_Id'];

				array_push($faculty, Account::CreateAccountWithInfo($id, $firstname, $lastname, $username, $roleId));
			}
			return $faculty;
		}
		else{
			return NULL;
		}

		$stmt->close();
		$connection->close();	
	}

	public static function GetStudent($id){
		$connection = new mysqli(self::$server, self::$s_username, self::$s_pass, self::$dbName);

		if($connection->connect_error)
			die($connection->connect_error);

		$stmt = $connection->prepare("SELECT *  FROM Students WHERE Id = ?");
		
		if ( false===$stmt ) {
		  die('prepare() failed: ' . htmlspecialchars($connection->error));
		}

		$stmt->bind_param("d", $id);
		$stmt->execute();
		$res = $stmt->get_result();

		if($res->num_rows > 0){

			$row = $res->fetch_assoc();
			$id = $row['Id'];
			$firstname = $row['Firstname'];
			$lastname = $row['Lastname'];
			$groupid = $row['Group_Id'];

			$student= Student::Create($id, $firstname,$lastname,$groupid);

			return $student;
		}
		else{
			return NULL;
		}

		$stmt->close();
		$connection->close();
	}
	public static function GetGroupMembers($groupId){
		$connection = new mysqli(self::$server, self::$s_username, self::$s_pass, self::$dbName);

		if($connection->connect_error)
			die($connection->connect_error);

		$stmt = $connection->prepare("SELECT *  FROM Students WHERE Group_Id = ? ORDER BY Firstname");
		
		if ( false===$stmt ) {
		  die('prepare() failed: ' . htmlspecialchars($connection->error));
		}

		$stmt->bind_param("d", $groupId);
		$stmt->execute();
		$res = $stmt->get_result();

		if($res->num_rows > 0){
			$students = array();
			while($row = $res->fetch_assoc()){
				$id = $row['Id'];
				$firstname = $row['Firstname'];
				$lastname = $row['Lastname'];
				$groupid = $row['Group_Id'];

				array_push($students, Student::Create($id, $firstname, $lastname, $groupid));
			}
			return $students;
		}
		else{
			return NULL;
		}

		$stmt->close();
		$connection->close();
	}

	public function UpdateMemberInfo($id, $firstname, $lastname){
		$connection = new mysqli(self::$server, self::$s_username, self::$s_pass, self::$dbName);

		if($connection->connect_error)
			die($connection->connect_error);

		$stmt = $connection->prepare("UPDATE students SET Firstname = ?, Lastname = ? WHERE Id = ?");
		
		if ( false===$stmt ) {
		  die('prepare() failed: ' . htmlspecialchars($connection->error));
		}

		if(!$stmt->bind_param("ssd", $firstname, $lastname, $id)){
			die("error binding params");
		}
		
		if($stmt->execute() === false){
			die("error executing query");
		}

		if($stmt->affected_rows == 0){
			$success = false;
		}
		else{
			$success = true;
		}

		$stmt->close();
		$connection->close();
		return $success;
	}

	public function DeleteMember($id){
		$connection = new mysqli(self::$server, self::$s_username, self::$s_pass, self::$dbName);

		if($connection->connect_error)
			die($connection->connect_error);

		$stmt = $connection->prepare("DELETE FROM Students WHERE Id = ?");
		
		if ( false===$stmt ) {
		  die('prepare() failed: ' . htmlspecialchars($connection->error));
		}

		if(!$stmt->bind_param("d",$id)){
			die("error binding params");
		}
		
		if($stmt->execute() === false){
			die("error executing query");
		}

		if($stmt->affected_rows == 0){
			$success = false;
		}
		else{
			$success = true;
		}

		$stmt->close();
		$connection->close();
		return $success;
	}

	public static function AddStudents($students){
		$connection = new mysqli(self::$server, self::$s_username, self::$s_pass, self::$dbName);

		if($connection->connect_error)
			die($connection->connect_error);

		$stmt = $connection->prepare("INSERT INTO Students (Firstname, Lastname, Group_Id) VALUES (?,?,?)");
		
		if ( false===$stmt ) {
		  die('prepare() failed: ' . htmlspecialchars($connection->error));
		}

		foreach($students as $s){
			if(!$stmt->bind_param("ssd",$s->firstname,$s->lastname, $s->groupid)){
				die("error binding params");
			}
			
			if($stmt->execute() === false){
				die("error executing query");
			}
			if($stmt->affected_rows == 0){
				die("error inserting on of the records");
			}
		}

		$stmt->close();
		$connection->close();
		return true;
	}

	public static function UpdateAdviser($groupid, $adviserid){
		$connection = new mysqli(self::$server, self::$s_username, self::$s_pass, self::$dbName);

		if($connection->connect_error)
			die($connection->connect_error);

		$stmt = $connection->prepare("UPDATE Faculty_Assignment SET Account_Id = ? WHERE Group_Id = ? AND Faculty_Type_Id = ?");
		
		if ( false===$stmt ) {
		  die('prepare() failed: ' . htmlspecialchars($connection->error));
		}

		$facultyid = 1;
		if(!$stmt->bind_param("ddd", $adviserid, $groupid, $facultyid))
			die("error binding params");
		
		if($stmt->execute() === false){
			die("error executing query");
		}

		if($stmt->affected_rows == 0){
			$success = false;
		}
		else{
			$success = true;
		}

		$stmt->close();
		$connection->close();
		return $success;
	}

	public static function UpdatePanels($panelchair, $panelists, $groupid){
		$connection = new mysqli(self::$server, self::$s_username, self::$s_pass, self::$dbName);

		if($connection->connect_error)
			die($connection->connect_error);

		//Update Panel Chair
		$stmt = $connection->prepare("UPDATE Faculty_Assignment SET Account_Id = ? WHERE Group_Id = ? AND Faculty_Type_Id = ?");

		$facultyid = 2;//Panel Chair
		if(!$stmt->bind_param("ddd", $panelchair, $groupid, $facultyid))
			die("error binding parameters");



		$stmt->execute();
		$stmt->close();

		//Delete Current Panels
		$facultyid = 3;//Panelists
		$del_stmt = $connection->prepare("DELETE FROM Faculty_Assignment WHERE Group_Id = ? AND Faculty_Type_Id = ?");

		if(!$del_stmt->bind_param("dd", $groupid, $facultyid))
			die("error binding parameters");

		$del_stmt->execute();
		$del_stmt->close();

		//Insert new panels
		$ins_stmt = $connection->prepare("INSERT INTO  Faculty_Assignment (Group_Id, Account_Id, Faculty_Type_Id) VALUES (?,?,?)");

		foreach($panelists as $p){
			if(!$ins_stmt->bind_param("ddd", $groupid,$p, $facultyid)){
				die("error binding insert parameters");
			}
			$ins_stmt->execute();
			if($ins_stmt->affected_rows == 0)
				die("not inserted to db");
		}

		$ins_stmt->close();
		

		$success = true;
		$connection->close();

		return $success;
	}

	public static function DeleteGroup($groupid){
		
		$connection = new mysqli(self::$server, self::$s_username, self::$s_pass, self::$dbName);

		if($connection->connect_error)
			die($connection->connect_error);

		//Delete Members
		$mem_stmt = $connection->prepare("DELETE FROM Students WHERE Group_Id = ?");
		$mem_stmt->bind_param('d', $groupid);
		$mem_stmt->execute();
		$mem_stmt->close();

		//Delete Panels, Adviser & Professor
		$fac_stmt = $connection->prepare("DELETE FROM Faculty_Assignment WHERE Group_Id = ?");
		$fac_stmt->bind_param('d', $groupid);
		$fac_stmt->execute();
		$fac_stmt->close();

		//Delete Group
		$grp_stmt = $connection->prepare("DELETE FROM Groups WHERE Id = ?");
		$grp_stmt->bind_param('d', $groupid);
		$grp_stmt->execute();
		$grp_stmt->close();

		return true;
	}

	public static function UpdateTitle($groupid, $new_title){
		$connection = new mysqli(self::$server, self::$s_username, self::$s_pass, self::$dbName);

		if($connection->connect_error)
			die($connection->connect_error);

		//Update Panel Chair
		$stmt = $connection->prepare("UPDATE Groups SET Thesis_Title = ? WHERE Id = ?");

		$facultyid = 2;//Panel Chair
		if(!$stmt->bind_param("sd", $new_title, $groupid))
			die("error binding parameters");

		$stmt->execute();

		return true;
	}
	//-----------------------------------GRADES-------------------------------------------
	public static function GetCriteria(){
		$connection = new mysqli(self::$server, self::$s_username, self::$s_pass, self::$dbName);

		if($connection->connect_error)
			die($connection->connect_error);

		$stmt = $connection->prepare("SELECT *  FROM Criteria");
		if ( false===$stmt ) {
		  die('prepare() failed: ' . htmlspecialchars($connection->error));
		}

		$rc = $stmt->execute();
		if ( false===$rc ) {
		  die('execute() failed: ' . htmlspecialchars($stmt->error));
		}

		$res = $stmt->get_result();

		if($res->num_rows > 0){
			$criteria = array();
			while($row = $res->fetch_assoc()){
				$id = $row['Id'];
				$title = $row['Title'];
				$descs = array();
				array_push($descs, $row['Beginner']);
				array_push($descs, $row['Acceptable']);
				array_push($descs, $row['Proficient']);
				array_push($descs, $row['Exemplary']);

				array_push($criteria, Criterion::Create($id, $title, $descs));
			}
			return $criteria;
		}
		else{
			return NULL;
		}

		$stmt->close();
		$connection->close();
	}
	public static function AddGrades($id, $groupId, $scores){
		$connection = new mysqli(self::$server, self::$s_username, self::$s_pass, self::$dbName);

		if($connection->connect_error)
			die($connection->connect_error);

		$stmt = $connection->prepare("INSERT INTO Grades (Criteria_Id, Group_Id, Panelist_Id, Grade) VALUES (?,?,?,?)");
		if(!$stmt){
			die("Error: ". $connection->error);
		}

		$scoreslength = count($scores);
		echo $scoreslength;
		for($x = 0; $x<$scoreslength; $x++){
			$criteriaId = $x+1;

			$stmt->bind_param('dddd', $criteriaId, $groupId, $id, $scores[$x]);
			$stmt->execute();
		}

		$stmt->close();
		$connection->close();	
		return true;
	}
}

?>