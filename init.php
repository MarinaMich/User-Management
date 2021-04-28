<?php
session_start();

require_once 'classes/Database.php';
require_once 'classes/Config.php';
require_once 'classes/Validate.php';
require_once 'classes/Input.php';
require_once 'classes/Token.php';
require_once 'classes/Session.php';
require_once 'classes/User.php';
require_once 'classes/Redirect.php';
require_once 'classes/Cookie.php';

$GLOBALS['config'] = [
	'mysql' => [
		'host' => 'localhost',
		'database' => 's_marlin',
		'username' => 'root',
		'password' => 'mysql'
	],
	'session' => [
		'token_name' => 'token',
		'session_user' => 'user'
	],
	'cookie' => [
		'cookie_name' => 'hash',
		'cookie_expiry' => 604800
	]
];

if(Cookie::exists(Config::get('cookie.cookie_name')) && !Session::exists(Config::get('session.session_user'))) {
	$hash = Cookie::get(Config::get('cookie.cookie_name'));
	$hashCheck = Database::getInstance()->get('user_cookie', ['hash', '=', $hash]);

	if($hashCheck->count()) {
		$user = new User($hashCheck->first()->user_id);
		$user->login();
	}
}
