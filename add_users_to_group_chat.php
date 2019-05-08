<?php
include('db_connection.php');
session_start();

$output='<br><table class="table table-bordered table-striped">
            <tr>
                <td width="70%" text-center>Пользователь</td>           
                <td colspan="2" width="30%" text-center>Действие</td>           
            </tr>';

    $query = "
            SELECT * FROM users WHERE user_id!='".$_SESSION['user_id']."'
    ";
    $statement=$connect->prepare($query);
    $statement->execute();
    $result=$statement->fetchAll();
    
    foreach($result as $row)
    {
       $output .= '<tr>
                <td>'.$row['username'].'</td>           
                <td><button class="btn btn-success btn-xs add_user_to_chat" type="button" data-addeduserid="'.$row['user_id'].'">Добавить</button></td>
                <td><button class="btn btn-danger btn-xs drop_user_from_chat" type="button" data-deleteduserid="'.$row['user_id'].'">Удалить</button></td>
            </tr>
            ';
    }            
            
     $output .= '</table>';
    echo $output;


?>