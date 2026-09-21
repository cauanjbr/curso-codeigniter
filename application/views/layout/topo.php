<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($titulo_pagina) ? html_escape($titulo_pagina) : (isset($titulo) ? html_escape($titulo) : 'Curso'); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
        html,
        body {
            min-height: 100%;
        }

        body {
            color: #262626;
            background: #fff;
        }

        .top-navbar {
            min-height: 84px;
            padding: 12px 22px;
            background-color: #292b2c !important;
        }

        .top-navbar .navbar-brand {
            margin-right: 28px;
            font-size: 26px;
            font-weight: 400;
        }

        .top-navbar .nav-link {
            padding-right: 14px !important;
            padding-left: 14px !important;
            font-size: 21px;
        }

        .navbar-search .form-control {
            width: 290px;
            height: 55px;
            padding-right: 18px;
            padding-left: 18px;
            font-size: 20px;
        }

        .navbar-search .btn {
            height: 55px;
            margin-left: 12px;
            padding-right: 24px;
            padding-left: 24px;
            font-size: 20px;
        }

        .page-shell {
            display: flex;
            min-height: calc(100vh - 84px);
        }

        .sidebar {
            flex: 0 0 320px;
            width: 320px;
            background: #fafafa;
            border-right: 1px solid #eeeeee;
        }

        .sidebar .nav-link {
            padding: 17px 22px;
            color: #1684c5;
            font-size: 22px;
        }

        .sidebar .nav-link.active {
            color: #fff;
            background: #087dcc;
        }

        .main-content {
            min-width: 0;
            flex: 1;
            padding: 20px 20px 48px 24px;
        }

        .page-title {
            margin: 0 0 30px;
            padding: 0 0 7px;
            border-bottom: 1px solid #dedede;
            font-size: 60px;
            font-weight: 300;
            line-height: 1.2;
        }

        @media (max-width: 991.98px) {
            .top-navbar {
                min-height: auto;
            }

            .navbar-search {
                margin-top: 12px;
                margin-bottom: 5px;
            }

            .navbar-search .form-control {
                width: auto;
                flex: 1;
            }
        }

        @media (max-width: 767.98px) {
            .page-shell {
                display: block;
                min-height: auto;
            }

            .sidebar {
                width: 100%;
            }

            .sidebar .nav {
                flex-direction: row !important;
            }

            .sidebar .nav-link {
                padding: 11px 15px;
                font-size: 17px;
            }

            .main-content {
                padding: 20px 15px 40px;
            }

            .page-title {
                font-size: 42px;
            }

        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark top-navbar">
        <?= anchor('livros', 'Cursos IsmWeb', array('class' => 'navbar-brand')); ?>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Abrir menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuPrincipal">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <?= anchor('livros', 'Listar livros', array('class' => 'nav-link')); ?>
                </li>
                <li class="nav-item">
                    <?= anchor('usuarios', 'Listar usuários', array('class' => 'nav-link')); ?>
                </li>
                <li class="nav-item">
                    <?= anchor('sair', 'Sair', array('class' => 'nav-link')); ?>
                </li>
            </ul>

            <form class="form-inline navbar-search" onsubmit="return false;">
                <input class="form-control" type="search" placeholder="Buscar" aria-label="Buscar">
                <button class="btn btn-outline-success" type="submit">Buscar</button>
            </form>

        </div>
    </nav>

    <div class="page-shell">
        <aside class="sidebar">
            <nav class="nav flex-column">
                <?= anchor('livros', 'Listar livros', array('class' => 'nav-link')); ?>
                <?= anchor('usuarios', 'Listar usuários', array('class' => 'nav-link')); ?>
                <?= anchor('sair', 'Sair', array('class' => 'nav-link')); ?>
            </nav>
        </aside>

        <main class="main-content">
