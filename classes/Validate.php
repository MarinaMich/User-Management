<?php

class Validate {
	private $passed = false, $errors = [], $db = null;

	public function __construct(){
		$this->db = Database::getInstance();
	}
// в $source содержатся данные из глобального массива $_POST
// в $items идет массив правил валидации
	public function check($source, $items = []){
		foreach ($items as $item => $rules) {
			foreach ($rules as $rule => $rule_value) {
				//получаем значение input из формы
				//$_POST['user_name']
				$value = $source[$item];
//проверка на обязательность заполнения
				if($rule == 'required' && empty($value)){
					$this->addError("{$item} is required");
//если не пустая переменная (поля заполнены)					
				} else if(!empty($value)) {
					switch ($rule) {
						case 'min':
							if(strlen($value) < $rule_value){
								$this->addError("{$item} должно быть минимум {$rule_value} символов.");
							}
						break;
						case 'max':
							if(strlen($value) > $rule_value){
								$this->addError("{$item} должно быть максимум {$rule_value} символов.");
							}
						break;
						case 'matches':
							if($value != $source[$rule_value] ){
								$this->addError("{$rule_value} должно совпадать с {$item}");
							}
						break;
						//case 'unique':
						//	$check = $this->db->get($rule_value, [$item, '=', $value]);
							//возвращаем количество результатов поиска из БД - сколько пользователей с таким именем
						//	if($check->count()){
						//		$this->addError("{$item} уже существует");
						//	}
						//break;
						case 'email':
							if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
								$this->addError("{$item} неверный формат email");
							}
						break;
					}
				}
			}
		}

		if(empty($this->errors)){
		$this->passed = true;
		}
		return $this;
	}


//записывает ошибки в массив $errors[]
	public function addError($error){
		$this->errors[] = $error;
	}
// возвращает массив, возникщих при валидации ошибок
	public function errors(){
		return $this->errors;
	}
// возвращает значение $passed
	public function passed(){
		return $this->passed;
	}
}