/* 
background.js
Фоновые скрипты для подгрузки пользовательских данных
*/

$(document).ready(function() {

    getUserInfo(); 
    link_dialogs_list();
    link_groups_list();

    function updates(){
        fetch_user();
        update_last_activity();
        fetch_dialogs();        
        fetch_groups_chats();
    }

    setInterval(updates, 5000);

    //Обновление активности пользователя
    function update_last_activity() {
        $.ajax({
            url:"update_last_activity.php", 
            success:function(){
                      
            },
            error: function(xhr, str){
                 
            }                 
        });
    };

    function link_dialogs_list() {
        $.ajax({
            url:"dialogs_list_html.php",
            method: "get",
            success:function(data){
                $('#dialogs').html(data);
                fetch_dialogs(); 
            }
        });
    };

    function link_groups_list() {
        $.ajax({
            url:"groups_list_html.php",
            method: "get",
            success:function(data){
                $('#groups').html(data);
                fetch_groups_chats();
            }
        });
    };    

    //Получение информации в профиле пользователя
    function getUserInfo() {
        $.ajax({
            type: "POST",
            url: "get_user_info.php",                        
            success: function(data){ 
                var result = JSON.parse(data);  
                $('#profileUserPhoto').attr('src', result[0]["photo"]);             
                $('#username-profile').html(result[0]["username"]);                 
                $('#person-profile').html(result[0]["perconname"]);
                $('#position-profile').html(result[0]["position"]); 
                $('#worknumber-profile').html(result[0]["worknumber"]); 
                $('#mobilenumber-profile').html(result[0]["mobilenumber"]);
                
                $('#inputUserName').val(result[0]["username"]); 
                $('#inputPersonName').val(result[0]["perconname"]);
                $('#inputUserPosition').val(result[0]["position"]); 

                $('#inputUserWorkNumber').val(result[0]["worknumber"]); 
                $('#inputUserMobileNumber').val(result[0]["mobilenumber"]);
            },
            error: function(xhr, str){
                alert("Ошибка ", xhr.responseCode);                
            }
        });
    }; //getUserInfo

    //Получение списка контактов
    function fetch_user() {
        $.ajax({
            url:"fetch_user.php",
            timeout: 4000,
            method:"POST",
            success:function(data){
                $('#contacts-panel').html(data);
            }
        });
    };    

    //Получение списка диалогов
    function fetch_dialogs(){
        $.ajax({
            url: "fetch_dialogs.php",
            timeout: 4000,
            method: "POST",
            success:function(data){
                $('#dialogs_details').html(data);
            },
            error: function(xhr, str){
                                  
            }
        });
    };
    
    //Список бесед
    function fetch_groups_chats(){              
        $.ajax({
            url:"fetch_groups.php",
            timeout: 4000,
            method:"POST",
            success:function(data){
                $('#groups_details').html(data);
            }
        });  
      };

    //Получение истории диалога 
    function fetch_dialog_chat_history(to_user_id) {
        $.ajax({
            url: "fetch_user_chat_history.php",
            method: "POST",
            data:{to_user_id:to_user_id},
            success: function(data){
                $('.dialog-history').html(data);
            }
        });
    };

    //Окно диалога
    $(document).on('click', '.dialogElement', function(){
        $('#dialogs').empty();
        var to_user_id=$(this).data('touserid');
        var to_user_name=$(this).data('tousername');
        $.ajax({
            url:"dialog_history.php",
            method: "get",
            success:function(result){
                $('#dialogs').html(result);
                fetch_dialog_chat_history(to_user_id);
                $('#dialog-sender').html(to_user_name);
                $('#send-dialog-chat').attr('data-touserid', to_user_id);
                var block = document.getElementsByClassName('.dialog-history');
                block.scrollTop=block.scrollHeight;        
            }
        });
    });

    //Закрыть окно диалога
    $(document).on('click', '#close-dialog-form', function(){
        $('#dialogs').empty();
        link_dialogs_list();
    });
        


    //Получение истории группы 
    function fetch_group_chat_history(to_group_id) {
        $.ajax({
            url: "fetch_group_chat_history.php",
            method: "POST",
            data:{to_chat_id:to_group_id},
            success: function(data){
                $('.group-history').html(data);
            }
        });
    };

    //Открыть окно группы
    $(document).on('click', '.groupElement', function(){
        $('#groups').empty();
        var to_chat_id=$(this).data('chatgroupid');
        var to_chat_name=$(this).data('chatgroupname');
        $.ajax({
            url:"group_history.php",
            method: "get",
            success:function(result){
                $('#groups').html(result);
                fetch_group_chat_history(to_chat_id);
                $('#group-name').html(to_chat_name);
                $('#send-group-chat').attr('data-tochatid', to_chat_id);
                var targetDiv = $(".group-history");
                targetDiv.scrollTop( targetDiv.prop('scrollHeight') );            
            }
        });
    });

    //Закрыть окно группы
    $(document).on('click', '#close-group-form', function(){
        $('#groups').empty();
        link_groups_list();
    });
    

    $("#dialog").dialog({autoOpen: false,
    title: "Новая группа",    
    modal:true,
    buttons:[{text:"Создать", click: createNewGroup}],
    width: 400,
    height: 160
    
});

    //Открыть диалоговое окно создания группы
    $(document).on('click', '#btn_create_group_dialog', function(){
        $("#dialog").dialog("open");
    });

    
    

       
      
   

}); //document.ready


