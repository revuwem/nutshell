<?php
include('config.php');

try{

$opt=array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);
$connect = new PDO($dsn, $user, $password, $opt);
}
catch(Exception $ex){
 die("Ошибка подключения к базе данных. Проверьте параметры конфигурации подключения к базе данных config.php");

};

date_default_timezone_set('Europe/Moscow');


// Функция возвращает время, когда пользователь последний раз авторизовывался
function fetch_user_last_activity($user_id, $connect)
{
    $query="
        SELECT * FROM login_details
        WHERE user_id='$user_id'
        ORDER BY last_activity DESC
        LIMIT 1
    ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
       return $row['last_activity']; 
    }
};

// Функция возвращает историю сообщений приватного чата
function fetch_user_chat_history($from_user_id, $to_user_id, $connect)
{
    $query = "
        SELECT
            *
        FROM
            `chat_message`
        WHERE
            (from_user_id = '".$from_user_id."' AND to_user_id = '".$to_user_id."') OR(from_user_id = '".$to_user_id."' AND to_user_id = '".$from_user_id."')
        ORDER BY
            TIMESTAMP        
    ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $output = '<ul class="list-unstyled">';
    foreach($result as $row)
    {
         $user_name='';
        if($row["from_user_id"]==$from_user_id)
        {
            $user_name = '<b class="text-success">You</b>';
        }
        else
        {
            $user_name = '<b class="text-warning">'.get_user_name($row['from_user_id'], $connect).'</b>';
        }
        $output .= '
            <li style="border-bottom: 1px dotted #ccc">
                <p>'.$user_name.' - '.$row["chat_message"].'
                <div align="right">
                    - <small><em>'.$row['timestamp'].'</em></small>
                </div>
                <p>
            </li>
        ';
    }
    $output .= '</ul>';
    $query = "
        UPDATE chat_message
        SET status = '0'
        WHERE from_user_id = '".$to_user_id."'
        AND to_user_id='".$from_user_id."'
        AND status = '1'
    ";
    $statement=$connect->prepare($query);
    $statement->execute();
    return $output;
};

// Фукнция возвращает имя пользователя для $user_id
function get_user_name($user_id, $connect)
{
    $output='';
    $query = "SELECT perconname FROM users WHERE user_id = '$user_id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result=$statement->fetchAll();
    foreach($result as $row)
    {        
        return $row['perconname'];
    }
};


//Функция возвращает фото пользователя для $user_id
function get_user_photo($user_id, $connect){
    $query="SELECT photo FROM users WHERE user_id = '$user_id'";
    $statement=$connect->prepare($query);
    $statement->execute();
    $result=$statement->fetchAll();
    foreach($result as $row){
        return $row['photo'];
    }
};


//Функция возвращает фото группы для $group_id
function get_group_photo($group_id, $connect){
    $query="SELECT photo FROM chat_groups WHERE chat_group_id = '$group_id'";
    $statement=$connect->prepare($query);
    $statement->execute();
    $result=$statement->fetchAll();
    foreach($result as $row){
        return $row['photo'];
    }
};

//Функция возвращает количество непрочитанных сообщений в чате

function count_unseen_message($from_user_id, $to_user_id, $connect)
{
    $query = "
        SELECT count(*) FROM chat_message
        WHERE from_user_id = '$from_user_id'
        AND to_user_id = '$to_user_id'
        AND status = '1'
    ";
    
    $statement=$connect->prepare($query);
    $statement->execute();
    $count = $statement->fetchColumn();
    $output='';
    if($count>0)
    {
        $output = '<span class="label label-success">'.$count.'</span>';
    }
    return $output;
};


function fetch_is_type_status($user_id, $connect)
{
    $query="
        SELECT is_type FROM login_details
        WHERE user_id = '".$user_id."'
        ORDER BY last_activity DESC
        LIMIT 1
    ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
        if($row["is_type"]=='yes')
        {
            $output = '<small><em><span class="text-muted">Печатает...</span></em></small>';
        }
    }
    return $output;
};


//Функция возвращает название группы $chat_group_id
function get_group_chat_name($chat_group_id, $connect)
{
    $query = "SELECT chat_name FROM chat_groups WHERE chat_group_id = '$chat_group_id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result=$statement->fetchAll();
    foreach($result as $row)
    {
        return $row['chat_name'];        
    }
};


//Функция возвращает историю чата группы 
function fetch_group_chat_history($from_user_id, $to_chat_id, $connect)
{
     $query="
       SELECT * FROM chat_groups_messages WHERE to_chat_group_id='".$to_chat_id."' 
     "; 
    $statement=$connect->prepare($query);
    $statement->execute();
    $result=$statement->fetchAll();
    $output='<ul class="list-unstyled">';
    foreach($result as $row)
    {
        $user_name='';
        if($row['from_user_id']==$from_user_id)
        {
            $user_name = '<b class="text-success">You</b>';
        }
        else
        {
            $user_name = '<b class="text-warning">'.get_user_name($row['from_user_id'], $connect).'</b>';
        }
        $output .= '
            <li style="border-bottom: 1px dotted #ccc">
                <p>'.$user_name.' - '.$row["chat_message"].'
                <div align="right">
                    - <small><em>'.$row['timestamp'].'</em></small>
                </div>
                <p>
            </li>
        ';
    }
    $output .= '</ul>';
    return $output;
};

function get_user_email($connect, $user_id){
    $output='';
    $query = "SELECT email FROM users WHERE user_id = '$user_id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result=$statement->fetchAll();
    foreach($result as $row)
    {        
        return $row['email'];
    }
}


?>