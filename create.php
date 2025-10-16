<?php
require_once __DIR__ . '/src/db.php';
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
