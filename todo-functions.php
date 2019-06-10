<?php
include('db_connection.php');
session_start();

//Фукнция возвращает список групп, в которых состоит пользователь
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

//Фукнция возвращает JSON со списком задач группы $group_id
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


//Функция добавляет новую задачу и возвращает уведомление с результатом
function add_task($connect, $group_id, $title, $description, $due_date){
    $output='';
    try {

        if($title!='' && $description!='' && $due_date!=''){
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
        }
        else{
            $output .= '<div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Внимание. <strong>Для создания задачи укажите все необходимые атрибуты!</strong>
        </div>';
        echo $output;
        }

    } catch (Exception $ex) {
        echo $ex;
    };
};

//Функция возвращает результат обновления статуса задачи
function update_task_status($connect, $task_id){

    try {
       
        $new_status=null;

        $query="SELECT status FROM task_list WHERE task_id=?";
        $statement=$connect->prepare($query);
        $statement->execute(array($task_id));
        $result=$statement->fetchAll();

        foreach($result as $row){

            switch ($row['status']){
                case 1: $new_status=2;break;
                case 2: $new_status=3;break;
            };

            
            $query="UPDATE task_list SET status=? WHERE task_id=? ";
            $statement=$connect->prepare($query);
            $statement->execute(
                array($new_status, $task_id)
            );
            $result=$statement->rowCount();

            if($result==1){
                echo $ouptut="true";
            }
            else{
                echo $ouptut="false";
            };
        };

    } catch (Exception $ex) {
        echo $ex;
    }
};

//Фукнция возвращает результат удаления задачи
function delete_task($connect, $task_id){
    try {
        $output='';
        
        $query="DELETE FROM task_list WHERE task_id=?";
        $statement=$connect->prepare($query);
        $statement->execute(array($task_id));
        $result=$statement->rowCount();

        if($result==1)
        {
            echo $ouptut="true";
        }
        else{
            echo $ouptut="false";
        };

    } catch (Exception $ex) {
        echo $ex;
    }
};


switch ($_POST["action"]){

    case 'user_groups': get_users_group($connect, $_SESSION["user_id"]); break;
    case 'add_task':
        add_task($connect, $_POST["group_id"], $_POST["title"], $_POST["description"], $_POST["due_date"]);
        break;
    case 'get_info': get_group_tasks($connect, $_POST["group_id"]); break;
    case 'update_status': update_task_status($connect, $_POST["task_id"]); break;
    case 'delete': delete_task($connect, $_POST["task_id"]); break;
};
