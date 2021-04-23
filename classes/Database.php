<?php

class Database {
	private static $instance = null;
	private $pdo, $stmt, $error = false, $results, $count;

	private function __construct() {
		try {
			$this->pdo = new PDO("mysql:host=" . Config::get('mysql.host') . ";dbname=" . Config::get('mysql.database'), Config::get('mysql.username'), Config::get('mysql.password'));
		} catch (PDOException $e) {
			echo 'Невозможно установить соединение с базой данных:' . $e->getMessage();
		}
	}
	//в этом методе созданный объект класса записывается в свойство этого же класса
	public static function getInstance() {
		if (!isset(self::$instance)){
			self::$instance = new Database;
		}
		return self::$instance;
	}
	
	/* создание sql-запроса
		string - $sql
		array - $params
		Return value: $this
	*/
	public function query($sql, $params = []) {
		$this->error = false;
		$this->stmt = $this->pdo->prepare($sql);

		if(count($params)) {
			$i = 1;
			foreach ($params as $param) {
				$this->stmt->bindValue($i, $param);
				$i++;
			}
		}
		if(!$this->stmt->execute()) {
			$this->error = true;
			echo 'У вас ошибка в sql-запросе';
		}
		$this->results = $this->stmt->fetchAll(PDO::FETCH_OBJ);
		$this->count = $this->stmt->rowCount();
		return $this;
	}

	public function error() {
		return $this->error;
	}

	public function results() {
		return $this->results;
	}

	public function count() {
		return $this->count;
	}

	/* метод для составления запросов к БД через action на выбор SELECT* или DELETE
		string - $action
		string - $table
		array - $where
	   Return value: $this
	*/ 
	public function action($action, $table, $where = []) {
		if(count($where) === 3) {
			$operators = ['=', '<', '>', '<=','>='];
			$field = $where[0];
			$operator = $where[1];
			$value = $where[2];
			//in_array -- Проверить, присутствует ли в массиве нужное значение
			if(in_array($operator, $operators)) {
				$sql = "{$action} FROM `{$table}` WHERE {$field} {$operator} ?";
				if(!$this->query($sql, [$value])->error()) {
					return $this;
				}
			} else {
				echo 'у вас использован не верный оператор';
			}
		} 
		return false;
		echo 'количество членов массива не равно 3';
	}

	/* получени данных из БД без sql в обработчике 
		string - $table
		array - $where
		Return value: $this
	*/
	public function get($table, $where = []) {
		return $this->action('SELECT *', $table, $where);
	}

	/* удаление данных из БД без sql в обработчике 
		string - $table
		array - $where
		Return value: $this
	*/
	public function delete($table, $where = []) {
		return $this->action('DELETE', $table, $where);
	}

	/* добавление данных в БД  
		string - $table
		array - $fields
		Return value: boolean
	*/
	public function insert($table, $fields = [])
	{
		$values = '';
		foreach ($fields as $field) {
			$values .= "?,";
		}
		//удаляем запятую из конца строки
		$values =rtrim($values, ',');
		// implode()объединяет элементы массива в строку
		// array_keys() - Выбрать все ключи массива
		$sql = "INSERT INTO {$table} (`" . implode('` , `' ,array_keys($fields)) . "`) VALUES (" . $values . ")"; //или ({$values})
		
		if(!$this->query($sql, $fields)->error()){
			return true;
		}
		return false;
	}

	/* обновление данных в БД  
		string - $table
		string - $id
		array - $fields
		Return value: boolean
	*/
	public function update($table, $id, $fields = []) {
		$set = '';
		foreach ($fields as $key => $field) {
			$set .= "$key = ?,";
		}

		$set = rtrim($set, ',');
		$sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

		if(!$this->query($sql, $fields)->error()) {
			return true;
		}
		return false;
	}

	//для выбора из массива, полученного в results(), первого массива с данными 
	public function first()
	{
		return $this->results()[0];
	}	

}