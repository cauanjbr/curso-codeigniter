<h1 class="page-title"><?= html_escape($titulo); ?></h1>

<?php if ($atualizado): ?>
    <div class="alert alert-success" role="alert">
        Usuário atualizado com sucesso.
    </div>
<?php endif; ?>

<?= anchor(
    'usuarios/add',
    'Add usuário',
    array('title' => 'Cadastrar usuário', 'class' => 'btn btn-success btn-lg mb-2')
); ?>

<div class="table-responsive mt-3">
    <table class="table table-striped table-bordered">
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
                    <tr>
                        <td><?= html_escape($usuario->id); ?></td>
                        <td><?= html_escape($usuario->nome); ?></td>
                        <td><?= html_escape($usuario->email); ?></td>
                        <td><?= $usuario->ativo ? 'Ativo' : 'Inativo'; ?></td>
                        <td>
                            <?= anchor(
                                'usuarios/edit/' . rawurlencode($usuario->id),
                                'Editar',
                                array('class' => 'btn btn-primary btn-sm')
                            ); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Nenhum usuário cadastrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
