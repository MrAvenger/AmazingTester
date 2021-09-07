<html lang="en">
<head>
<meta charset="UTF8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Система тестирования AmazingTester</title>
<!-- CSS only -->
<link rel="stylesheet" href="<?php echo base_url() ?>/assets/style.css" type="text/css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
<!-- JS only -->
<script src="https://kit.fontawesome.com/437be00af9.js" crossorigin="anonymous"></script>
</head> 
<header>
    <?php $uri=service('uri'); ?>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark" style="background-color: darkred;">
        <div class="container-fluid">
            <a class="navbar-brand" href="/Codeigniter4">AmazingTester</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= ($uri->getSegment(1) == '' ? 'active':null) ?>" aria-current="page" href="/Codeigniter4"><i class="fas fa-home"></i> Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($uri->getSegment(1) == 'test_list' ? 'active':null) ?>" href="test_list"><i class="fas fa-university"></i> Тесты</a>
                    </li>
                    <?php if (session()->get('role')=="Admin"):?>
                    <li class="nav-item">
                        <a class="nav-link" href="admin"><i class="fas fa-user-shield"></i> Панель администратора</a>
                    </li>
                    <?php endif;?>
                </ul>
                <ul class="navbar-nav my-2 my-lg-0">
                    <?php if(!session()->get('isLoggedIn')): ?>   
                    <li>
                        <a class="nav-link <?= ($uri->getSegment(1) == 'login' ? 'active':null) ?>" href="login"><i class="fas fa-sign-in-alt"></i> Авторизация</a>
                    </li>
                    <li>
                        <a class="nav-link <?= ($uri->getSegment(1) == 'register' ? 'active':null) ?>" href="register"><i class="far fa-registered"></i> Регистрация</a>
                    </li>
                     
                    <?php else: ?>
                    <li>
                        <a class="nav-link <?= ($uri->getSegment(1) == 'dashboard' ? 'active':null) ?>" href="dashboard"><i class="fab fa-cpanel"></i> Панель</a>
                    </li>
                    <li>
                        <a class="nav-link <?= ($uri->getSegment(1) == 'profile' ? 'active':null) ?>" href="profile"><i class="fas fa-user-circle"></i> Профиль</a>
                    </li>
                    <li>
                        <a class="nav-link <?= ($uri->getSegment(1) == 'logout' ? 'active':null) ?>" href="logout"><i class="fas fa-door-open"></i> Выход</a>
                    </li>
                            
                    <?php endif; ?>

                </ul>
            </div> 
        </div>
          </nav>
</header>