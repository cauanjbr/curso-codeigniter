<h1 class="page-title"><?= html_escape($titulo); ?></h1>

<section class="row">
    <div class="col-12 col-md-5">
        <?php if ($erro): ?>
            <div class="alert alert-danger" role="alert">
                Não foi possível atualizar o usuário. Tente novamente.
            </div>
        <?php endif; ?>

        <?= form_open('usuarios/edit/' . rawurlencode($usuario->id)); ?>
            <div class="form-group">
                <?= form_label('Nome', 'nome'); ?>
                <?= form_input(array(
                    'name' => 'nome',
                    'id' => 'nome',
                    'class' => 'form-control',
                    'value' => set_value('nome', $usuario->nome)
                )); ?>
                <?= form_error('nome'); ?>
            </div>

            <div class="form-group">
                <?= form_label('E-mail', 'email'); ?>
                <?= form_input(array(
                    'type' => 'email',
                    'name' => 'email',
                    'id' => 'email',
                    'class' => 'form-control',
                    'value' => set_value('email', $usuario->email)
                )); ?>
                <?= form_error('email'); ?>
            </div>

            <?= form_submit(
                'submit',
                'Salvar alterações',
                array('class' => 'btn btn-outline-success')
            ); ?>

            <?= anchor('usuarios', 'Cancelar', array('class' => 'btn btn-link')); ?>
        <?= form_close(); ?>
    </div>
</section>
