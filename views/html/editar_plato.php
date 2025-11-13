<?php
require_once "../../models/platos.php";
$model = new Menu();
$plato = $model->ObtenerPlato($_GET['id']);
?>

<form action="../../controlador/platocontrolador.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="accion" value="actualizar">
    <input type="hidden" name="idplato" value="<?= $plato['idplato'] ?>">
    <input type="hidden" name="imagen_actual" value="<?= $plato['imagenpla'] ?>">

    <label>Nombre:</label><input type="text" name="nombre" value="<?= $plato['nombreplato'] ?>"><br>
    <label>Descripción:</label><textarea name="descripcion"><?= $plato['descripcion'] ?></textarea><br>
    <label>Precio:</label><input type="number" name="precio" value="<?= $plato['precio'] ?>"><br>
    <label>Imagen:</label><input type="file" name="imagen"><br>
    <img src="../img/<?= $plato['imagenpla'] ?>" width="100"><br>
    <label>Disponible:</label>
    <select name="disponible">
        <option value="1" <?= $plato['disponible'] ? 'selected' : '' ?>>Sí</option>
        <option value="0" <?= !$plato['disponible'] ? 'selected' : '' ?>>No</option>
    </select><br>
    <button type="submit">Actualizar</button>
</form>
