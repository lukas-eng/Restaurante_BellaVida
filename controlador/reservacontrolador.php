<?php
require_once "../configs/conexion.php";
require_once "../models/reserva.php";

class ReservaController {

    private $modelReserva;

    public function __construct() {
        $this->modelReserva = new Reserva();
    }

    public function crearReserva() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['crear_reserva'])) {
            session_start();
            
            if (!isset($_SESSION['usuario'])) {
                header("Location: /restaurante/views/html/iniciarsesion.php");
                exit;
            }

            $fecha_evento = $_POST['fecha_evento'];
            $numero_personas = $_POST['numero_personas'];
            $descripcion = $_POST['descripcion'] ?? '';

            // Validaciones
            if (empty($fecha_evento) || empty($numero_personas)) {
                header("Location: /restaurante/views/html/reseva.html?error=campos_vacios");
                exit;
            }

            if (!is_numeric($numero_personas) || $numero_personas <= 0) {
                header("Location: /restaurante/views/html/reseva.html?error=personas_invalido");
                exit;
            }

            $this->modelReserva->crearReserva(
                $_SESSION['usuario']['id_usuario'],
                $fecha_evento,
                $numero_personas,
                $descripcion
            );

            header("Location: /restaurante/views/html/mis_reservas.php?exito=1");
            exit;
        }
    }

    public function actualizarEstadoReserva() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar_estado_reserva'])) {
            session_start();
            
            if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
                header("Location: /restaurante/views/html/perfil.php?error=sin_permiso");
                exit;
            }

            $id_reserva = $_POST['id_reserva'];
            $estado = $_POST['estado'];

            if (!in_array($estado, ['pendiente', 'confirmada', 'cancelada'])) {
                header("Location: /restaurante/views/html/ver_reservas.php?error=estado_invalido");
                exit;
            }

            $this->modelReserva->actualizarEstadoReserva($id_reserva, $estado);

            header("Location: /restaurante/views/html/ver_reservas.php?actualizado=1");
            exit;
        }
    }
}

$objeto = new ReservaController();

if (isset($_POST['crear_reserva'])) {
    $objeto->crearReserva();
} elseif (isset($_POST['actualizar_estado_reserva'])) {
    $objeto->actualizarEstadoReserva();
}

?>
