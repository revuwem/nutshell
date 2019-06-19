<?php

//Скрипт содержит функции анализа выполнения задач группы, формирования отчет и отправки его на почту, если она указана в профиле

include('db_connection.php');
session_start();


function make_task_analyse_report($connect, $group_id, $month){
    try{

        $output='';

        $report=''; //разметка отчета
        $period = null; //период, за который нужен отчет

        $total_tasks=null;   //суммарное количество задач
        $completed_tasks=null;  //количество выполненных задач
        $running_tasks=null;    //количество задач в работе
        $tasks_to_perform=null; //количество задач к выполнению
        $non_completed_tasks=null;  //количество невыполненных задач

        $completed_tasks_percent=null;  //процент выполненных задач
        $running_tasks_percent=null;    //процент задач в работе
        $tasks_to_perform_percent=null; //процент задач к выполнению
        $non_completed_tasks_percent=null;  //процент невыполненных задач

        define("STATUS_TO_WORK", 1);    //статус задачи к выполнению = 1
        define("STATUS_IN_WORK", 2);    //статус задачи в работе = 2
        define("STATUS_COMPLETED", 3);  //статус выполненной задачи = 3

       
        //Формируем дату для поиска за период

        $year=date('Y');
        $daystart='01';
        $dayfinish='31';

        if($month=='00'){
            $month=date('m');
        }

        $date_placeholder_1 = $year."-".$month."-".$daystart;
        $date_placeholder_2=  $year."-".$month."-".$dayfinish;

        //Проверяем сколько всего существует задач для выбранной группы        
        $query="SELECT count(*) FROM `task_list` where group_id=? and create_date BETWEEN ? AND ?";
        $statement=$connect->prepare($query);
        $statement->execute(array($group_id, $date_placeholder_1, $date_placeholder_2));
        $total_tasks=$statement->fetchColumn();

        if($total_tasks>0){

            //Выбираем данные задач группы для анализа 
            $query="SELECT * FROM `task_list` where group_id=? and create_date BETWEEN ? AND ?";
            $statement=$connect->prepare($query);
            $statement->execute(array($group_id, $date_placeholder_1, $date_placeholder_2));
            $result=$statement->fetchAll();


            foreach($result as $row){

                $current_date=date('Y-m-d');
                

                //Если текущая дата больше срока выполнения задачи - она считается невыполненной
                if(($current_date>$row['due_date'])&&($row["status"]!=STATUS_COMPLETED)){

                    $non_completed_tasks=$non_completed_tasks+1;

                }
                else if($row["status"]==STATUS_COMPLETED){

                    $completed_tasks=$completed_tasks+1;

                }
                else if($row["status"]==STATUS_IN_WORK){

                    $running_tasks=$running_tasks+1;
                }
                else{
                    $tasks_to_perform=$tasks_to_perform+1;
                };
            };

            //Все результаты округляются до двух знаков после запятой
            //Вычисляем процент невыполненных задач

            $total_tasks = floatval($total_tasks);

            $non_completed_tasks_percent=$non_completed_tasks/$total_tasks*100;
            $non_completed_tasks_percent=round($non_completed_tasks_percent, 2);

            //Вычисляем процент завершенных задач
            $completed_tasks_percent=$completed_tasks/$total_tasks*100;
            $completed_tasks_percent=round($completed_tasks_percent, 2);

            //Вычисляем процент задач в работе 
            $running_tasks_percent=$running_tasks/$total_tasks*100;
            $running_tasks_percent=round($running_tasks_percent, 2);

            //Вычисляем процент задач к выполнению
            $tasks_to_perform_percent=$tasks_to_perform/$total_tasks*100;
            $tasks_to_perform_percent=round($tasks_to_perform_percent, 2);

            // Формируем строковое представление периода, за который софрмирован отчет
            switch($month){
                case '00': $period='текущий месяц'; break;
                case '01': $period='Январь'; break;
                case '02': $period='Февраль'; break;
                case '03': $period='Март'; break;
                case '04': $period='Апрель'; break;
                case '05': $period='Май'; break;
                case '06': $period='Июнь'; break;
                case '07': $period='Июль'; break;
                case '08': $period='Август'; break;
                case '09': $period='Сентябрь'; break;
                case '10': $period='Октябрь'; break;
                case '11': $period='Ноябрь'; break;
                case '12': $period='Декабрь'; break;                
            };

            //формируем отчет
            $report .= "Добрый день, ".get_user_name($_SESSION['user_id'], $connect).". Вы запросили отчет о выполнении задач группы ".get_group_chat_name($group_id, $connect).".\r\n";
            $report .= "<br><br>";
            $report .= "Отчет \" Анализ выполнения задач рабочей группой\"";
            $report .= "<br>"; 
            $report .= "Группа: ".get_group_chat_name($group_id, $connect)." <br>";
            $report .= "Период: ".$period.", ".$year." ";
            $report .= "<br>"; 

            $tableheader="<table cellpadding='0' cellspacing='0' height='100%' width='100%' id='bodyTable'>
                            <tr>
                            <td align='center' valign='top'>
                                <table cellpadding='10' cellspacing='0' width='600' id='emailContainer'>
                                <tr>
                                    <td align='center' valign='top'>
                                    <table cellpadding='20' cellspacing='0' width='100%' id='emailHeader' style='border: 1px solid grey; background-color:rgba(155, 111, 191, 1); color: whitesmoke;'>
                                        <tr>
                                        <td align='center' valign='top'>
                                            Выполнено
                                        </td>
                                        <td align='center' valign='top'>
                                            Выполняются
                                        </td>
                                        <td align='center' valign='top'>
                                            Взяты в работу
                                        </td>
                                        <td align='center' valign='top'>
                                            Не выполнено
                                        </td>
                                        </tr>                                        
                                    </table>
                                    </td>
                                </tr>
                                <tr>";          

                $tablefooter="<tr>
                                <td align='center' valign='top'>
                                <table cellpadding='10' cellspacing='0' width='100%' id='emailFooter'>
                                    <tr>
                                    <td align='left' valign='top'>
                                        Отчет сформирован на основе данных приложения Nutshell
                                    </td>
                                    <td align='right' valign='top'>
                                        ".$current_date."
                                    </td>
                                    </tr>
                                </table>
                                </td>
                            </tr>
                            </table>
                            </td>
                        </tr>
                        </table>";  
                        
                $tablebody="<tr>
                                <td align='center' valign='top'>
                                <table cellpadding='20' cellspacing='0' width='100%' id='emailBody' style='border: 1px solid grey;'>
                                    <tr>
                                    <td align='center' valign='top'>
                                        ".$completed_tasks_percent."%
                                    </td>
                                    <td align='center' valign='top'>
                                    ".$running_tasks_percent."%
                                    </td>
                                    <td align='center' valign='top'>
                                    ".$tasks_to_perform_percent."%
                                    </td>
                                    <td align='center' valign='top'>
                                    ".$non_completed_tasks_percent."%
                                    </td>
                                    </tr> 
                                    <tr cellpadding='0' cellspacing='0' width='100%' id='emailBody'>
                                            <td colspan='4' style='border-top: 1px solid grey; background-color:rgba(186, 133, 228, 0.6);'>Всего поставленных задач: ".$total_tasks."</td>
                                        </tr>             
                                </table>
                                </td>
                            </tr>";

                $report .= $tableheader;
                $report .= $tablebody;
                $report .= $tablefooter;

                $email=get_user_email($connect, $_SESSION['user_id']);
                $headers = 'From: nutshellkrow88@gmail.com';
                $headers  .= 'MIME-Version: 1.0' . "\r\n";
                $headers .= "Content-type: text/html; charset = \"utf-8\".\r\n";


                if(mail($email, 'Отчет', $report, $headers))
                {
                    echo $output='<div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Успешно!</strong> Отчет отправлен на Ваш e-mail. 
                            </div>';
                }
                else{
                    echo $output='<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Внимание!</strong> Не удалось отправить отчет. Проверьте, что в вашем профиле указан e-mail. 
                        </div>';
                }; 
        }
        else{
            echo $output='<div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Внимание!</strong> Для группы не найдено задач за выбранный период. 
            </div>';
        };
    }
    catch(Exception $ex){
        echo $output='<div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Внимание!</strong> Ошибка формирования отчета. '.$ex.'
    </div>';
    }
}

echo make_task_analyse_report($connect, $_POST['group_id'], $_POST['month']);
?>