<?php
session_start();
// Si el usuario ya inició sesión, lo llevamos al menú
if (isset($_SESSION['usuario']) && !empty($_SESSION['usuario'])) {
    header('Location: views/html/menu.php');
    exit;
}

// Si no hay sesión activa, mostrar la página de inicio de sesión
header('Location: views/html/iniciarsesion.php');
exit;
?>
