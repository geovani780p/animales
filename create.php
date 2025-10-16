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
include __DIR__ . '/_header.php';
?>
<h1 class="h3">Nuevo animal</h1>
<form class="row g-3" method="post" action="store.php">
  <div class="col-md-6">
    <label class="form-label">Nombre de la mascota</label>
    <input type="text" name="nombre" class="form-control" required>
  </div>
  <div class="col-md-3">
    <label class="form-label">Edad (años)</label>
    <input type="number" name="edad" class="form-control" min="0" max="100" required>
  </div>
  <div class="col-md-3">
    <label class="form-label">Especie</label>
    <input type="text" name="especie" class="form-control" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Raza</label>
    <input type="text" name="raza" class="form-control" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Nombre del dueño</label>
    <input type="text" name="dueno" class="form-control" required>
  </div>
  <div class="col-12">
    <button class="btn btn-success">Guardar</button>
    <a class="btn btn-secondary" href="index.php">Cancelar</a>
  </div>
</form>
<?php include __DIR__ . '/_footer.php'; ?>
