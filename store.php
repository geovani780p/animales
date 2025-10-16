<?php
require_once __DIR__ . '/src/db.php';

$db = new DB();

// Sanitizar y validar
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
    $result = $db->col->insertOne([
        'nombre'  => $nombre,
        'edad'    => $edad,
        'especie' => $especie,
        'raza'    => $raza,
        'dueno'   => $dueno,
        'creadoEn'=> new MongoDB\BSON\UTCDateTime()
    ]);
    $id = (string)$result->getInsertedId();
    header('Location: index.php?ok=1&id=' . $id);
    exit;
} catch (Throwable $e) {
    http_response_code(500);
    echo 'Error al insertar: ' . htmlspecialchars($e->getMessage());
}
