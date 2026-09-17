<h1 class="page-title"><?= html_escape($titulo); ?></h1>

<div class="card">
    <div class="card-header">
        Informações do livro
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0 books-table">
                <tbody>
                    <tr>
                        <th scope="row">ID</th>
                        <td><?= html_escape($info->ID); ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Nome do livro</th>
                        <td><?= html_escape($info->NOME_LIVRO); ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Autor</th>
                        <td><?= html_escape($info->AUTOR_LIVRO); ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Preço</th>
                        <td><?= html_escape(formatar_valor_brasileiro($info->preco)); ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Data de cadastro</th>
                        <td><?= html_escape(formatar_data_brasileira($info->data_cadastro)); ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Resumo</th>
                        <td>
                            <?php if (!empty($info->resumo)): ?>
                                <?= nl2br(html_escape($info->resumo)); ?>
                            <?php else: ?>
                                <span class="text-muted">Resumo não cadastrado.</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer">
        <a class="btn btn-primary" href="/curso/index.php/site/livros">Voltar para a lista</a>
    </div>
</div>
