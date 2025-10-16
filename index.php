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

use MongoDB\BSON\ObjectId;

$db = new DB();

$busqueda = $_GET['q'] ?? '';
$filtro = [];
if ($busqueda !== '') {
    $regex = new MongoDB\BSON\Regex($busqueda, 'i');
    $filtro = ['$or' => [
        ['nombre' => $regex],
        ['especie' => $regex],
        ['raza' => $regex],
        ['dueno' => $regex],
    ]];
}

$cursor = $db->col->find($filtro, ['sort' => ['_id' => -1]]);

include __DIR__ . '/_header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h3 m-0">Listado de animales</h1>
  <form class="d-flex" method="get" action="">
    <input class="form-control me-2" type="search" name="q" placeholder="Buscar..." value="<?= h($busqueda) ?>">
    <button class="btn btn-outline-light" type="submit">Buscar</button>
  </form>
</div>

<div class="table-responsive">
<table class="table table-dark table-striped align-middle">
  <thead>
    <tr>
      <th>Nombre</th>
      <th>Edad</th>
      <th>Especie</th>
      <th>Raza</th>
      <th>Dueño</th>
      <th class="text-end">Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($cursor as $doc): ?>
      <tr>
        <td><?= h($doc['nombre'] ?? '') ?></td>
        <td><?= h((string)($doc['edad'] ?? '')) ?></td>
        <td><?= h($doc['especie'] ?? '') ?></td>
        <td><?= h($doc['raza'] ?? '') ?></td>
        <td><?= h($doc['dueno'] ?? '') ?></td>
        <td class="text-end">
          <a class="btn btn-sm btn-primary" href="edit.php?id=<?= (string)$doc['_id'] ?>">Editar</a>
          <a class="btn btn-sm btn-danger" href="delete.php?id=<?= (string)$doc['_id'] ?>" onclick="return confirm('¿Eliminar este registro?');">Eliminar</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
<?php include __DIR__ . '/_footer.php'; ?>
