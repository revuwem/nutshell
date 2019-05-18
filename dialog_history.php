<div class="container-fluid d-none d-sm-block col-sm-7 col-md-7 col-lg-8 main shadow">
    <div class="row header">
        <div class="col col-12"><img class="rounded-circle  avatar"
                src="https://bootdey.com/img/Content/avatar/avatar1.png">
            <p id="dialog-sender"></p>
        </div>
    </div>
    <div class="row history">
        <div class="container-fluid dialog-history">
            Здесь будет история сообщений
        </div>
    </div>
    <div class="row input-dialog-reply">
        <form action="javascript:void(null);" onsubmit="sendDialogMessage()" id="dialogReplyForm" method="POST">
            <div class="input-group">
                <input type="text" class="form-control" name="dialogReply" id="dialogReply"
                    placeholder="Введите ваше сообщение..." autocomplete="false">
                <div class="input-group-append">
                    <button class="btn form-control" type="submit" name="send-dialog-chat" id="send-dialog-chat"
                        data-touserid=""><span class="fa fa-paper-plane" aria-hidden="true"></span></button>
                </div>
            </div>
        </form>
    </div>
</div>