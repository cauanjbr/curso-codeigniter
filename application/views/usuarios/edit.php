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

            <fieldset class="border rounded p-3 mb-3">
                <legend class="w-auto px-2 mb-0 h6">Trocar senha (opcional)</legend>

                <div class="form-group">
                    <?= form_label('Nova senha', 'nova_senha'); ?>
                    <?= form_password(array(
                        'name' => 'nova_senha',
                        'id' => 'nova_senha',
                        'class' => 'form-control',
                        'autocomplete' => 'new-password'
                    )); ?>
                    <?= form_error('nova_senha'); ?>
                </div>

                <div class="form-group mb-0">
                    <?= form_label('Repita a nova senha', 'repita_nova_senha'); ?>
                    <?= form_password(array(
                        'name' => 'repita_nova_senha',
                        'id' => 'repita_nova_senha',
                        'class' => 'form-control',
                        'autocomplete' => 'new-password'
                    )); ?>
                    <?= form_error('repita_nova_senha'); ?>
                    <small class="form-text text-muted">Deixe em branco para manter a senha atual.</small>
                </div>
            </fieldset>

            <?= form_submit(
                'submit',
                'Salvar alterações',
                array('class' => 'btn btn-outline-success')
            ); ?>

            <?= anchor('usuarios', 'Cancelar', array('class' => 'btn btn-link')); ?>
        <?= form_close(); ?>
    </div>
</section>
