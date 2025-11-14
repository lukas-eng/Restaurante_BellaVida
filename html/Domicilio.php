<?php
session_start();

// Requiere que el usuario esté logueado para hacer domicilios
if (!isset($_SESSION['usuario'])) {
    header('Location: iniciarsesion.php');
    exit;
}

// Incluir navbar dinámico
include 'navbar.php';

// Incluir el contenido de la página (sin la navbar estática)
readfile('Domicilio.html');
?>
