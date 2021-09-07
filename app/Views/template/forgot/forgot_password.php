<body>
    <div class="container-fluid d-flex h-100 justify-content-center align-items-center p-0">
    <div class="row bg-white shadow-sm">
      <div class="col border rounded p-4">
        <h3 class="text-center mb-4">Сброс пароля</h3>
        <?php if(session()->get('success_forgot')): ?>
          <div class="alert alert-success" role="alert">
            <?= session()->get('success_forgot') ?>
          </div>
        <?php endif; ?>
        <?php if(session()->get('error_forgot')): ?>
          <div class="alert alert-danger" role="alert">
            <?= session()->get('error_forgot') ?>
          </div>
        <?php endif; ?>
        <form id="form_log" action="forgot_password" method="POST" style="max-width: 400px;">
              <div class="row mb-3">
                <div class="col-sm-10">
                <label for="email" class="form-label">Email:</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="email-aaddon"><i class="far fa-envelope"></i></span>
                      <input type="email" class="form-control" name="email" placeholder="Эл.почта" aria-label="Эл.почта" aria-describedby="email-aaddon">
                    </div>
                  </div>
                  <div class="col-sm-10">
                </div>
                <?php if(isset($validation)): ?>
                    <div id="result2_form" class="col-12">
                      <div class="alert alert-danger" role="alert">
                        <?= $validation->listErrors() ?>
                      </div>
                    </div>
                  <?php endif; ?>
                <button type="submit" class="btn btn-primary">Сбросить пароль</button>
          </form>
      </div>
    </div>
    </div>
    <!-- JS, Popper.js, and jQuery | fa-fa icons -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src='http://code.jquery.com/jquery-2.1.1.min.js'></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js" integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/437be00af9.js" crossorigin="anonymous"></script>
</body>
