<?php
session_start();
require_once "../../models/usuario.php";

if (!isset($_GET['id_usuario'])) {
    header("Location: perfil.php");
    exit;
}

$modelUsuario = new Usuario();
$usuario = $modelUsuario->listarUsuarioId($_GET['id_usuario']);

if (!$usuario) {
    echo "Usuario no encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Editar Usuario</h2>
        <form action="../../controlador/usuariocontrolador.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $usuario['id_usuario']; ?>">
            
            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
            </div>

            <div class="mb-3">
                <label>Correo</label>
                <input type="email" name="correo" class="form-control" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required>
            </div>

            <div class="mb-3">
                <label>documento</label>
                <input type="text" name="documento" class="form-control" value="<?php echo htmlspecialchars($usuario['documento']); ?>" required>
            </div>

            <div class="mb-3">
                <label>telefono</label>
                <input type="text" name="telefono" class="form-control" value="<?php echo htmlspecialchars($usuario['telefono']); ?>" required>
            </div>


            <div class="mb-3">
                <label>Rol</label>
                <select name="rol" class="form-control">
                    <option value="admin" <?php echo $usuario['rol'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                    <option value="usuario" <?php echo $usuario['rol'] == 'usuario' ? 'selected' : ''; ?>>Usuario</option>
                </select>
            </div>

            <button type="submit" name="editar_usuario" class="btn btn-primary">Guardar Cambios</button>
            <a href="perfil.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
