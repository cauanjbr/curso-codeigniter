<h1 class="page-title"><?= html_escape($titulo); ?></h1>

<?= anchor(
    'usuarios/add',
    'Add usuário',
    array('title' => 'Cadastrar usuário', 'class' => 'btn btn-success btn-lg mb-2')
); ?>

<p>Lista usuários fica aqui</p>
