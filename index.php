<?php
include('db_connection.php');
session_start();
//Проверка авторизации пользователя
if(!isset($_SESSION['user_id']))
{
    header("location:login.php");
}
?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Nutshell work chat</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!--Custom Styles-->
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/chatboxstyle.css">
    <!--Font Awesome-->
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    
     
     <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.js"></script>    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.js"></script>
    <script>
       function check_group_name(){
                var group_name=$('#chat_name').val();
                if(group_name.length!=0)
                {                       
                    $('#create_chat').removeAttr('disabled');
                }
                else
                {
                    $('#create_chat').attr('disabled', 'disabled');
                }
            };
        function check_text_message(){
                var text_message=$('.text-message').val();
                if(text_message.length!=0)
                {                       
                    $('.send').removeAttr('disabled');
                }
                else
                {
                    $('.send').attr('disabled', 'disabled');
                }
            };   
        
      </script>
    
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>  
  </head>
  <body> 
     <div class="container-fluid">
       <div class="row">
            <div class="container-fluid tab">
                    <button class="tablinks" onclick="openTab(event, 'Groups')" id="defaultOpen"><i class="fa fa-comments-o" aria-hidden="true"></i></button>               
                    <button class="tablinks" onclick="openTab(event, 'Dialogs')"><i class="fa fa-comment-o" aria-hidden="true"></i></button>                
                    <button class="tablinks" onclick="openTab(event, 'Favorites')"><i class="fa fa-heart-o" aria-hidden="true"></i></button>
                    <button class="tablinks" onclick="openTab(event, 'Friends')"><i class="fa fa-address-book-o" aria-hidden="true"></i></button>
                </div>         
        <div class="container-fluid"> 
            <nav class="navbar"> 
                <div class="container-fluid" >
                     <div class="navbar-header">
                        <img class="" src="icons/logo.png" alt="nutshell"  >
                     </div> 
                     <div class="table-responsive">
                        <p align="right">Hi - <?php echo $_SESSION['username']; ?> - <a href="logout.php">Logout</a></p>
                       </div>                      
                </div>                
            </nav>
        <div class="container-fluid content tabcontent app" id="Dialogs">
        <div class="row app-one">
          <div class="col-sm-4 side">
            <!--Садйбар со списком существующих диалогов-->
            <div class="side-one">
              <div class="row heading">
                <div class="col-sm-4 col-xs-4">
                  <h4>Диалоги</h4>                               
                </div>
                <div class="col-sm-1 col-xs-1  heading-dot  pull-right">
                  <i class="fa fa-ellipsis-v fa-2x  pull-right" aria-hidden="true"></i>
                </div>
                <div class="col-sm-2 col-xs-2 heading-compose  pull-right">
                  <i class="fa fa-comments fa-2x  pull-right" aria-hidden="true"></i>
                </div>
              </div>
      
              <div class="row searchBox">
                <div class="col-sm-12 searchBox-inner">
                  <div class="form-group has-feedback">
                    <input id="searchText" type="text" class="form-control" name="searchText" placeholder="Поиск">
                    <span class="form-control-feedback"><i class="fa fa-search" aria-hidden="true"></i></span>
                  </div>
                </div>
              </div>

            <!--Список диалогов-->
              <div class="row sideBar">
              
              </div>
                
            </div>
            <!--Сайдбар для создания нового диалога-->
            <div class="side-two">
              <div class="row newMessage-heading">
                <div class="row newMessage-main">
                  <div class="col-sm-2 col-xs-2 newMessage-back">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                  </div>
                  <div class="col-sm-10 col-xs-10 newMessage-title">
                    Написать сообщение
                  </div>
                </div>
              </div>
      
              <div class="row composeBox">
                <div class="col-sm-12 composeBox-inner">
                  <div class="form-group has-feedback">
                    <input id="composeText" type="text" class="form-control" name="searchText" placeholder="Search People">
                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                  </div>
                </div>
              </div>
      
              <div class="row compose-sideBar">
                <div class="row sideBar-body">
                  <div class="col-sm-3 col-xs-3 sideBar-avatar">
                    <div class="avatar-icon">
                      <img src="https://bootdey.com/img/Content/avatar/avatar1.png">
                    </div>
                  </div>
                  <div class="col-sm-9 col-xs-9 sideBar-main">
                    <div class="row">
                      <div class="col-sm-8 col-xs-8 sideBar-name">
                        <span class="name-meta">John Doe
                      </span>
                      </div>
                      <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                        <span class="time-meta pull-right">18:18
                      </span>
                      </div>
                    </div>
                  </div>
                </div>
      
                <div class="row sideBar-body">
                  <div class="col-sm-3 col-xs-3 sideBar-avatar">
                    <div class="avatar-icon">
                      <img src="https://bootdey.com/img/Content/avatar/avatar2.png">
                    </div>
                  </div>
                  <div class="col-sm-9 col-xs-9 sideBar-main">
                    <div class="row">
                      <div class="col-sm-8 col-xs-8 sideBar-name">
                        <span class="name-meta">John Doe
                      </span>
                      </div>
                      <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                        <span class="time-meta pull-right">18:18
                      </span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row sideBar-body">
                  <div class="col-sm-3 col-xs-3 sideBar-avatar">
                    <div class="avatar-icon">
                      <img src="https://bootdey.com/img/Content/avatar/avatar3.png">
                    </div>
                  </div>
                  <div class="col-sm-9 col-xs-9 sideBar-main">
                    <div class="row">
                      <div class="col-sm-8 col-xs-8 sideBar-name">
                        <span class="name-meta">John Doe
                      </span>
                      </div>
                      <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                        <span class="time-meta pull-right">18:18
                      </span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row sideBar-body">
                  <div class="col-sm-3 col-xs-3 sideBar-avatar">
                    <div class="avatar-icon">
                      <img src="https://bootdey.com/img/Content/avatar/avatar4.png">
                    </div>
                  </div>
                  <div class="col-sm-9 col-xs-9 sideBar-main">
                    <div class="row">
                      <div class="col-sm-8 col-xs-8 sideBar-name">
                        <span class="name-meta">John Doe
                      </span>
                      </div>
                      <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                        <span class="time-meta pull-right">18:18
                      </span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row sideBar-body">
                  <div class="col-sm-3 col-xs-3 sideBar-avatar">
                    <div class="avatar-icon">
                      <img src="https://bootdey.com/img/Content/avatar/avatar5.png">
                    </div>
                  </div>
                  <div class="col-sm-9 col-xs-9 sideBar-main">
                    <div class="row">
                      <div class="col-sm-8 col-xs-8 sideBar-name">
                        <span class="name-meta">John Doe
                      </span>
                      </div>
                      <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                        <span class="time-meta pull-right">18:18
                      </span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row sideBar-body">
                  <div class="col-sm-3 col-xs-3 sideBar-avatar">
                    <div class="avatar-icon">
                      <img src="https://bootdey.com/img/Content/avatar/avatar6.png">
                    </div>
                  </div>
                  <div class="col-sm-9 col-xs-9 sideBar-main">
                    <div class="row">
                      <div class="col-sm-8 col-xs-8 sideBar-name">
                        <span class="name-meta">John Doe
                      </span>
                      </div>
                      <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                        <span class="time-meta pull-right">18:18
                      </span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row sideBar-body">
                  <div class="col-sm-3 col-xs-3 sideBar-avatar">
                    <div class="avatar-icon">
                      <img src="https://bootdey.com/img/Content/avatar/avatar2.png">
                    </div>
                  </div>
                  <div class="col-sm-9 col-xs-9 sideBar-main">
                    <div class="row">
                      <div class="col-sm-8 col-xs-8 sideBar-name">
                        <span class="name-meta">John Doe
                      </span>
                      </div>
                      <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                        <span class="time-meta pull-right">18:18
                      </span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row sideBar-body">
                  <div class="col-sm-3 col-xs-3 sideBar-avatar">
                    <div class="avatar-icon">
                      <img src="https://bootdey.com/img/Content/avatar/avatar3.png">
                    </div>
                  </div>
                  <div class="col-sm-9 col-xs-9 sideBar-main">
                    <div class="row">
                      <div class="col-sm-8 col-xs-8 sideBar-name">
                        <span class="name-meta">John Doe
                      </span>
                      </div>
                      <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                        <span class="time-meta pull-right">18:18
                      </span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row sideBar-body">
                  <div class="col-sm-3 col-xs-3 sideBar-avatar">
                    <div class="avatar-icon">
                      <img src="https://bootdey.com/img/Content/avatar/avatar4.png">
                    </div>
                  </div>
                  <div class="col-sm-9 col-xs-9 sideBar-main">
                    <div class="row">
                      <div class="col-sm-8 col-xs-8 sideBar-name">
                        <span class="name-meta">John Doe
                      </span>
                      </div>
                      <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                        <span class="time-meta pull-right">18:18
                      </span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row sideBar-body">
                  <div class="col-sm-3 col-xs-3 sideBar-avatar">
                    <div class="avatar-icon">
                      <img src="https://bootdey.com/img/Content/avatar/avatar5.png">
                    </div>
                  </div>
                  <div class="col-sm-9 col-xs-9 sideBar-main">
                    <div class="row">
                      <div class="col-sm-8 col-xs-8 sideBar-name">
                        <span class="name-meta">John Doe
                      </span>
                      </div>
                      <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                        <span class="time-meta pull-right">18:18
                      </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      
          <div class="col-sm-8 conversation">
            <div class="row heading">
              <div class="col-sm-2 col-md-1 col-xs-3 heading-avatar">
                <div class="heading-avatar-icon">
                  <img src="https://bootdey.com/img/Content/avatar/avatar6.png">
                </div>
              </div>
              <div class="col-sm-8 col-xs-7 heading-name">
                <a class="heading-name-meta">John Doe
                </a>
                <span class="heading-online">Online</span>
              </div>
              <div class="col-sm-1 col-xs-1  heading-dot pull-right">
                <i class="fa fa-ellipsis-v fa-2x  pull-right" aria-hidden="true"></i>
              </div>
            </div>
      
            <div class="row message" id="conversation">
              <div class="row message-previous">
                <div class="col-sm-12 previous">
                  <a onclick="previous(this)" id="ankitjain28" name="20">
                  Show Previous Message!
                  </a>
                </div>
              </div>
      
              <div class="row message-body">
                <div class="col-sm-12 message-main-receiver">
                  <div class="receiver">
                    <div class="message-text">
                     Hi, what are you doing?!
                    </div>
                    <span class="message-time pull-right">
                      Sun
                    </span>
                  </div>
                </div>
              </div>
      
              <div class="row message-body">
                <div class="col-sm-12 message-main-sender">
                  <div class="sender">
                    <div class="message-text">
                      I am doing nothing man!
                    </div>
                    <span class="message-time pull-right">
                      Sun
                    </span>
                  </div>
                </div>
              </div>
            </div>
      
            <div class="row reply">
              <div class="col-sm-1 col-xs-1 reply-emojis">
                <i class="fa fa-smile-o fa-2x"></i>
              </div>
              <div class="col-sm-9 col-xs-9 reply-main">
                <textarea class="form-control" rows="1" id="comment"></textarea>
              </div>
              <div class="col-sm-1 col-xs-1 reply-recording">
                <i class="fa fa-microphone fa-2x" aria-hidden="true"></i>
              </div>
              <div class="col-sm-1 col-xs-1 reply-send">
                <i class="fa fa-send fa-2x" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>   
        </div> 
        <div class="container-fluid content tabcontent" id="Friends"> 
                <div class="tab-content col-lg-5 col-md-5 col-sm-5 col-xs-5">
                        <div class="tab-content-header">
                            <h4>Пользователи</h4>
                        </div>
                        <div class="container-fluid tab-content-content" id="user_details">                            
                        </div> 
                </div>
        </div>
         <div class="container-fluid content tabcontent" id="Groups">
                <div class="tab-content col-lg-5 col-md-5 col-sm-5 col-xs-5">
                        <div class="tab-content-header">
                            <h4>Беседы<button name="group_chat_creator" id="group_chat_creator" class="btn btn-success btn-xs pull-right">Создать беседу</button></h4>
                               </div>
                        <div class="tab-content-content" id="groups_chats_details" style="overflow-y: scroll;">
                        </div>                
                     
                </div>
                <div class="group-chat-message-space col-lg-7 col-md-7 col-sm-7 col-xs-7">  
                </div>
         </div>        
               
          <div class="container-fluid content tabcontent" id="Favorites">
                <div class="tab-content col-lg-5 col-md-5 col-sm-5 col-xs-5">
                        <div class="tab-content-header">
                            <h4>Избранное</h4> 
                        </div>                            
                        <div class="container-fluid tab-content-content" id="favorites_details">
                        </div> 
                </div>
        </div>             
        </wrapper>
     </div>
