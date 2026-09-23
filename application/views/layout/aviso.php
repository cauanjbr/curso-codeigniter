<?php $aviso = $this->session->flashdata('aviso'); ?>
<?php if (is_array($aviso)): ?>
    <div class="alert alert-<?= $aviso['tipo'] === 'success' ? 'success' : 'danger'; ?>" role="alert">
        <?= html_escape($aviso['mensagem']); ?>
    </div>
<?php endif; ?>
