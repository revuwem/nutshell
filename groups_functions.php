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
                foreach($result as $row){            
                    $output .= '<tr>
                        <td width="70%"><img class="avatar rounded-circle" src="'.get_user_photo($row['user_id'], $connect).'"> '.get_user_name($row['user_id'], $connect).' ';
                    
                    if($row["relation_type"]==1){
                        $output .= '<p class="font-weight-light small"><i>Создатель</i></p>';
                    };

                    $output .= '</td>';
                
                    if($row['user_id']==$_SESSION["user_id"])
                    {
                        $output .= '<td width="30%"><br><button class="btn btn-danger btn-xs drop_user_from_group" type="button" data-userid="'.$row['user_id'].'">Выйти</button></td>
                        ';
                    }
                    else{
                        $output .= '<td width="30%"><br><button class="btn btn-danger btn-xs drop_user_from_group" type="button" data-userid="'.$row['user_id'].'">Удалить</button></td>
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
        
        if($filePath!='')
        {
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
                                    <strong>Успешно!</strong> Изменения вступят в силу после обновления окна чата.
                                </div>';
                }
                else{
                    echo $output='<div class="alert alert-warning alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Внимание!</strong> Не удалось обновить фото.
                                </div>';
                };            
            }
            else{            
                echo $output='<div class="alert alert-warning alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Внимание!</strong> Не удалось загрузить файл.
                                </div>';
            };
        }
        else{
            echo $output='<div class="alert alert-warning alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Внимание!</strong> Файл не выбран!
                                </div>';
        };
    } catch (Exception $th) {
        echo $th;
    }    
};

//Функция обновления названия группы
function update_group_name($connect, $group_id, $new_name){
    try {
       
        if($new_name!='' && trim($new_name)!=''){

            $query="UPDATE `chat_groups` SET `chat_name` = ? WHERE `chat_groups`.`chat_group_id` = ?;";
            $statement=$connect->prepare($query);
            $statement->execute(
                array($new_name, $group_id)
            );
            $result=$statement->rowCount();
            if($result==1){

                echo $output='<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Успешно!</strong> Изменения вступят в силу после обновления окна чата.
                </div>';
            }
            else{
                echo $output='<div class="alert alert-warning alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Внимание!</strong> Не удалось обновить название группы.
                            </div>';
            }
        }
        else{
            echo $output='<div class="alert alert-warning alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Внимание!</strong> Пожалуйста, укажите новое название группы.
                                </div>';
        };

    } catch (Exception $ex) {
        echo $ex;
    };   
};


//Функция вовзращает данные пользователей, которые не состоят в группе, для дальнейшего добавления в группу
function fetch_new_group_participants($connect, $group_id, $param){

    try {

        $output='';

        $query="SELECT count(*) FROM users WHERE user_id NOT IN (SELECT user_id FROM chat_groups_participants where chat_group_id=?)";
        $statement=$connect->prepare($query);
        $statement->execute(
            array($group_id)
        );
        $result=$statement->fetchAll();

        //Если есть пользователи, не состоящие в группе
        if($result>0){

            if($param==''&&trim($param)==''){
                $query="SELECT * FROM users WHERE user_id NOT IN (SELECT user_id FROM chat_groups_participants where chat_group_id=?) and user_id!=?";
                $statement=$connect->prepare($query);
                $statement->execute(
                    array($group_id, $_SESSION['user_id'])
                );
            }
            else{
                $placeholder="%$param%";
                $query="SELECT * FROM users WHERE (user_id NOT IN (SELECT user_id FROM chat_groups_participants where chat_group_id=?)) and perconname LIKE ? and user_id!=?";
                $statement=$connect->prepare($query);
                $statement->execute(
                    array($group_id, $placeholder, $_SESSION['user_id'])
                );
            };
            
            $result=$statement->fetchAll();

            foreach($result as $row){   

                $output .= '<tr>
                                <td width="70%">
                                    <img class="avatar rounded-circle" src="'.get_user_photo($row['user_id'], $connect).'"> '.get_user_name($row['user_id'], $connect).' ';                
                $output .= '</td>';
                $output .= '<td width="30%"><br><button class="btn btn-success btn-xs add_user_to_group" type="button" data-userid="'.$row['user_id'].'">Добавить</button>
                                </td>';          
                
                $output .= '</tr>';
            }; 
            echo $output;            
        }
        else{
            $output="<span>Все пользователи состоят в этой группе.</span>";
        };

    } catch (Exception  $ex) {
        echo $ex;
    };
};

