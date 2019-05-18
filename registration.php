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
        $message='<label class="text-danger">Имя пользователя должно быть уникальным!</label>';
    }
    else
    {
      $query="SELECT COUNT(*) FROM users WHERE email= :email";
      $statement=$connect->prepare($query);
      $statement->execute(
          array(':email'=>$_POST["email"])
      );
      $count=$statement->fetchColumn();
      if($count>0)
      {
          $message='<label class="text-danger">E-mail должен быть уникальным!</label>';
      }
      else
      {
          $query="INSERT INTO `users` (`user_id`, `username`, `password`, `firstname`, `lastname`, `position`, `email`) 
                  VALUES (NULL, :username, :password, :personname, :personsurname, :personposition, :email);
          ";
          $statement=$connect->prepare($query);
          $statement->execute(
              array(
                  ':username'=>$_POST["username"],
                  ':password'=>password_hash($_POST["password"], PASSWORD_DEFAULT),
                  'personname'=>$_POST["personname"],
                  ':personsurname'=>$_POST["personsurname"],
                  ':personposition'=>$_POST["personposition"],
                  ':email' => $_POST["email"]
              )
          );
          $result=$statement->rowCount();
          //Если $result==0 - запись не удалось добавить, иначе авторизуем нового пользователя
          if($result==0)
          {
              $message='<label>Ошибка регистрации!</label>';
          }
          else{
              $query="SELECT user_id FROM users WHERE username = :username";
              $statement=$connect->prepare($query);
              $statement->execute(
                array(':username'=>$_POST["username"])
              );
              $result=$statement->fetchAll();
              foreach($result as $row)
              {
                $_SESSION['user_id']=$row['user_id'];
                $_SESSION['username']=$_POST["username"];
                $sub_query="INSERT INTO login_details(user_id) VALUES ('".$row['user_id']."')";
                $statement=$connect->prepare($sub_query);
                $statement->execute();
                $_SESSION['login_details_id']=$connect->lastInsertId();
                header("location:index.php");
              }
          } 
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
    <title>Nutshell - Регистрация</title>

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
        <form class="login-form" method="post" autocomplete="off">
        <input style="display:none">
        <input type="password" style="display:none">
        <label for="personname" style="text-align:left">Имя</label>
          <input type="text" class="form-control" name="personname" required autocomplete="off"/>
          <label for="personsurname" style="text-align:left">Фамилия</label>
          <input type="text" class="form-control" name="personsurname" required autocomplete="off"/>
          <label for="personposition" style="text-align:left">Должность</label>
          <input type="text" class="form-control" name="personposition" required autocomplete="off"/>
          <label for="personposition" style="text-align:left">E-mail</label>
          <input type="email" class="form-control" name="email" required autocomplete="off"/>  
          <label for="username" style="text-align:left">Имя пользователя</label>
          <input type="text" class="form-control" name="username" value="" style="display:none" autocomplete="on"/>          
          <input type="text" class="form-control" name="username" value="" onfocus="this.removeAttribute('readonly');" readonly placeholder="Уникальное имя пользователя, e-mail или телефон" required autocomplete="off"/>          
          <label for="password">Пароль</label>
          <input type="password" class="form-control" name="non-password" value="" style="display:none" autocomplete="on"/>  
          <input type="password" class="form-control" name="password" id="password" value="" onkeyup="checkPassUpdate(); return false;" style="display:block" onfocus="this.removeAttribute('readonly');" readonly placeholder="Пароль должен содержать не менее 8 символов" required autocomplete="off"/>
          <label for="confirmpassword">Подтверждение пароля</label>
          <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Подтвердите новый пароль" onkeyup="checkPassUpdate(); return false;">                               
          <br> <div class="confirm-password-valid"></div> <br>
          <br>
          <button type="submit" name="createuser" class="log-btn">Создать аккаунт</button><br>
          <p class="message"><a href="login.php">На главную</a></p>         
        </form>
      </div>       
   </div>   
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script>
    //Валидация пароля
        function checkPassUpdate(){  
          var psw1 = document.getElementById('password');
          var psw2 = document.getElementById('confirmpassword');
          var message = document.getElementById('confirm-password-valid');
          var errorColor = "#FFC5B8";
          var successColor = "#CDFFC7";
          if (psw1.value.length>7)
          {
            psw1.style.backgroundColor=successColor;
          }
          else{
            psw1.style.backgroundColor=errorColor;
            message.style.color=errorColor;
            message.innerHTML =" Длина пароля должна быть не менее 8 символов!"
            return;
          }
          if(psw1.value==psw2.value)
          {
            psw2.style.backgroundColor=successColor;
          }
          else{
            psw2.style.backgroundColor=errorColor;
            message.style.color=successColor;
            message.innerHTML=" Введеные пароли не совпадают!"
          }
        };
  
    </script>
  </body>
</html>