<?php
include('db_connection.php');
session_start();

function getUserData($connect, $user_id) {
    $output='';
    try {
        $query="SELECT * FROM `users` WHERE user_id= :user_id";
        $statement=$connect->prepare($query);
        $statement->execute(
            array(':user_id' => $_SESSION['user_id'])
        );
        $result=$statement->fetchAll();        
        $json = json_encode($result);
        echo $json;
        
    } catch (Exception $ex) {
        $output = $ex;
    }
};

getUserData($connect, $_SESSION['user_id']);
?>