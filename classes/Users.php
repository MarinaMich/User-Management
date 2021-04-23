<?php

require_once 'User.php';

class Users extends User {
	private $db, $data_users;

	public function __construct() {
		$this->db = Database::getInstance();
		var_dump($this->$db);
		exit;
		//$this->find();
	}
	
	//проба вывода всех пользователей
	public function find() {
		//$this->$data_users = $this->db->get('users', ['id', '>=', 1]);
		
		//if($this->$data_users) {
			//return true;
		//}
		//return false;
	}

	/* получение значения $data_users
		Return value: $this
	*/
	public function data_users() {
		//return $this->$data_users;
	}

}