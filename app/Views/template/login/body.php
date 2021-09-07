<body>
    <div class="container-fluid d-flex h-100 justify-content-center align-items-center p-0">
    <div class="row bg-white shadow-sm">
      <div class="col border rounded p-4">
        <h3 class="text-center mb-4">Форма входа</h3>
        <?php if(session()->get('success')): ?>
          <div class="alert alert-success" role="alert">
            <?= session()->get('success') ?>
          </div>
        <?php endif; ?>
        <?php if(session()->get('error_login_status')): ?>
          <div class="alert alert-danger" role="alert">
            <?= session()->get('error_login_status') ?>
          </div>
        <?php endif; ?>
        <form id="form_log" class="form-center" action="login" method="POST" style="max-width: 400px;">
              <div class="row mb-3">
                <div class="col-sm-10">
                <label for="email" class="form-label">Email:</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="email-aaddon"><i class="far fa-envelope"></i></span>
                      <input type="email" class="form-control" name="email" placeholder="Эл.почта" aria-label="Эл.почта" aria-describedby="email-aaddon">
                    </div>
                  </div>
                  <div class="col-sm-10">
                  <label for="password" class="form-label">Пароль:</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="pass-addon"><i class="fas fa-key"></i></span>
                      <input type="password" class="form-control" name="password" placeholder="Пароль" aria-label="Пароль" aria-describedby="pass-addon">
                      <span class="input-group-text">
                        <i id="eye_log" class="far fa-eye-slash" onclick="showHidePwd('2');"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <?php if(isset($validation)): ?>
                    <div id="result2_form" class="col-12">
                      <div class="alert alert-danger" role="alert">
                        <?= $validation->listErrors() ?>
                      </div>
                    </div>
                  <?php endif; ?>
                <a type="button" href="register" class="btn btn-warning">Нет аккаунта</a>
                <button type="submit" class="btn btn-primary">Войти</button>
                <br>
                <a href="forgot_password">Забыли пароль?</a>
                <?php if(isset($login_button)): ?>
                <div class="form-group">
                <h7>Войти или зарегистрироваться с помощью:</h7>
                
                  <a class="btn btn-light" href="<?= $login_button ?>"><img width="20px" alt="Google sign-in" style="margin:3px;" 
                src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png" border="0" height="20px;" title="Google" />Google</a>
                </div>
                <?php endif; ?>
          </form>
      </div>
    </div>
    </div>
    <!-- JS, Popper.js, and jQuery | fa-fa icons -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src='http://code.jquery.com/jquery-2.1.1.min.js'></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js" integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/437be00af9.js" crossorigin="anonymous"></script>
    <script type="text/javascript">
        function showHidePwd(num) {
            switch(num){
            case "1":{
                var input = form_reg.password;
                var eye=document.getElementById("eye_reg");
            }break;
            case "2":{
                var input = form_log.password;
                var eye=document.getElementById("eye_log");
            }break;
            }
            
            if (input.type === "password") {
                input.type = "text";
                eye.className = "far fa-eye";

            } else {
                input.type = "password";
                eye.className = "far fa-eye-slash";

            }
        }
    </script>
</body>
