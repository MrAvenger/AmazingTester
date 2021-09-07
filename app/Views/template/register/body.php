<body>
    <div id="reg_div" class="bg-light p-5 rounded-lg m-3">
        <h1 class="display-4">Форма регистрации</h1>
        <p class="lead">Регистрация займёт не более 5-ти минут.</p>
              <form id="form_reg" method="POST" action="register">
                <?php if(session()->get('success')): ?>
                  <div class="alert alert-success" role="alert">
                    <?= session()->get('success') ?>
                  </div>
                <?php endif; ?>
                <?php if(session()->get('error')): ?>
                  <div class="alert alert-danger" role="alert">
                    <?= session()->get('error') ?>
                  </div>
                <?php endif; ?>
                <?php if(session()->get('success_google')):?>
                  <div class="alert alert-success" role="alert">
                    <?= session()->get('success_google') ?>
                  </div>
                <?php endif; ?>
                <?php if(session()->get('user_google')){
                  $user_google=session()->get('user_google');
                }
                ?>
               <div class="row mb-3">
                  <div class="col-sm-6">
                  <label for="first_name" class="form-label">Имя:</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="first_name-addon">@</span>
                      <input type="text" class="form-control" id="first_name" name="first_name" value="<?php if(isset($user_google)) echo $user_google['first_name']; else echo $user['first_name'] ?>" placeholder="Имя" aria-label="Имя" aria-describedby="first_name-addon">
                    </div>
                  </div>
                  <div class="col-sm-6">
                  <label for="last_name" class="form-label">Фамилия:</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="last_name-addon">@</span>
                      <input type="text" class="form-control" id="last_name" name="last_name" value="<?php if(isset($user_google)) echo $user_google['last_name']; else echo $user['last_name'] ?>" placeholder="Фамилия" aria-label="Фамилия" aria-describedby="last_name-addon">
                    </div>
                  </div>
                  <div class="col-sm-6">
                  <label for="middle_name" class="form-label">Отчество:</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="middle_name-addon">@</span>
                      <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?php if(isset($user_google)) echo $user_google['middle_name']; else echo $user['middle_name'] ?>" placeholder="Отчество" aria-label="Отчество" aria-describedby="middle_name-addon">
                    </div>
                  </div>
                  <div class="col-sm-6">
                  <label for="sex" class="form-label">Пол:</label>
                    <div class="input-group mb-3">
                    <span class="input-group-text" id="male-addon"><i class="fas fa-male"></i></span>
                    <select id="sex" name="sex" class="form-select" aria-label="Default select example" aria-describedby="male-addon">
                      <?php if(isset($user_google)&&$user_google['gender']=='Мужской'): ?>
                      <option selected value="Мужской">Мужской</option>
                      <option value="Женский">Женский</option>
                      <?php elseif(isset($user_google)&&$user_google['gender']=='Женский'): ?>
                        <option value="Мужской">Мужской</option>
                        <option selected value="Женский">Женский</option>
                      <?php else: ?>
                        <option selected value="Мужской">Мужской</option>
                        <option value="Женский">Женский</option>
                      <?php endif; ?>
                    </select>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <label for="role" class="form-label">Кто вы?</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="male-addon"><i class="fas fa-user-tag"></i></span>
                      <select onchange="fields_for_role()" id="role" name="role" class="form-select" aria-label="Default select example" aria-describedby="male-addon">
                        <option selected value="User">Обучающийся</option>
                        <option value="Teacher">Преподаватель</option>
                      </select>
                    </div>
                  </div>
                  <div id="org_select_name" class="col-sm-6">
                    <label for="org" class="form-label">Выберите место обучения</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="org-addon"><i class="far fa-building"></i></span>
                      <select onchange="addorg()" id="org" name="org" class="form-select" aria-label="Default select example" aria-describedby="org-addon">
                        <option value="null" selected>Другое</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row mb-3" id="reg_user_dop_info"></div>
                <div class="row mb-3">
                    <div class="col-sm-6">
                      <label for="email" class="form-label">Email:</label>
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="email-addon"><i class="far fa-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" value="<?php if(isset($user_google)) echo $user_google['email']; else echo $user['email'] ?>" placeholder="Эл.почта" aria-label="Эл.почта" aria-describedby="email-addon">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <label for="password" class="form-label">Пароль:</label>
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="pass-addon"><i class="fas fa-key"></i></span>
                        <input type="password" class="form-control" name="password" value="<?= $user['password'] ?>" placeholder="Пароль" aria-label="Пароль" aria-describedby="pass-addon">
                        <span class="input-group-text">
                          <i id="eye_reg" class="far fa-eye-slash" onclick="showHidePwd();"></i>
                        </span>
                      </div>
                    </div>
                    <div class="col-sm-6">
                    <label for="password_confirm" class="form-label">Подтверждение пароля:</label>
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="pass-addon"><i class="fas fa-key"></i></span>
                        <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Повторите пароль" aria-label="Повторите пароль" aria-describedby="pass-addon">
                      </div>
                    </div>
                  </div>
                  <?php if(isset($validation)): ?>
                    <div id="result_form" class="col-12">
                      <div class="alert alert-danger" role="alert">
                        <?= $validation->listErrors() ?>
                      </div>
                    </div>
                  <?php endif; ?>
                  <a type="button" href="login" class="btn btn-warning">Уже есть аккаунт</a>
                  <button type="submit" id="regbtn" class="btn btn-primary">Зарегистрироваться</button>
            </div>
        </form>
    </div>
    <!-- JS, Popper.js, and jQuery | fa-fa icons -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src='http://code.jquery.com/jquery-2.1.1.min.js'></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js" integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/437be00af9.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url()?>/assets/js/registration.js"></script>
</body>
