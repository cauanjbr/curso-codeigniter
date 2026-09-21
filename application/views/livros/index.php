<h1 class="page-title"><?= html_escape($titulo); ?></h1>

<?php if ($cadastrado): ?>
    <div class="alert alert-success" role="alert">
        Livro cadastrado com sucesso.
    </div>
<?php endif; ?>

<?php if ($atualizado): ?>
    <div class="alert alert-success" role="alert">
        Livro atualizado com sucesso.
    </div>
<?php endif; ?>

<?php if ($apagado): ?>
    <div class="alert alert-success" role="alert">
        Livro apagado com sucesso.
    </div>
<?php endif; ?>

<?php if ($status_alterado): ?>
    <div class="alert alert-success" role="alert">
        Status do livro alterado com sucesso.
    </div>
<?php endif; ?>

<?php if ($erro_acao): ?>
    <div class="alert alert-danger" role="alert">
        Não foi possível realizar a ação. Tente novamente.
    </div>
<?php endif; ?>

<style>
    #tabelaLivros {
        font-size: 18px;
    }

    #tabelaLivros th,
    #tabelaLivros td {
        padding: 14px 16px;
        vertical-align: middle;
    }

    #tabelaLivros .badge {
        padding: 6px 8px;
        font-size: 14px;
    }
</style>

<div class="text-right mb-5">
    <?= anchor('livros/adicionar', 'Novo livro', array('class' => 'btn btn-success btn-lg')); ?>
</div>

<div class="row align-items-center mb-3">
    <div class="col-12 col-md-6 mb-3 mb-md-0">
        <label class="mb-0" for="livrosPorPagina">
            <select class="form-control d-inline-block mr-2" id="livrosPorPagina" style="width: 105px;">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
            resultados por página
        </label>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-inline justify-content-md-end">
            <label class="mr-2" for="pesquisarLivros">Pesquisar</label>
            <input
                class="form-control"
                type="search"
                id="pesquisarLivros"
                autocomplete="off"
                style="width: 245px;"
            >
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-hover" id="tabelaLivros">
        <thead>
            <tr>
                <th scope="col" data-coluna="id"># <span class="text-muted">↕</span></th>
                <th scope="col" data-coluna="titulo">Título <span class="text-muted">↕</span></th>
                <th scope="col" data-coluna="autor">Autor <span class="text-muted">↕</span></th>
                <th scope="col" data-coluna="preco" class="text-right">Preço <span class="text-muted">↕</span></th>
                <th scope="col" data-coluna="ativo">Status <span class="text-muted">↕</span></th>
                <th scope="col" class="text-right">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($livros as $livro): ?>
                <tr
                    data-livro
                    data-id="<?= (int) $livro->id; ?>"
                    data-titulo="<?= html_escape($livro->titulo); ?>"
                    data-autor="<?= html_escape($livro->autor); ?>"
                    data-preco="<?= html_escape($livro->preco); ?>"
                    data-ativo="<?= (int) $livro->ativo; ?>"
                    data-pesquisa="<?= html_escape($livro->titulo . ' ' . $livro->autor . ' ' . $livro->preco); ?>"
                >
                    <td><?= (int) $livro->id; ?></td>
                    <td><?= html_escape($livro->titulo); ?></td>
                    <td><?= html_escape($livro->autor); ?></td>
                    <td class="text-right"><?= number_format((float) $livro->preco, 2, '.', ''); ?></td>
                    <td>
                        <?php if ((int) $livro->ativo === 1): ?>
                            <span class="badge badge-success">Ativo</span>
                        <?php else: ?>
                            <span class="badge badge-danger">Inativo</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-right text-nowrap">
                        <?= anchor(
                            'livros/editar/' . (int) $livro->id,
                            'Editar',
                            array('class' => 'btn btn-primary')
                        ); ?>
                        <?= form_open(
                            'livros/apagar/' . (int) $livro->id,
                            array('class' => 'd-inline formulario-apagar')
                        ); ?>
                            <button class="btn btn-danger" type="submit">Apagar</button>
                        <?= form_close(); ?>

                        <?= form_open(
                            'livros/alterarStatus/' . (int) $livro->id,
                            array('class' => 'd-inline')
                        ); ?>
                            <button class="btn btn-info" type="submit">
                                <?= (int) $livro->ativo === 1 ? 'Desativar' : 'Ativar'; ?>
                            </button>
                        <?= form_close(); ?>
                    </td>
                </tr>
            <?php endforeach; ?>

            <tr id="nenhumLivro" hidden>
                <td colspan="6" class="text-center">Nenhum livro encontrado.</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="row align-items-center">
    <div class="col-12 col-md-6 mb-3 mb-md-0">
        <span id="resumoLivros"></span>
    </div>
    <div class="col-12 col-md-6">
        <nav aria-label="Paginação dos livros">
            <ul class="pagination justify-content-md-end mb-0" id="paginacaoLivros"></ul>
        </nav>
    </div>
