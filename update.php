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

$id = $_POST['id'] ?? '';
if (!$id) { http_response_code(400); die('Falta id'); }

$nombre  = trim($_POST['nombre'] ?? '');
$edad    = isset($_POST['edad']) ? (int)$_POST['edad'] : null;
$especie = trim($_POST['especie'] ?? '');
$raza    = trim($_POST['raza'] ?? '');
$dueno   = trim($_POST['dueno'] ?? '');

if ($nombre === '' || $edad === null || $especie === '' || $raza === '' || $dueno === '') {
    http_response_code(422);
    die('Datos incompletos');
}

try {
    $result = $db->col->updateOne(
        ['_id' => DB::oid($id)],
        ['$set' => [
            'nombre'  => $nombre,
            'edad'    => $edad,
            'especie' => $especie,
            'raza'    => $raza,
            'dueno'   => $dueno,
            'actualizadoEn' => new MongoDB\BSON\UTCDateTime()
        ]]
    );
    header('Location: index.php?updated=1');
    exit;
} catch (Throwable $e) {
    http_response_code(500);
    echo 'Error al actualizar: ' . htmlspecialchars($e->getMessage());
}
