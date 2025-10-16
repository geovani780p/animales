<?php
require_once __DIR__ . '/../src/db.php';



$db = new DB();

$id = $_GET['id'] ?? '';
if (!$id) { http_response_code(400); die('Falta id'); }

try {
    $db->col->deleteOne(['_id' => DB::oid($id)]);
    header('Location: index.php?deleted=1');
    exit;
} catch (Throwable $e) {
    http_response_code(500);
    echo 'Error al eliminar: ' . htmlspecialchars($e->getMessage());
}
