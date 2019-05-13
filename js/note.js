
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
        function editUserBasicInfo(){
            var formdata = $('#userBasicInfo').serialize();
            $.ajax({
              type: "POST", 
              url: "edit_userprofile.php",
              data: formdata,
              success: function(data){
                $('#editBasicInfoResult').html(data);
              },
              error: function(xhr, str){
                alert('Возникла ошибка: ', xhr.resonseCode);
              }
            });
          } 

          
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
     
