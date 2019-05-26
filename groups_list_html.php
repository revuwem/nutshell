<div class="container menu shadow">
    <div class="container-fluid side-list">
        <div class="row searchBox">
            <div class="container-fluid input-group">
                <input type="text" class="form-control" name="search_group" id="search_group" placeholder="Поиск группы...">
                <div class="input-group-append">
                    <button class="btn form-control" id="btn_cancel_search_group" name="btn_cancel_search_group"><span class="fa fa-search fa-fw"
                            aria-hidden="true"></span></button> 
                    <button class="btn form-control" id="btn_create_group_dialog" name="btn_create_group_dialog"><span class="fa fa-plus fa-fw"
                            aria-hidden="true"></span></button>                  
                </div>
            </div>
        </div>
        <!--/.searchBox-->
        <div class="row side-body">
            <div class="col-12 list-fixed" id="group-list">
                <ul class="list-unstyled list-group" id="groups_details">
                </ul>
                <ul class="list-unstyled list-group" id="groups_filter_details" style="display: none;">                    
                </ul>
            </div>           
        </div>
        <div id="create_group_dialog">
               <!-- <div class="input-group">
                   <input type="text" class="form-control" name="input_new_group_name" id="input_new_group_name" placeholder="Название группы..." autocomplete="off">
                   <div class="input-group-append">
                       <button class="btn btn-info">Создать</button>
                   </div>
               </div> -->
           </div>
    </div>    
</div>