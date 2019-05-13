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