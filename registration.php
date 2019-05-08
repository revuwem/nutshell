<?php    
include('db_connection.php');  
session_start();

$message='';

if(isset($_SESSION['user_id']))
{
    header('location:index.php');
}

if(isset($_POST["createuser"]))
{
    $query="SELECT COUNT(*) FROM users WHERE username= :username";
    $statement=$connect->prepare($query);
    $statement->execute(
        array(':username'=>$_POST["username"])
    );
    $count=$statement->fetchColumn();
    if($count>0)
    {
        $message='<label>Логин должен быть уникальным!</label>';
    }
    else
    { 
        $query="INSERT INTO `users` (`user_id`, `username`, `password`, `name`, `surname`, `position`) 
                VALUES (NULL, :username, :password, :personname, :personsurname, :personposition);
                ";
        $statement=$connect->prepare($query);
        $statement->execute(
            array(
                ':username'=>$_POST["username"],
                ':password'=>password_hash($_POST["password"], PASSWORD_DEFAULT),
                'personname'=>$_POST["personname"],
                ':personsurname'=>$_POST["personsurname"],
                ':personposition'=>$_POST["personposition"]
            )
        );
        $result=$statement->rowCount();
        if($result<0)
        {
            $message='<label>Ошибка регистрации!</label>';
        }        
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Nutshell - Авторизация</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/loginform.css" rel="stylesheet">   
  </head>
 
  <body>
   <div class="frame">
      <div class="form">
       <h3>Регистрация</h3>
       <p class="text-danger"><?php echo $message; ?></p>
       <p>Укажите информацию о себе</p>     
        <form class="login-form" method="post">
        <label for="personname" style="text-align:left">Имя</label>
          <input type="text" class="form-control" name="personname" required/>
        <label for="personsurname" style="text-align:left">Фамилия</label>
          <input type="text" class="form-control" name="personsurname" required/>
          <label for="personposition" style="text-align:left">Должность</label>
          <input type="text" class="form-control" name="personposition" required/>          
         <label for="username" style="text-align:left">Логин</label>
          <input type="text" class="form-control" name="username" placeholder="логин" required/>
           <label for="password">Пароль</label>
          <input type="password" class="form-control" name="password" placeholder="пароль" required/>
          <br>
          <button type="submit" name="createuser" class="log-btn">Создать аккаунт</button>          
        </form>
      </div>       
   </div>   
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>