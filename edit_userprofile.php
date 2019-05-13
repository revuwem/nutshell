<?php
include('db_connection.php');
session_start();

$message='';
//Обновление основной информации

    if(!empty ($_POST['inputUserName']) and !empty($_POST['inputPersonFirstName']) and !empty($_POST['inputPersonLastName']) and !empty($_POST['inputUserPosition']))
    {
        $new_username=$_POST['inputUserName'];
        $new_personFirstName=$_POST['inputPersonFirstName'];
        $new_personLastName=$_POST['inputPersonLastName'];
        $new_position=$_POST['inputUserPosition'];

        $query="SELECT COUNT(*) FROM users WHERE username= :username";
        $statement=$connect->prepare($query);
        $statement->execute(
            array(':username'=>$new_username)
        );
        $count=$statement->fetchColumn();
        if($count>0)
        {
            $message_basic_info='<label class="text-danger">Имя пользователя должно быть уникальным</label>';
        }
        else
        {
            $query="UPDATE `users` SET `username` = :username, `firstname` = :firstname, `lastname` = :lastname, `position` = :position
                    WHERE `users`.`user_id` = '".$_SESSION['user_id']."';
                ";
            $statement=$connect->prepare($query);
            $statement->execute(
                array(':username' => $new_username,
                ':firstname' => $new_personFirstName,
                ':lastname'=>$new_personLastName,
                ':position' => $new_position)
            );
            $count=$statement->rowCount();
            if($count=1)
            {
                $message_basic_info='<label class="text-success">Основная информация обновлена</label>';
            }
            else 
            {
                $message_basic_info='<label class="text-danger">Не удалось внести изменения</label>';                
            }
        }
    }
    else 
    {
        {
            $message_basic_info='<label class="text-danger">Пожалуйста, укажите всю основную информацию о себе</label>';
        }
    }    

?>