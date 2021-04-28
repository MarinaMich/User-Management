<?php
require_once '../init.php';
require_once '../authorization.php';

$id = $user->data()->id;

if($user->hasPermissions('admin')) {
	$user->update(['group_id' => 1], $id);
	Redirect::to('index.php');
} else {
	$user->update(['group_id' => 2], $id);
	Redirect::to('index.php');
}
