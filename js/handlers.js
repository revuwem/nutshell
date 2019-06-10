/* 
handlers.js
Скрипты-обработчики форм 
*/

//Функция обновления основной информации о пользователе
$(function () {
  $('#userBasicInfo').on('submit', function (e) {
    e.preventDefault();
    var $that = $(this),
      formdata = new FormData($that.get(0)); //создаем новый экземпляр объекта и передаем ему форму
    $('#editBasicInfoResult').css("display", "none");

    $.ajax({
      type: "POST",
      url: "edit_userprofile.php?action=basic",
      processData: false,
      contentType: false,
      data: formdata,
      success: function (data) {
        $('#editBasicInfoResult').html(data);
        $('#editBasicInfoResult').css("display", "block");
      },
      error: function (xhr, str) {
        alert('Возникла ошибка: ', xhr.responseCode);
      }
    });
  });
});

//Функция обновления контактов пользователя
function editUserContactsInfo() {
  var formdata = $('#userContactsInfo').serialize();
  $('#editBasicInfoResult').css("display", "none");
  $.ajax({
    type: "POST",
    url: "edit_userprofile.php?action=contacts",
    data: formdata,
    success: function (data) {
      $('#editContactsResult').html(data);
      $('#editContactsResult').css("display", "block");
      getUserInfo();
    },
    error: function (xhr, str) {
      alert('Возникла ошибка: ', xhr.responseCode);
    }
  });
};

//Функция валидации пароля перед обновлением
function checkPassUpdate() {
  var psw1 = document.getElementById('inputNewUserPassword');
  var psw2 = document.getElementById('inputConfirmNewUserPassword');
  var message = document.getElementById('confirm-password-valid');
  var errorColor = "#FFC5B8";
  var successColor = "#CDFFC7";
  if (psw1.value.length > 7) {
    psw1.style.backgroundColor = successColor;
  }
  else {
    psw1.style.backgroundColor = errorColor;
    message.style.color = errorColor;
    message.innerHTML = " Длина пароля должна быть не менее 8 символов!"
    return;
  }
  if (psw1.value == psw2.value) {
    psw2.style.backgroundColor = successColor;
  }
  else {
    psw2.style.backgroundColor = errorColor;
    message.style.color = successColor;
    message.innerHTML = " Введеные пароли не совпадают!"
  }
};



