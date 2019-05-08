<?php

include('db_connection.php');
session_start();


$data = array(
    ':from_user_id' => $_SESSION['user_id'],
    ':to_chat_id' => $_POST['to_chat_id'],    
    ':chat_message' => $_POST['chat_message']    
);

$query="INSERT INTO `chat_groups_messages`(`timestamp`, `from_user_id`, `to_chat_group_id`, `chat_message`) VALUES (CURRENT_TIMESTAMP(), :from_user_id, :to_chat_id, :chat_message)
";
$statement=$connect->prepare($query);
if($statement->execute($data))
{
    echo fetch_group_chat_history($_SESSION['user_id'], $_POST['to_chat_id'], $connect);
}
else echo '<span>Не удалось отправить сообщение</span>';

?>