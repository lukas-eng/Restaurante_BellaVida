<?php
require_once "../configs/conexion.php";
require_once "../models/domicilio.php";

class DomicilioController {

    private $modelDomicilio;

    public function __construct() {
        $this->modelDomicilio = new Domicilio();
    }

    public function crearDomicilio() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['crear_domicilio'])) {
            session_start();
            
            if (!isset($_SESSION['usuario'])) {
                header("Location: /restaurante/views/html/iniciarsesion.php");
                exit;
            }

            $direccion = $_POST['direccion'];
            $telefono_entrega = $_POST['telefono_entrega'];
            $descripcion_pedido = $_POST['descripcion_pedido'];
            $valor_total = $_POST['valor_total'];

            // Validaciones
            if (empty($direccion) || empty($telefono_entrega) || empty($descripcion_pedido) || empty($valor_total)) {
                header("Location: /restaurante/views/html/Domicilio.php?error=campos_vacios");
                exit;
            }

            if (!is_numeric($valor_total) || $valor_total <= 0) {
                header("Location: /restaurante/views/html/Domicilio.php?error=valor_invalido");
                exit;
            }

            $this->modelDomicilio->crearDomicilio(
                $_SESSION['usuario']['id_usuario'],
                $direccion,
                $telefono_entrega,
                $descripcion_pedido,
                $valor_total
            );

            header("Location: /restaurante/views/html/mis_domicilios.php?exito=1");
            exit;
        }
    }

    public function actualizarEstadoDomicilio() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar_estado_domicilio'])) {
            session_start();
            
            if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
                header("Location: /restaurante/views/html/perfil.php?error=sin_permiso");
                exit;
            }

            $id_domicilio = $_POST['id_domicilio'];
            $estado = $_POST['estado'];

            if (!in_array($estado, ['pendiente', 'en_preparacion', 'en_camino', 'entregado', 'cancelado'])) {
                header("Location: /restaurante/views/html/ver_domicilios.php?error=estado_invalido");
                exit;
            }

            $this->modelDomicilio->actualizarEstadoDomicilio($id_domicilio, $estado);

            header("Location: /restaurante/views/html/ver_domicilios.php?actualizado=1");
            exit;
        }
    }
}

$objeto = new DomicilioController();

if (isset($_POST['crear_domicilio'])) {
    $objeto->crearDomicilio();
} elseif (isset($_POST['actualizar_estado_domicilio'])) {
    $objeto->actualizarEstadoDomicilio();
}

?>
