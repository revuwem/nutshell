<?php
include('db_connection.php');
session_start();

function updateUserBasicInfo($connect, $username, $firstname, $lastname, $position){
    $message='';
    if($username!='' && $firstname!='' && $lastname!='' && $position!='')
    {
        $newUsername=$username;
        $newPersonFirstName=$firstname;
        $newPersonLastName=$lastname;
        $newPosititon=$position;

        //Проверка на дублирование имени пользователя
        $query="SELECT COUNT(*) FROM users WHERE username = :username and user_id != :user_id";
        $statement=$connect->prepare($query);        
        $statement->execute(
            array(
                ':username' => $newUsername,
                ':user_id' => $_SESSION['user_id']
            )
        );
        $count=$statement->fetchColumn();
        echo $count;
                      
        if($count==0)
        {
            try{        
                $query="UPDATE `users` SET `username` = :username, `firstname` = :newfirstname, `lastname` = :newlastname, `position` = :newposition
                        WHERE `users`.`user_id` = '".$_SESSION['user_id']."';";
                $statement=$connect->prepare($query);
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

switch($_GET['action']){
    case 'basic':
        echo 'Я работаю';
        updateUserBasicInfo($connect, $_POST["inputUserName"], $_POST['inputPersonFirstName'], $_POST['inputPersonLastName'], $_POST['inputUserPosition']);
        break;
}
?>
