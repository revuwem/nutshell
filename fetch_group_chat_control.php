<?php
include('db_connection.php');
session_start();

$output='';
$query="SELECT user_id FROM `users` WHERE user_id!='".$_SESSION['user_id']."'";
$statement =$connect->prepare($query);
$statement->execute();
$result=$statement->fetchAll();

$output='<table class="table table-striped table-bordered">
            <tr>
                <td width="80%">Пользователь</td>           
                <td width="20%">Действие</td>                
            </tr>';

foreach($result as $row)
{
    query="SELECT relation_id FROM `chat_groups_participants` WHERE chat_group_id='".$_POST[chat_id]."' and user_id='".$row['user_id']."'";
    $statement=$connect->prepare($query);
    $statement->execute();
    $result1=$statement->fetchAll();
    
    foreach($result1 as $row1)
    {
        $output .= '
                <tr>
                <td>'.get_user_name($row['username'], $connect).'</td>';
        
        if($row1['relation_id']!='')
        {
            $output .= '<td><button class="btn btn-success btn-xs add_user_to_group_chat" type="button" data-userid="'.$row['user_id'].'">Добавить</button></td>'; 
        }
        else 
        {
            $output .= '<td><button class="btn btn-danger btn-xs drop_user_from_group_chat" type="button" data-relationid="'.$row1['relation_id'].'">Удалить</button></td>'; 
        }
        $ouput .= '<tr>';
    }
}

$output .= '</table>';
echo $output;
?>