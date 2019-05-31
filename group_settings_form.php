
<div class="row">    
    <div class="col-12 py-2">  
        <form action="javascript: void(null);" onsubmit="update_group_photo()" autocomplete="off" enctype="multipart/form-data" id="form_updateGroupPhoto">  
        <div class="row">
                <div id="update-group-photo-feedback"></div>
                <div class="col-5">
                    <img src="" alt="Здесь будет фото группы" class="avatar-xl rounded-circle" id="current_group_photo">
                </div>       
                <div class="col-7">            
                    <label for="input_new_group_photo" class="font-weight-bold">Фото группы</label>            
                    <input type="file" class="form-control" accept="image/jpeg, image/png" name="input_new_group_photo" id="input_new_group_photo"><br> 
                    <input class="btn btn-sm form-control" type="submit" name="btn_save_group_photo" id="btn_save_group_photo" value="Обновить">
                </div>
            </div>
        </form>
    </div>   
    
    <div class="col-12 py-2">
        <form action="javascript: void(null);" onsubmit="update_group_name()" autocomplete="off" id="form_updateGroupName">  
            <div id="update-group-name-feedback"></div>   
            <label for="new_group_name" class="font-weight-bold">Название группы</label>
            <input type="text" class="form-control" name="new_group_name" id="new_group_name" autocomplete="off" placeholder="Новое название группы..."><br> 
            <input class="btn btn-save-profile-changes btn-sm" type="submit" name="btn_save_group_name" id="btn_save_group_name" value="Обновить"> 
        </form>
    </div>

    <div class="col-12 py-2">
        <form action="" autocomplete="off"> 
            <label for="group_participants" class="font-weight-bold">Участники</label>
            <table class="table table-hover table-striped" id="group_participants">
            </table>
        </form>
    </div>     
</div>        
