<h1 class="page-title"><?= html_escape($titulo); ?></h1>

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
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Nenhum usuário cadastrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
