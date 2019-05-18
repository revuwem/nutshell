/* 
background.js
Фоновые скрипты для подгрузки пользовательских данных
*/

$(document).ready(function() {

    getUserInfo();
    fetch_dialogs();  
    fetch_groups_chats();
    link_dialogs_list();
    link_groups_list();

    function updates(){
        fetch_user();
        update_last_activity();
        fetch_dialogs();
        fetch_groups_chats();
    }

    setInterval(updates, 3000);


    function link_dialogs_list() {
        $.ajax({
            url:"dialogs_list_html.php",
            method: "get",
            success:function(data){
                $('#list-dialogs').html(data);
            }
        });
    };

    function link_groups_list() {
        $.ajax({
            url:"groups_list_html.php",
            method: "get",
            success:function(data){
                $('#list-groups').html(data);
            }
        });
    };

    //Обновление активности пользователя
    function update_last_activity() {
        $.ajax({
            url:"update_last_activity.php", 
            success:function(){
                      
            },
            error: function(xhr, str){
                alert("Ошибка обновления активности:", xhr.responseCode);  
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
                $('#username-profile').html(result[0]["username"]);                 
                $('#person-profile').html(result[0]["firstname"].concat(" ", result[0]["lastname"]));
                $('#position-profile').html(result[0]["position"]); 
                $('#worknumber-profile').html(result[0]["worknumber"]); 
                $('#mobilenumber-profile').html(result[0]["mobilenumber"]);
                
                $('#inputUserName').val(result[0]["username"]); 
                $('#inputPersonFirstName').val(result[0]["firstname"]); 
                $('#inputPersonLastName').val(result[0]["lastname"]);                
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
    }; //fetch_user

    //Слайдер окно чата
    $(function(){
        $(".dialogElement").click(function() {
          $("#side-chatbox").css({
            "right": "0"
          });
        }); 
      
      $("#hide-side-chatbox").click(function() {
          $("#side-chatbox").css({
            "right": "-100%"
          });
        });
    });

    //Список диалогов
    function fetch_dialogs()
            {
                $.ajax({
                    url: "fetch_dialogs.php",
                    timeout: 4000,
                    method: "POST",
                    success:function(data){
                        $('#dialogs_details').html(data);
                    },
                    error: function(xhr, str){
                        debugger;
                        alert("Ошибка диалоги", xhr.responseCode);                
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
    function fetch_user_chat_history(to_user_id) {
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
    $(document).on('click', '.start-chat', function(){
        fetch_user_chat_history($(this).data('touserid'));
        $('#dialog-sender').html($(this).data('tousername'));
        $('#send-dialog-chat').attr('data-touserid', $(this).data('touserid'));
        var targetDiv = $(".dialog-history");
        targetDiv.scrollTop( targetDiv.prop('scrollHeight') );
    });

    //Получение истории группы 
    function fetch_group_chat_history(to_group_id) {
        $.ajax({
            url: "fetch_group_chat_history.php",
            method: "POST",
            data:{to_chat_id:to_group_id},
            success: function(data){
                $('#group-history').html(data);
            }
        });
    };

    //Окно группы
    $(document).on('click', '.start-group-chat', function(){
        fetch_group_chat_history($(this).data('togroupid'));
        $('#dialog-sender').html($(this).data('tousername'));
        $('#send-dialog-chat').attr('data-touserid', $(this).data('touserid'));
        var targetDiv = $(".dialog-history");
        targetDiv.scrollTop( targetDiv.prop('scrollHeight') );
    });

       
      
   

}); //document.ready


