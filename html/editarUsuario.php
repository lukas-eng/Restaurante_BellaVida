<?php
session_start();
require_once "../../models/usuario.php";

if (!isset($_SESSION['usuario'])) {
    header("Location: iniciarsesion.php");
    exit;
}

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

// Validar permisos: solo admin o el usuario logueado pueden editar
$es_admin = $_SESSION['usuario']['rol'] === 'admin';
$es_propio_usuario = $_SESSION['usuario']['id_usuario'] == $_GET['id_usuario'];

if (!$es_admin && !$es_propio_usuario) {
    echo "No tienes permiso para editar este usuario.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body style="background: linear-gradient(white,bisque); min-height: 100vh;">
    <?php include 'navbar.php'; ?>
    
    <div class="container mt-5">
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


            <?php if ($es_admin): ?>
            <div class="mb-3">
                <label>Rol</label>
                <select name="rol" class="form-control">
                    <option value="admin" <?php echo $usuario['rol'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                    <option value="usuario" <?php echo $usuario['rol'] == 'usuario' ? 'selected' : ''; ?>>Usuario</option>
                </select>
            </div>
            <?php else: ?>
            <input type="hidden" name="rol" value="<?php echo $usuario['rol']; ?>">
            <?php endif; ?>

            <button type="submit" name="editar_usuario" class="btn btn-primary">Guardar Cambios</button>
            <a href="perfil.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
