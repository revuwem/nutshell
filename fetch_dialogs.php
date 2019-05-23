<?

include('db_connection.php');
session_start();

//Выборка диалогов, в которых состоит пользователь
$query="SELECT * 
        FROM `users_chats_complicity` 
        WHERE user_1 = :user_id 
        OR user_2=:user_id
        ";

$statement=$connect->prepare($query);
$statement->execute(array(':user_id' => $_SESSION['user_id']));
$resultDialogs=$statement->fetchAll();

$output='';

    //Для каждого диалога формируем его элемент отображения
    foreach($resultDialogs as $rowDialog)
    {
        //Выбираем данные текущего диалога
        $query="SELECT * FROM `users_chats_complicity` WHERE chat_id = '".$rowDialog['chat_id']."'";
        $statement=$connect->prepare($query);
        $statement->execute();
        $result=$statement->fetchAll();

        foreach($result as $rowComplicity)
        {
            //Получаем id собеседника (не id текущего пользователя)           
            if($rowComplicity['user_1']==$_SESSION['user_id'])
            {
                $interlocutor=$rowComplicity['user_2'];
            }
            else{
                $interlocutor=$rowComplicity['user_1'];
            };  


            //Выбираем последнее сообщение диалога и id отправителя
            $query="SELECT chat_message, from_user_id FROM chat_message WHERE chat_id = '".$rowDialog['chat_id']."' ORDER BY timestamp DESC LIMIT 1
            ;";
                $statement=$connect->prepare($query);
                $statement->execute();
                $result=$statement->fetchAll();


            foreach($result as $message)
            {
                $output .= '<li class="list-group-item btn btn-light dialogElement start-chat mt-1" data-touserid="'.$interlocutor.'" data-tousername="'.get_user_name($interlocutor, $connect).'">
                                <div class="row">
                                    <div class="col col-2 col-sm-3 col-md-2 col-lg-1">
                                        <img class="rounded-circle  avatar" src="https://bootdey.com/img/Content/avatar/avatar1.png">
                                    </div>
                                    <div class="col col-10 col-sm-9 col-md-10 col-lg-11">
                                        <p class="font-weight-bold">'.get_user_name($interlocutor, $connect).'</p><span class="label label-success rounded-circle"> '.count_unseen_message($rowDialog['from_user_id'], $_SESSION['user_id'], $connect).'</span><br> 
                                    ';
                        if($message['from_user_id']==$_SESSION['user_id']){
                            $output .= '<p class="last-message">Вы:  '.$message['chat_message'].'</p>';
                        }
                        else{
                            $output .= '<p class="last-message">'.$message['chat_message'].'</p>';
                        } 
                    $output .= '</div>'; 
            }; 
        }; 
        $output .= '</div>            
                </li>
               
        ';      

    };
    
echo $output;

?>