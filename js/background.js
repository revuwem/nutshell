function editUserBasicInfo(){
    var formdata = $('#userBasicInfo').serialize();
    var action='basic';
    $.ajax({
      type: "POST", 
      url: "edit_userprofile.php?action=basic",
      data: formdata,
      success: function(data){
        $('#editBasicInfoResult').html(data);
      },
      error: function(xhr, str){
        alert('Возникла ошибка: ', xhr.resonseCode);
      }
    });
} 