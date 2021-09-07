<body>
    <!-- JS, Popper.js, and jQuery | fa-fa icons -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src='http://code.jquery.com/jquery-2.1.1.min.js'></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js" integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous"></script>
    <div id="category_list" class="container-fluid my-2">
        <?php foreach($categories as $item){?>
        <div class="p-5 rounded-lg m-3 bg-light">
            <div class="row">
            <!-- Grid column -->
                <div class="col-md-4 offset-md-1 mx-3 mt-5">
                    <!-- Featured image -->
                    <div class="view overlay">
                        <img src="<?php echo base_url().'/public/uploads/images/categories/'.$item['image']?>" class="img-fluid">
                        <a>
                        <div class="mask rgba-white-slight"></div>
                        </a>
                    </div>
                </div>
                <!-- Grid column -->
                <!-- Grid column -->
                <div class="col-md-7 text-md-left ml-3 mt-3 ">
                    <!-- Excerpt -->
                    <h6 class="h6 pb-1"><i class="fas fa-desktop pr-1"></i> Категория тестов</h6>
                    <h4 class="h4 mb-4"><?php echo $item['name']?></h4>
                    <p class="font-weight-normal">Перейти к тестам данной категории можно нажав на кнопку ниже.</p>
                    <p class="font-weight-normal">создал <a><strong>Администратор</strong></a>, <?php echo date("d.m.Y",strtotime($item['created_at'])) ?></p>
                    <a class="btn btn-primary">Перейти к тестам</a>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->
        </div>
        <?php } ?>
    </div>
</body>