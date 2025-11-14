<?php
session_start();
require_once "../../models/usuario.php";

if (!isset($_SESSION['usuario'])) {
    header("Location: iniciarsesion.php");
    exit;
}

$modelUsuario = new Usuario();
$usuarios = $modelUsuario->listarUsuarios();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil - Lista Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body style="background: linear-gradient(white,bisque); min-height: 100vh;">
    <?php include 'navbar.php'; ?>
    
    <div class="container mt-5">
        <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
            <!-- Vista para Administradores -->
            <h4>Usuarios registrados</h4>
            <?php if (isset($_GET['eliminado']) && $_GET['eliminado'] == 1): ?>
                <div class="alert alert-success">Usuario eliminado correctamente.</div>
            <?php endif; ?>
            
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Documento</th>
                        <th>Telefono</th>
                        <th>Password</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($user['correo']); ?></td>
                            <td><?php echo htmlspecialchars($user['documento']); ?></td>
                            <td><?php echo htmlspecialchars($user['telefono']); ?></td>
                            <td><?php echo htmlspecialchars($user['password']); ?></td>
                            <td><?php echo htmlspecialchars($user['rol']); ?></td>
                            <td>
                                <a href="editarUsuario.php?id_usuario=<?php echo $user['id_usuario']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <?php if ($_SESSION['usuario']['id_usuario'] != $user['id_usuario']): ?>
                                <form method="POST" action="../../controlador/usuariocontrolador.php" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
                                    <input type="hidden" name="id" value="<?php echo $user['id_usuario']; ?>">
                                    <button type="submit" name="eliminar_usuario" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                                <?php endif; ?>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <!-- Vista para Usuarios Normales -->
            <h4>Mi Perfil</h4>
            <div class="card">
                <div class="card-body">
                    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?></p>
                    <p><strong>Correo:</strong> <?php echo htmlspecialchars($_SESSION['usuario']['correo']); ?></p>
                    <p><strong>Documento:</strong> <?php echo htmlspecialchars($_SESSION['usuario']['documento']); ?></p>
                    <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($_SESSION['usuario']['telefono']); ?></p>
                    <p><strong>Rol:</strong> <?php echo htmlspecialchars($_SESSION['usuario']['rol']); ?></p>
                    <a href="editarUsuario.php?id_usuario=<?php echo $_SESSION['usuario']['id_usuario']; ?>" class="btn btn-warning">Editar Mi Perfil</a>
                </div>
            </div>
        <?php endif; ?>
        
        <a href="cerrarsesion.php" class="btn btn-danger mt-3">Cerrar sesión</a>
    </div>
</body>
</html>
