<?php
session_start();
require_once __DIR__ . '/../../models/platos.php';

// Verificar si el usuario está logueado y es administrador
$esAdmin = isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';

// Si no es admin, redirigir en caso de intentar acciones protegidas
if (!$esAdmin && (isset($_POST['agregar']) || isset($_GET['eliminar']) || isset($_POST['editar']))) {
    header("Location: menu.php");
    exit;
}

$model = new Menu();


if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $imagen = $_FILES['imagen']['name'];
    $ruta = "../img/" . basename($imagen);
    move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);

    $model->RegistrarPlato($nombre, $descripcion, $precio, $ruta, 1);
    header("Location: menu.php");
    exit;
}


if (isset($_GET['eliminar'])) {
    $model->EliminarPlato($_GET['eliminar']);
    header("Location: menu.php");
    exit;
}


if (isset($_POST['editar'])) {
    $id = $_POST['idplato'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $imagen = $_FILES['imagen']['name'];

    if ($imagen) {
        $ruta = "../img/" . basename($imagen);
        move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);
    } else {
        $ruta = $_POST['imagen_actual'];
    }

    $model->EditarPlato($id, $nombre, $descripcion, $precio, $ruta, 1);
    header("Location: menu.php");
    exit;
}


$platos = $model->ListarPlatos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Platos</title>
  <link rel="stylesheet" href="../css/menu.css">

</head>
<body>

<h1>Gestión del Menu</h1>


<?php if ($esAdmin): ?>
<div class="form-container">
  <h2>Agregar Nuevo Plato</h2>
  <form method="POST" enctype="multipart/form-data">
    <input type="text" name="nombre" placeholder="Nombre del plato" required>
    <textarea name="descripcion" placeholder="Descripción" required></textarea>
    <input type="number" name="precio" placeholder="Precio" required>
    <input type="file" name="imagen" accept="image/*" required>
    <button type="submit" name="agregar">Agregar</button>
  </form>
</div>
<?php endif; ?>


<div class="menu-contenedor">
  <?php foreach ($platos as $p): ?>
  <div class="plato-card">
    <img src="<?= htmlspecialchars($p['imagen']) ?>" alt="">
    <div class="plato-info">
      <h3><?= htmlspecialchars($p['nombre']) ?></h3>
      <p><?= htmlspecialchars($p['descripcion']) ?></p>
      <span class="precio">$<?= number_format($p['precio'], 0, ',', '.') ?></span>
    </div>

    <?php if ($esAdmin): ?>
    <details>
      <summary>Editar</summary>
      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="idplato" value="<?= $p['id'] ?>">
        <input type="hidden" name="imagen_actual" value="<?= $p['imagen'] ?>">
        <input type="text" name="nombre" value="<?= $p['nombre'] ?>" required>
        <textarea name="descripcion" required><?= $p['descripcion'] ?></textarea>
        <input type="number" name="precio" value="<?= $p['precio'] ?>" required>
        <input type="file" name="imagen" accept="image/*">
        <button type="submit" name="editar">Actualizar</button>
      </form>
    </details>
   
    <a href="?eliminar=<?= $p['id'] ?>" class="eliminar" onclick="return confirm('¿Eliminar este plato?')">Eliminar</a>
    <?php endif; ?>
  </div>
  <?php endforeach; ?>
</div>

</body>
</html>