</div>

<script>
    (function () {
        var corpoTabela = document.querySelector('#tabelaLivros tbody');
        var linhas = Array.prototype.slice.call(document.querySelectorAll('[data-livro]'));
        var pesquisa = document.getElementById('pesquisarLivros');
        var porPagina = document.getElementById('livrosPorPagina');
        var resumo = document.getElementById('resumoLivros');
        var paginacao = document.getElementById('paginacaoLivros');
        var nenhumLivro = document.getElementById('nenhumLivro');
        var paginaAtual = 1;
        var colunaOrdenada = null;
        var direcao = 1;

        Array.prototype.forEach.call(document.querySelectorAll('.formulario-apagar'), function (formulario) {
            formulario.addEventListener('submit', function (evento) {
                if (!window.confirm('Tem certeza que deseja apagar este livro?')) {
                    evento.preventDefault();
                }
            });
        });

        function criarBotaoPaginacao(texto, pagina, desabilitado, ativo) {
            var item = document.createElement('li');
            var botao = document.createElement('button');

            item.className = 'page-item' + (desabilitado ? ' disabled' : '') + (ativo ? ' active' : '');
            botao.className = 'page-link';
            botao.type = 'button';
            botao.textContent = texto;
            botao.disabled = desabilitado;
            botao.addEventListener('click', function () {
                paginaAtual = pagina;
                atualizarTabela();
            });
            item.appendChild(botao);

            return item;
        }

        function valorOrdenacao(linha, coluna) {
            var valor = linha.getAttribute('data-' + coluna) || '';

            if (coluna === 'id' || coluna === 'preco' || coluna === 'ativo') {
                return Number(valor);
            }

            return valor.toLocaleLowerCase('pt-BR');
        }

        function atualizarTabela() {
            var termo = pesquisa.value.trim().toLocaleLowerCase('pt-BR');
            var limite = Number(porPagina.value);
            var filtradas = linhas.filter(function (linha) {
                return linha.getAttribute('data-pesquisa').toLocaleLowerCase('pt-BR').indexOf(termo) !== -1;
            });

            if (colunaOrdenada) {
                filtradas.sort(function (linhaA, linhaB) {
                    var valorA = valorOrdenacao(linhaA, colunaOrdenada);
                    var valorB = valorOrdenacao(linhaB, colunaOrdenada);

                    if (valorA < valorB) return -1 * direcao;
                    if (valorA > valorB) return 1 * direcao;
                    return 0;
                });
            }

            linhas.forEach(function (linha) {
                linha.hidden = true;
            });

            var total = filtradas.length;
            var totalPaginas = Math.max(1, Math.ceil(total / limite));
            paginaAtual = Math.min(paginaAtual, totalPaginas);
            var inicio = (paginaAtual - 1) * limite;
            var fim = Math.min(inicio + limite, total);

            filtradas.slice(inicio, fim).forEach(function (linha) {
                linha.hidden = false;
                corpoTabela.insertBefore(linha, nenhumLivro);
            });

            nenhumLivro.hidden = total !== 0;
            resumo.textContent = 'Mostrando de ' + (total ? inicio + 1 : 0) + ' até ' + fim + ' de ' + total + ' registros';

            paginacao.innerHTML = '';
            paginacao.appendChild(criarBotaoPaginacao('Anterior', paginaAtual - 1, paginaAtual === 1, false));

            for (var pagina = 1; pagina <= totalPaginas; pagina++) {
                paginacao.appendChild(criarBotaoPaginacao(String(pagina), pagina, false, pagina === paginaAtual));
            }

            paginacao.appendChild(criarBotaoPaginacao('Próximo', paginaAtual + 1, paginaAtual === totalPaginas, false));
        }

        pesquisa.addEventListener('input', function () {
            paginaAtual = 1;
            atualizarTabela();
        });

        porPagina.addEventListener('change', function () {
            paginaAtual = 1;
            atualizarTabela();
        });

        Array.prototype.forEach.call(document.querySelectorAll('[data-coluna]'), function (cabecalho) {
            cabecalho.style.cursor = 'pointer';
            cabecalho.addEventListener('click', function () {
                var coluna = cabecalho.getAttribute('data-coluna');

                if (colunaOrdenada === coluna) {
                    direcao *= -1;
                } else {
                    colunaOrdenada = coluna;
                    direcao = 1;
                }

                atualizarTabela();
            });
        });

        atualizarTabela();
    }());
</script>
