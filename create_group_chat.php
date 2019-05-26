<?php
include('db_connection.php');
session_start();

function fetch_users_as_new_participants($connect){
    $ouput='<tbody>';
    try{
        $query="SELECT * FROM users WHERE user_id!= :current_user";
        $statement=$connect->prepare($query);
        $statement->execute(
            array(':current_user' => $_SESSION['user_id'])
        );
        $result=$statement->fetchAll();
        if(count($result)>0)
        {
            foreach($result as $row)
            {
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

                $ouput .= '<tr>
                            <td class="text-right"><img  class="avatar" src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="фото"></td>   
                            <td>'.get_user_name($row['user_id'], $connect).' '.$status.'</td>
                            <td><button class="btn btn-success btn-sm btn-xs" data-userid="'.$result['user_id'].'">Добавить</button></td>                        
                        </tr>';
            }
            $ouput .= '</tbody>';
        }
        else{
            $ouput .= '<tr><td>Не найдено ни одного контакта.<td><tr>';
        }
        echo $ouput;
    }
    catch(Exception $ex){
        echo $ex;
    };
};
?>


<div class="container menu shadow py-3 group-panel" id="new_group-panel"> 
    <div class="row header">
        <div class="col col-2">
            <button class="btn"><span class="fa fa-arrow-left fa-fw" aria-hidden="false"></span></button>
        </div>
        <div class="col col-10"><h6 class="my-auto">Создание новой группы</h6></div>
        <div class="create-group-feedback"></div>
        <div class="container-fluid input-group my-2">
            <input type="text" class="form-control" name="input_new_group_name" id="input_new_group_name">
            <div class="input-group-append">
                <button class="btn btn-block btn-info" name="btn_create_group" id="btn_create_group">Создать</button>
            </div>
        </div>
    </div>    
    <div class="row">
        <div class="container-fluid">
            <table class="table table-hover" id="participants">
                                    
            </table>
        </div>
    </div>
</div>