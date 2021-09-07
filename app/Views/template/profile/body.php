<body>
    <div class="bg-light p-5 rounded-lg m-3">
        <h1 class="display-4">Профиль</h1>
        <!-- <p class="lead"><?= $user['first_name'].' '.$user['last_name'].' '.$user['middle_name'] ?>.</p> -->
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
        <form id="form_profile" method="POST" action="profile">
                <div class="row mb-3">
                  <div class="col-sm-6">
                  <label for="first_name" class="form-label">Имя:</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="first_name-addon">@</span>
                      <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $user['first_name'] ?>" placeholder="Имя" aria-label="Имя" aria-describedby="first_name-addon">
                    </div>
                  </div>
                  <div class="col-sm-6">
                  <label for="last_name" class="form-label">Фамилия:</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="last_name-addon">@</span>
                      <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $user['last_name'] ?>" placeholder="Фамилия" aria-label="Фамилия" aria-describedby="last_name-addon">
                    </div>
                  </div>
                  <div class="col-sm-6">
                  <label for="middle_name" class="form-label">Отчество:</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="middle_name-addon">@</span>
                      <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?= $user['middle_name'] ?>" placeholder="Отчество" aria-label="Отчество" aria-describedby="middle_name-addon">
                    </div>
                  </div>
                  <div class="col-sm-6">
                  <label for="sex" class="form-label">Пол:</label>
                    <div class="input-group mb-3">
                    <span class="input-group-text" id="male-addon"><i class="fas fa-male"></i></span>
                    <select id="sex" name="sex" class="form-select" aria-label="Default select example" aria-describedby="male-addon">
                      <?php if($user['gender']=='Мужской'): ?>
                      <option selected value="Мужской">Мужской</option>
                      <option value="Женский">Женский</option>
                      <?php else: ?>
                      <option selected value="Женский">Женский</option>
                      <option value="Мужской">Мужской</option>
                      <?php endif; ?>
                    </select>
                    </div>
                  </div>
                </div>
                <div class="row mb-3">
                <div class="col-sm-6">
                    <label for="org" class="form-label">Место обучения</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="org-addon"><i class="far fa-building"></i></span>
                      <select id="org" name="org" class="form-select" onchange="getgroup_class()" aria-label="Default select example" aria-describedby="org-addon">
                        <option selected>Другое</option>
                      </select>
                    </div>
                  </div>
                  <div id="dop_info_group" class="col-sm-6">
                    <label for="course" class="form-label">Группа/класс:</label>
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="group-class-addon"><i class="fas fa-user-friends"></i></span><select id="group_class" name="group_class" class="form-select" aria-label="Default select example" aria-describedby="group-class-addon">
                        <option selected value=null>Не указано</option></select>
                  </div>
                </div>
                </div>
                <div class="row mb-3">
                  <div class="col-sm-6">
                  <label for="email" class="form-label">Email:</label>
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="email-addon"><i class="far fa-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?>" placeholder="Эл.почта" aria-label="Эл.почта" aria-describedby="email-addon" readonly>
                      </div>
                    </div>
                    <div class="col-sm-6">
                    <label for="password" class="form-label">Пароль:</label>
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="pass-addon"><i class="fas fa-key"></i></span>
                        <input type="password" class="form-control" name="password" value="<?= set_value('password') ?>" placeholder="Введите для изменения" aria-label="Пароль" aria-describedby="pass-addon">
                        <span class="input-group-text">
                          <i id="eye_reg" class="far fa-eye-slash" onclick="showHidePwd()"></i>
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
                  <button type="submit" id="regbtn" class="btn btn-primary">Обновить данные</button>
            </div>
        </form>
    </div>
    <!-- JS, Popper.js, and jQuery | fa-fa icons -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src='http://code.jquery.com/jquery-2.1.1.min.js'></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js" integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/437be00af9.js" crossorigin="anonymous"></script>
    <script type="text/javascript">
      var my_account = <?php echo json_encode($user); ?>;
    </script>
    <script src="<?php echo base_url()?>/assets/js/profile.js"></script>
</body>
