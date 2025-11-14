<?php
session_start();
require_once "../../models/domicilio.php";

if (!isset($_SESSION['usuario'])) {
    header("Location: iniciarsesion.php");
    exit;
}

$modelDomicilio = new Domicilio();
$mis_domicilios = $modelDomicilio->listarDomiciliosUsuario($_SESSION['usuario']['id_usuario']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Domicilios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body style="background: linear-gradient(white,bisque); min-height: 100vh;">
    <?php include 'navbar.php'; ?>
    
    <div class="container mt-5">
        <h2>Mis Domicilios</h2>
        
        <?php if (isset($_GET['exito']) && $_GET['exito'] == 1): ?>
            <div class="alert alert-success">Pedido creado correctamente. Espera que sea procesado.</div>
        <?php endif; ?>

        <a href="Domicilio.php" class="btn btn-primary mb-3">Nuevo Pedido a Domicilio</a>

        <?php if (empty($mis_domicilios)): ?>
            <p>No tienes pedidos a domicilio registrados.</p>
        <?php else: ?>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Dirección</th>
                        <th>Teléfono Entrega</th>
                        <th>Descripción</th>
                        <th>Valor Total</th>
                        <th>Estado</th>
                        <th>Fecha Pedido</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mis_domicilios as $domicilio): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($domicilio['direccion']); ?></td>
                            <td><?php echo htmlspecialchars($domicilio['telefono_entrega']); ?></td>
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
                            <td><?php echo date('d/m/Y H:i', strtotime($domicilio['fecha_pedido'])); ?></td>
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
