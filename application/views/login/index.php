<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= html_escape($titulo); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        html, body {
            min-height: 100%;
        }

        body {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 110px 15px 40px;
            background: #f4f4f4;
        }

        .login-box {
            width: 100%;
            max-width: 450px;
        }

        .login-title {
            margin-bottom: 12px;
            font-size: 46px;
            font-weight: 300;
        }

        .login-box .form-control {
            height: 62px;
            font-size: 21px;
        }

        .login-box .btn {
            height: 70px;
            font-size: 25px;
        }
    </style>
</head>
<body>
    <main class="login-box">
        <h1 class="login-title">Dados de acesso</h1>

        <?php if ($erro): ?>
            <div class="alert alert-danger" role="alert">
                Nome, e-mail ou senha inválidos.
            </div>
        <?php endif; ?>

        <?= form_open('login'); ?>
            <div class="form-group mb-0">
                <label class="sr-only" for="login">Nome ou e-mail</label>
                <input
                    class="form-control"
                    type="text"
                    name="login"
                    id="login"
                    value="<?= html_escape(set_value('login')); ?>"
                    placeholder="Nome ou e-mail"
                    autocomplete="username"
                    autofocus
                >
                <?= form_error('login'); ?>
            </div>

            <div class="form-group mb-3">
                <label class="sr-only" for="senha">Senha</label>
                <input
                    class="form-control"
                    type="password"
                    name="senha"
                    id="senha"
                    placeholder="Senha"
                    autocomplete="current-password"
                >
                <?= form_error('senha'); ?>
            </div>

            <button class="btn btn-primary btn-block" type="submit">Logar</button>
        <?= form_close(); ?>
    </main>
</body>
</html>
