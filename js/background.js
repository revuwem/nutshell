/* 
background.js
Фоновые скрипты для подгрузки пользовательских данных
*/

$(document).ready(function() {

    getUserInfo();  

    function updates(){
        getUserInfo();
        fetch_user();
        update_last_activity();
        
    }

    setInterval(updates, 3000);

    //Обновление активности пользователя
    function update_last_activity() {
        $.ajax({
            url:"update_last_activity.php", 
            success:function(){
                      
            },
            error: function(xhr, str){
                debugger;
                alert("Ошибка обновления активности: ", xhr.responseCode);  
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
                debugger;
                alert("Ошибка ", xhr.responseCode);                
            }
        });
    }; //getUserInfo

    //Получение списка контактов
    function fetch_user() {
        $.ajax({
            url:"fetch_user.php",
            method:"POST",
            success:function(data){
                $('#contacts-panel').html(data);
            },
            error: function(xhr, str){
                debugger;
                alert("Ошибка получения списка контактов: ", xhr.responseCode);  
            } 
        });
    }; //fetch_user

}); //document.ready


