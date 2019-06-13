<?php
include('db_connection.php');
session_start();

//Отображение списка контактов пользователя с кнопкой перехода к диалогу

$query="SELECT * FROM users WHERE user_id != '".$_SESSION['user_id']."'";
$statement=$connect->prepare($query);
$statement->execute();
$result=$statement->fetchAll();

$output='
    <table class="table table-hover">           
';

if(count($result)!=0){

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
                <td><img class="avatar" src="'.get_user_photo($row['user_id'], $connect).'" alt="фото"></td>
                <td><p class="font-weight-bold">'.$row['username'].'</p> '.$status.'<br> <p class="font-weight-lighter">'.$row['position'] .'</p><br><p class="font-weight-lighter">Рабочий номер телефона: '.$row['worknumber'].'</p>
                <br><p class="font-weight-lighter">Мобильный номер телефона: '.$row['mobilenumber'].'</p></td>            
            
            </tr>
        ';
    };
}
else{
    $output='<label class="m-2">Не найдено других контактов.</label>';
}

$output .= '</table>';
echo $output;
?>


