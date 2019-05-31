<?php
include('db_connection.php');
session_start();


function get_users_group($connect, $user_id)
{
    $output='';

    try {
        
        $query="SELECT chat_group_id FROM `chat_groups_participants` WHERE user_id=?";
        $statement=$connect->prepare($query);
        $statement->execute(array($user_id));

        $result=$statement->fetchAll();

        if(count($result)>0)
        {
            foreach($result as $row)
            {
                $output .= '<option data-groupid="'.$row["chat_group_id"].'">'.get_group_chat_name($row["chat_group_id"], $connect).'</option>';                
            }
            echo $output;
        }
        else{
            $output .= '<option>У вас нет групп</option>';
            echo $output;
        };
    } catch (Exception $ex) {
        echo $ex;
    }
};


function get_group_tasks($connect, $group_id)
{
    try {
       
        $query="SELECT * FROM task_list WHERE group_id='$group_id'";
        $statement=$connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        
        $json = json_encode($result);
        echo $json;

        
          

    } catch (Exception $ex) {
        echo $ex;
    }
};

function add_task($connect, $group_id, $title, $description, $due_date){
    $output='';
    try {

        $query="INSERT INTO `task_list` (`task_id`, `group_id`, `title`, `description`, `due_date`, `status`) 
        VALUES (NULL, :group_id, :title, :description, :due_date, :status);";
        $statement=$connect->prepare($query);
        $statement->execute(
            array(
                ':group_id' => $group_id,
                ':title' => $title,
                ':description' => $description,
                ':due_date' => $due_date,
                ':status' => '1'
            )
        );

        $result = $statement->rowCount();
        if($result==1){
            $output .= '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Успешно!</strong> Новая задача появится в списке назначенных задач.
          </div>';
          echo $output;
        }
        else{
            $output .= '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Не удалось создать задачу. <strong>Попробуйте еще раз!</strong>
          </div>';
          echo $output;
        };

    } catch (Exception $ex) {
        echo $ex;
    };
};


switch ($_POST["action"]){

    case 'user_groups': get_users_group($connect, $_SESSION["user_id"]); break;
    case 'add_task':
        add_task($connect, $_POST["group_id"], $_POST["title"], $_POST["description"], $_POST["due_date"]);
        break;
    case 'get_info': get_group_tasks($connect, $_POST["group_id"]); break;
};
