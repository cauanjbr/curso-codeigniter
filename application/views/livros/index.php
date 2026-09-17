<h1 class="page-title"><?= html_escape($titulo); ?></h1>

<div class="table-responsive">
    <table class="table table-striped table-bordered books-table">
        <thead>
            <tr>
                <th class="book-number" scope="col">#</th>
                <th class="book-name" scope="col">Nome do livro</th>
                <th class="book-author" scope="col">Autor</th>
                <th class="book-price" scope="col">Preço</th>
                <th class="book-date" scope="col">Data de cadastro</th>
                <th class="book-action" scope="col">Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($livros)): ?>
                <?php foreach ($livros as $livro): ?>
                    <tr>
                        <td><?= html_escape($livro->ID); ?></td>
                        <td><?= html_escape($livro->NOME_LIVRO); ?></td>
                        <td><?= html_escape($livro->AUTOR_LIVRO); ?></td>
                        <td><?= html_escape(formatar_valor_brasileiro($livro->preco)); ?></td>
                        <td><?= html_escape(formatar_data_brasileira($livro->data_cadastro)); ?></td>
                        <td class="text-nowrap">
                            <?= anchor(
                                'site/info/' . rawurlencode($livro->ID),
                                'info',
                                array('class' => 'btn btn-info btn-sm mr-1')
                            ); ?>

                            <?= anchor_popup(
                                'site/info/' . rawurlencode($livro->ID),
                                'info',
                                array(
                                    'class' => 'btn btn-success btn-sm',
                                    'width' => '1200',
                                    'height' => '800',
                                    'scrollbars' => 'yes',
                                    'resizable' => 'yes',
                                    'window_name' => 'livro_info_' . $livro->ID
                                )
                            ); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Nenhum livro cadastrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
