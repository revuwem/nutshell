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


//Отправка сообщения в группе
function sendGroupMessage() {
  var to_chat_id = $('#send-group-chat').data('tochatid');
  var chat_message = $('#groupReply').val();
  $.ajax({
      url:"insert_group_chat.php",
      method: "POST",
      data:{to_chat_id:to_chat_id, chat_message:chat_message},
      success: function(data)
      {  
          $('#groupReply').val('');
          $('.group-history').html(data);
      }
  });
};



//Ограничение на отправку сообщения 
//Если поле ввода не пустое и строка сообщения не состоит из пробелов - разблокировать кнопку "Отправить"
function check_text_message(text){  
    if(text.length!=0 && text.trim()!="")  
    {                       
        $('.send-chat').removeAttr('disabled');
    }
    else
    {
        $('.send-chat').attr('disabled', 'disabled');
    }  
};

$(document).on('keypress', '.input-message', function(){
  check_text_message($(this).val());
});

$(document).on('keyup', '.input-message', function(){
check_text_message($(this).val());
});

$(document).on('keydown', '.input-message', function(){
check_text_message($(this).val());
});

//Фильтр контактов для создания или открытия диалога
$(document).on('click', '#search_dialog', function(){  
    $('#dialogs_details').css("display", "none");
    $('#dialogs_filter_details').css("display", "block");
});

$(document).on('click', '#btn_cancel_search_dialog', function(){
  $('#dialogs_details').css("display", "block");
  $('#dialogs_filter_details').css("display", "none");
});





