<h1 class="page-title"><?= html_escape($titulo); ?></h1>

<?php if ($atualizado): ?>
    <div class="alert alert-success" role="alert">
        Usuário atualizado com sucesso.
    </div>
<?php endif; ?>

<?php if ($apagado): ?>
    <div class="alert alert-success" role="alert">
        Usuário apagado com sucesso.
    </div>
<?php endif; ?>

<?php if ($erro_exclusao): ?>
    <div class="alert alert-danger" role="alert">
        Não é possível apagar a conta que está conectada.
    </div>
<?php endif; ?>

<?= anchor(
    'usuarios/add',
    'Add usuário',
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
                            <?php if ($estaLogado): ?>
                                <span class="btn btn-success btn-sm disabled" aria-disabled="true">Ativo</span>
                            <?php else: ?>
                                <span class="btn btn-danger btn-sm disabled" aria-disabled="true">Inativo</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= anchor(
                                'usuarios/edit/' . rawurlencode($usuario->id),
                                'Editar',
                                array('class' => 'btn btn-primary btn-sm mr-1')
                            ); ?>

                            <?php if ($estaLogado): ?>
                                <button class="btn btn-danger btn-sm" type="button" disabled title="A conta conectada não pode ser apagada">
                                    Apagar
                                </button>
                            <?php else: ?>
                                <form
                                    class="d-inline"
                                    method="post"
                                    action="<?= html_escape(site_url('usuarios/del/' . rawurlencode($usuario->id))); ?>"
                                    onsubmit="return confirm('Tem certeza que deseja apagar este usuário?');"
                                >
                                    <button class="btn btn-danger btn-sm" type="submit">Apagar</button>
                                </form>
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
