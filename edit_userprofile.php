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
                if($result==1){
                    $message='Изменения сохранены.';
                }
                else{
                    $message='Что-то пошло не так! Попробуйте еще раз.';
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
};

function updateUserContactsInfo($connect, $worknumber, $mobilenumber){
    $output='';
    try{
        $query="UPDATE `users` SET `worknumber` = :worknumber, `mobilenumber` = :mobilenumber WHERE `users`.`user_id` = :user_id;";
        $statement=$connect->prepare($query);
        $statement->execute(
            array(
            ':worknumber' => $worknumber,
            ':mobilenumber' => $mobilenumber,
            ':user_id' => $_SESSION['user_id']
            )
        );
        $result=$statement->rowCount();
        if($result==1)
        {
            $output='Изменения сохранены.';
        }
        else{
            $output='Что-то пошло не так! Попробуйте еще раз.';
        }
    }
    catch(Exception $ex){
        $ouptup=$ex;
    }    
};

function updateUserPassword($connect, $newPassword){
    $output='';
    try {
        $query="UPDATE `users` SET `password` = :password WHERE `users`.`user_id` = :user_id;";
        $statement=$connect->prepare($query);
        $statement->execute(
            array(
                ':password' => password_hash($newPassword, PASSWORD_DEFAULT),
                ':user_id' => $_SESSION['user_id']
            )
        );
        $result=$statement->rowCount();
        if($result==1)
        {
            $output='Изменения сохранены.';
        }
        else {
            $output='Что-то пошло не так! Попробуйте еще раз.';
        }
    } catch (Exception $ex) {
        $ouptup=$ex;
    }
};

switch($_GET['action']){
    case 'basic':        
        updateUserBasicInfo($connect, $_POST["inputUserName"], $_POST['inputPersonFirstName'], $_POST['inputPersonLastName'], $_POST['inputUserPosition']);
        break;
    case 'contacts':
        updateUserContactsInfo($connect, $_POST["inputUserWorkNumber"], $_POST["inputUserMobileNumber"]);
        break;
    case 'security':
        updateUserPassword($connect, $_POST["inputNewUserPassword"]);
        break;
}
?>
