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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: linear-gradient(white,bisque); height:100vh; display: flex;">
    <div style="margin: 10px;width:100%; display:flex; flex-direction:row;">
        <div class="card" style="width:350px; height:450px;border-radius:15px;">
            <img class="card-img-top" src="../img/usuario.png" alt="Card image" style="width:100%">
            <div class="card-body">
            <h2>Bienvenida, <?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?></h2>
            </div>
        </div>
    <div class="container mt-4" >
        <h4>Usuarios registrados:</h4>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Documento</th>
                    <th>Telefono</th>
                    <th>Password</th>
                    <th>Rol</th>
                    <th>Editar</th>
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
                        <td><a href="editarUsuario.php?id_usuario=<?php echo $user['id_usuario']; ?>" class="btn btn-warning btn-sm">Editar</a></td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <a href="cerrarsesion.php" class="btn btn-danger">Cerrar sesión</a>
    </div>
    </div>
</body>
</html>
