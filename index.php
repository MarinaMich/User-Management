<?php 
require_once 'init.php';

$user = new User;

$users = $user->get_users();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
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
            <a class="nav-link" href="index.php">Главная</a>
          </li>
        </ul>
        <?php if($user->isLoggedIn()): ?>
          <ul class="navbar-nav">
            <li class="nav-item">
              <a href="user_profile.php?id=<? echo $user->data()->id;?>" class="nav-link">Привет, <?php echo $user->data()->user_name;?></a>
            </li>
            <li class="nav-item">
              <a href="logout.php" class="nav-link">Выйти</a>
            </li>
          </ul>
        <?php else:?>
          <ul class="navbar-nav">
            <li class="nav-item">
              <a href="login.php" class="nav-link">Войти</a>
            </li>
            <li class="nav-item">
              <a href="register.php" class="nav-link">Регистрация</a>
            </li>
          </ul>
        <?php endif;?>
      </div>
    </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="jumbotron">
          <h1 class="display-4">Привет, мир!</h1>
          <p class="lead">Это дипломный проект по разработке на PHP. На этой странице список наших пользователей.</p>
          <hr class="my-4">
          <?php if(!$user->isLoggedIn()): ?>
          <p>Чтобы стать частью нашего проекта вы можете пройти регистрацию.</p>
          <a class="btn btn-primary btn-lg" href="register.php" role="button">Зарегистрироваться</a>
        <?php endif;?>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <h1>Пользователи</h1>
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Имя</th>
              <th>Email</th>
              <th>Статус</th>
            </tr>
          </thead>

          <tbody>
            <?php foreach ($users as $items=>$item): ?>
            <tr>
              <td><?php echo $item->id;?> </td>
              <td><a href="user_profile.php?id=<? echo $item->id;?>"><?php echo $item->user_name;?></a></td>
              <td><?php echo $item->email;?></td>
              <td><?php echo $item->status;?></td>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>