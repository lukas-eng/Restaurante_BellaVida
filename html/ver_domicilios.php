<?php
session_start();
require_once "../../models/domicilio.php";

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: perfil.php?error=sin_permiso");
    exit;
}

$modelDomicilio = new Domicilio();
$todos_domicilios = $modelDomicilio->listarTodosDomicilios();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Domicilios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body style="background: linear-gradient(white,bisque); min-height: 100vh;">
    <?php include 'navbar.php'; ?>
    
    <div class="container mt-5">
        <h2>Gestionar Domicilios</h2>
        
        <?php if (isset($_GET['actualizado']) && $_GET['actualizado'] == 1): ?>
            <div class="alert alert-success">Estado de domicilio actualizado correctamente.</div>
        <?php endif; ?>

        <?php if (empty($todos_domicilios)): ?>
            <p>No hay pedidos a domicilio registrados.</p>
        <?php else: ?>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th>Dirección</th>
                        <th>Descripción Pedido</th>
                        <th>Valor Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($todos_domicilios as $domicilio): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($domicilio['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($domicilio['correo']); ?></td>
                            <td><?php echo htmlspecialchars($domicilio['direccion']); ?></td>
                            <td><?php echo htmlspecialchars($domicilio['descripcion_pedido']); ?></td>
                            <td>$<?php echo number_format($domicilio['valor_total'], 2); ?></td>
                            <td>
                                <span class="badge bg-<?php 
                                    echo $domicilio['estado'] == 'entregado' ? 'success' : 
                                         ($domicilio['estado'] == 'pendiente' ? 'warning' :
                                         ($domicilio['estado'] == 'en_preparacion' ? 'info' :
                                         ($domicilio['estado'] == 'en_camino' ? 'primary' : 'danger')));
                                ?>">
                                    <?php echo htmlspecialchars($domicilio['estado']); ?>
                                </span>
                            </td>
                            <td>
                                <form method="POST" action="../../controlador/domiciliocontrolador.php" style="display:inline;">
                                    <input type="hidden" name="id_domicilio" value="<?php echo $domicilio['id_domicilio']; ?>">
                                    <select name="estado" class="form-select form-select-sm" style="width: auto; display:inline;">
                                        <option value="">Cambiar estado</option>
                                        <option value="pendiente" <?php echo $domicilio['estado'] == 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                        <option value="en_preparacion" <?php echo $domicilio['estado'] == 'en_preparacion' ? 'selected' : ''; ?>>En Preparación</option>
                                        <option value="en_camino" <?php echo $domicilio['estado'] == 'en_camino' ? 'selected' : ''; ?>>En Camino</option>
                                        <option value="entregado" <?php echo $domicilio['estado'] == 'entregado' ? 'selected' : ''; ?>>Entregado</option>
                                        <option value="cancelado" <?php echo $domicilio['estado'] == 'cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                                    </select>
                                    <button type="submit" name="actualizar_estado_domicilio" class="btn btn-sm btn-primary">Actualizar</button>
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
