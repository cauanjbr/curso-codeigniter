<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0b0b0c">
    <title>Catálogo de livros</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@600;700&display=swap">
    <style>
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
            --fonte-titulo: "Playfair Display", Georgia, "Times New Roman", serif;
            --fonte-texto: Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif;
            --raio: 14px;
        }

        * { box-sizing: border-box; }

        [hidden] { display: none !important; }

        html { background: var(--preto); }

        body {
            margin: 0;
            min-height: 100vh;
            color: var(--texto);
            font-family: var(--fonte-texto);
            line-height: 1.5;
            background:
                radial-gradient(1200px 520px at 50% -140px, rgba(212, 175, 55, .16), transparent 70%),
                radial-gradient(700px 400px at 100% 30%, rgba(212, 175, 55, .05), transparent 70%),
                var(--preto);
        }

        a { color: inherit; }

        /* Texto lido por leitores de tela, mas invisível na página */
        .so-leitor {
            position: absolute;
            width: 1px;
            height: 1px;
            overflow: hidden;
            clip: rect(0 0 0 0);
            white-space: nowrap;
        }

        :focus-visible {
            outline: 2px solid var(--dourado-claro);
            outline-offset: 3px;
        }

        .container {
            width: 100%;
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* ---------- Topo ---------- */
        .barra {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding-top: 22px;
            padding-bottom: 22px;
        }

        .marca {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-family: var(--fonte-titulo);
            font-size: 22px;
            text-decoration: none;
        }

        .marca__icone {
            display: grid;
            place-items: center;
            width: 36px;
            height: 36px;
            border: 1px solid var(--dourado);
            border-radius: 50%;
            color: var(--dourado);
            font-size: 17px;
        }

        .botao-contorno {
            display: inline-block;
            padding: 9px 20px;
            border: 1px solid var(--dourado);
            border-radius: 999px;
            color: var(--dourado-claro);
            font-size: 15px;
            font-weight: 500;
            text-decoration: none;
            transition: background-color .2s, color .2s;
        }

        .botao-contorno:hover {
            background: var(--dourado);
            color: var(--preto);
        }

        .heroi {
            padding-top: 48px;
            padding-bottom: 56px;
            text-align: center;
        }

        .heroi__selo {
            margin: 0 0 14px;
            color: var(--dourado);
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .28em;
            text-transform: uppercase;
        }

        .heroi h1 {
            margin: 0;
            font-family: var(--fonte-titulo);
            font-size: clamp(38px, 6vw, 68px);
            font-weight: 700;
            line-height: 1.1;
            background: linear-gradient(180deg, var(--dourado-claro) 10%, var(--dourado) 55%, var(--dourado-escuro) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .ornamento {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            margin: 22px auto;
            color: var(--dourado);
        }

        .ornamento::before,
        .ornamento::after {
            content: "";
            width: 90px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--dourado));
        }

        .ornamento::after { transform: scaleX(-1); }

        .heroi__texto {
            max-width: 560px;
            margin: 0 auto;
            color: var(--texto-suave);
            font-size: 18px;
        }

        /* ---------- Ferramentas: busca, filtros e ordem ---------- */
        .ferramentas {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 14px;
            padding: 16px;
            margin-bottom: 18px;
            border: 1px solid var(--borda);
            border-radius: var(--raio);
            background: rgba(18, 18, 20, .85);
        }

        .busca {
            position: relative;
            flex: 1 1 280px;
        }

        .busca svg {
            position: absolute;
            top: 50%;
            left: 14px;
            width: 18px;
            height: 18px;
            color: var(--dourado);
            transform: translateY(-50%);
            pointer-events: none;
        }

        .campo {
            width: 100%;
            height: 46px;
            padding: 0 14px;
            border: 1px solid var(--borda);
            border-radius: 10px;
            background: var(--preto);
            color: var(--texto);
            font: inherit;
            font-size: 15px;
        }

        .busca .campo { padding-left: 42px; }

        .campo::placeholder { color: #7d776b; }

        .campo:focus {
            border-color: var(--dourado);
            outline: none;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, .2);
        }

        select.campo {
            width: auto;
            min-width: 190px;
            cursor: pointer;
        }

        .filtros {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .filtro {
            height: 46px;
            padding: 0 16px;
            border: 1px solid var(--borda);
            border-radius: 999px;
            background: transparent;
            color: var(--texto-suave);
            font: inherit;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: border-color .2s, color .2s, background-color .2s;
        }

        .filtro:hover { border-color: var(--dourado); color: var(--texto); }

        .filtro[aria-pressed="true"] {
            border-color: var(--dourado);
            background: var(--dourado);
            color: var(--preto);
        }

        .filtro__qtd { opacity: .7; }

        .contagem {
            margin: 0 0 22px;
            color: var(--texto-suave);
            font-size: 14px;
        }

        /* ---------- Grade de livros ---------- */
        .grade {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 28px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .grade > li {
            animation: surgir .5s ease both;
            animation-delay: calc(var(--ordem, 0) * 45ms);
        }

        @keyframes surgir {
            from { opacity: 0; transform: translateY(14px); }
        }

        .livro {
            position: relative;
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100%;
            padding: 14px 14px 18px;
            border: 1px solid var(--borda);
            border-radius: var(--raio);
            background: linear-gradient(180deg, var(--grafite), var(--preto-2));
            color: inherit;
            font: inherit;
            text-align: left;
            cursor: pointer;
            transform: perspective(900px) rotateX(var(--giro-x, 0deg)) rotateY(var(--giro-y, 0deg)) translateY(var(--sobe, 0));
            transition: transform .25s ease, border-color .25s, box-shadow .25s;
        }

        /* Reflexo dourado que acompanha o mouse */
        .livro::after {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background: radial-gradient(260px circle at var(--luz-x, 50%) var(--luz-y, 0%), rgba(243, 215, 127, .16), transparent 60%);
            opacity: 0;
            transition: opacity .25s;
            pointer-events: none;
        }

        .livro:hover,
        .livro:focus-visible {
            --sobe: -6px;
            border-color: var(--dourado);
            box-shadow: 0 18px 40px rgba(0, 0, 0, .55), 0 0 0 1px rgba(212, 175, 55, .35), 0 0 36px rgba(212, 175, 55, .12);
        }

        .livro:hover::after,
        .livro:focus-visible::after { opacity: 1; }

        .livro__capa {
            display: block;
            width: 100%;
            height: auto;
            aspect-ratio: 5 / 7;
            margin-bottom: 16px;
            border-radius: 8px;
            background: var(--preto);
            object-fit: cover;
            box-shadow: 0 10px 24px rgba(0, 0, 0, .5);
        }

        .livro__titulo {
            display: block;
            margin-bottom: 6px;
            font-family: var(--fonte-titulo);
            font-size: 19px;
            font-weight: 600;
            line-height: 1.3;
        }

        .livro__autor {
            display: -webkit-box;
            margin-bottom: 14px;
            overflow: hidden;
            color: var(--texto-suave);
            font-size: 14px;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .livro__rodape {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-top: auto;
        }

        .preco {
            display: inline-block;
            padding: 4px 12px;
            border: 1px solid var(--dourado);
            border-radius: 999px;
            color: var(--dourado-claro);
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
        }

        .preco--gratis {
            background: var(--dourado);
            color: var(--preto);
        }

        .livro__ver {
            color: var(--dourado);
            font-size: 13px;
            font-weight: 500;
            opacity: .75;
            transition: opacity .2s, transform .2s;
        }

        .livro:hover .livro__ver { opacity: 1; transform: translateX(3px); }

        .vazio {
            padding: 60px 20px;
            border: 1px dashed var(--borda);
            border-radius: var(--raio);
            color: var(--texto-suave);
            font-size: 18px;
            text-align: center;
        }

        .vazio strong {
            display: block;
            margin-bottom: 6px;
            color: var(--dourado-claro);
            font-family: var(--fonte-titulo);
            font-size: 24px;
        }

        /* ---------- Janela de detalhes ---------- */
        .detalhe {
            width: min(880px, calc(100% - 32px));
            max-height: calc(100% - 32px);
            padding: 0;
            border: 1px solid var(--dourado-escuro);
            border-radius: 18px;
            background: linear-gradient(160deg, #1d1b16, var(--preto-2) 45%);
            color: var(--texto);
            box-shadow: 0 30px 80px rgba(0, 0, 0, .7), 0 0 60px rgba(212, 175, 55, .12);
        }

        .detalhe::backdrop {
            background: rgba(0, 0, 0, .78);
            backdrop-filter: blur(4px);
        }

        .detalhe[open] { animation: abrir .28s ease; }

        @keyframes abrir {
            from { opacity: 0; transform: translateY(16px) scale(.97); }
        }

        .detalhe__corpo {
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 32px;
            padding: 32px;
        }

        .detalhe__capa {
            width: 100%;
            height: auto;
            aspect-ratio: 5 / 7;
            border: 1px solid var(--borda);
            border-radius: 10px;
            background: var(--preto);
            object-fit: cover;
            box-shadow: 0 16px 36px rgba(0, 0, 0, .6);
        }

        .detalhe__info {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .detalhe__titulo {
            margin: 12px 0 6px;
            padding-right: 40px;
            font-family: var(--fonte-titulo);
            font-size: clamp(26px, 3.4vw, 36px);
            line-height: 1.15;
            color: var(--dourado-claro);
            overflow-wrap: anywhere;
        }

        .detalhe__autor {
            margin: 0 0 20px;
            color: var(--texto-suave);
        }

        .detalhe__resumo {
            margin: 0 0 24px;
            padding-top: 20px;
            border-top: 1px solid var(--borda);
            font-size: 16px;
            line-height: 1.7;
            white-space: pre-line;
            overflow-wrap: anywhere;
        }

        .detalhe__navegacao {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: auto;
        }

        .detalhe__posicao {
            color: var(--texto-suave);
            font-size: 14px;
        }

        .botao {
            height: 42px;
            padding: 0 18px;
            border: 1px solid var(--dourado);
            border-radius: 999px;
            background: transparent;
            color: var(--dourado-claro);
            font: inherit;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color .2s, color .2s;
        }

        .botao:hover:not(:disabled) {
            background: var(--dourado);
            color: var(--preto);
        }

        .botao:disabled {
            opacity: .35;
            cursor: default;
        }

        .detalhe__fechar {
            position: absolute;
            top: 14px;
            right: 14px;
            display: grid;
            place-items: center;
            width: 40px;
            height: 40px;
            padding: 0;
            border: 1px solid var(--borda);
            border-radius: 50%;
            background: var(--preto);
            color: var(--texto);
            font-size: 22px;
            line-height: 1;
            cursor: pointer;
        }

        .detalhe__fechar:hover { border-color: var(--dourado); color: var(--dourado-claro); }

        .dica {
            margin: 0;
            padding: 0 32px 22px;
            color: #7d776b;
            font-size: 13px;
        }

        /* ---------- Rodapé ---------- */
        .rodape {
            margin-top: 80px;
            padding: 28px 0 36px;
            border-top: 1px solid var(--borda);
            color: #7d776b;
            font-size: 14px;
            text-align: center;
        }

        .rodape span { color: var(--dourado); }

        /* ---------- Celular ---------- */
        @media (max-width: 720px) {
            .container { padding: 0 16px; }
            .heroi { padding-top: 24px; padding-bottom: 36px; }
            .heroi__texto { font-size: 16px; }
            .ferramentas { padding: 12px; }
            select.campo { width: 100%; }
            .filtros { width: 100%; }
            .filtro { flex: 1; padding: 0 10px; }
            .grade { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; }
            .livro { padding: 10px 10px 14px; }
            .livro__titulo { font-size: 16px; }
            .livro__ver { display: none; }
            .detalhe__corpo { grid-template-columns: 1fr; gap: 20px; padding: 22px; }
            .detalhe__capa { width: 150px; }
            .dica { display: none; }
        }

        @media (hover: none) {
            .dica { display: none; }
        }

        /* Quem pediu menos movimento no sistema não vê animações */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container barra">
            <a class="marca" href="<?= html_escape(base_url()); ?>">
                <span class="marca__icone" aria-hidden="true">&#10070;</span>
                Catálogo de livros
            </a>
            <?php if ($logado): ?>
                <a class="botao-contorno" href="<?= html_escape(site_url('livros')); ?>">Ir para o painel</a>
            <?php else: ?>
                <a class="botao-contorno" href="<?= html_escape(site_url('login')); ?>">Entrar</a>
            <?php endif; ?>
        </div>

        <div class="container heroi">
            <p class="heroi__selo">Biblioteca Cursos IsmWeb</p>
            <h1>Livros para ler e aprender</h1>
            <div class="ornamento" aria-hidden="true">&#10070;</div>
            <p class="heroi__texto">
                <?php if (empty($livros)): ?>
                    Novos títulos chegam em breve.
                <?php else: ?>
                    <?= count($livros); ?> <?= count($livros) === 1 ? 'título disponível' : 'títulos disponíveis'; ?>.
                    Escolha um livro para ver os detalhes.
                <?php endif; ?>
            </p>
        </div>
    </header>

    <main class="container">
        <?php if (empty($livros)): ?>
            <p class="vazio"><strong>Nenhum livro disponível</strong>Volte mais tarde para conferir as novidades.</p>
        <?php else: ?>
            <div class="ferramentas" id="ferramentas" role="search" hidden>
                <label class="busca">
                    <span class="so-leitor">Buscar livros</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="11" cy="11" r="7"></circle><path d="m20 20-3.5-3.5"></path></svg>
                    <input class="campo" type="search" id="busca" placeholder="Buscar por título ou autor" autocomplete="off">
                </label>

                <div class="filtros" role="group" aria-label="Filtrar por preço">
                    <button class="filtro" type="button" data-filtro="todos" aria-pressed="true">Todos <span class="filtro__qtd"><?= count($livros); ?></span></button>
                    <button class="filtro" type="button" data-filtro="gratis" aria-pressed="false">Gratuitos <span class="filtro__qtd"><?= (int) $total_gratuitos; ?></span></button>
                    <button class="filtro" type="button" data-filtro="pagos" aria-pressed="false">Pagos <span class="filtro__qtd"><?= (int) $total_pagos; ?></span></button>
                </div>

                <select class="campo" id="ordem" aria-label="Ordenar livros">
                    <option value="padrao">Ordem do catálogo</option>
                    <option value="titulo">Título (A–Z)</option>
                    <option value="titulo-desc">Título (Z–A)</option>
                    <option value="autor">Autor (A–Z)</option>
                    <option value="preco">Menor preço</option>
                    <option value="preco-desc">Maior preço</option>
                </select>
            </div>

            <p class="contagem" id="contagem" aria-live="polite"></p>

            <ul class="grade" id="grade">
                <?php foreach ($livros as $posicao => $livro): ?>
                    <li style="--ordem: <?= (int) $posicao; ?>">
                        <button
                            class="livro"
                            type="button"
                            data-livro
                            data-posicao="<?= (int) $posicao; ?>"
                            data-titulo="<?= html_escape($livro->titulo); ?>"
                            data-autor="<?= html_escape($livro->autor); ?>"
                            data-resumo="<?= html_escape($livro->resumo); ?>"
                            data-preco="<?= html_escape((float) $livro->preco); ?>"
                            data-preco-formatado="<?= html_escape($livro->preco_formatado); ?>"
                            data-capa="<?= html_escape($livro->capa_url); ?>"
                            aria-haspopup="dialog"
                        >
                            <img class="livro__capa" src="<?= html_escape($livro->capa_url); ?>" alt="" width="350" height="490" loading="lazy">
                            <span class="livro__titulo"><?= html_escape($livro->titulo); ?></span>
                            <span class="livro__autor"><?= html_escape($livro->autor); ?></span>
                            <span class="livro__rodape">
                                <span class="preco<?= $livro->gratuito ? ' preco--gratis' : ''; ?>"><?= html_escape($livro->preco_formatado); ?></span>
                                <span class="livro__ver" aria-hidden="true">Ver detalhes &rarr;</span>
                            </span>
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>

            <p class="vazio" id="semResultado" hidden>
                <strong>Nenhum livro encontrado</strong>
                Tente outro termo de busca ou mude o filtro.
            </p>
        <?php endif; ?>
    </main>

    <dialog class="detalhe" id="detalhe" aria-labelledby="detalheTitulo">
        <button class="detalhe__fechar" type="button" id="detalheFechar" aria-label="Fechar">&times;</button>
        <div class="detalhe__corpo">
            <img class="detalhe__capa" id="detalheCapa" src="" alt="">
            <div class="detalhe__info">
                <div><span class="preco" id="detalhePreco"></span></div>
                <h2 class="detalhe__titulo" id="detalheTitulo"></h2>
                <p class="detalhe__autor" id="detalheAutor"></p>
                <p class="detalhe__resumo" id="detalheResumo"></p>
                <div class="detalhe__navegacao">
                    <button class="botao" type="button" id="detalheAnterior">&larr; Anterior</button>
                    <span class="detalhe__posicao" id="detalhePosicao"></span>
                    <button class="botao" type="button" id="detalheProximo">Próximo &rarr;</button>
                </div>
            </div>
        </div>
        <p class="dica">Dica: use as setas &larr; &rarr; do teclado para trocar de livro e Esc para fechar.</p>
    </dialog>

    <footer class="rodape">
        <div class="container">Cursos IsmWeb <span>&#10070;</span> Catálogo de livros</div>
    </footer>

    <script>
        (function () {
            var grade = document.getElementById('grade');

            if (!grade) {
                return;
            }

            var cards = Array.prototype.slice.call(grade.querySelectorAll('[data-livro]'));
            var busca = document.getElementById('busca');
            var ordem = document.getElementById('ordem');
            var botoesFiltro = Array.prototype.slice.call(document.querySelectorAll('[data-filtro]'));
            var contagem = document.getElementById('contagem');
            var semResultado = document.getElementById('semResultado');
            var filtroAtual = 'todos';
            var visiveis = cards.slice();

            // As ferramentas só aparecem com JavaScript ligado; sem ele a grade continua visível
            document.getElementById('ferramentas').hidden = false;

            function normalizar(texto) {
                return texto.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
            }

            function comparar(a, b) {
                var campo = ordem.value;
                var sentido = campo.indexOf('-desc') !== -1 ? -1 : 1;
                campo = campo.replace('-desc', '');

                if (campo === 'padrao') {
                    return Number(a.dataset.posicao) - Number(b.dataset.posicao);
                }

                if (campo === 'preco') {
                    return (Number(a.dataset.preco) - Number(b.dataset.preco)) * sentido
                        || a.dataset.titulo.localeCompare(b.dataset.titulo, 'pt-BR');
                }

                return a.dataset[campo].localeCompare(b.dataset[campo], 'pt-BR', { sensitivity: 'base' }) * sentido;
            }

            function atualizar() {
                var termo = normalizar(busca.value.trim());

                visiveis = cards.filter(function (card) {
                    var preco = Number(card.dataset.preco);
                    var passaFiltro = filtroAtual === 'todos'
                        || (filtroAtual === 'gratis' && preco <= 0)
                        || (filtroAtual === 'pagos' && preco > 0);

                    return passaFiltro && normalizar(card.dataset.titulo + ' ' + card.dataset.autor).indexOf(termo) !== -1;
                }).sort(comparar);

                cards.forEach(function (card) {
                    card.parentElement.hidden = true;
                });

                visiveis.forEach(function (card, indice) {
                    var item = card.parentElement;
                    item.style.setProperty('--ordem', Math.min(indice, 12));
                    item.hidden = false;
                    grade.appendChild(item);
                });

                semResultado.hidden = visiveis.length !== 0;
                contagem.textContent = visiveis.length === cards.length
                    ? 'Mostrando todos os ' + cards.length + ' livros'
                    : 'Mostrando ' + visiveis.length + ' de ' + cards.length + ' livros';
            }

            busca.addEventListener('input', atualizar);
            ordem.addEventListener('change', atualizar);

            botoesFiltro.forEach(function (botao) {
                botao.addEventListener('click', function () {
                    filtroAtual = botao.dataset.filtro;
                    botoesFiltro.forEach(function (outro) {
                        outro.setAttribute('aria-pressed', outro === botao ? 'true' : 'false');
                    });
                    atualizar();
                });
            });

            // Inclinação 3D do card seguindo o mouse (só em telas com mouse e sem "reduzir movimento")
            var podeAnimar = window.matchMedia('(hover: hover) and (prefers-reduced-motion: no-preference)').matches;

            if (podeAnimar) {
                cards.forEach(function (card) {
                    card.addEventListener('pointermove', function (evento) {
                        var area = card.getBoundingClientRect();
                        var x = (evento.clientX - area.left) / area.width;
                        var y = (evento.clientY - area.top) / area.height;

                        card.style.setProperty('--giro-x', ((0.5 - y) * 8).toFixed(2) + 'deg');
                        card.style.setProperty('--giro-y', ((x - 0.5) * 10).toFixed(2) + 'deg');
                        card.style.setProperty('--luz-x', (x * 100).toFixed(1) + '%');
                        card.style.setProperty('--luz-y', (y * 100).toFixed(1) + '%');
                    });

                    card.addEventListener('pointerleave', function () {
                        card.style.removeProperty('--giro-x');
                        card.style.removeProperty('--giro-y');
                    });
                });
            }

            // Janela de detalhes
            var detalhe = document.getElementById('detalhe');
            var anterior = document.getElementById('detalheAnterior');
            var proximo = document.getElementById('detalheProximo');
            var indiceAberto = -1;

            function mostrar(indice) {
                var card = visiveis[indice];
                var preco = document.getElementById('detalhePreco');

                if (!card) {
                    return;
                }

                indiceAberto = indice;
                document.getElementById('detalheCapa').src = card.dataset.capa;
                document.getElementById('detalheCapa').alt = 'Capa de ' + card.dataset.titulo;
                document.getElementById('detalheTitulo').textContent = card.dataset.titulo;
                document.getElementById('detalheAutor').textContent = card.dataset.autor;
                document.getElementById('detalheResumo').textContent = card.dataset.resumo;
                document.getElementById('detalhePosicao').textContent = (indice + 1) + ' de ' + visiveis.length;
                preco.textContent = card.dataset.precoFormatado;
                preco.classList.toggle('preco--gratis', Number(card.dataset.preco) <= 0);
                anterior.disabled = indice === 0;
                proximo.disabled = indice === visiveis.length - 1;

                if (!detalhe.open) {
                    detalhe.showModal();
                }
            }

            cards.forEach(function (card) {
                card.addEventListener('click', function () {
                    mostrar(visiveis.indexOf(card));
                });
            });

            anterior.addEventListener('click', function () { mostrar(indiceAberto - 1); });
            proximo.addEventListener('click', function () { mostrar(indiceAberto + 1); });
            document.getElementById('detalheFechar').addEventListener('click', function () { detalhe.close(); });

            // Clique fora da janela (no fundo escuro) fecha
            detalhe.addEventListener('click', function (evento) {
                if (evento.target === detalhe) {
                    detalhe.close();
                }
            });

            detalhe.addEventListener('keydown', function (evento) {
                if (evento.key === 'ArrowLeft') { mostrar(indiceAberto - 1); }
                if (evento.key === 'ArrowRight') { mostrar(indiceAberto + 1); }
            });

            // Ao fechar, o foco volta para o livro que estava aberto
            detalhe.addEventListener('close', function () {
                if (visiveis[indiceAberto]) {
                    visiveis[indiceAberto].focus();
                }
            });

            atualizar();
        }());
    </script>
</body>
</html>
