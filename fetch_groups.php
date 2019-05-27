<?php

include('db_connection.php');
session_start();

$output='';
$message='';
$query="SELECT chat_group_id 
        FROM chat_groups_participants 
        WHERE user_id='".$_SESSION['user_id']."' ORDER BY chat_group_id DESC
    ";
$statement=$connect->prepare($query);
$statement->execute();
$resultGroups=$statement->fetchAll();

if(count($resultGroups)>0)
{
   foreach($resultGroups as $rowGroup)
   {

        $output .= '<li class="list-group-item btn btn-light groupElement mt-1" data-chatgroupid="'.$rowGroup['chat_group_id'].'" data-chatgroupname="'.get_group_chat_name($rowGroup['chat_group_id'], $connect).'" data-chatgroupphoto="'.get_group_photo($rowGroup['chat_group_id'], $connect).'">
            <div class="row">
                <div class="col col-2 col-sm-3 col-md-2 col-lg-1">
                    <img class="rounded-circle  avatar" src="'.get_group_photo($rowGroup['chat_group_id'], $connect).'">
                </div>
                <div class="col col-10 col-sm-9 col-md-10 col-lg-11">
                    <p class="font-weight-bold">'.get_group_chat_name($rowGroup['chat_group_id'], $connect).'</p><br>
            ';
      
       $query="SELECT chat_message, from_user_id 
                FROM chat_groups_messages 
                WHERE to_chat_group_id='".$rowGroup['chat_group_id']."' 
                ORDER BY timestamp DESC LIMIT 1
       ";
       
       $statement=$connect->prepare($query);
       $statement->execute();
       $result=$statement->fetchAll();      
       foreach($result as $messages)
       {            
           $message=$messages['chat_message'];

           if($messages['from_user_id']==$_SESSION['user_id']){
                $output .= '<p class="last-message">Вы: '.$message.'</p>'; 
           }
           else{
                $output .= '<p class="last-message">'.get_user_name($messages['from_user_id'], $connect).': '.$message.'</p>';  
           }             
       };
       $output .= '</div>                    
                </div>                
            </li>
        ';              
   };
}
else 
{
    $output = '<br><span>Вы не состоите ни в одной беседе</span>'; 
}
echo $output;
?>

