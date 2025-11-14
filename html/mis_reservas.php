<?php
session_start();
require_once "../../models/reserva.php";

if (!isset($_SESSION['usuario'])) {
    header("Location: iniciarsesion.php");
    exit;
}

$modelReserva = new Reserva();
$mis_reservas = $modelReserva->listarReservasUsuario($_SESSION['usuario']['id_usuario']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body style="background: linear-gradient(white,bisque); min-height: 100vh;">
    <?php include 'navbar.php'; ?>
    
    <div class="container mt-5">
        <h2>Mis Reservas</h2>
        
        <?php if (isset($_GET['exito']) && $_GET['exito'] == 1): ?>
            <div class="alert alert-success">Reserva creada correctamente. Espera confirmación del administrador.</div>
        <?php endif; ?>

        <a href="reseva.html" class="btn btn-primary mb-3">Nueva Reserva</a>

        <?php if (empty($mis_reservas)): ?>
            <p>No tienes reservas registradas.</p>
        <?php else: ?>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Fecha Evento</th>
                        <th>Número de Personas</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Fecha Solicitud</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mis_reservas as $reserva): ?>
                        <tr>
                            <td><?php echo date('d/m/Y H:i', strtotime($reserva['fecha_evento'])); ?></td>
                            <td><?php echo htmlspecialchars($reserva['numero_personas']); ?></td>
                            <td><?php echo htmlspecialchars($reserva['descripcion']); ?></td>
                            <td>
                                <span class="badge bg-<?php 
                                    echo $reserva['estado'] == 'confirmada' ? 'success' : 
                                         ($reserva['estado'] == 'pendiente' ? 'warning' : 'danger');
                                ?>">
                                    <?php echo htmlspecialchars($reserva['estado']); ?>
                                </span>
                            </td>
                            <td><?php echo date('d/m/Y H:i', strtotime($reserva['fecha_reserva'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <a href="perfil.php" class="btn btn-secondary mt-3">Volver</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
