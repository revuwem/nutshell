<?php
include('db_connection.php');
include('upload_files.php');
session_start();


//Фукнция создает новую группу и возвращает сообщение об успешном или неуспешном результате
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

//Фукнция возвращает информацию о группе
function get_group_data($connect, $group_id){
    try{

        $query="SELECT * FROM `chat_groups` WHERE chat_group_id=?";
        $statement=$connect->prepare($query);
        $statement->execute(array($group_id));
        $result=$statement->fetchAll();

        $json=json_encode($result);
        echo $json;
        
    }
    catch(Exception $ex)
    {
        echo $ex;
    }
};


//Функция возвращает таблицу с участниками группы 
function get_group_participants($connect, $group_id){

    try{

        $output='';


        $query="SELECT relation_type FROM `chat_groups_participants` WHERE user_id=? and chat_group_id=?";
        $statement=$connect->prepare($query);
        $statement->execute(array($_SESSION['user_id'], $group_id));
        $result_user_relation=$statement->fetchAll();


        $query="SELECT * FROM `chat_groups_participants` WHERE chat_group_id=? order by relation_type
        ";

        $statement=$connect->prepare($query);
        $statement->execute(array($group_id));
        $result=$statement->fetchAll();
       

        foreach($result_user_relation as $user_relation)
        {
            //Если пользователь создатель группы - он может добавлять и удалять участников
        //Иначе пользователь может только просмотреть список участников
            if($user_relation["relation_type"]==1)
            {
                $output='<tr>
                    <td colspan="2">
                        <div class="container-fluid input-group">
                            <input type="text" class="form-control" name="search_new_group_participants" id="search_new_group_participants" placeholder="Поиск контакта...">
                            <div class="input-group-append">
                                <button class="btn form-control" id="btn_cancel_search_new_group_participants"><span class="fa fa-search fa-fw"
                    aria-hidden="true"></span></button>
                             </div>
                        </div>
                    <td>
                </tr>';

                foreach($result as $row){            
                    $output .= '<tr>
                        <td width="70%"><img class="avatar rounded-circle" src="'.get_user_photo($row['user_id'], $connect).'"> '.get_user_name($row['user_id'], $connect).' ';
                    
                    if($row["relation_type"]==1){
                        $output .= '<p class="font-weight-light small"><i>Создатель</i></p>';
                    };

                    $output .= '</td>';
                
                    if($row['user_id']==$_SESSION["user_id"])
                    {
                        $output .= '<td width="30%"><br><button class="btn btn-danger btn-xs drop_user_from_chat" type="button" data-deleteduserid="'.$row['user_id'].'">Выйти</button></td>
                        ';
                    }
                    else{
                        $output .= '<td width="30%"><br><button class="btn btn-danger btn-xs drop_user_from_chat" type="button" data-deleteduserid="'.$row['user_id'].'">Удалить</button></td>
                        ';
                    };
                    $output .= '</tr>';
                };            
            }
            else{
                foreach($result as $row){            
                    $output .= '<tr>
                        <td width="100%"><img class="avatar rounded-circle" src="'.get_user_photo($row['user_id'], $connect).'"> '.get_user_name($row['user_id'], $connect).' ';  
                        
                    if($row["relation_type"]==1){
                        $output .= '<p class="font-weight-light small"><i>Создатель</i></p>';
                    };

                    $output .= '</td></tr>';
                };
            };

        };   

        echo $output;
    }
    catch(Exception $ex){
        echo $ex;
    }
};

//Фукнция обновления фото группы
function update_group_photo($connect, $group_id, $filePath, $errorCode){

    try {
        
        $newphoto=load_photo($filePath, $errorCode);
        if($newphoto!=''){

            $query="UPDATE `chat_groups` SET `photo` = :newphoto WHERE `chat_groups`.`chat_group_id` = :group_id";
            $statement=$connect->prepare($query);
            $statement->execute(
                array(
                    ':newphoto' => $newphoto,
                    ':group_id' => $group_id
                )
            );
            $result=$statement->rowCount();
            if($result==1)
            {
               echo $output='<div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Успешно!</strong> Фото будет обновлено.
                            </div>';
            }
            else{
                echo $output='<div class="alert alert-warning alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Не удалось!</strong> Ошибка.
                            </div>';
            };            
        }
        else{            
            echo $output='<div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                 <strong>Не удалось!</strong> Ошибка.
                            </div>';
        };
    } catch (Exception $th) {
        echo $th;
    }
};

//Функция обновления названия группы
function update_group_name($connect){
    $output='<div class="alert alert-warning alert-dismissible">
                                 <button type="button" class="close" data-dismiss="alert">&times;</button>
                                 <strong>Не удалось!</strong> Ошибка.
                             </div>';
    echo $output;
};

switch($_POST["action"])
{
    case 'add': add_new_group($connect, $_POST['group_name']);break;
    case 'info': get_group_data($connect, $_POST['group_id']); break;
    case 'participants': get_group_participants($connect, $_POST['group_id']); break; 
                   break;
    case 'update_group_name': update_group_name($connect); break;
    case 'update_photo': update_group_photo($connect, $_POST["group_id"], $_FILES['input_new_group_photo']['tmp_name'], $_FILES['input_new_group_photo']['error']); break;
}
?>