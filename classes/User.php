<?php

class User {
	private $db, $data, $session_name, $isLoggedIn, $cookieName;

	public function __construct($user = null) {
		$this->db = Database::getInstance();
		$this->session_name = Config::get('session.session_user');
		$this->cookieName = Config::get('cookie.cookie_name');

		if(!$user) {
			if(Session::exists($this->session_name)) {
				$user = Session::get($this->session_name);

				if($this->find($user)) {
					$this->isLoggedIn = true;

				} else {

				}
			}
		} else {
			$this->find($user);
		}
	}

	public function create($fields = []) {
		$this->db->insert('users', $fields);
	}

	/* вход на сайт зарегистрированного пользователя
		string - $email
		string - $password
		Return value: boolean
	*/
	public function login($email = null, $password = null, $remember = false) {
		if(!$email && !$password && $this->exists()) {
			Session::put($this->session_name, $this->data()->id);
		} else {
			$user = $this->find($email);
			if($user) {
				if(password_verify($password, $this->data()->password)) {
				Session::put($this->session_name, $this->data()->id);
					if($remember) {
						$hash = hash('sha256', uniqid());
						$hashCheck = $this->db->get('user_cookie', ['user_id', '=', $this->data()->id]);
						if(!$hashCheck->count()) {
							$this->db->insert('user_cookie', [
								'user_id'=> $this->data()->id,
								'hash' => $hash,
							]);
						} else {
							$hash = $hashCheck->first()->hash;
						}
						Cookie::put($this->cookieName, $hash, Config::get('cookie.cookie_expiry'));
					}
				return true;
				}
			}
		}
		return false;
	}

	/* поиск по email или id
		string - $email
		Return value: boolean
	*/
	public function find($value = null) {
		if(is_numeric($value)) {
			$this->data = $this->db->get('users',['id', '=', $value])->first();
		} else {
			$this->data = $this->db->get('users',['email', '=', $value])->first();
		} 
		
		if($this->data) {
			return true;
		}
		
		return false;
	}

	/* получение значения $data
		Return value: $this
	*/
	public function data() {
		return $this->data;
	}

	/* существует или нет в БД данные
	*/
	public function exists() {
		return (!empty($this->data())) ? true : false;
	}

	/* залогиненен пользователь или нет
		Return value: boolean
	*/
	public function isLoggedIn() {
		return $this->isLoggedIn;
	}
	/* вывод всех пользователей из БД
		Return value: array
	*/
	function get_users(){
		$sql = "SELECT * FROM users";
		if($this->db->query($sql)) {
			return $this->db->results();
		}
	}

	/* выход
	*/
	public function logout() {
		$this->db->delete('users_cookie', ['user_id', '=', $this->data()->id]);
		Session::delete($this->session_name);
		Cookie::delete($this->cookieName);
	}

	/* изменение имени и статуса пользователя
		array - $fields
		int - $id
		Return value: boolean
	*/	
	public function update($fields = [],$id = null) {
		if(!$id && $this->isLoggedIn()) {
			$id = $this->data()->id;
		}
		$this->db->update('users', $id, $fields);
	}

	/* проверка групп - админ или пользователь
	    string - $key
	    Return value: boolean
	*/
	public function hasPermissions($key=null) {
		if($key) {
			$group = $this->db->get('groups', ['id', '=', $this->data()->group_id]);
			if($group->count()) {
				$permissions = $group->first()->permissions;
				$permissions = json_decode($permissions, true);

				if($permissions[$key]) {
					return true;
				}
			}
		}
		return false;
	}
}