</div>
    <script>
      function openTab(evt, tabName) {
          var i, tabcontent, tablinks;
          tabcontent = document.getElementsByClassName("tabcontent");
          for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
          }
          tablinks = document.getElementsByClassName("tablinks");
          for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
          }
          document.getElementById(tabName).style.display = "block";
          evt.currentTarget.className += " active";
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();
      </script>   
    <script>
        $(function(){
      $(".heading-compose").click(function() {
        $(".side-two").css({
          "left": "0"
        });
      });
  
      $(".newMessage-back").click(function() {
        $(".side-two").css({
          "left": "-100%"
        });
      });
  })
        $(document).ready(function(){           
              
            
                fetch_user(); 
                fetch_dialogs();
                fetch_groups_chats();


            function update_activity_data()
            {
                update_last_activity();
                fetch_user();   
                update_chat_history_data();                
                fetch_dialogs();
                fetch_groups_chats();
                update_group_chat_history_data();                
            };

            setInterval(update_activity_data, 5000);                   
            
            
            function fetch_user()
            {
                $.ajax({
                    url:"fetch_user.php",
                    method:"POST",
                    success:function(data){
                        $('#user_details').html(data);
                    }
                })
            };
            
            function fetch_dialogs()
            {
                $.ajax({
                    url: "fetch_dialogs.php",
                    method: "POST",
                    success:function(data){
                        $('#dialogs_details').html(data);
                    }
                })
            };
            
            function fetch_groups_chats(){              
              $.ajax({
                  url:"fetch_groups.php",
                  method:"POST",
                  success:function(data){
                      $('#groups_chats_details').html(data);
                  }
              })  
            };
            
            function update_last_activity()
            {
                $.ajax({
                    url:"update_last_activity.php", 
                    success:function(){
                        
                    }                   
                })
            };  
            
            function make_chat_dialog_box(to_user_id, to_user_name)
            {
                $('.message-space').empty();
                var message_box = '<div class="message-space-header container">'; 
                message_box = '<div class="row">'; 
                message_box += '<div class="col-md-11 col-xs-11"><span>'+to_user_name+'</span></div>';
                message_box += '<div class="col-md-1 col-xs-1"><button class="close_chat btn btn-warning btn-xs">x</button></div>';
                message_box += '</div>';               
                message_box += '<div class="message-box" id="user_model_details">';
                message_box += '<div class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'"></div>';
                message_box += fetch_user_chat_history(to_user_id);
                message_box += '</div>';    
                //message_box += '<div class="container">';
                message_box += '<form action="" method="post">';
                message_box += '<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control chat_message text-message" placeholder="Напишите сообщение..." onkeyup="check_text_message();"></textarea>';
                message_box += '<br><button align="right" type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-info send_chat send" disabled>Отправить</button>'; 
                message_box += '</form>';                
                $('.message-space').append(message_box);  
            }
            
            $(document).on('click', '.close_chat', function(){
                $('.message-space').empty();
            });
            
            
            $(document).on('click', '.start_chat', function(){
                var to_user_id = $(this).data('touserid');
                var to_user_name = $(this).data('tousername'); 
                make_chat_dialog_box(to_user_id, to_user_name); 
                var block = document.getElementById("user_model_details");
                block.scrollTop = block.scrollHeight;
            });
            
            $(document).on('click', '.send_chat', function(){
                var to_user_id = $(this).attr('id');
                var chat_message = $('#chat_message_'+to_user_id).val();
                $.ajax({
                    url:"insert_chat.php",
                    method: "POST",
                    data:{to_user_id:to_user_id, chat_message:chat_message},
                    success: function(data)
                    {  
                        $('#chat_message_'+to_user_id).val('');
                        $('#chat_history_'+to_user_id).html(data);
                    }
                })
            });
            
          function fetch_user_chat_history(to_user_id)
            {
               $.ajax({
                   url: "fetch_user_chat_history.php",
                   method: "POST",
                   data:{to_user_id:to_user_id},
                   success: function(data){
                       $('#chat_history_'+to_user_id).html(data);
                   }
               })
            };
            
            
            function update_chat_history_data()
            {
                $('.chat_history').each(function(){
                    var to_user_id = $(this).data('to_user_id');
                    fetch_user_chat_history(to_user_id);
                });
            };
            
            $(document).on('focus', '.chat_message', function(){
               var is_type = 'yes';
                $.ajax({
                    url:"update_is_type_status.php",
                    method:"POST",
                    data:{is_type:is_type},
                    success:function()
                    {
                        
                    }                    
                    
                })
            });
            
            $(document).on('blur', '.chat_message', function(){ 
                var is_type='no';
                $.ajax({
                    url:"update_is_type_status.php",
                    method:"POST",
                    data:{is_type:is_type},
                    success:function()
                    {
                        
                    }
                })
                    
            });           
           
            
            function create_group_chat_box()
            {            
                $('.group-chat-message-space').empty();
                var chat_creator = '<div class="container-fluid chat-creator">';  
                chat_creator += '<form action="" method="post">';
                chat_creator += '<label for="chat_name">Название</label>';
                chat_creator += '<input type="text" class="form-control" id="new_chat_name" name="chat_name" value="" required">';
                chat_creator += '<br><button type="button" id="create_group_chat" class="form-control btn btn-sm btn-primary">Создать чат</button>';
                chat_creator += '</form>';
                chat_creator += '<div class="container-fluid" id="chat_group_control">';
                chat_creator += '</div>';
                chat_creator += '</div>';  
                $('.group-chat-message-space').append(chat_creator);
            };
            
            $(document).on('click', '#group_chat_creator', function(){                
                create_group_chat_box();                
            });
            
            $(document).on('click', '#create_group_chat', function(){
                if($('#new_chat_name').val()!="")
                    {
                        var chat_name=$('#new_chat_name').val();  
                        $.ajax({
                            url:"create_group_chat.php",
                            method:"POST",
                            data:{group_name:chat_name},
                            success:function(data){
                                $('#new_chat_name').val(''); start_chat_group_control(data);
                            }
                        })
                    }
                else alert("Не указано название беседы");
                
            });           
            
            //Отображение таблицы управления участниками группы
            function start_chat_group_control(chat_id)
            {
                $.ajax({
                    url:"fetch_group_chat_control.php",
                    method:"POST",
                    data:{chat_id:chat_id},
                    success:function(data){
                        $("#group-chat-message-space").html(data);
                    }
                })
            };
            
            $(document).on('click', '.edit_group_chat', function(){
                var chat_id = $(this).data('chatgroupid');
                start_chat_group_control(chat_id);
            });
            
            
            
            
            //Функция формирует область просмотра сообщений чата группы
            function make_chat_group_box(to_chat_id, to_chat_name)
            {
                $('.group-chat-message-space').empty();
                var message_box = '<div class="message-space-header container">'; 
                message_box = '<div class="row">'; 
                message_box += '<div class="col-md-11 col-xs-11"><span>'+to_chat_name+'</span></div>';
                message_box += '<div class="col-md-1 col-xs-1"><button class="close_group_chat btn btn-warning">x</button></div>';
                message_box += '</div>';               
                message_box += '<div class="message-box" id="chat_group_model_details">';
                message_box += '<div class="chat_group_history" data-to-chat="'+to_chat_id+'" id="chat_group_history_'+to_chat_id+'"></div>';
                message_box += fetch_group_chat_history(to_chat_id);
                message_box += '</div>';
                message_box += '<form action="" method="post">';
                message_box += '<textarea name="chat_group_message_'+to_chat_id+'" id="chat_group_message_'+to_chat_id+'" class="form-control chat_group_message text-message" placeholder="Напишите сообщение..." onkeyup="check_text_message();"></textarea>';
                message_box += '<button type="button" name="send_group_chat" id="'+to_chat_id+'" class="btn btn-info send_group_chat send" disabled>Отправить</button>'; 
                message_box += '</form>';                
                $('.group-chat-message-space').append(message_box);  
            };            
            
            
            $(document).on('click', '.close_group_chat', function(){
                $('.group-chat-message-space').empty();
            }); 
            
            $(document).on('click', '.start_group_chat', function(){
                var to_group_chat_id = $(this).data('tochatgroupid');
                var to_group_chat_name = $(this).data('tochatgroupname'); 
                make_chat_group_box(to_group_chat_id, to_group_chat_name);                
            });
            
            $(document).on('click', '.send_group_chat', function(){
                var to_chat_id = $(this).attr('id');
                var chat_message = $('#chat_group_message_'+to_chat_id).val();
                $.ajax({
                    url:"insert_group_chat.php",
                    method: "POST",
                    data:{to_chat_id:to_chat_id, chat_message:chat_message},
                    success: function(data)
                    {  
                        $('#chat_group_message_'+to_chat_id).val('');
                        $('#chat_group_history_'+to_chat_id).html(data);
                    }
                })
            });
            
            
            function fetch_group_chat_history(to_chat_id)
            {
               $.ajax({
                   url: "fetch_group_chat_history.php",
                   method: "POST",
                   data:{to_chat_id:to_chat_id},
                   success: function(data){
                       $('#chat_group_history_'+to_chat_id).html(data);
                   }
               })
            };
            
            
            function update_group_chat_history_data()
            {
                $('.chat_group_history').each(function(){
                    var to_chat_id = $(this).data('toChat');
                    fetch_group_chat_history(to_chat_id);
                });
            };
        }); 
      </script>
  </body>
</html>