<?php   

// Скрипт реализовывает авторизацию пользователя, при успешной авторизации создается пользовательская сессия
include('db_connection.php');  
session_start();
    
    
    $message='';
   
    if(isset($_SESSION['user_id']))
    {
        header('location:index.php');
    }
    
    if(isset($_POST['login']))
    {
        //Проверка на существование пользователя с указанным логином
        $query="SELECT count(*) FROM users WHERE username= :username";
        $statement=$connect->prepare($query);
        $statement->execute(
            array(':username'=>$_POST["username"])
        );
        $count=$statement->fetchColumn();
        if ($count>0)
        {
            //Выборка данных о пользователе с указанным логином
            $query="SELECT * FROM users WHERE username= :username";
            $statement=$connect->prepare($query);
            $statement->execute(
                array(':username'=>$_POST["username"])
            );
            $result = $statement->fetchAll();
            foreach($result as $row)
            {             
                if(password_verify($_POST["password"], $row["password"]))
                {
                    $_SESSION['user_id']=$row['user_id'];
                    $_SESSION['username']=$row['username'];
                    $sub_query="INSERT INTO login_details(user_id) VALUES ('".$row['user_id']."')";
                    $statement=$connect->prepare($sub_query);
                    $statement->execute();
                    $_SESSION['login_details_id']=$connect->lastInsertId();
                    header("location:index.php");
                }
                else
                {
                    $message= "<label>Неверный пароль! Попробуйте еще раз.</label>";
                }
            }
        }
        else 
        {
            $message= "<label>Неверный логин! Попробуйте еще раз.</label>";
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
   <div class="login">
      <div class="form">
       <h3>Авторизация</h3>
       <br>
       <p class="text-danger"><?php echo $message; ?></p>
        <form class="login-form" method="post">
         <label for="username" style="text-align:left">Имя пользователя</label>
          <input type="text" class="form-control" name="username" placeholder="логин" required/>
           <label for="password">Пароль</label>
          <input type="password" class="form-control" name="password" placeholder="пароль" required/>
          <button type="submit" name="login" class="log-btn">Войти</button>
          <p class="message">Не зарегистрированы? <a href="registration.php">Создайте аккаунт</a></p>
          <p class="message">Забыли пароль? <a href="resetpassword.php">Восстановите пароль</a></p>
        </form>
      </div>       
   </div>   
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>