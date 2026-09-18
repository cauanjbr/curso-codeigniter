<h1 class="page-title"><?= html_escape($titulo); ?></h1>

<section class="row">
    <div class="col-12 col-md-5">
        <?php if ($sucesso): ?>
            <div class="alert alert-success" role="alert">
                Usuário cadastrado com sucesso.
            </div>
        <?php endif; ?>

        <?php if ($erro): ?>
            <div class="alert alert-danger" role="alert">
                Não foi possível cadastrar o usuário. Tente novamente.
            </div>
        <?php endif; ?>

        <?= form_open('usuarios/add'); ?>
            <div class="form-group">
                <?= form_label('Nome', 'nome'); ?>
                <?= form_input(array(
                    'name' => 'nome',
                    'id' => 'nome',
                    'class' => 'form-control',
                    'value' => set_value('nome')
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
                    'value' => set_value('email')
                )); ?>
                <?= form_error('email'); ?>
            </div>

            <div class="form-group">
                <?= form_label('Senha', 'senha'); ?>
                <?= form_password(array(
                    'name' => 'senha',
                    'id' => 'senha',
                    'class' => 'form-control'
                )); ?>
                <?= form_error('senha'); ?>
            </div>

            <div class="form-group">
                <?= form_label('Repita Senha', 'repita_senha'); ?>
                <?= form_password(array(
                    'name' => 'repita_senha',
                    'id' => 'repita_senha',
                    'class' => 'form-control'
                )); ?>
                <?= form_error('repita_senha'); ?>
            </div>

            <?= form_submit(
                'submit',
                'Cadastrar',
                array('class' => 'btn btn-outline-success')
            ); ?>
        <?= form_close(); ?>
    </div>
</section>
