<?php
require_once '../init.php';
require_once '../authorization.php';
 
$user->delete(['id', '=', $user->data()->id]);

Redirect::to('index.php');
