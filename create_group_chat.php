<?php
include('db_connection.php');

session_start();

$chat_group_name = $_POST['group_name'];
$output = '';

$query = "
    INSERT INTO `chat_groups`(`chat_name`, `chat_group_creator`, `timestamp_created`) VALUES ('".$chat_group_name."', '".$_SESSION['user_id']."', CURRENT_TIMESTAMP());
";
$statement=$connect -> prepare($query);
$statement->execute();
$result = $statement->rowCount();


if($result<0)
{    
    echo 'alert("Не удалось создать беседу")'; 
}
else 
{
    $query = "SELECT chat_group_id FROM chat_groups WHERE chat_group_creator='".$_SESSION[user_id]."' and chat_name='".$chat_group_name."' order by timestamp_created desc limit 1";
    $statement=$connect->prepare($query);
    $statement->execute();
    $ouput=$statement->fetchAll();
    echo $output;
}

?>