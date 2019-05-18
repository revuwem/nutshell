<?

include('db_connection.php');
session_start();


$query="
    SELECT DISTINCT from_user_id FROM chat_message WHERE to_user_id='".$_SESSION['user_id']."'
";

$statement=$connect->prepare($query);
$statement->execute();
$resultDialog=$statement->fetchAll();

$output='';

    foreach($resultDialog as $rowDialog)
    {
        $query="
            SELECT chat_message, from_user_id FROM chat_message WHERE (from_user_id = '".$rowDialog['from_user_id']."' AND to_user_id = '".$_SESSION['user_id']."') OR(from_user_id = '".$_SESSION['user_id']."' AND to_user_id = '".$rowDialog['from_user_id']."') ORDER BY timestamp DESC LIMIT 1
        ;";
            $statement=$connect->prepare($query);
            $statement->execute();
            $result=$statement->fetchAll();
        foreach($result as $message)
        {

            $output .= '<li class="list-group-item btn btn-light dialogElement start-chat" data-touserid="'.$rowDialog['from_user_id'].'" data-tousername="'.get_user_name($rowDialog['from_user_id'], $connect).'">
                            <div class="row">
                                 <div class="col col-2 col-sm-3 col-md-2 col-lg-1">
                                    <img class="rounded-circle  avatar" src="https://bootdey.com/img/Content/avatar/avatar1.png">
                                </div>
                                <div class="col col-10 col-sm-9 col-md-10 col-lg-11">
                                    <p class="font-weight-bold">'.get_user_name($rowDialog['from_user_id'], $connect).'</p><span class="label label-success rounded-circle"> '.count_unseen_message($rowDialog['from_user_id'], $_SESSION['user_id'], $connect).'</span><br> 
                                ';
                    if($message['from_user_id']==$_SESSION['user_id']){
                        $output .= '<p class="last-message">Вы:  '.$message['chat_message'].'</p>';
                    }
                    else{
                        $output .= '<p class="last-message">'.$message['chat_message'].'</p>';
                    } 
                $output .= '</div>'; 
        }        

    }
$output .= '</div>
        </li>
';
echo $output;

?>