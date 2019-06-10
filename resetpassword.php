<?php


include('db_connection.php');

// Функция изменяет пароль пользователя на временный и отправляет письмо на почту с новым паролем
function reset_password($connect) {

    $message='';
    $hello_mes='';

    //Проверка что у 
    $query="SELECT email FROM users WHERE username= :username";
    $statement=$connect->prepare($query);
    $statement->execute(
        array(':username'=>$_POST["username"])
    );
    $count=$statement->fetchColumn();

    if ($count!='')
    {
        $temp_password='';
        $simv = array ("92", "83", "7", "66", "45", "4", "36", "22", "1", "0", 
                   "k", "l", "m", "n", "o", "p", "q", "1r", "3s", "a", "b", "c", "d", "5e", "f", "g", "h", "i", "j6", "t", "u", "v9", "w", "x5", "6y", "z5");
        
        for ($k = 0; $k < 8; $k++)
        {
          shuffle ($simv);
          $temp_password = $temp_password.$simv[1]; 
        }
        
        //Меняем пароль пользователя на временный
        $query="UPDATE users set `password` = :password WHERE username = :username";
        $statement=$connect->prepare($query);
        $statement->execute(
            array(':password' => password_hash($temp_password, PASSWORD_DEFAULT),
            ':username' => $_POST["username"])
        );
        $result=$statement->rowCount();

        if($result==1)
        {

            $query="SELECT email, perconname FROM users WHERE username = :username";
            $statement=$connect->prepare($query);
            $statement->execute(
                array(':username' => $_POST["username"])
            );
            $result=$statement->fetchAll();
            if($result!='')
            {
                foreach($result as $row)
                {
                    $email = $row['email'];
                    $perconname = $row['perconname'];                    
                }
                $hello_mes .="Добрый день, ".$perconname.". Для вашей учетной записи был запрошен сброс пароля. \r\n";
                $hello_mes .="Ваш временный пароль: ".$temp_password.". \r\n"; 
                $hello_mes .="Пожалуйста, используйте этот пароль для доступа к аккаунту Nutshell. В дальнейшем, Вы сможете изменить пароль в настройках учетной записи Nutshell.";
                
                mail($email, 'Восстановление пароля', $hello_mes, 'From: nutshellkrow88@gmail.com');

                $message='<label class="text-success">На Ваш e-mail отправлено письмо с временным паролем.</label>';
            }
            else $message='<label class="text-danger">Произошла ошибка 2. Пожалуйста, попробуйте еще раз.</label>';
        }
        else $message='<label class="text-danger">Произошла ошибка 1. Пожалуйста, попробуйте еще раз. </label>';        
    }
    else $message='<label class="text-danger">Пользователь не найден, либо не указан e-mail! Пожалуйста, зарегистрируйте новый аккаунт.</label>';    
echo $message;
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
       <h3>Воостановление пароля</h3>
       <br>
       <p class="text-danger">
           <?php 
            if(isset($_POST["resetpass"]))
            {
                reset_password($connect);    
            } 
            ?>
        </p>
        <form class="login-form" method="post">
         <label for="username" style="text-align:left">Имя пользователя</label>
          <input type="text" class="form-control" name="username" required/>           
          <button type="submit" name="resetpass" class="log-btn">Отправить новый пароль</button>     
          <p class="message"><a href="login.php">На главную</a></p>       
        </form>
      </div>       
   </div>   
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>