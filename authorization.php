<?php
require_once 'init.php';
//получаем id конкретного пользователя при переходе по ссылке из списка пользователей
$id_profile = $_GET['id'];
$user = new User;
if(!$user->isLoggedIn()) {
    Redirect::to('login.php');
}
//проверяем залогиненый пользователь админ или нет
$admin = $user->hasPermissions('admin');
//получаем id залогиненого пользователя
$user_login = $user->data()->id;
//по id профиля находим в БД нужного пользователя
$user->find($id_profile);
//получаем его данные для вывода на страницу
$user_profile = $user->data();