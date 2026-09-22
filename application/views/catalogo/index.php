<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catálogo de livros</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; color: #292b2c; background: #fff; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif; }
        .container { width: 88%; max-width: 1660px; margin: 0 auto; }
        .cabecalho { background: #f7f7f7; padding: 24px 0; }
        .cabecalho .container { display: flex; justify-content: space-between; align-items: center; gap: 20px; }
        .marca { color: inherit; font-size: 28px; text-decoration: none; }
        .painel { color: #555; font-size: 16px; text-decoration: none; }
        a:hover { text-decoration: underline; }
        a:focus-visible { outline: 3px solid #1684c5; outline-offset: 5px; }
        h1 { font-size: 56px; font-weight: 300; line-height: 1.2; margin: 0 0 24px; padding: 8px 0 22px; border-bottom: 1px solid #ddd; }
        .livro { display: flex; align-items: flex-start; gap: 24px; margin-bottom: 70px; }
        .capa { width: 150px; height: 215px; object-fit: contain; object-position: top center; flex: 0 0 150px; }
        .conteudo { min-width: 0; }
        h2 { margin: 0 0 12px; font-size: 30px; font-weight: 400; line-height: 1.3; overflow-wrap: anywhere; }
        .autor { margin: 0 0 10px; color: #666; font-size: 16px; }
        .resumo { margin: 0; font-size: 22px; font-weight: 300; line-height: 1.6; white-space: pre-line; overflow-wrap: anywhere; }
        .vazio { font-size: 20px; padding: 24px 0; }
        @media (max-width: 600px) {
            .container { width: auto; margin: 0 20px; }
            .cabecalho { padding: 20px 0; }
            .marca { font-size: 22px; }
            .painel { font-size: 14px; }
            h1 { font-size: 42px; padding-top: 16px; }
            .livro { gap: 16px; margin-bottom: 40px; }
            .capa { width: 95px; height: 140px; flex-basis: 95px; }
            h2 { font-size: 22px; }
            .resumo { font-size: 17px; }
        }
    </style>
</head>
<body>
    <header class="cabecalho">
        <div class="container">
            <a class="marca" href="<?= html_escape(base_url()); ?>">Catálogo de livros</a>
            <a class="painel" href="<?= html_escape(site_url('login')); ?>">Entrar</a>
        </div>
    </header>
    <main class="container">
        <h1>Livros</h1>
        <?php if (empty($livros)): ?>
            <p class="vazio">Nenhum livro disponível no momento.</p>
        <?php else: ?>
            <?php foreach ($livros as $livro): ?>
                <article class="livro">
                    <img class="capa" src="<?= html_escape($livro->capa_url); ?>" alt="Capa de <?= html_escape($livro->titulo); ?>" width="150" height="215" loading="lazy">
                    <div class="conteudo">
                        <h2><?= html_escape($livro->titulo); ?></h2>
                        <p class="autor"><?= html_escape($livro->autor); ?></p>
                        <p class="resumo"><?= html_escape($livro->resumo); ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>
</body>
</html>
