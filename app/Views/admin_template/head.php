<head>
    <?php $uri=service('uri'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AmazingTester | Админ панель</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css"
        href="<?php echo base_url()?>/assets/js/jquery-toast-plugin/src/jquery.toast.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css"
        integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/437be00af9.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js">
    </script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="<?php echo base_url()?>/assets/js/jquery-toast-plugin/src/jquery.toast.js"></script>
    <style>
    .sidebar {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 100;
        padding: 90px 0 0;
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        z-index: 99;
    }

    @media (max-width: 767.98px) {
        .sidebar {
            top: 11.5rem;
            padding: 0;
        }
    }

    .navbar {
        box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .1);
    }

    @media (min-width: 767.98px) {
        .navbar {
            top: 0;
            position: sticky;
            z-index: 999;
        }
    }

    .sidebar .nav-link {
        color: #333;
    }

    .sidebar .nav-link.active {
        color: #0d6efd;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-light bg-light p-3">
        <div class="d-flex col-12 col-md-3 col-lg-2 mb-2 mb-lg-0 flex-wrap flex-md-nowrap justify-content-between">
            <a class="navbar-brand" href="#">
                Админ панель
            </a>
            <button class="navbar-toggler d-md-none collapsed mb-3" type="button" data-toggle="collapse"
                data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <!-- <div class="col-12 col-md-4 col-lg-2">
            <input class="form-control form-control-dark" type="text" placeholder="Search" aria-label="Search">
        </div> -->
        <div class="col-12 col-md-5 col-lg-8 d-flex align-items-center justify-content-md-end mt-3 mt-md-0">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-expanded="false">
                    Привет, <?php echo session()->get('first_name'); ?>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="#">Настройки</a></li>
                    <!-- <li><a class="dropdown-item" href="#">Messages</a></li> -->
                    <li><a class="dropdown-item" href="<?php echo base_url()?>/logout">Выход</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(1) == 'admin' &&$uri->getSegment(2) == null ? 'active':null) ?>"
                                aria-current="page" href="<?php echo base_url() ?>/admin">
                                <i class="fas fa-home"></i>
                                <span class="ml-2">Главная</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(2) == 'users' ? 'active':null) ?>"
                                href="<?php echo base_url() ?>/admin/users">
                                <i class="fas fa-users"></i>
                                <span class="ml-2">Пользователи</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(2) == 'subjects' ? 'active':null) ?>"
                                href="<?php echo base_url() ?>/admin/subjects">
                                <i class="far fa-compass"></i>
                                <span class="ml-2">Учебные предметы</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(2) == 'organizations' ? 'active':null) ?>"
                                href="<?php echo base_url() ?>/admin/organizations">
                                <i class="fa fa-building-o" aria-hidden="true"></i>
                                <span class="ml-2">Организации</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(2) == 'groups_classes' ? 'active':null) ?>" href="<?php echo base_url() ?>/admin/groups_classes">
                                <i class="fas fa-user-friends"></i>
                                <span class="ml-2">Группы/классы</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?= ($uri->getSegment(2) == 'tests' ? 'active':null) ?>" href="#">
                                <i class="fas fa-vials"></i>
                                <span class="ml-2">Тесты</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>