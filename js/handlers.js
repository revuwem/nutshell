/* 
handlers.js
Скрипты-обработчики форм 
*/

//Функция обновления основной информации о пользователе
function editUserBasicInfo(){
    var formdata = $('#userBasicInfo').serialize();  
    $('#editBasicInfoResult').css("display", "none");  
    $.ajax({
      type: "POST", 
      url: "edit_userprofile.php?action=basic",
      data: formdata,
      mimeType: "multipart/form-data",
      success: function(data){
        $('#editBasicInfoResult').html(data);
        $('#editBasicInfoResult').css("display", "block");
      },
      error: function(xhr, str){
        alert('Возникла ошибка: ', xhr.responseCode);
      }
    });
    getUserInfo();
};

//Функция обновления контактов пользователя
function editUserContactsInfo(){
  var formdata=$('#userContactsInfo').serialize();
  $('#editBasicInfoResult').css("display", "none"); 
  $.ajax({
    type:"POST",
    url:"edit_userprofile.php?action=contacts",
    data: formdata,
    success: function(data){
      $('#editContactsResult').html(data);
      $('#editContactsResult').css("display", "block");
      getUserInfo();
    },
    error: function(xhr, str){
      alert('Возникла ошибка: ', xhr.responseCode);
    }
  });  
};

//Функция валидации пароля перед обновлением
function checkPassUpdate(){  
  var psw1 = document.getElementById('inputNewUserPassword');
  var psw2 = document.getElementById('inputConfirmNewUserPassword');
  var message = document.getElementById('confirm-password-valid');
  var errorColor = "#FFC5B8";
  var successColor = "#CDFFC7";
  if (psw1.value.length>7)
  {
    psw1.style.backgroundColor=successColor;
  }
  else{
    psw1.style.backgroundColor=errorColor;
    message.style.color=errorColor;
    message.innerHTML =" Длина пароля должна быть не менее 8 символов!"
    return;
  }
  if(psw1.value==psw2.value)
  {
    psw2.style.backgroundColor=successColor;
  }
  else{
    psw2.style.backgroundColor=errorColor;
    message.style.color=successColor;
    message.innerHTML=" Введеные пароли не совпадают!"
  }
};
  


//Функция обновления пароля пользователя
function editUserPassword(){
  var formdata=$('#userPasswordInfo').serialize(); 
  $('#editBasicInfoResult').css("display", "none"); 
  $.ajax({
    type: "POST",
    url: "edit_userprofile.php?action=security",
    data: formdata,
    success: function(data){
      $('#editPasswordResult').html(data);
      $('#editPasswordResult').css("display", "block");
      $('#inputNewUserPassword').val('');
      $('#inputConfirmNewUserPassword').val('');

    },
    error: function(xhr, str){
      alert('Возникла ошибка: ', xhr.responseCode);
    }
  });
  getUserInfo();
};

//Отправка сообщения в диалоге
function sendDialogMessage() {
  var to_user_id = $('#send-dialog-chat').data('touserid');
  var chat_message = $('#dialogReply').val();
  $.ajax({
      url:"insert_chat.php",
      method: "POST",
      data:{to_user_id:to_user_id, chat_message:chat_message},
      success: function(data)
      {  
          $('#dialogReply').val('');
          $('.dialog-history').html(data);
      }
  });
};