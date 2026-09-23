<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0b0b0c">
    <title><?= isset($titulo_pagina) ? html_escape($titulo_pagina) : (isset($titulo) ? html_escape($titulo) : 'Curso'); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@600;700&display=swap">
    <style>
        /* Tema preto e dourado do painel: mesmas cores e fontes do catálogo público */
        :root {
            --preto: #0b0b0c;
            --preto-2: #121214;
            --grafite: #1b1b1f;
            --borda: #2a2a2f;
            --dourado: #d4af37;
            --dourado-claro: #f3d77f;
            --dourado-escuro: #9c7a1c;
            --texto: #f3efe6;
            --texto-suave: #b3ab9a;
            --texto-apagado: #7d776b;
            --vermelho: #e0676b;
            --fonte-titulo: "Playfair Display", Georgia, "Times New Roman", serif;
            --fonte-texto: Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif;
            --raio: 14px;
        }

        html,
        body {
            min-height: 100%;
        }

        html { background: var(--preto); }

        body {
            color: var(--texto);
            font-family: var(--fonte-texto);
            background:
                radial-gradient(1100px 480px at 60% -160px, rgba(212, 175, 55, .12), transparent 70%),
                var(--preto);
        }

        a { color: var(--dourado-claro); }
        a:hover { color: var(--dourado); }

        :focus-visible {
            outline: 2px solid var(--dourado-claro);
            outline-offset: 2px;
        }

        /* ---------- Barra superior e menu lateral ---------- */
        .top-navbar {
            min-height: 76px;
            padding: 12px 22px;
            border-bottom: 1px solid var(--borda);
            background-color: rgba(11, 11, 12, .92) !important;
        }

        .top-navbar .navbar-brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-right: 28px;
            color: var(--texto) !important;
            font-family: var(--fonte-titulo);
            font-size: 24px;
        }

        .top-navbar .navbar-brand::before {
            content: "\2756";
            display: grid;
            place-items: center;
            width: 34px;
            height: 34px;
            border: 1px solid var(--dourado);
            border-radius: 50%;
            color: var(--dourado);
            font-size: 15px;
        }

        .top-navbar .nav-link {
            padding-right: 14px !important;
            padding-left: 14px !important;
            color: var(--texto-suave) !important;
            font-size: 17px;
        }

        .top-navbar .nav-link:hover,
        .top-navbar .nav-link.active {
            color: var(--dourado-claro) !important;
        }

        .top-navbar .navbar-text {
            color: var(--texto-suave) !important;
            font-size: 15px;
        }

        .top-navbar .navbar-text strong { color: var(--dourado-claro) !important; }

        .page-shell {
            display: flex;
            min-height: calc(100vh - 76px);
        }

        .sidebar {
            flex: 0 0 260px;
            width: 260px;
            padding-top: 18px;
            border-right: 1px solid var(--borda);
            background: rgba(18, 18, 20, .7);
        }

        .sidebar .nav-link {
            padding: 14px 22px;
            border-left: 3px solid transparent;
            color: var(--texto-suave);
            font-size: 17px;
            transition: color .2s, background-color .2s;
        }

        .sidebar .nav-link:hover { color: var(--texto); }

        .sidebar .nav-link.active {
            border-left-color: var(--dourado);
            background: rgba(212, 175, 55, .08);
            color: var(--dourado-claro);
        }

        .main-content {
            min-width: 0;
            flex: 1;
            padding: 32px 32px 56px;
        }

        .page-title {
            margin: 0 0 28px;
            padding: 0 0 14px;
            border-bottom: 1px solid var(--borda);
            font-family: var(--fonte-titulo);
            font-size: 46px;
            font-weight: 700;
            line-height: 1.15;
            background: linear-gradient(180deg, var(--dourado-claro) 10%, var(--dourado) 60%, var(--dourado-escuro) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* ---------- Bootstrap no tema escuro ---------- */
        label,
        .col-form-label { color: var(--texto-suave); }

        .form-control,
        .form-control:focus,
        .custom-select {
            border-color: var(--borda);
            background-color: var(--preto);
            color: var(--texto);
        }

        .form-control:focus {
            border-color: var(--dourado);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, .2);
        }

        .form-control::placeholder { color: var(--texto-apagado); }
        .form-control-file { color: var(--texto-suave); }
        select.form-control option { background: var(--preto-2); color: var(--texto); }

        .text-muted { color: var(--texto-apagado) !important; }
        .text-danger { color: #f08c8f !important; }
        hr, .border { border-color: var(--borda) !important; }

        .btn { border-radius: 999px; font-weight: 500; }

        .btn-success,
        .btn-success:hover,
        .btn-success:focus {
            border-color: var(--dourado);
            background: var(--dourado);
            color: var(--preto);
        }

        .btn-success:hover { background: var(--dourado-claro); border-color: var(--dourado-claro); }

        .btn-primary,
        .btn-outline-success {
            border-color: var(--dourado);
            background: transparent;
            color: var(--dourado-claro);
        }

        .btn-primary:hover,
        .btn-outline-success:hover {
            border-color: var(--dourado);
            background: var(--dourado);
            color: var(--preto);
        }

        .btn-info {
            border-color: var(--borda);
            background: transparent;
            color: var(--texto-suave);
        }

        .btn-info:hover {
            border-color: var(--texto-suave);
            background: rgba(255, 255, 255, .06);
            color: var(--texto);
        }

        .btn-danger {
            border-color: rgba(224, 103, 107, .55);
            background: transparent;
            color: var(--vermelho);
        }

        .btn-danger:hover {
            border-color: var(--vermelho);
            background: var(--vermelho);
            color: var(--preto);
        }

        /* O Bootstrap pinta botões desativados com a cor original; aqui eles só ficam apagados */
        .btn-info:disabled,
        .btn-info.disabled,
        .btn-danger:disabled,
        .btn-danger.disabled,
        .btn-primary:disabled,
        .btn-primary.disabled {
            background: transparent;
        }

        .btn-info:disabled,
        .btn-info.disabled { border-color: var(--borda); color: var(--texto-suave); }

        .btn-danger:disabled,
        .btn-danger.disabled { border-color: rgba(224, 103, 107, .55); color: var(--vermelho); }

        .btn:disabled,
        .btn.disabled { opacity: .35; }

        /* Botão "Escolher arquivo" do campo de imagem */
        .form-control-file::file-selector-button {
            margin-right: 12px;
            padding: 7px 16px;
            border: 1px solid var(--dourado);
            border-radius: 999px;
            background: transparent;
            color: var(--dourado-claro);
            font: inherit;
            cursor: pointer;
            transition: background-color .2s, color .2s;
        }

        .form-control-file::file-selector-button:hover {
            background: var(--dourado);
            color: var(--preto);
        }

        .btn-link { color: var(--dourado-claro); }

        .alert-success {
            border-color: rgba(212, 175, 55, .45);
            background: rgba(212, 175, 55, .1);
            color: var(--dourado-claro);
        }

        .alert-danger {
            border-color: rgba(224, 103, 107, .45);
            background: rgba(224, 103, 107, .1);
            color: #f5b3b5;
        }

        .badge {
            padding: 5px 11px;
            border: 1px solid transparent;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-success { border-color: var(--dourado); background: transparent; color: var(--dourado-claro); }
        .badge-danger { border-color: var(--borda); background: transparent; color: var(--texto-apagado); }
        .badge-secondary { background: var(--dourado); color: var(--preto); }

        .table { color: var(--texto); }

        .table thead th {
            border-top: 0;
            border-bottom: 1px solid var(--borda);
            color: var(--dourado);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .12em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .table td,
        .table-bordered,
        .table-bordered td,
        .table-bordered th { border-color: var(--borda); }

        .table-striped tbody tr:nth-of-type(odd) { background: rgba(255, 255, 255, .02); }

        .table-hover tbody tr:hover,
        .table-striped tbody tr:hover {
            background: rgba(212, 175, 55, .06);
            color: var(--texto);
        }

        .page-link {
            border-color: var(--borda);
            background: var(--preto);
            color: var(--texto-suave);
        }

        .page-link:hover { border-color: var(--dourado); background: var(--grafite); color: var(--dourado-claro); }
        .page-item.active .page-link { border-color: var(--dourado); background: var(--dourado); color: var(--preto); }
        .page-item.disabled .page-link { border-color: var(--borda); background: var(--preto-2); color: #4d4a44; }

        .img-thumbnail { border-color: var(--borda); background: var(--preto); }

        /* ---------- Peças das listas (livros e usuários) ---------- */
        .painel-cabecalho {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 28px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--borda);
        }

        .painel-cabecalho .page-title {
            margin: 0;
            padding: 0;
            border: 0;
        }

        .painel-subtitulo {
            margin: 6px 0 0;
            color: var(--texto-suave);
        }

        .painel-ferramentas {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 14px;
            margin-bottom: 18px;
            padding: 14px;
            border: 1px solid var(--borda);
            border-radius: var(--raio);
            background: rgba(18, 18, 20, .85);
        }

        .painel-busca {
            position: relative;
            flex: 1 1 280px;
            margin: 0;
        }

        .painel-busca svg {
            position: absolute;
            top: 50%;
            left: 14px;
            width: 18px;
            height: 18px;
            color: var(--dourado);
            transform: translateY(-50%);
            pointer-events: none;
        }

        .painel-busca .form-control,
        .painel-ferramentas select.form-control {
            height: 44px;
            border-radius: 10px;
        }

        .painel-busca .form-control { padding-left: 42px; }

        .painel-ferramentas label { margin: 0; }

        .painel-cartao {
            overflow: hidden;
            border: 1px solid var(--borda);
            border-radius: var(--raio);
            background: linear-gradient(180deg, var(--grafite), var(--preto-2));
        }

        .painel-cartao .table { margin: 0; }

        .painel-cartao .table th,
        .painel-cartao .table td {
            padding: 14px 18px;
            vertical-align: middle;
        }

        .painel-cartao .table-bordered,
        .painel-cartao .table-bordered td,
        .painel-cartao .table-bordered th {
            border-right: 0;
            border-left: 0;
        }

        .painel-cartao .table-bordered { border: 0; }

        .item-lista {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 220px;
        }

        .item-lista__titulo {
            display: block;
            font-family: var(--fonte-titulo);
            font-size: 17px;
            font-weight: 600;
            line-height: 1.3;
        }

        .item-lista__detalhe {
            display: block;
            color: var(--texto-suave);
            font-size: 13px;
        }

        .capa-mini {
            flex: 0 0 44px;
            width: 44px;
            height: 62px;
            border: 1px solid var(--borda);
            border-radius: 6px;
            background: var(--preto);
            object-fit: cover;
            box-shadow: 0 6px 14px rgba(0, 0, 0, .45);
        }

        .capa-mini--vazia,
        .avatar {
            display: grid;
            place-items: center;
            color: var(--dourado);
            font-family: var(--fonte-titulo);
            font-weight: 700;
        }

        .capa-mini--vazia { font-size: 20px; }

        .avatar {
            flex: 0 0 42px;
            width: 42px;
            height: 42px;
            border: 1px solid var(--dourado);
            border-radius: 50%;
            background: rgba(212, 175, 55, .08);
            font-size: 16px;
            text-transform: uppercase;
        }

        .painel-rodape-lista {
            margin-top: 16px;
            color: var(--texto-suave);
            font-size: 14px;
        }

        @media (max-width: 991.98px) {
            .top-navbar {
                min-height: auto;
            }
        }

        @media (max-width: 767.98px) {
            .page-shell {
                display: block;
                min-height: auto;
            }

            .sidebar {
                width: 100%;
                padding-top: 0;
                border-right: 0;
                border-bottom: 1px solid var(--borda);
            }

            .sidebar .nav {
                flex-direction: row !important;
            }

            .sidebar .nav-link {
                padding: 11px 15px;
                border-bottom: 3px solid transparent;
                border-left: 0;
                font-size: 15px;
            }

            .sidebar .nav-link.active { border-bottom-color: var(--dourado); }

            .main-content {
                padding: 22px 16px 40px;
            }

            .page-title {
                font-size: 34px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { transition: none !important; }
        }
    </style>
</head>
<?php
// Destaca no menu a seção aberta (livros ou usuarios)
$secaoAtual = $this->uri->segment(1);
$classeMenu = function ($secao) use ($secaoAtual) {
    return array(
        'class' => 'nav-link' . ($secaoAtual === $secao ? ' active' : ''),
        'aria-current' => $secaoAtual === $secao ? 'page' : 'false'
    );
};
$usuarioLogado = $this->session->userdata('usuario_logado');
?>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark top-navbar">
        <?= anchor('livros', 'Cursos IsmWeb', array('class' => 'navbar-brand')); ?>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Abrir menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuPrincipal">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <?= anchor('catalogo', 'Catálogo', array('class' => 'nav-link')); ?>
                </li>
                <li class="nav-item">
                    <?= anchor('livros', 'Listar livros', $classeMenu('livros')); ?>
                </li>
                <li class="nav-item">
                    <?= anchor('usuarios', 'Listar usuários', $classeMenu('usuarios')); ?>
                </li>
                <li class="nav-item">
                    <?= anchor('sair', 'Sair', array('class' => 'nav-link')); ?>
                </li>
            </ul>

            <?php if (!empty($usuarioLogado['nome'])): ?>
                <span class="navbar-text">
                    Conectado como <strong class="text-white"><?= html_escape($usuarioLogado['nome']); ?></strong>
                </span>
            <?php endif; ?>
        </div>
    </nav>

    <div class="page-shell">
        <aside class="sidebar">
            <nav class="nav flex-column">
                <?= anchor('livros', 'Listar livros', $classeMenu('livros')); ?>
                <?= anchor('usuarios', 'Listar usuários', $classeMenu('usuarios')); ?>
                <?= anchor('sair', 'Sair', array('class' => 'nav-link')); ?>
            </nav>
        </aside>

        <main class="main-content">
