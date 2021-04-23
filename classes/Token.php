<?php

class Token {
	public static function generate() {
		//uniqid() - генерирует уникальный ID
		return Session::put(Config::get('session.token_name'), md5(uniqid()));
	}

//$token - получаем из формы
	public static function check($token) {
		$tokenName = config::get('session.token_name');

		if(Session::exists($tokenName) && $token == Session::get($tokenName)) {
			Session::delete($tokenName);
			return true;
		}
		return false;
	}
}