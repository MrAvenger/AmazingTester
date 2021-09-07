<body>
    <div class="container-fluid d-flex h-100 justify-content-center align-items-center p-0">
    <div class="row bg-white shadow-sm">
      <div class="col border rounded p-4">
        <h3 class="text-center mb-4">Смена пароля</h3>
        <form id="form_reset" method="POST" style="max-width: 400px;">
              <div class="row mb-3">
                <div class="col-sm-10">
                  <div class="col-sm-10">
                    <label for="password" class="form-label">Пароль:</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="pass-addon"><i class="fas fa-key"></i></span>
                      <input type="hidden" name="token">
                      <input type="password" class="form-control" name="password" placeholder="Новый пароль" aria-label="Пароль" aria-describedby="pass-addon">
                      <span class="input-group-text">
                        <i id="eye_res" class="far fa-eye-slash" onclick="showHidePwd();"></i>
                      </span>
                    </div>
                    <label for="password" class="form-label">Подтвердите пароль:</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="pass-addon"><i class="fas fa-key"></i></span>
                      <input type="password" class="form-control" name="password_confirm" placeholder="Повтор нового пароля" aria-label="Пароль" aria-describedby="pass-addon">
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
                <button type="submit" class="btn btn-primary">Сменить пароль</button>
                <br>
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
        function showHidePwd() {
            var input = form_reset.password;
            var eye=document.getElementById("eye_res");
            
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
