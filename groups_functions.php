<?php
include('db_connection.php');
session_start();


//возвращает tbody с пользователями и кнопкой добавить
//предполагалось что если юзер состоит в группе - кнопка удалить
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


function add_new_group($connect, $group_name){

    $output='';
    $data=array(
        ':chat_name' => $group_name,
        ':creator' => $_SESSION['user_id']
    );

    try{

        $query="INSERT INTO `chat_groups` (`chat_group_id`, `chat_name`, `chat_group_creator`, `timestamp_created`) 
                VALUES (NULL, :chat_name, :creator, CURRENT_TIME());";

        $statement=$connect->prepare($query);
        $statement->execute($data);
        $result=$statement->rowCount();

        if($result==1)
        {
            $output .= '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Успешно!</strong> Новая группа появится в списке групп.
          </div>';
        }
        else{
            $output .= '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Не удалось создать новую группу. <strong>Попробуйте еще раз!</strong>
          </div>';
        };
        echo $output;
    }
    catch(Exception $ex){
        echo $ex;
    };
};


switch($_POST["action"])
{
    case 'add': add_new_group($connect, $_POST['group_name']);
}
?>

