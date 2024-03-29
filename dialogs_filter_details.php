<?php
include('db_connection.php');
session_start();


//Функция возвращает список пользователей с применением фильтра по имени пользователя $param
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
            
        }
        else{
            $query="SELECT * FROM users WHERE user_id != '".$_SESSION['user_id']."'";
            $statement=$connect->prepare($query);
            $statement->execute();   
                    
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
                $status = '<span class="badge badge-pill badge-success ml-1 p-1"> </span>'; 
                }
                else
                {
                    $status = '<span class="badge badge-pill badge-danger ml-1 p-1"> </span>';
                }

                $output .= '<li class="list-group-item btn btn-light dialogElement start-chat mt-1" data-touserid="'.$row['user_id'].'" data-tousername="'.get_user_name($row['user_id'], $connect).'" data-touserphoto="'.get_user_photo($row['user_id'], $connect).'">
                                <div class="row">
                                    <div class="col col-2 col-sm-3 col-md-2 col-lg-1">
                                        <img src="'.get_user_photo($row['user_id'], $connect).'" alt="" class="rounded-circle avatar">
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
            $output='<li><label>Не найдено контактов по такому запросу.</label></li>';
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