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
       $output .= '<div class="container-fluid dialog-element"> 
                   <span class="col-lg-9 col-md-9 col-sm-9 col-xs-9" style="font-weight:bold">'.get_group_chat_name($rowGroup['chat_group_id'], $connect).'</span> 
                   <a href="" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 btn pull-right edit-group_chat" type="button" data-chatgroupid="'.$rowGroup['chat_group_id'].'" data-chatgroupname="'.get_group_chat_name($rowGroup['chat_group_id'], $connect).'"><i class="fa fa-cog fa-1x" aria-hidden="true"></i></a>';
       
       foreach($result as $messages)
       {
          $message=$messages['chat_message'];
           $output .= '<p>'.$message.'</p>';  
       }
       $output .= '<div class="row"><a class="btn start_group_chat pull-right" type="button" data-                      tochatgroupid="'.$rowGroup['chat_group_id'].'" data-tochatgroupname="'.get_group_chat_name($rowGroup['chat_group_id'], $connect).'"><i class="fa fa-angle-right fa-2x" aria-hidden="true"></i></a>    
                    </div>
                    </div>
                ';
   }
}
else 
{
    $output = '<br><span>Вы не состоите ни в одной беседе</span>'; 
}
echo $output;
?>