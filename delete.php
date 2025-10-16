<?php
// Intentar diferentes rutas para db.php
$possible_paths = [
    __DIR__ . '/src/db.php',           // Ruta normal
    __DIR__ . '/../src/db.php',        // Ruta alternativa (por si acaso)
    dirname(__FILE__) . '/src/db.php', // Usando dirname como alternativa
];

$db_path = null;
foreach ($possible_paths as $path) {
    if (file_exists($path)) {
        $db_path = $path;
        break;
    }
}

if ($db_path === null) {
    die("Error: No se pudo encontrar el archivo db.php en ninguna de las rutas: " . implode(', ', $possible_paths));
}

require_once $db_path;



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
