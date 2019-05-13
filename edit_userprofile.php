<?php
include('db_connection.php');
session_start();


function updateUserBasicInfo($message){
    $message='';
    if(!empty($_POST["inputUserName"]) && !empty($_POST["inputPersonFirstName"]) && !empty($_POST["inputPersonLastName"]) && !empty($_POST["inputUserPosition"]))
    {
        $newUsername=$_POST["inputUserName"];
        $newPersonFirstName=$_POST["inputPersonFirstName"];
        $newPersonLastName=$_POST["inputPersonLastName"];
        $newPosititon=$_POST["inputUserPosition"];

        //Проверка на дублирование имени пользователя
        $query="SELECT COUNT(*) FROM users WHERE username = :username and user_id = :user_id";
        $statement=$connect->prepare($query);
        $statement->execute(
            array(
                ':username' => $newUsername,
                ':user_id'  => $_SESSION["user_id"]
            )
        );
        $count=$statement->fetchAll();
        if($count=0)
        {
            try{        
                $query="UPDATE `users` SET `username` = :username, `firstname` = :newfirstname, `lastname` = :newlastname, `position` = :newposition
                        WHERE `users`.`user_id` = '".$_SESSION['user_id']."';";
                $statement->prepare($query);
                $statement->execute(
                    array(
                        ':username' => $newUsername,
                        ':newfirstname' => $newPersonFirstName,
                        ':newlastname' => $newPersonLastName,
                        ':newposition' => $newPosititon
                    )
                );
                $result=$statement->rowCount();
                if($result=1){
                    $message='Основная информация о Вас обновлена';
                }
                else{
                    $message='Что-то пошла не так! Попробуйте еще раз';
                }
            }
            catch(Exception $ex)
            {
                $message=$ex;
            }
        }
        else{
            $message='Имя пользователя должно быть уникальным!';
        }
        
    }
    else{
        $message='Пожалуйста, заполните все поля!';
    }
echo $message;
}


?>
