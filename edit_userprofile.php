<?php
include('db_connection.php');
session_start();

function can_upload($file){
	// если имя пустое, значит файл не выбран
    if($file['inputUserPhoto'] == '')
		return 'Вы не выбрали файл.'.$file['inputUserPhoto'];
	
	/* если размер файла 0, значит его не пропустили настройки 
	сервера из-за того, что он слишком большой */
	if($file['size'] == 0)
		return 'Файл слишком большой.';
	
	// разбиваем имя файла по точке и получаем массив
	$getMime = explode('.', $file['name']);
	// нас интересует последний элемент массива - расширение
	$mime = strtolower(end($getMime));
	// объявим массив допустимых расширений
	$types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');
	
	// если расширение не входит в список допустимых - return
	if(!in_array($mime, $types))
		return 'Недопустимый тип файла.';
	
	return true;
};
  
  function make_upload($file){	
	// формируем уникальное имя картинки: случайное число и name
	$name = mt_rand(0, 10000) . $file['name'];
	copy($file['tmp_name'], 'img/' . $name);
};

function updateUserBasicInfo($connect, $username, $firstname, $lastname, $position, $photo){
    $message='';
    if($username!='' && $firstname!='' && $lastname!='' && $position!='')
    {
        
        // проверяем, можно ли загружать изображение
      $check = can_upload($photo);
    
      if($check === true)
      {
            // загружаем изображение на сервер
            make_upload($photo);
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
                    $query="UPDATE `users` SET `username` = :username, `firstname` = :newfirstname, `lastname` = :newlastname, `position` = :newposition, `photo` = :newphoto
                            WHERE `users`.`user_id` = '".$_SESSION['user_id']."';";
                    $statement=$connect->prepare($query);
                    $statement->execute(
                        array(
                            ':username' => $username,
                            ':newfirstname' => $firstname,
                            ':newlastname' => $lastname,
                            ':newposition' => $position,
                            ':newphoto' => $photo

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
        echo "<strong>$check</strong>";  
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
        updateUserBasicInfo($connect, $_POST["inputUserName"], $_POST['inputPersonFirstName'], $_POST['inputPersonLastName'], $_POST['inputUserPosition'], $_FILES['inputUserPhoto']);
        break;
    case 'contacts':
        updateUserContactsInfo($connect, $_POST["inputUserWorkNumber"], $_POST["inputUserMobileNumber"]);
        break;
    case 'security':
        updateUserPassword($connect, $_POST["inputCurrentUserPassword"], $_POST["inputNewUserPassword"]);
        break;
}
?>
