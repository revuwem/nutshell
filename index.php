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
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Nutshell</title>

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--Font Awesome-->
  <link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.min.css">

  <!-- Custom styles -->
  <link href="css/style.css" rel="stylesheet">
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
  <div class="d-flex" id="wrapper">

<!-- Sidebar -->
<div class="border-right" id="sidebar-wrapper">
  <div class="sidebar-heading">Nutshell</div>
  <div class="list-group list-group-flush">
    <a class="list-group-item list-group-item-action active" data-toggle="list" href="#Groups" role="tab"><span class="fa fa-comments-o fa-fw" aria-hidden="true"></span> Группы</a>
    <a class="list-group-item list-group-item-action" data-toggle="list" href="#Dialogs" role="tab"><span class="fa fa-comment-o fa-fw" aria-hidden="true"></span> Диалоги</a>
    <a class="list-group-item list-group-item-action" data-toggle="list" href="#Tasks" role="tab"><span class="fa fa-tasks fa-fw" aria-hidden="true"></span> Задачи</a>
    <a class="list-group-item list-group-item-action" data-toggle="list" href="#Contacts" role="tab"><span class="fa fa-address-book-o fa-fw" aria-hidden="true"></span> Контакты</a>        
    <a class="list-group-item list-group-item-action" data-toggle="list" href="#Marks" role="tab"><span class="fa fa-thumb-tack fa-fw" aria-hidden="true"></span> Закладки</a>    
    <a class="list-group-item list-group-item-action" data-toggle="list" href="#Profile" role="tab"><span class="fa fa-cogs fa-fw" aria-hidden="true"></span> Профиль</a>    
  </div>
</div>
<!-- /#sidebar-wrapper -->

<!-- Page Content -->
<div id="page-content-wrapper">

  <nav class="navbar navbar-expand-lg navbar-light border-bottom justify-content-between">       
    <a class="btn" id="menu-toggle"><i class="fa fa-align-left" aria-hidden="true"></i></a>
    <a class="btn" href="logout.php"><span class="fa fa-sign-out fa-fw" aria-hidden="true"></span>Выход</a>
  </nav>

  <div class="container-fluid tab-content">
    <div class="tab-pane show active" id="Groups" role="tabpanel">
      <h3>Группы</h3>
    </div>
    <div class="tab-pane" id="Dialogs" role="tabpanel">
        <div class="container-fluid app">
            <div class="row app-one">
              <div class="col col-4 side">
                <div class="row header">
                  <div class="col">
                    <p class="header-text">Диалоги</p> 
                  </div>
                </div>
                <div class="row searchBox">
                  <div class="input-group">
                    <input type="text" class="form-control" id="searchDialog" name="searchDialog" placeholder="Поиск"><span class="fa fa-search"></span> 
                  </div>
                </div>
                <div class="row side-body">
                <ul class="list-unstyled list-group">
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col dialog-item">
                          <div class="row">
                              <div class="col-3">
                                <img class="rounded-circle  avatar" src="https://bootdey.com/img/Content/avatar/avatar1.png">
                              </div>
                              <div class="col-9">
                                <p>User Name</p>
                                <span class="float-right fa fa-angle-right"></span> 
                              </div>                 
                          </div>
                          <div class="row">
                              <div class="col-9 last-message-text"><p>last message last message last message</p></div>
                              <div class="col-3"><span class="small">18:18</span></div>                              
                          </div>
                      </div>                
                  </li>            
                  </ul>  
                </div>
              </div>
              <div class="col col-8">
                <div class="row header">
                  <div class="col col-2 col-md-1" >
                    <button type="button" class="close">&times;</button>
                  </div>                  
                  <div class="col col-10 header-info">
                    <img class="rounded-circle  avatar" src="https://bootdey.com/img/Content/avatar/avatar1.png"><span class="rounded-circle online"></span>
                    <p class="header-text">User Name</p>
                  </div>            
                </div>
                <div class="row history">
                  <div class="col col-12">
                    <div class="row message-sender">
                     <div class="col col-2"><img class="rounded-circle  avatar" src="https://bootdey.com/img/Content/avatar/avatar1.png"><span class="rounded-circle online"></span></div>
                      <div class="col col-8 col-lg-4"><p>Some message text!</p></div>
                      <div class="col col-2 col-md-2"><span>18:18</span></div>
                    </div>
                    <div class="row message-receiver justify-content-end">
                     <div class="col col-2"><span>18:18</span></div>
                      <div class="col col-8 col-lg-4"><p class="float-right">Some message text!</p></div>
                      <div class="col col-2 col-md-1"><img class="rounded-circle  avatar" src="https://bootdey.com/img/Content/avatar/avatar1.png"><span class="rounded-circle online"></span></div>
                    </div>
                  </div>            
                </div>
                <div class="row reply">
                  <form action="" class="input-group">
                    <input type="text" class="col-11 form-control" placeholder="Введите сообщение...">
                    <button class="col-1 btn form-control"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>              
                  </form>
                </div>
              </div>
            </div>
          </div>                
    </div><!--/#Dialogs-->
    <div class="tab-pane" id="Tasks" role="tabpanel">
      <h3>Задачи</h3>
    </div>
    <div class="tab-pane" id="Contacts" role="tabpanel">
      <h3>Контакты</h3>
    </div>
    <div class="tab-pane" id="Marks" role="tabpanel">
      <h3>Закладки</h3>
    </div>
    <div class="tab-pane" id="Profile" role="tabpanel">
        <div class="grid profile-content">
            <aside class="sidebar">

            </aside>
            <main class="edit-profile">

            </main>
        </div><!--/.profile-content-->      
    </div>
  </div><!--/#tab-content-->
</div>
<!-- /#page-content-wrapper -->

</div>
<!-- Bootstrap core JavaScript -->
<script src="js/jquery/jquery.min.js"></script>
  <script src="js/bootstrap/bootstrap.bundle.min.js"></script>
<!-- /#wrapper -->
<!-- Menu Toggle Script -->
<script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");     
    });

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
    });
  </script>
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