<h1 class="page-title"><?= html_escape($titulo); ?></h1>

<section class="row">
    <div class="col-12 col-md-5">
        <?php
        echo form_open('site/enviar');

        echo '<div class="form-group">';
        echo form_label('E-mail', 'email');
        echo form_input(array(
            'type' => 'email',
            'name' => 'email',
            'id' => 'email',
            'class' => 'form-control'
        ));
        echo '</div>';

        echo '<div class="form-group">';
        echo form_label('Senha', 'senha');
        echo form_password(array(
            'name' => 'senha',
            'id' => 'senha',
            'class' => 'form-control'
        ));
        echo '</div>';

        echo form_submit(
            'submit',
            'Enviar',
            array('class' => 'btn btn-outline-success btn-block')
        );

        echo form_close();
        ?>
    </div>
</section>
