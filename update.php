<?php
require_once __DIR__ . '/src/db.php';


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
