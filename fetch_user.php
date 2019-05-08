<?php
include('db_connection.php');
session_start();

$query="SELECT * FROM users WHERE user_id != '".$_SESSION['user_id']."'";
$statement=$connect->prepare($query);
$statement->execute();
$result=$statement->fetchAll();

$output='
    <table class="table table-bordered table-striped">
        <tr>
            <td width="70%">Имя</td>           
            <td width="30%">Статус</td>           
        </tr>   
';
// <td width="10%">Действие</td>

foreach($result as $row)
{
    $status='';
    $current_timestamp=strtotime(date('Y-m-d H:i:s').'-10 second');
    $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
    $user_last_activity = fetch_user_last_activity($row['user_id'], $connect);
    if($user_last_activity>$current_timestamp)
    {
       $status = '<span class="label label-success">Online</span>'; 
    }
    else
    {
        $status = '<span class="label label-danger">Offline</span>';
    }
    $output .= '
        <tr>
            <td>'.$row['username'].' '.count_unseen_message($row['user_id'], $_SESSION['user_id'], $connect).' '.fetch_is_type_status($row['user_id'], $connect).'</td>
            <td>'.$status.'</td>            
        </tr>
    ';
}

$output .= '</table>';
echo $output;
?>

<!--<td><button class="btn btn-primary btn-xs start_chat" type="button" data-touserid="'.$row['user_id'].'" data-tousername="'.$row['username'].'">К диалогу</button></td>-->

