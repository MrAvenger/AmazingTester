<div id="Modal_User_Edit" class="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header" id="edit_tittle">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_edit_user" method="POST">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label for="first_name" class="form-label">Имя:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="first_name-addon">@</span>
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                    placeholder="Имя" aria-label="Имя" aria-describedby="first_name-addon">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="last_name" class="form-label">Фамилия:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="last_name-addon">@</span>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                    placeholder="Фамилия" aria-label="Фамилия" aria-describedby="last_name-addon">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="middle_name" class="form-label">Отчество:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="middle_name-addon">@</span>
                                <input type="text" class="form-control" id="middle_name" name="middle_name"
                                    placeholder="Отчество" aria-label="Отчество" aria-describedby="middle_name-addon">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="sex" class="form-label">Пол:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="male-addon"><i class="fas fa-male"></i></span>
                                <select id="sex" name="sex" class="form-select" aria-label="Default select example"
                                    aria-describedby="male-addon">
                                    <option selected value="Мужской">Мужской</option>
                                    <option value="Женский">Женский</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="role" class="form-label">Роль</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="male-addon"><i class="fas fa-user-tag"></i></span>
                                <select id="role" name="role" onchange="fields_for_role()" class="form-select"
                                    aria-label="Default select example" aria-describedby="male-addon">
                                    <option selected value="User">Обучающийся</option>
                                    <option value="Teacher">Преподаватель</option>
                                    <option value="Admin">Администратор</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="edit_user_div" class="row mb-3">
                        <div id="org_select_name" class="col-sm-6">
                            <label id="org_lable" for="org" class="form-label">Выберите место обучения</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="org-addon"><i class="far fa-building"></i></span>
                                <select onchange="getgroup_class()" id="org" name="org" class="form-select"
                                    aria-label="Default select example" aria-describedby="org-addon">
                                </select>
                            </div>
                        </div>
                        <div id="class_group_div" class="col-sm-6"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label for="email" class="form-label">Email:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="email-addon"><i class="far fa-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Эл.почта"
                                    aria-label="Эл.почта" aria-describedby="email-addon">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="password" class="form-label">Пароль:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="pass-addon"><i class="fas fa-key"></i></span>
                                <input type="password" class="form-control" name="password"
                                    placeholder="Введите если обязателен" aria-label="Пароль"
                                    aria-describedby="pass-addon">
                                <!-- <span class="input-group-text">
                          <i id="eye_reg" class="far fa-eye-slash" onclick="showHidePwd('1');"></i>
                        </span> -->
                            </div>
                        </div>
                    </div>
                    <div id="result_form" class="col-12">
                    </div>
                </form>
            </div>
            <div class="modal-footer" id="buttons_edit_user">
            </div>
        </div>
    </div>
</div>
</div>