<h1 class="page-title"><?= html_escape($titulo); ?></h1>

<section class="row">
    <div class="col-12">
        <p class="lead">Bem-vindo ao sistema de livros e usuários.</p>

        <p>
            <?= anchor('site/livros', 'Ver livros', array('class' => 'btn btn-primary mr-2')); ?>
            <?= anchor('usuarios', 'Ver usuários', array('class' => 'btn btn-success')); ?>
        </p>
    </div>
</section>
