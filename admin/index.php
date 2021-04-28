<?php
require_once '../init.php';
require_once '../authorization.php';

if(!$admin) {
    Redirect::to('../index.php');
} 
$user = new User;

$users = $user->get_users();

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Users</title>
    	
    	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <!-- Bootstrap core CSS -->
    	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Custom styles for this template -->
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">User Management</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Управление пользователями</a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="../user_profile.php?id=<? echo $user->data()->id;?>" class="nav-link">Привет, <?php echo $user->data()->user_name;?></a>
                    </li>
                    <li class="nav-item">
                        <a href="../logout.php" class="nav-link">Выйти</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container">
            <div class="col-md-12">
                <h1>Пользователи</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Email</th>
                            <th>Действия</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($users as $items=>$item): ?>
                        <tr>
                            <td><?php echo $item->id;?></td>
                            <td><?php echo $item->user_name;?></td>
                            <td><?php echo $item->email;?></td>
                            <td>
                                <?php if($item->group_id == 1) : ?>
                              	<a href="give_group.php?id=<? echo $item->id;?>" class="btn btn-success">Назначить администратором</a>
                                <?php else:?>
                                <a href="give_group.php?id=<? echo $item->id;?>" class="btn btn-danger">Разжаловать</a>
                                <?php endif;?>
                                <a href="../user_profile.php?id=<? echo $item->id;?>" class="btn btn-info">Посмотреть</a>
                                <a href="edit.php?id=<? echo $item->id;?>" class="btn btn-warning">Редактировать</a>
                                <a href="delete_user.php?id=<? echo $item->id;?>" class="btn btn-danger" onclick="return confirm('Вы уверены?');">Удалить</a>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>  
    </body>
</html>
