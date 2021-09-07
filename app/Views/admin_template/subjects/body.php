        <div class="row">
            <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Учебные предметы</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Просмотр</li>
                    </ol>
                </nav>
                <h1 class="h2">Управление учебными предметами/дисциплинами</h1>
                
                <!-- <p>Это главная страница админ панели</p> -->
                <button type="button" class="btn btn-primary btn-lg m-3" onclick="add_open()" data-toggle="modal" data-target="#Modal_Subject_Edit"><i class="fas fa-plus"></i> Добавить предмет</button>
                <div class="table-responsive-xl">
                <table id="table_subjects" class="table table-sm table-responsive-sm table-hover">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Название</th>
                      <th scope="col">Изображение</th>
                      <th scope="col">Группа</th>
                      <th scope="col">Организация</th>
                      <th scope="col">Создал</th>
                      <th scope="col">Создано</th>
                      <th scope="col">Обновлено</th>
                      <th scope="col">Действия</th>
                    </tr>
                  </thead>

                </table>
                </div>                
            </main>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>/assets/js/admin/subjects.js"></script>