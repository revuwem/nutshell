<div class="container message-space shadow">
    <div class="row header">
        <div class="col col-12"><button class="btn" id="close-group-form"><span class="fa fa-arrow-left fa-fw"aria-hidden="true"></span></button><img class="rounded-circle  avatar"
                src="https://bootdey.com/img/Content/avatar/avatar1.png">
            <p id="group-name"></p>
        </div>
    </div>
    <div class="row history">
        <div class="container-fluid group-history">            
        </div>
    </div>
    <div class="row input-group-reply input-reply">
        <form action="javascript:void(null);" onsubmit="sendGroupMessage()" id="groupReplyForm" method="POST">
            <div class="input-group">
                <input type="text" class="form-control input-message" name="groupReply" id="groupReply"
                    placeholder="Введите ваше сообщение..." autocomplete="false">
                <div class="input-group-append">
                    <button class="btn form-control send-chat" type="submit" name="send-group-chat" id="send-group-chat"
                        data-touserid="" disabled ><span class="fa fa-paper-plane" aria-hidden="true"></span></button>
                </div>
            </div>
        </form>
    </div>
</div>