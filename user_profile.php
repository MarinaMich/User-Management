<?php
require_once 'init.php';
require_once 'authorization.php';

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
                <!-- если в профиль зашел админ или собственник профиля-->
                <?php if($admin === true || $user_login === $id_profile) :?>
                <li class="nav-item">
                    <a class="nav-link" href="changepassword.php?id=<?php echo $user->data()->id;?>">Изменить пароль</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php?id=<?php echo $user->data()->id;?>">Изменить профиль</a>
                </li>
                <?php endif;?>
            </ul>
            
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="logout.php" class="nav-link">Выйти</a>
                </li>
            </ul>
           
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Данные пользователя</h1>
            <table class="table">
                <thead>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Дата регистрации</th>
                    <th>Статус</th>
                </thead>

                <tbody>
                    <tr>
                        <td><?php echo $user_profile->id;?></td>
                        <td><?php echo $user_profile->user_name;?></td>
                        <td><?php echo date('d-m-Y', $user_profile->date_reg);?></td>
                        <td><?php echo $user_profile->status;?></td>
                    </tr>
                </tbody>
            </table>


            </div>
        </div>
    </div>
</body>
</html>