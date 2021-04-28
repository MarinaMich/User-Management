<?php
require_once 'init.php';

if(Input::exists()) {
  if(Token::check(Input::get('token'))) {
  
    $validate = new Validate();

    $validate->check($_POST, [
        
      'email' => [
        'required' => true,
        'email' => true,
      ],
      'password' => [
        'required' => true,
      ]
    ]);
    //если валидация прошла
    if($validate->passed()){

      $user = new User;
      $remember = (Input::get('remember')) === 'on' ? true : false;
      $login = $user->login(Input::get('email'), Input::get('password'), $remember);

      if($login) {
        Redirect::to('index.php');
        
      } else {
        Session::flash('danger', 'Логин или пароль не верны');
      }

    //если  валидация не прошла - выводим список ошибок
    } else {
      $errors = $validate->errors();
    }
  }      
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form action="" method="post" class="form-signin">
    	  <img class="mb-4" src="images/apple-touch-icon.png" alt="" width="72" height="72">
    	  <h1 class="h3 mb-3 font-weight-normal">Авторизация</h1>
        <?php if(isset($errors)): ?>
          <div class="alert alert-danger">
            <ul>
              <?php foreach ($errors as $error):?>
                <li><?php echo $error;?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <?php if(Session::exists('success') == true):?>
            <div class="alert alert-success">
                <?php echo Session::flash('success');?>
            </div>
        <?php endif;?>
        
        <?php if(Session::flash('danger')): ?>
            <div class="alert alert-danger">
              <?php echo Session::flash('danger');?>
            </div>
        <?php endif;?> 

        <!--<div class="alert alert-info">
          Логин или пароль неверны
        </div> -->

    	  <div class="form-group">
          <input type="email" name="email" class="form-control" placeholder="Email">
        </div>
        <div class="form-group">
          <input type="password" name="password" class="form-control" placeholder="Пароль">
        </div>
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    	  <div class="checkbox mb-3">
    	    <label>
            <input type="checkbox" name="remember"> Запомнить меня
    	    </label>
    	  </div>
    	  <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
    	  <p class="mt-5 mb-3 text-muted">&copy; 2017-2020</p>
    </form>
</body>
</html>