//Функция обновления пароля пользователя
function editUserPassword() {
  var formdata = $('#userPasswordInfo').serialize();
  $('#editBasicInfoResult').css("display", "none");
  $.ajax({
    type: "POST",
    url: "edit_userprofile.php?action=security",
    data: formdata,
    success: function (data) {
      $('#editPasswordResult').html(data);
      $('#editPasswordResult').css("display", "block");
      $('#inputNewUserPassword').val('');
      $('#inputConfirmNewUserPassword').val('');

    },
    error: function (xhr, str) {
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
    url: "insert_chat.php",
    method: "POST",
    data: { to_user_id: to_user_id, chat_message: chat_message },
    success: function (data) {
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
    url: "insert_group_chat.php",
    method: "POST",
    data: { to_chat_id: to_chat_id, chat_message: chat_message },
    success: function (data) {
      $('#groupReply').val('');
      $('.group-history').html(data);
    }
  });
};



//Ограничение на отправку сообщения 
//Если поле ввода не пустое и строка сообщения не состоит из пробелов - разблокировать кнопку "Отправить"
function check_text_message(text) {
  if (text.length != 0 && text.trim() != "") {
    $('.send-chat').removeAttr('disabled');
  }
  else {
    $('.send-chat').attr('disabled', 'disabled');
  }
};

$(document).on('keypress', '.input-message', function () {
  check_text_message($(this).val());
});

$(document).on('keyup', '.input-message', function () {
  check_text_message($(this).val());
});

$(document).on('keydown', '.input-message', function () {
  check_text_message($(this).val());
});

/*Фильтр контактов для создания или открытия диалога*/
//UI
$(document).on('click', '#search_dialog', function () {
  $('#dialogs_details').css("display", "none");
  $('#dialogs_filter_details').css("display", "block");
  $('#btn_cancel_search_dialog>span').removeClass('fa-search').addClass('fa-close');
  dialogs_filter_details($(this).val());
});

$(document).on('click', '#btn_cancel_search_dialog', function () {
  $('#dialogs_details').css("display", "block");
  $('#dialogs_filter_details').css("display", "none");
  $('#btn_cancel_search_dialog>span').removeClass('fa-close').addClass('fa-search');
});

//Выгрузка списка контактов, отфильтрованных по param=username=#search_dialog.value
function dialogs_filter_details(param) {
  $.ajax({
    url: "dialogs_filter_details.php",
    method: "post",
    data: { username: param },
    success: function (data) {
      $('#dialogs_filter_details').html(data);
    },
    error: function (xhr, str) {
      debugger;
      console.log("Ошибка фильтра диалогов: ", xhr.responseCode);
    }
  });
};

//Обработка нажатий клавиш в поле поиска контакта для применения фильтра
$(document).on('keypress', '#search_dialog', function () {
  dialogs_filter_details($(this).val());
});

$(document).on('keyup', '#search_dialog', function () {
  dialogs_filter_details($(this).val());
});

$(document).on('keydown', '#search_dialog', function () {
  dialogs_filter_details($(this).val());
});


/*Фильтр групп*/
//UI
$(document).on('click', '#search_group', function () {
  $('#groups_details').css("display", "none");
  $('#groups_filter_details').css("display", "block");
  $('#btn_cancel_search_group>span').removeClass('fa-search').addClass('fa-close');
  groups_filter_details($(this).val());
});

$(document).on('click', '#btn_cancel_search_group', function () {
  $('#groups_details').css("display", "block");
  $('#groups_filter_details').css("display", "none");
  $('#btn_cancel_search_group>span').removeClass('fa-close').addClass('fa-search');
});

//Выгрузка списка групп пользователя, отфильтрованных по param=groupname=#search_group.value
function groups_filter_details(param) {
  $.ajax({
    url: "groups_filter_details.php",
    method: "post",
    data: { groupname: param },
    success: function (data) {
      $('#groups_filter_details').html(data);
    },
    error: function (xhr, str) {
      debugger;
      console.log("Ошибка фильтра групп: ", xhr.responseCode);
    }
  });
};

//Обработка нажатий клавиш в поле поиска группы для применения фильтра
$(document).on('keypress', '#search_group', function () {
  groups_filter_details($(this).val());
});

$(document).on('keyup', '#search_group', function () {
  groups_filter_details($(this).val());
});

$(document).on('keydown', '#search_dialog', function () {
  groups_filter_details($(this).val());
});


//Создание группы
function createNewGroup(group_name) {
  var action = "add";
  var group_name = $('#input_new_group_name').val();
  if (group_name != '' && group_name.trim() != '') {
    $.ajax({
      url: "groups_functions.php",
      method: "post",
      data: { group_name: group_name, action: action },
      success: function (data) {
        $('#create_group_feedback').html(data);
      }
    });
  }
  else {
    var output = '<div class="alert alert-warning alert-dismissible">';
    output += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
    output += 'Пожалуйста, укажите <strong>название группы</strong>.';
    output += '</div>';
    $('#create_group_feedback').html(output);

    $("#dialog").dialog({
      height: 200
    });
  }
};





//TODO: настройки группы: изменить фото, название, удалить\добавить участников


//Обновление фото группы
var file; //временный путь к фото в директории на сервере

$('input[type=file]').on('change', prepareUpload);

//Функция сохраняет в file временный путь к файлу, выбранному в input[type=file]
function prepareUpload(event) {
  file = event.target.files;
};

//Функция обновления фотографии группы
function update_group_photo(e) {
  e.preventDefault();
  $('#update-group-photo-feedback').css("display", "none");


  var form = $('#form_updateGroupPhoto'),
    formdata = new FormData(form.get(0)),
    action = "update_photo",
    group_id = $('#group_settings_dialog').data('groupid');

  formdata.append('action', action);
  formdata.append('group_id', group_id);
  formdata.append('userfile', file);


  $.ajax({
    type: "post",
    url: "groups_functions.php",
    processData: false,
    contentType: false,
    data: formdata,
    success: function (data) {
      $('#update-group-photo-feedback').html(data);
      $('#update-group-photo-feedback').css("display", "block");
      file = null;
    },
    error: function (xhr, str) {
      alert("Ошибка обновления фото");
    }
  });

};

//Обновление названия группы
function update_group_name(e) {
  e.preventDefault();
  $('#update-group-name-feedback').css("display", "none");

  var new_name = $('#new_group_name').val(),
    group_id = $('#group_settings_dialog').data('groupid');
  action = "update_group_name";

  $.ajax({
    type: "post",
    url: "groups_functions.php",
    data: { new_name: new_name, group_id: group_id, action: action },
    success: function (data) {
      $('#update-group-name-feedback').html(data);
      $('#update-group-name-feedback').css("display", "block");
    },
    error: function (xhr, str) {
      alert("Ошибка обновления названия группы");
    }
  });
};

//Функция выполняет ajax-запрос для получения данных несостоящих в группе пользователей с кнопкой Добавить и заполняет таблицу Участники
function fetch_new_group_participants(param) {

  var action = "fetch_new_participants";

  $.ajax({
    url: "groups_functions.php",
    type: "post",
    data: { action: action, param: param },
    success: function (data) {
      $('#group_participants').html(data);
    }
  });
}



$(document).on('keypress', '#search_new_group_participants', function () {
  // загружаем пользователей, не состоящих в группе
  fetch_new_group_participants($(this).val()); 
});
$(document).on('keydown', '#search_new_group_participants', function () {
  // загружаем пользователей, не состоящих в группе
  fetch_new_group_participants($(this).val()); 
});
$(document).on('keyup', '#search_new_group_participants', function () {
  // загружаем пользователей, не состоящих в группе
  fetch_new_group_participants($(this).val()); 
});

$(document).on('click', '#search_new_group_participants', function () {
  // загружаем пользователей, не состоящих в группе
  fetch_new_group_participants($(this).val()); 
  //Показываем кнопку отмены 
  $('#btn_cancel_search_new_group_participants>span').css("display", "block");
});

//Кнопка отмены добавления новых участников
$(document).on('click', '#btn_cancel_search_new_group_participants', function () {

  //Загружаем список участников
  var group_id = $('#group_settings_dialog').data('groupid');
  var action = 'participants';
  $.ajax({
    url: "groups_functions.php",
    method: "post",
    data: { group_id: group_id, action: action },
    success: function (data) {
      $('#group_participants').html(data);
    }
  });  
  
  //Прячем кнопку отмены
  $('#btn_cancel_search_new_group_participants>span').css("display", "none");
  $('#btn_cancel_search_new_group_participants').blur();
  //Очищаем поле поиска 
  $('#search_new_group_participants').val('');
  
});

//Добавление нового участника в группу
$(document).on('click', '.add_user_to_group', function(e){

  e.preventDefault();

  var group_id = $('#group_settings_dialog').data('groupid');
  var user_id = $(this).data('userid');
  var action ="add_user_to_group";

  $.ajax({
    type:"post",
    url: "groups_functions.php",
    data: {action:action, user_id:user_id, group_id:group_id},
    success:function(data){
      $('#participants-feedback').html(data);
    }
  });
});


//Удаление участника из группы
$(document).on('click', '.drop_user_from_group', function(e){

  e.preventDefault();

  var group_id = $('#group_settings_dialog').data('groupid');
  var user_id = $(this).data('userid');
  var action ="drop_user_from_group";

  $.ajax({
    type:"post",
    url: "groups_functions.php",
    data: {action:action, user_id:user_id, group_id:group_id},
    success:function(data){
      $('#participants-feedback').html(data);
    }
  });
});




function get_group_tasks(group_id) {
  var action = "get_info";

  $.ajax({
    url: "todo-functions.php",
    type: "post",
    data: {
      action: action,
      group_id: group_id
    },
    success: function (data) {
      if (data) {
        var result = JSON.parse(data);
        var liStarted = '',
          liInProcessing = '',
          liComplete = '';
        for (var key in result) {

          switch (result[key]["status"]) {
            case '1': liStarted += '<li class="task-element"><p class="font-weight-bold mr-3">' + result[key]["title"] + '</p><span>' + result[key]["due_date"] + '</span><br><span>' + result[key]["description"] + '</span><span class="btnUpdateTaskElement" data-taskid="' + result[key]["task_id"] + '">\u2192</span><span class="btnDeleteTaskElement" data-taskid="' + result[key]["task_id"] + '">\u00D7</span></li>';
              break;
            case '2': liInProcessing += '<li class="task-element"><p class="font-weight-bold mr-3">' + result[key]["title"] + '</p><span>' + result[key]["due_date"] + '</span><br><span>' + result[key]["description"] + '</span><span class="btnUpdateTaskElement" data-taskid="' + result[key]["task_id"] + '">\u2192</span><span class="btnDeleteTaskElement" data-taskid="' + result[key]["task_id"] + '">\u00D7</span></li>';
              break;
            case '3': liComplete += '<li class="task-element"><p class="font-weight-bold mr-3">' + result[key]["title"] + '</p><span>' + result[key]["due_date"] + '</span><br><span>' + result[key]["description"] + '</span><span class="btnDeleteTaskElement" data-taskid="' + result[key]["task_id"] + '">\u00D7</span></li>';
              break;
          }
        }
        $('#tasksStarted').html(liStarted);
        $('#tasksInProcessing').html(liInProcessing);
        $('#tasksComplete').html(liComplete);

      }
      else {
        var output = '<br><div class="alert alert-warning alert-dismissible">';
        output += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        output += 'У этой группы нет задач. <strong>Будьте первым!</strong>';
        output += '</div>';

        $('#load-tasks-feedback').html(output);
      }
    },
    error: function (xhr, str) {
      debugger;
      alert('Ошибка получения задач');
    }
  });
};


function add_new_group_task() {
  var group_id = $("#selectUserGroups option:selected").data('groupid'),
    title = $('#inputAddTaskTitle').val(),
    description = $('#inputAddTaskDescription').val(),
    due_date = $('#inputAddTaskDueDate').val(),
    action = 'add_task';

  $.ajax({
    url: "todo-functions.php",
    type: "post",
    data: {
      group_id: group_id,
      action: action,
      title: title,
      description: description,
      due_date: due_date
    },
    success: function (data) {
      $('#create-task-feedback').html(data);
      $('#inputAddTaskTitle').val('');
      $('#inputAddTaskDescription').val('');
      $('#inputAddTaskDueDate').val('');
      get_group_tasks(group_id);
    }

  });

};

$(document).on('click', '.btnUpdateTaskElement', function () {

  var task_id = $(this).data('taskid'),
    action = 'update_status',
    group_id = $("#selectUserGroups option:selected").data('groupid');

  $.ajax({
    url: "todo-functions.php",
    type: "post",
    data: { task_id: task_id, action: action },
    success: function (data) {

      var fail = '<div class="alert alert-warning alert-dismissible">';
      fail += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
      fail += '<strong>Не удалось!</strong> Пожалуйста, попробуйте еще раз.';
      fail += '</div>';

      if (data) {
        get_group_tasks(group_id);
      }
      else {
        $('#load-tasks-feedback').html(fail);
      };
    },
    error: function (xhr, str) {
      debugger;
      alert("Ошибка обновления статуса задачи. " + xhr.responseCode);
    }
  });
});

$(document).on('click', '.btnDeleteTaskElement', function () {

  var task_id = $(this).data('taskid'),
    action = 'delete',
    group_id = $("#selectUserGroups option:selected").data('groupid');

  $.ajax({
    url: "todo-functions.php",
    type: "post",
    data: { task_id: task_id, action: action },
    success: function (data) {

      var fail = '<div class="alert alert-warning alert-dismissible">';
      fail += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
      fail += '<strong>Не удалось!</strong> Пожалуйста, попробуйте еще раз.';
      fail += '</div>';

      if (data) {
        get_group_tasks(group_id);
      }
      else {
        $('#load-tasks-feedback').html(fail);
      };
    },
    error: function (xhr, str) {
      debugger;
      alert("Ошибка обновления статуса задачи. " + xhr.responseCode);
    }
  });
});






