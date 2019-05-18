<?php

include('db_connection.php');
session_start();

$output='';
$message='';
$query="
    SELECT chat_group_id FROM chat_groups_participants WHERE user_id='".$_SESSION['user_id']."' ORDER BY chat_group_id DESC
    ";
$statement=$connect->prepare($query);
$statement->execute();
$resultGroups=$statement->fetchAll();

if(count($resultGroups)>0)
{
   foreach($resultGroups as $rowGroup)
   {
      
       $query="
        SELECT chat_message FROM chat_groups_messages WHERE to_chat_group_id='".$rowGroup['chat_group_id']."' ORDER BY timestamp DESC LIMIT 1
       ";
       
       $statement=$connect->prepare($query);
       $statement->execute();
       $result=$statement->fetchAll();
       $output .= '<li class="list-group-item btn btn-light groupElement" data-chatgroupid="'.$rowGroup['chat_group_id'].'" data-chatgroupname="'.get_group_chat_name($rowGroup['chat_group_id'], $connect).'">
                        <div class="row">
                            <div class="col col-2 col-sm-3 col-md-3 col-lg-3">
                                <img class="rounded-circle  avatar" src="https://bootdey.com/img/Content/avatar/avatar1.png">
                            </div>
                            <div class="col col-10 col-sm-9 col-md-9 col-lg-9">
                                <p>'.get_group_chat_name($rowGroup['chat_group_id'], $connect).'</p><br>
       ';
       foreach($result as $messages)
       {
          $message=$messages['chat_message'];
           $output .= '<p class="last-message">'.$message.'</p>';  
       }

       $output .= '</div>                    
                </div>
            </li>
        ';

       /*
       $output .= '<div class="row"><a class="btn start_group_chat pull-right" type="button" data-tochatgroupid="'.$rowGroup['chat_group_id'].'" data-tochatgroupname="'.get_group_chat_name($rowGroup['chat_group_id'], $connect).'"><i class="fa fa-angle-right fa-2x" aria-hidden="true"></i></a>    
                    </div>
                    </div>
                ';
        */
   }
}
else 
{
    $output = '<br><span>Вы не состоите ни в одной беседе</span>'; 
}
echo $output;
?>

