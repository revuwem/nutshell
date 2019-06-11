<?php
include('db_connection.php');
include('upload_files.php');
session_start();



//Возвращает уведомление о результате изменения основной информации в профиле пользователя
function updateUserBasicInfo($connect, $username, $perconname, $position, $filePath, $errorCode){
    $message='';
    if($username!='' && $perconname!='' &&  $position!='')
    {

        $newphoto=load_photo($filePath, $errorCode);
        //Если фото загрузилось на сервер
        if($newphoto!='')
        {
            //Проверка на дублирование имени пользователя
            $query="SELECT COUNT(*) FROM users WHERE username = :username and user_id != :user_id";
            $statement=$connect->prepare($query);        
            $statement->execute(
                array(
                    ':username' => $username,
                    ':user_id' => $_SESSION['user_id']
                )
            );
            $count=$statement->fetchColumn();       
            if($count==0)
            {
                try{        
                    $query="UPDATE `users` SET `username` = :username, `perconname` = :newperconname, `position` = :newposition, `photo` =:newphoto
                            WHERE `users`.`user_id` = '".$_SESSION['user_id']."';";
                    $statement=$connect->prepare($query);
                    $statement->execute(
                        array(
                            ':username' => $username,
                            ':newperconname' => $perconname,
                            ':newposition' => $position,
                            ':newphoto' => $newphoto
                        )
                    );
                    $result=$statement->rowCount();
                    if($result==1){
                        $message='Изменения сохранены. Пожалуйста, обновите страницу.';
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
        // выводим сообщение об ошибке
        echo "<strong>Внимание!</strong>Не удалось загрузить фото.";  
        }
    }
    else{
        $message='Пожалуйста, заполните все поля!';
    }
echo $message;
};


//Возвращает уведомление о результате изменения контактной информации в профиле пользователя
function updateUserContactsInfo($connect, $worknumber, $mobilenumber, $email){
    $output='';
    try{
        $query="UPDATE `users` SET `worknumber` = :worknumber, `mobilenumber` = :mobilenumber, `email` =:email WHERE `users`.`user_id` = :user_id;";
        $statement=$connect->prepare($query);
        $statement->execute(
            array(
            ':worknumber' => $worknumber,
            ':mobilenumber' => $mobilenumber,
            ':user_id' => $_SESSION['user_id'],
            ':email' =>$email
            )
        );
        $result=$statement->rowCount();
        if($result==1)
        {
            $output='Изменения сохранены. Пожалуйста, обновите страницу.';
        }
        else{
            $output='Что-то пошло не так! Попробуйте еще раз.';
        }
        echo $output; 
    }
    catch(Exception $ex){
        $ouptup=$ex;
    }      
};

//Фукнция вовзращает уведомление о результате изменения пароля пользователя
function updateUserPassword($connect, $currentPassword, $newPassword){
    $output='';
    try {
            $query="SELECT password FROM users WHERE user_id= :user_id";
            $statement=$connect->prepare($query);
            $statement->execute(
                array(':user_id' => $_SESSION['user_id'])
            );
            $result=$statement->fetchAll();
            foreach($result as $row)
            if(password_verify($currentPassword, $row["password"]))
            {
                //Обновление пароля
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
                    $output='Изменения сохранены. Пожалуйста, обновите страницу.';
                }
                else {
                    $output='Что-то пошло не так! Попробуйте еще раз.';
                }
            }
            else{
                $output='Текущий пароль неверен. Для продолжения введите правильный пароль.';
            }
            echo $output;
    } catch (Exception $ex) {
        $ouptup=$ex;
    }        
};

switch($_GET['action']){
    case 'basic':        
        updateUserBasicInfo($connect, $_POST["inputUserName"], $_POST['inputPersonName'], $_POST['inputUserPosition'], $_FILES['inputUserPhoto']['tmp_name'], $_FILES['inputUserPhoto']['error']);
        break;
    case 'contacts':
        updateUserContactsInfo($connect, $_POST["inputUserWorkNumber"], $_POST["inputUserMobileNumber"], $_POST["inputUserEmail"]);
        break;
    case 'security':
        updateUserPassword($connect, $_POST["inputCurrentUserPassword"], $_POST["inputNewUserPassword"]);
        break;
}
?>
