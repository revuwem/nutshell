<?php
include('db_connection.php');
session_start();
//Если пользователь не авторизован - перенаправляем на страницу авторизации
if(!isset($_SESSION['user_id']))
{
    header("location:login.php");
}
?>
<!doctype html>
<html lang="ru">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">  
    <title>Nutshell</title>
    <!--Bootstrap-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!--Custom styles-->
    
    <!--Font Awesome-->
    <link rel="stylesheet" href="icons/font-awesome-4.7.0/css/font-awesome.min.css">
  </head>
  <body>          
    <header class="nav">
        <div class="container-fluid">
            <div class="row">
                <div class="col-9 text-center">
                    <h4 class="head-text">Nutshell</h4>
                </div>
                <div class="d-flex col-3 navbar justify-content-center"> 
                    <ul class="nav dropdown">
                        <li class="nav-item"><img src="icons/sidebar/users.png" alt="" width="30em"></li>
                        <li class="nav-item dropdown">                            
                            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                                <?php echo $_SESSION['username'] ?>                              
                            </a>
                            <div class="container dropdown-menu">
                                <a href="#" class="dropdown-item">Профиль</a>
                                <a href="logout.php" class="dropdown-item">Выйти</a>                       
                            </div>
                        </li>
                    </ul> 
                </div> 
            </div>    
        </div>
    </header>
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>