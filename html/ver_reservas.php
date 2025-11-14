<?php
session_start();
require_once "../../models/reserva.php";

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: perfil.php?error=sin_permiso");
    exit;
}

$modelReserva = new Reserva();
$todas_reservas = $modelReserva->listarTodasReservas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body style="background: linear-gradient(white,bisque); min-height: 100vh;">
    <?php include 'navbar.php'; ?>
    
    <div class="container mt-5">
        <h2>Gestionar Reservas</h2>
        
        <?php if (isset($_GET['actualizado']) && $_GET['actualizado'] == 1): ?>
            <div class="alert alert-success">Estado de reserva actualizado correctamente.</div>
        <?php endif; ?>

        <?php if (empty($todas_reservas)): ?>
            <p>No hay reservas registradas.</p>
        <?php else: ?>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Fecha Evento</th>
                        <th>Personas</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($todas_reservas as $reserva): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($reserva['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($reserva['correo']); ?></td>
                            <td><?php echo htmlspecialchars($reserva['telefono']); ?></td>
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
                            <td>
                                <form method="POST" action="../../controlador/reservacontrolador.php" style="display:inline;">
                                    <input type="hidden" name="id_reserva" value="<?php echo $reserva['id_reserva']; ?>">
                                    <select name="estado" class="form-select form-select-sm" style="width: auto; display:inline;">
                                        <option value="">Cambiar estado</option>
                                        <option value="pendiente" <?php echo $reserva['estado'] == 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                        <option value="confirmada" <?php echo $reserva['estado'] == 'confirmada' ? 'selected' : ''; ?>>Confirmada</option>
                                        <option value="cancelada" <?php echo $reserva['estado'] == 'cancelada' ? 'selected' : ''; ?>>Cancelada</option>
                                    </select>
                                    <button type="submit" name="actualizar_estado_reserva" class="btn btn-sm btn-primary">Actualizar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
