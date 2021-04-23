<?php 

class Session {
	//запись в сессию
	public static function put($name, $value) {
		return $_SESSION[$name] = $value;
	}

	//есть ли такая сессия
	public static function exists($name) {
		return (isset($_SESSION[$name]) ? true : false);
	}

	//удаляет сессию
	public static function delete($name) {
		if(self::exists($name)) {
			unset($_SESSION[$name]);
		}
	}

	//получение данных из сессии
	public static function get($name) {
		return $_SESSION[$name];
	}

	//создание flasch-сообщений
	public static function flash($name, $string = '') {
		if(self::exists($name) && self::get($name) !== '') {
			$session = self::get($name);
			self::delete($name);
			return $session;
		} else {
			self::put($name, $string);
		}
	}
}