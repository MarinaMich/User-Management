<?php
require_once '../init.php';
require_once '../authorization.php';

if(!$admin) {
    Redirect::to('../index.php');
} 
$id = $user->data()->id;
if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validate->check($_POST, [
            'user_name' => [
                'required' => true,
                'min' => 2
            ],
            'email' => [
                'required' => true,
                'email' => true
            ],
            'status' =>['max' => 200]
        ]);

        if($validate->passed()) {
            $user->update([
                'user_name' => Input::get('user_name'),
                'email' => Input::get('email'),
                'status' => Input::get('status')
            ], $id);
        
            Session::flash('success', 'Профиль обновлен');

            return Redirect::to('edit.php?id='. $id);
              
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
                    <a class="nav-link" href="../index.php">Главная</a>
                </li>
                <?php if($admin): ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Управление пользователями</a>
                </li>
                <?php endif;?>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="profile.html" class="nav-link">Профиль</a>
                  </li>
                <li class="nav-item">
                    <a href="../logout.php" class="nav-link">Выйти</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1>Профиль пользователя - <?php echo $user->data()->user_name;?></h1>
                <?php if (Session::exists('success') == true) : ?>
                <div class="alert alert-success">
                    <?php echo Session::flash('success'); ?>
                </div>
                <?php endif;?>
                <?php if(isset($errors)): ?>
                    <div class="alert alert-danger">
                        <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach;?>  
                        </ul>
                    </div>
                <?php endif;?>
                        
                <form action="" method="post" class="form">
                    <div class="form-group">
                        <label for="username">Имя</label>
                        <input type="text" name="user_name" id="username" class="form-control" value="<?php echo $user->data()->user_name;?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?php echo $user->data()->email;?>">
                    </div>
                    <div class="form-group">
                        <label for="status">Статус</label>
                        <input type="text" name="status" id="status" class="form-control" value="<?php echo $user->data()->status;?>">
                    </div>
                    <input type="hidden" name="token" value="<?php echo Token::generate();?>">

                    <div class="form-group">
                        <button class="btn btn-warning" type="submit" >Обновить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>