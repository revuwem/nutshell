//Функция обновления основной информации о пользователе
function editUserBasicInfo(){
    var formdata = $('#userBasicInfo').serialize();    
    $.ajax({
      type: "POST", 
      url: "edit_userprofile.php?action=basic",
      data: formdata,
      success: function(data){
        $('#editBasicInfoResult').html(data);
      },
      error: function(xhr, str){
        alert('Возникла ошибка: ', xhr.responseCode);
      }
    });
} 

//Функция обновления контактов пользователя
function editUserContactsInfo(){
  var formdata=$('#userContactsInfo').serialize();
  $.ajax({
    type:"POST",
    url:"edit_userprofile.php?action=contacts",
    data: formdata,
    success: function(data){
      $('#editContactsResult').html(data);
    },
    error: function(xhr, str){
      alert('Возникла ошибка: ', xhr.responseCode);
    }
  });
}


//Функция валидации пароля перед обновлением
function checkPassUpdate(){  
  var psw1 = document.getElementById('inputNewUserPassword');
  var psw2 = document.getElementById('inputConfirmNewUserPassword');
  var message = document.getElementById('confirm-password-valid');
  var errorColor = "#FFC5B8";
  var successColor = "#CDFFC7";
  if (psw1.nodeValue.length>7 && psw2.nodeValue.length>7){
    psw1.style.backgroundColor=successColor;
    if(psw1.value==psw2.value)
    {
      psw2.style.backgroundColor=successColor;
    }
    else{
      psw2.style.backgroundColor=errorColor;
      message.style.color=successColor;
      message.innerHTML=" Введеные пароли не совпадают!"
    }
  }
  else{
    psw1.style.backgroundColor=errorColor;
    message.style.color=errorColor;
    message.innerHTML =" Длина пароля должна быть не менее 8 символов!"
  }
}


//Функция обновления пароля пользователя
function editUserPassword(){
  var formdata=$('#userPasswordInfo').serialize(); 
  $.ajax({
    type: "POST",
    url: "edit_userprofile.php?action=security",
    data: formdata,
    success: function(data){
      $('#editPasswordResult').html(data);
    },
    error: function(xhr, str){
      alert('Возникла ошибка: ', xhr.responseCode);
    }
  });
}