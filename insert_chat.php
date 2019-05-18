<?php
include('db_connection.php');
session_start();

try{
$data = array(
    ':to_user_id'   => $_POST['to_user_id'],
    ':from_user_id' => $_SESSION['user_id'],
    ':chat_message' =>  $_POST['chat_message'],
    ':status'   => '1'
);

$query="
    INSERT INTO chat_message (to_user_id, from_user_id, chat_message, status)
    VALUES (:to_user_id, :from_user_id, :chat_message, :status)
";
$statement = $connect->prepare($query);
if ($statement->execute($data))
{
    echo fetch_user_chat_history($_SESSION['user_id'], $_POST['to_user_id'], $connect);
}
else echo '<span>Не удалось отправить сообщение</span>';
}
catch(Exception $ex){
    echo $ex;    
}

?>