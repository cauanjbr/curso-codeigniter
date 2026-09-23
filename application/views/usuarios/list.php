<div class="painel-cabecalho">
    <div>
        <h1 class="page-title"><?= html_escape($titulo); ?></h1>
        <p class="painel-subtitulo">
            <?= count($usuarios); ?> <?= count($usuarios) === 1 ? 'usuário com acesso ao painel' : 'usuários com acesso ao painel'; ?>
        </p>
    </div>
    <?= anchor(
        'usuarios/add',
        '+ Novo usuário',
        array('title' => 'Cadastrar usuário', 'class' => 'btn btn-success btn-lg')
    ); ?>
</div>

<?php $this->load->view('layout/aviso'); ?>

<div class="painel-ferramentas">
    <label class="painel-busca" for="pesquisarUsuarios">
        <span class="sr-only">Pesquisar usuários</span>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="11" cy="11" r="7"></circle><path d="m20 20-3.5-3.5"></path></svg>
        <input
            class="form-control"
            type="search"
            id="pesquisarUsuarios"
            placeholder="Pesquisar por nome ou e-mail"
            autocomplete="off"
        >
    </label>
</div>

<div class="painel-cartao">
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="tabelaUsuarios">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Usuário</th>
                    <th scope="col" class="d-none d-lg-table-cell">E-mail</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-right">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($usuarios)): ?>
                    <?php foreach ($usuarios as $usuario): ?>
                        <?php
                        $estaLogado = (int) $usuario->id === $usuario_logado_id;

                        // Iniciais para o avatar: primeira letra do primeiro e do último nome
                        $partesNome = preg_split('/\s+/', trim((string) $usuario->nome), -1, PREG_SPLIT_NO_EMPTY);
                        $iniciais = $partesNome ? mb_substr($partesNome[0], 0, 1) : '?';
                        if (count($partesNome) > 1) {
                            $iniciais .= mb_substr(end($partesNome), 0, 1);
                        }
                        ?>
                        <tr
                            data-usuario
                            data-pesquisa="<?= html_escape($usuario->nome . ' ' . $usuario->email); ?>"
                        >
                            <td class="text-muted"><?= html_escape($usuario->id); ?></td>
                            <td>
                                <div class="item-lista">
                                    <span class="avatar" aria-hidden="true"><?= html_escape($iniciais); ?></span>
                                    <span>
                                        <span class="item-lista__titulo"><?= html_escape($usuario->nome); ?></span>
                                        <span class="item-lista__detalhe d-lg-none"><?= html_escape($usuario->email); ?></span>
                                    </span>
                                </div>
                            </td>
                            <td class="d-none d-lg-table-cell text-muted"><?= html_escape($usuario->email); ?></td>
                            <td class="text-nowrap">
                                <?php if ((int) $usuario->ativo === 1): ?>
                                    <span class="badge badge-success">Ativo</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Inativo</span>
                                <?php endif; ?>
                                <?php if ($estaLogado): ?>
                                    <span class="badge badge-secondary">Você</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-right text-nowrap">
                                <?= anchor(
                                    'usuarios/edit/' . (int) $usuario->id,
                                    'Editar',
                                    array('class' => 'btn btn-primary btn-sm')
                                ); ?>

                                <?php if ($estaLogado): ?>
                                    <button class="btn btn-info btn-sm" type="button" disabled title="A conta conectada não pode ser desativada">
                                        Desativar
                                    </button>
                                    <button class="btn btn-danger btn-sm" type="button" disabled title="A conta conectada não pode ser apagada">
                                        Apagar
                                    </button>
                                <?php else: ?>
                                    <?= form_open('usuarios/status/' . (int) $usuario->id, array('class' => 'd-inline')); ?>
                                        <button class="btn btn-info btn-sm" type="submit">
                                            <?= (int) $usuario->ativo === 1 ? 'Desativar' : 'Ativar'; ?>
                                        </button>
                                    <?= form_close(); ?>

                                    <?= form_open(
                                        'usuarios/del/' . (int) $usuario->id,
                                        array(
                                            'class' => 'd-inline',
                                            'onsubmit' => "return confirm('Tem certeza que deseja apagar este usuário?');"
                                        )
                                    ); ?>
                                        <button class="btn btn-danger btn-sm" type="submit">Apagar</button>
                                    <?= form_close(); ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">Nenhum usuário cadastrado.</td>
                    </tr>
                <?php endif; ?>
                <tr id="nenhumResultado" hidden>
                    <td colspan="5" class="text-center text-muted py-5">Nenhum usuário encontrado.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    (function () {
        var campoPesquisa = document.getElementById('pesquisarUsuarios');
        var linhas = Array.prototype.slice.call(document.querySelectorAll('[data-usuario]'));
        var nenhumResultado = document.getElementById('nenhumResultado');

        // Minúsculas e sem acentos, como na busca do catálogo
        function normalizar(texto) {
            return texto.normalize('NFD').replace(/[̀-ͯ]/g, '').toLocaleLowerCase('pt-BR');
        }

        campoPesquisa.addEventListener('input', function () {
            var termo = normalizar(campoPesquisa.value.trim());
            var quantidadeVisivel = 0;

            linhas.forEach(function (linha) {
                var exibir = normalizar(linha.getAttribute('data-pesquisa')).indexOf(termo) !== -1;

                linha.hidden = !exibir;

                if (exibir) {
                    quantidadeVisivel++;
                }
            });

            nenhumResultado.hidden = quantidadeVisivel !== 0 || termo === '';
        });
    }());
</script>
