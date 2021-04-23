<?php

require_once 'init.php';

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
  
        $validate = new Validate();

        $validation = $validate->check($_POST, [
            'user_name' => [
                'required' => true,
                'min' => 2,
                //'max' => 10,
            
            ],
            'email' => [
                'required' => true,
                'email' => true,
                //email должен быть уникальным в таблице users и поэтому ошибка - имя занято
                'unique' => 'users'
            ],
            'password' => [
                'required' => true,
                'min' => 3
            ],
            'password_again' => [
                'required' => true,
                //password_again должен совпадать с значением поля password
                'matches' => 'password'
            ]
        ]);
        
        if($validation->passed()){
            $user = new User;
            $user->create([
                'email' => Input::get('email'),
                'password' => password_hash(Input::get('password'),PASSWORD_DEFAULT),
                'user_name' => Input::get('user_name'),
                'date_reg' => time()
                
            ]);
                Session::flash('success','Регистрация пройдена'); 
                Redirect::to('login.php');
        } else {
            $errors = $validation->errors();
        } 
    }      
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register</title>
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form action="" method="post" class="form-signin">
    	<img class="mb-4" src="images/apple-touch-icon.png" alt="" width="72" height="72">
    	<h1 class="h3 mb-3 font-weight-normal">Регистрация</h1>
        <?php if(isset($errors)):?>
            <div class="alert alert-danger">
              <ul>
                <?php foreach ($errors as $error):?>
                  <li><?php echo $error;?></li>
                <?php endforeach; ?>
              </ul>
            </div>
        <?php endif;?>    
        
           
        <div class="alert alert-info">
          Информация
        </div>

    	<div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo Input::get('email') ?>">
        </div>
        <div class="form-group">
            <input type="text" name="user_name" class="form-control" placeholder="Ваше имя" value="<?php echo Input::get('user_name') ?>">
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control"placeholder="Пароль">
        </div>
        
        <div class="form-group">
            <input type="password" name="password_again" class="form-control" placeholder="Повторите пароль">
        </div>

        <input type="hidden" name="token" value="<?php echo Token::generate();?>">
    	<div class="checkbox mb-3">
    	    <label>
    	       <input type="checkbox"> Согласен со всеми правилами
    	    </label>
    	</div>
    	<button class="btn btn-lg btn-primary btn-block" type="submit">Зарегистрироваться</button>
    	<p class="mt-5 mb-3 text-muted">&copy; 2017-2020</p>
    </form>
</body>
</html>
