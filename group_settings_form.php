<div class="row">
    <div class="col-12 py-2">
        <div class="row">
            <div class="col-4">
                <img src="" alt="Здесь будет фото группы" class="avatar-xl rounded-circle" id="current_group_photo">
            </div>
            <div class="col-8">
                <div id="update-group-photo-feedback"></div>
                <form method="post" autocomplete="off" enctype="multipart/form-data" id="form_updateGroupPhoto">
                    <label for="input_new_group_photo" class="font-weight-bold">Фото группы</label>
                    <input type="file" class="form-control" accept="image/jpeg, image/png" name="input_new_group_photo"
                        id="input_new_group_photo"><br>
                    <button class="btn btn-sm form-control btn-save-profile-changes" type="button"
                        name="btn_update_group_photo" id="btn_update_group_photo"
                        onclick="javascript:update_group_photo(event);">Обновить</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-12 py-2">
        <form action="javascript: void(null);" method="post" autocomplete="off" id="form_updateGroupName">
            <div id="update-group-name-feedback"></div>
            <label for="new_group_name" class="font-weight-bold">Название группы</label>
            <input type="text" class="form-control" name="new_group_name" id="new_group_name" autocomplete="off"
                placeholder="Новое название группы..."><br>
            <button class="btn btn-save-profile-changes btn-sm" type="button" name="btn_update_group_name"
                id="btn_update_group_name" onclick="javascript:update_group_name(event);">Обновить</button>
        </form>
    </div>

    <div class="col-12 py-2">
        <form action="" autocomplete="off">
            <label for="group_participants" class="font-weight-bold">Участники</label>
            <div id="participants-feedback"></div>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <td colspan="2">
                            <div class="container-fluid input-group">
                                <input type="text" class="form-control" name="search_new_group_participants"
                                    id="search_new_group_participants" placeholder="Добавить участника...">
                                <div class="input-group-append">
                                    <button class="btn form-control" type="button" id="btn_cancel_search_new_group_participants"><span
                                            class="fa fa-close fa-fw" aria-hidden="true" style="display:none"></span></button>
                                </div>
                            </div>
                        <td>
                    </tr>
                </thead>
                <tbody id="group_participants">
                </tbody>
            </table>
        </form>
    </div>
</div>