function check_user_group_admin($connect, $group_id){

    try{
        $query="SELECT relation_type from chat_groups_participants where user_id=? and chat_group_id=?";
        $statement=$connect->prepare($query);
        $statement->execute(
            array($_SESSION['user_id'], $group_id)
        );
        $result=$statement->fetchAll();
        foreach($result as $row){
            return $row['relation_type'];
        }
    }
    catch(Exception $ex){
        echo $ex;
    }

};

//Проверка, что добавляемый пользователь не состоит в группе
function check_user_group_participant($connect, $user_id, $group_id){
    try{
        $query="SELECT relation_id from chat_groups_participants where user_id=? and chat_group_id=?";
        $statement=$connect->prepare($query);
        $statement->execute(
            array($user_id, $group_id)
        );
        $result=$statement->fetchAll();
        foreach($result as $row){
            if($row['relation_id']!=''){
                return true;
            }
        }
    }
    catch(Exception $ex){
        echo $ex;
    }
};

function add_user_to_group($connect, $user_id, $group_id){
    try {
        
        if(check_user_group_admin($connect, $group_id)!=1){
            echo $output='<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Внимание!</strong> Управление участниками доступно только создателю группы.
                    </div>';
        }
        else if(check_user_group_participant($connect, $user_id, $group_id)){
            echo $output='<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Внимание!</strong> Пользователь уже состоит в группе.
                    </div>';
        }
        else{
        
            $query="INSERT INTO `chat_groups_participants` (`relation_type`, `user_id`, `chat_group_id`, `timestamp_added`) VALUES ('2', ?, ?, CURRENT_TIME());";
            $statement=$connect->prepare($query);
            $statement->execute(
                array($user_id, $group_id)
            );
            $result=$statement->rowCount();

            if($result==1){
                    echo $output='<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Успешно!</strong> Пользователь добавлен в группу.
                </div>';
            }
            else{
                echo $output='<div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>Внимание!</strong> Не удалось добавить пользователя в группу.
                                    </div>';
            };
        };
    } catch (Exception  $ex) {
        echo $output='<div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Внимание! </strong> '.$ex.'
                                </div>';
    }
};

function drop_user_from_group($connect, $user_id, $group_id){
    try {
        
        if(check_user_group_admin($connect, $group_id)!=1){
            echo $output='<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Внимание!</strong> Управление участниками доступно только создателю группы.
                    </div>';
        }
        else if(!check_user_group_participant($connect, $user_id, $group_id)){
            echo $output='<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Внимание!</strong> Пользователь еще не состоит в группе.
                    </div>';
        }
        else{
        
            $query="DELETE FROM chat_groups_participants WHERE user_id=? and chat_group_id=?";
            $statement=$connect->prepare($query);
            $statement->execute(
                array($user_id, $group_id)
            );
            $result=$statement->rowCount();

            if($result==1){
                    echo $output='<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Успешно!</strong> Пользователь исключен из группы.
                </div>';
            }
            else{
                echo $output='<div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>Внимание!</strong> Не удалось исключить пользователя из группы.
                                    </div>';
            };
        };
    } catch (Exception  $ex) {
        echo $output='<div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Внимание! </strong> '.$ex.'
                                </div>';
    }
};

switch($_POST["action"])
{
    case 'add': add_new_group($connect, $_POST['group_name']);break;
    case 'info': get_group_data($connect, $_POST['group_id']); break;
    case 'participants': get_group_participants($connect, $_POST['group_id']); break;                    
    case 'update_group_name': update_group_name($connect, $_POST['group_id'], $_POST['new_name']); break;
    case 'update_photo': update_group_photo($connect, $_POST["group_id"], $_FILES['input_new_group_photo']['tmp_name'], $_FILES['input_new_group_photo']['error']); break;
    case 'fetch_new_participants': fetch_new_group_participants($connect, $_POST['group_id'], $_POST['param']); break;
    case 'add_user_to_group': add_user_to_group($connect, $_POST['user_id'], $_POST['group_id']); break;
    case 'drop_user_from_group': drop_user_from_group($connect, $_POST['user_id'], $_POST['group_id']); break;

}


?>