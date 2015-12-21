<div id="settings-modal" class="popup-basic text-center fs14 mfp-with-anim">
    <div class="panel panel-info">
        <div class="panel-heading">
            <span class="panel-title">Работайте совместно с другими</span>
        </div>
        <div class="panel-body border">
            <div class="col-md-12">
                <input type="text" id="edit-name" placeholder="Имя проекта" class="form-control">
            </div>

            <div class="col-md-12 divider"></div>

            <div class="col-md-9">
                <input type="text" id="email" placeholder="Электронная почта" class="form-control" required pattern="^[^\s@＠=]+[@|＠][^\.\s@＠]+(\.[^\.\s@＠]+)+$">
            </div>
            <div class="col-md-3">
                <button class="btn btn-lg btn-danger" id="done">Пригласить</button>
            </div>
            <div class="col-md-12 members p15 text-left">
                <ul class="users-list user-list pln pb10"></ul>
            </div>

            <div class="col-md-12 divider"></div>

            <p class="blank-text">Люди, которых Вы приглашаете, смогут добавлять, удалять и завершать задачи из этого списка.</p>
            <div class="col-md-3 col-xs-3 drop-list">
                <i data-placement="bottom" style="font-size:20px; font-style: normal;" class="entypo-trash tooltitle" id="del-proj" data-original-title="Удалить"></i>
            </div>
            <div class="col-md-3">
                <button class="btn btn-lg btn-danger" id="save-proj">Сохранить</button>
            </div>
        </div>
    </div>
</div>

<div id="add-proj" class="popup-basic text-center fs14 mfp-with-anim">
    <div class="panel panel-info">
        <div class="panel-heading">
            <span class="panel-title">Добавить новый проект</span>
        </div>
        <div class="panel-body border">
            <div class="row">
                <div class="col-md-12">
                    <input type="text" id="project-input" placeholder="Имя проекта" class="form-control">
                </div>
                <div class="col-md-3">
                    <button class="btn btn-lg btn-danger" id="save-add">Добавить</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="add-label" class="popup-basic text-center fs14 mfp-with-anim">
    <div class="panel panel-info">
        <div class="panel-heading">
            <span class="panel-title">Добавить новую метку</span>
        </div>
        <div class="panel-body border">
            <div class="row">
                <div class="col-md-12">
                    <input type="text" id="label-input" placeholder="Имя метки" class="form-control">
                </div>
                <div class="col-md-3">
                    <button class="btn btn-lg btn-danger" id="add-save-label">Добавить</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal-text" class="popup-basic text-center fs14 mfp-with-anim mfp-hide">
    <div class="panel panel-info">
        <div class="panel-heading">
            <span class="panel-title">Подтверждение запроса</span>
        </div>
        <div class="panel-body border">
            <p>Вы действительно хотите удалить все завершенные задачи в этом списке?</p>
            <div class="mt20">
                <button type="button" class="btn btn-rounded btn-dark del">Удалить</button>
                <button type="button" class="btn ml10 btn-rounded btn-default cancel">Нет, не нужно</button>
            </div>
        </div>
    </div>
</div>