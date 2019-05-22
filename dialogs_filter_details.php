<?php
include('db_connection.php');
session_start();

function fetch_filtered_dialogs_details($connect, $param){
    
    $output='';
    
    try{

        if($param!='')
        {
            $placeholder="%$param%";
            $query="SELECT
                        *
                    FROM
                        `users`
                    WHERE
                        user_id != '".$_SESSION['user_id']."' AND perconname LIKE ?
                        
                ";
            
            $statement=$connect->prepare($query);
            $statement->execute(
                array($placeholder)
            );
            $govno='1';
        }
        else{
            $query="SELECT * FROM users WHERE user_id != '".$_SESSION['user_id']."'";
            $statement=$connect->prepare($query);
            $statement->execute();   
            $govno='2';         
        }
        
        
        $result=$statement->fetchAll();
        if(count($result)>0)
        {
            foreach($result as $row){

                //Определение статуса пользователя
                //Если последняя активность > (текущее время-10s) - пользователь в сети(online)
                $status='';
                $current_timestamp=strtotime(date('Y-m-d H:i:s').'-10 second');
                $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
                $user_last_activity = fetch_user_last_activity($row['user_id'], $connect);
                if($user_last_activity>$current_timestamp)
                {
                $status = '<span class="badge badge-pill badge-success ml-1">Online</span>'; 
                }
                else
                {
                    $status = '<span class="badge badge-pill badge-danger ml-1">Offline</span>';
                }

                $output .= '<li class="list-group-item btn btn-light dialogElement start-chat" data-touserid="'.$row['user_id'].'" data-tousername="'.get_user_name($row['user_id'], $connect).'">
                                <div class="row">
                                    <div class="col col-2 col-sm-3 col-md-2 col-lg-1">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="" class="rounded-circle avatar">
                                    </div>
                                    <div class="col col-10 col-sm-9 col-md-10 col-lg-11">
                                        <p class="font-weight-bold">'.get_user_name($row['user_id'], $connect).' </p>'.$status.'
                                    </div>
                                </div>
                            </li>
                ';        
                    
            };
        }
        else{
            $output='<li><label>Не найдено контактов по такому запросу.</label>' .$govno.'</li>';
        }
        echo $output;
    }
    catch(Exception $ex)
    {
        $output='<li><label>Что-то пошло не так. Ошибка! '.$ex.'</label></li>';
        echo $output;
    }
};

fetch_filtered_dialogs_details($connect, $_POST["username"]);



?>