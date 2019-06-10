<?php
include('db_connection.php');
session_start();


//Фукнция добавляет новое сообщение в историю сообщений приватного чата
function insert_chat_message($connect, $chat_id){
    try
    {
        $data = array(
            ':chat_id' => $chat_id,
            ':to_user_id'   => $_POST['to_user_id'],
            ':from_user_id' => $_SESSION['user_id'],
            ':chat_message' =>  $_POST['chat_message'],
            ':status'   => '1'
        );
        $query="
            INSERT INTO chat_message (chat_id, to_user_id, from_user_id, chat_message, status)
            VALUES (:chat_id, :to_user_id, :from_user_id, :chat_message, :status)
        ";
        $statement = $connect->prepare($query);
        if ($statement->execute($data))
        {
            echo fetch_user_chat_history($_SESSION['user_id'], $_POST['to_user_id'], $connect);
        }
        else echo '<span>Не удалось отправить сообщение</span>';
    }
    catch(Exception $ex)
    {
        echo $ex;
    };
};

try{
    $complicity=array(
        ':user_sender' => $_SESSION['user_id'],
        ':user_receiver' => $_POST['to_user_id']);


    
    $query="SELECT
            count(chat_id) as count
            FROM
            `users_chats`
            WHERE
            (user_1 = :user_sender AND user_2 = :user_receiver) OR (user_1 = :user_receiver AND user_2 = :user_sender)";
    $statement=$connect->prepare($query);
    $statement->execute($complicity);
    $result=$statement->fetchColumn();


    //Если количество chat_id, где User_1 - отправитель и user_2 - получатель(или наоборот) - создаем для них новый chat_id
    //Если найден 1 chat_id - узнаем его значение
    if($result==0)
    {
        $query="INSERT INTO `users_chats` (`user_1`, `user_2`) VALUES (:user_sender, :user_receiver);";
        $statement=$connect->prepare($query);
        $statement->execute($complicity);

        $query  = $connect->query("SELECT LAST_INSERT_ID() FROM `users_chats`");
        $chat_id = $query->fetchColumn();

        if($chat_id!='')
        {  

            insert_chat_message($connect, $chat_id);
        }
        else 
        {
            echo '<span>Не удалось отправить сообщение</span>';
            
        };
    }
    else{
        $query="SELECT
            chat_id
            FROM
            `users_chats`
            WHERE
            (user_1 = :user_sender AND user_2 = :user_receiver) OR (user_1 = :user_receiver AND user_2 = :user_sender)";
        $statement=$connect->prepare($query);
        $statement->execute($complicity);
        $result=$statement->fetchColumn();        

        insert_chat_message($connect, $result);
    };
}
catch(Exception $ex){
    echo $ex;    
};

?>