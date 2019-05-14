/* 
background.js
Фоновые скрипты для подгрузки пользовательских данных
*/

$(document).ready(function() {

    getUserInfo();  

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
    };

}); //document.ready

function newFunction(getUserInfo) {
    getUserInfo();
}

