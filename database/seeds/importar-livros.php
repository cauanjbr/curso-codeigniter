<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$root = dirname(__DIR__, 2);
define('BASEPATH', $root . '/system/');
define('ENVIRONMENT', 'development');
require $root . '/application/config/database.php';
$cfg = $db['default'];
$conn = new mysqli($cfg['hostname'], $cfg['username'], $cfg['password'], $cfg['database']);
$conn->set_charset('utf8mb4');
$books = json_decode(file_get_contents(__DIR__ . '/livros-programacao.json'), true, 512, JSON_THROW_ON_ERROR);
foreach ($books as $book) {
    $src = $root . '/assets/capas/' . $book['img'];
    if (!is_file($src) || !getimagesize($src)) { throw new RuntimeException('Capa inválida: ' . $book['img']); }
    $target = $root . '/uploads/livros/' . $book['img'];
    if (!is_file($target) && !copy($src, $target)) { throw new RuntimeException('Não foi possível copiar a capa'); }
}
$conn->begin_transaction();
try {
    $find = $conn->prepare('SELECT id FROM livros WHERE titulo = ? LIMIT 1');
    $insert = $conn->prepare('INSERT INTO livros (titulo, autor, preco, resumo, ativo, img) VALUES (?, ?, ?, ?, ?, ?)');
    $count = 0;
    foreach ($books as $book) {
        $find->bind_param('s', $book['titulo']);
        $find->execute();
        if ($find->get_result()->num_rows) { continue; }
        $insert->bind_param('ssdsis', $book['titulo'], $book['autor'], $book['preco'], $book['resumo'], $book['ativo'], $book['img']);
        $insert->execute();
        $count++;
    }
    $conn->commit();
    echo "Livros adicionados: $count\n";
} catch (Throwable $e) { $conn->rollback(); throw $e; }
