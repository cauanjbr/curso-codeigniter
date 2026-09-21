<h1 class="page-title"><?= html_escape($titulo); ?></h1>

<div class="mb-4">
    <?= anchor('livros', 'Voltar a lista livros', array('class' => 'btn btn-primary btn-lg')); ?>
</div>

<?php if ($erro): ?>
    <div class="alert alert-danger" role="alert">
        Não foi possível atualizar o livro. Tente novamente.
    </div>
<?php endif; ?>

<?php if ($erro_upload): ?>
    <div class="alert alert-danger" role="alert">
        <?= html_escape($erro_upload); ?>
    </div>
<?php endif; ?>

<?= form_open_multipart('livros/editar/' . (int) $livro->id); ?>
    <div class="form-group">
        <?= form_label('Título', 'titulo'); ?>
        <?= form_input(array(
            'name' => 'titulo',
            'id' => 'titulo',
            'class' => 'form-control form-control-lg',
            'placeholder' => 'Título do livro',
            'value' => set_value('titulo', $livro->titulo)
        )); ?>
        <?= form_error('titulo'); ?>
    </div>

    <div class="form-group">
        <?= form_label('Autor', 'autor'); ?>
        <?= form_input(array(
            'name' => 'autor',
            'id' => 'autor',
            'class' => 'form-control form-control-lg',
            'placeholder' => 'Autor do livro',
            'value' => set_value('autor', $livro->autor)
        )); ?>
        <?= form_error('autor'); ?>
    </div>

    <div class="form-group">
        <?= form_label('Valor', 'preco'); ?>
        <?= form_input(array(
            'type' => 'number',
            'name' => 'preco',
            'id' => 'preco',
            'class' => 'form-control form-control-lg',
            'placeholder' => 'Valor do livro',
            'step' => '0.01',
            'min' => '0',
            'value' => set_value('preco', $livro->preco)
        )); ?>
        <?= form_error('preco'); ?>
    </div>

    <div class="form-group">
        <?= form_label('Resumo', 'resumo'); ?>
        <?= form_textarea(array(
            'name' => 'resumo',
            'id' => 'resumo',
            'class' => 'form-control',
            'rows' => 9,
            'value' => set_value('resumo', $livro->resumo)
        )); ?>
        <?= form_error('resumo'); ?>
    </div>

    <div class="form-group">
        <?= form_label('Ativo', 'ativo'); ?>
        <?= form_dropdown(
            'ativo',
            array('1' => 'Sim', '0' => 'Não'),
            set_value('ativo', (string) $livro->ativo),
            array('id' => 'ativo', 'class' => 'form-control form-control-lg')
        ); ?>
        <?= form_error('ativo'); ?>
    </div>

    <div class="form-group">
        <?= form_label('Imagem do livro', 'imagem'); ?>

        <?php if (!empty($livro->img)): ?>
            <div class="mb-3">
                <img
                    src="<?= html_escape(base_url('uploads/livros/' . rawurlencode($livro->img))); ?>"
                    alt="Capa de <?= html_escape($livro->titulo); ?>"
                    class="img-thumbnail"
                    style="max-width: 180px; max-height: 220px;"
                >
            </div>
        <?php endif; ?>

        <?= form_upload(array(
            'name' => 'imagem',
            'id' => 'imagem',
            'class' => 'form-control-file',
            'accept' => 'image/jpeg,image/png,image/gif'
        )); ?>
        <small class="form-text text-muted">
            Deixe vazio para manter a imagem atual. Formatos: JPG, PNG ou GIF, até 2 MB.
        </small>
    </div>

    <hr class="my-5">

    <?= form_submit('submit', 'Salvar alterações', array('class' => 'btn btn-success btn-lg')); ?>
<?= form_close(); ?>
