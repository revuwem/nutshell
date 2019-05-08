<?php
include('db_connection.php');
session_start();

echo fetch_group_chat_history($_SESSION['user_id'], $_POST['to_chat_id'], $connect);
?>
