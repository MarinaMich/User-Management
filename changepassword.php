<?php 
require_once 'init.php';
require_once 'authorization.php';

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
        $validate = new Validate;
        $validate->check($_POST, [
            'current_password' => [
                'required' => true,
                'min' => 3
            ],
            'new_password' => [
                'required' => true,
                'min' => 3
            ],
            'new_password_agein' => [
                'required' => true,
                'min' => 3,
                'matches' => 'new_password'
            ],
        ]);

        if($validate->passed()) {
            if(password_verify(Input::get('current_password'),$user->data()->password)) {
                $user->update(['password' => password_hash(Input::get('new_password'), PASSWORD_DEFAULT)]);
                Session::flash('success', 'Пароль обновлен');
            } else {
                Session::flash('danger', 'Ошибка валидации - старый пароль не верный!');
            }
        } else {
           $errors = $validate->errors();
        }
    }
}

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
                <!-- если в профиль зашел собственник профиля-->
                <?php if($user_login === $id_profile) :?>
                <li class="nav-item">
                    <a class="nav-link" href="changepassword.php?id=<?php echo $user->data()->id;?>">Изменить пароль</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php?id=<?php echo $user->data()->id;?>">Изменить профиль</a>
                </li>
                <?php endif;?>
            </ul>

            <ul class="navbar-nav">
                <?php if($user->isLoggedIn()): ?>
                <li class="nav-item">
                    <a href="user_profile.php?id=<? echo $user->data()->id;?>" class="nav-link">Привет, <?php echo $user->data()->user_name;?></a>
                </li>
                <?php endif;?>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link">Выйти</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1>Изменить пароль</h1>

                <?php if(Session::exists('success') == true): ?>
                <div class="alert alert-success"><?php echo Session::flash('success');?></div>
                <?php endif;?>
                <?php if(Session::flash('danger')): ?>
                <div class="alert alert-danger"><?php echo Session::flash('danger');?></div>
                <?php endif;?>
               
                <?php if(isset($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif;?>
                
                <form action="" method="post" class="form">
                    <div class="form-group">
                        <label for="current_password">Текущий пароль</label>
                        <input type="password" name="current_password" id="current_password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="current_password">Новый пароль</label>
                        <input type="password" name="new_password" id="current_password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="current_password">Повторите новый пароль</label>
                        <input type="password" name="new_password_agein" id="current_password" class="form-control">
                    </div>
                    <input type="hidden" name="token" value="<?php echo Token::generate();?>">
                    <div class="form-group">
                        <button class="btn btn-warning">Изменить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>