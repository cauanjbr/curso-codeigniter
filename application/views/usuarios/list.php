<h1 class="page-title"><?= html_escape($titulo); ?></h1>

<?php $this->load->view('layout/aviso'); ?>

<?= anchor(
    'usuarios/add',
    'Novo usuário',
    array('title' => 'Cadastrar usuário', 'class' => 'btn btn-success btn-lg mb-2')
); ?>

<div class="d-flex justify-content-end align-items-center mt-3 mb-2">
    <label class="mb-0 mr-2" for="pesquisarUsuarios">Pesquisar</label>
    <input
        class="form-control"
        style="max-width: 260px;"
        type="search"
        id="pesquisarUsuarios"
        placeholder="Nome ou e-mail"
        autocomplete="off"
    >
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered" id="tabelaUsuarios">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">E-mail</th>
                <th scope="col">Status</th>
                <th scope="col">Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($usuarios)): ?>
                <?php foreach ($usuarios as $usuario): ?>
                    <?php $estaLogado = (int) $usuario->id === $usuario_logado_id; ?>
                    <tr
                        data-usuario
                        data-pesquisa="<?= html_escape($usuario->nome . ' ' . $usuario->email); ?>"
                    >
                        <td><?= html_escape($usuario->id); ?></td>
                        <td><?= html_escape($usuario->nome); ?></td>
                        <td><?= html_escape($usuario->email); ?></td>
                        <td>
                            <?php if ((int) $usuario->ativo === 1): ?>
                                <span class="badge badge-success">Ativo</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Inativo</span>
                            <?php endif; ?>
                            <?php if ($estaLogado): ?>
                                <span class="badge badge-secondary">Você</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-nowrap">
                            <?= anchor(
                                'usuarios/edit/' . (int) $usuario->id,
                                'Editar',
                                array('class' => 'btn btn-primary btn-sm mr-1')
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
                    <td colspan="5" class="text-center">Nenhum usuário cadastrado.</td>
                </tr>
            <?php endif; ?>
            <tr id="nenhumResultado" hidden>
                <td colspan="5" class="text-center">Nenhum usuário encontrado.</td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    (function () {
        var campoPesquisa = document.getElementById('pesquisarUsuarios');
        var linhas = Array.prototype.slice.call(document.querySelectorAll('[data-usuario]'));
        var nenhumResultado = document.getElementById('nenhumResultado');

        campoPesquisa.addEventListener('input', function () {
            var termo = campoPesquisa.value.trim().toLocaleLowerCase('pt-BR');
            var quantidadeVisivel = 0;

            linhas.forEach(function (linha) {
                var conteudo = linha.getAttribute('data-pesquisa').toLocaleLowerCase('pt-BR');
                var exibir = conteudo.indexOf(termo) !== -1;

                linha.hidden = !exibir;

                if (exibir) {
                    quantidadeVisivel++;
                }
            });

            nenhumResultado.hidden = quantidadeVisivel !== 0 || termo === '';
        });
    }());
</script>
