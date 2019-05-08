<?

include('db_connection.php');
session_start();


$query="
    SELECT DISTINCT from_user_id FROM chat_message WHERE to_user_id='".$_SESSION['user_id']."'
";

$statement=$connect->prepare($query);
$statement->execute();
$resultDialog=$statement->fetchAll();

$output='<div>';
    foreach($resultDialog as $rowDialog)
    {
        $query="
            SELECT chat_message FROM chat_message WHERE to_user_id='".$_SESSION['user_id']."' AND from_user_id='".$rowDialog['from_user_id']."' ORDER BY timestamp DESC LIMIT 1
        ;";
            $statement=$connect->prepare($query);
            $statement->execute();
            $result=$statement->fetchAll();
        foreach($result as $message)
        {
            $output .= '<div class="container dialog-element">
               <h5 style="font-weight:bold">'.get_user_name($rowDialog['from_user_id'], $connect).'</h5>'.count_unseen_message($rowDialog['from_user_id'], $_SESSION['user_id'], $connect).'
                <br>
                <p>'.$message['chat_message'].'</p>
                <a class="btn start_chat pull-right" type="button" data-touserid="'.$rowDialog['from_user_id'].'" data-tousername="'.get_user_name($rowDialog['from_user_id'], $connect).'"><i class="fa fa-angle-right fa-2x" aria-hidden="true"></i></a>
                </div>
            ';
        }        

    }
$output .= '</div>';
echo $output;




?>