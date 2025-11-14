<?php
// navbar.php - Barra de navegación para usuarios logueados
if (!isset($_SESSION['usuario'])) {
    header("Location: iniciarsesion.php");
    exit;
}
?>

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgb(84, 119, 116);">
    <div class="container-fluid">
        <a class="navbar-brand" href="perfil.php">
            <img src="../img/logo.png" alt="Logo" style="width: 50px;" class="rounded me-2">
            <strong>Bella Vita</strong>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                    <!-- Opciones para Administrador -->
                    <li class="nav-item">
                        <a class="nav-link" href="perfil.php">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ver_reservas.php">Reservas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ver_domicilios.php">Domicilios</a>
                    </li>
                <?php else: ?>
                    <!-- Opciones para Usuario Normal -->
                    <li class="nav-item">
                        <a class="nav-link" href="mis_reservas.php">Mis Reservas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mis_domicilios.php">Mis Domicilios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="perfil.php">Mi Perfil</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="cerrarsesion.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
