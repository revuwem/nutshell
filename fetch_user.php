<?php
include('db_connection.php');
session_start();


$query="SELECT * FROM users WHERE user_id != '".$_SESSION['user_id']."'";
$statement=$connect->prepare($query);
$statement->execute();
$result=$statement->fetchAll();

$output='
    <table class="table table-hover">           
';


foreach($result as $row)
{
    $status='';
    $current_timestamp=strtotime(date('Y-m-d H:i:s').'-10 second');
    $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
    $user_last_activity = fetch_user_last_activity($row['user_id'], $connect);
    if($user_last_activity>$current_timestamp)
    {
    $status = '<span class="badge badge-pill badge-success ml-1 p-1"> </span>'; 
    }
    else
    {
        $status = '<span class="badge badge-pill badge-danger ml-1 p-1"> </span>';
    }
    $output .= '
        <tr>
            <td width="15%"><img src="" alt="фото"></td>
            <td width="60%">'.$row['username'].' '.$status.' '.count_unseen_message($row['user_id'], $_SESSION['user_id'], $connect).' '.fetch_is_type_status($row['user_id'], $connect).'<br></td>            
            <td width="25%"><button class="btn btn-outline-info btn-sm start_chat" type="button" data-touserid="'.$row['user_id'].'" data-tousername="'.$row['username'].'">К диалогу</button></td>            
        </tr>
    ';
}

$output .= '</table>';
echo $output;
?>


