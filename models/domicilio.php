<?php
require_once __DIR__ . "/../configs/conexion.php";

class Domicilio {

    private $db;
    
    public function __construct() {
        $this->db = Database::connect();
    }

    public function crearDomicilio($id_usuario, $direccion, $telefono_entrega, $descripcion_pedido, $valor_total) {
        $sql = "INSERT INTO domicilios (id_usuario, direccion, telefono_entrega, descripcion_pedido, valor_total) 
                VALUES (:id_usuario, :direccion, :telefono_entrega, :descripcion_pedido, :valor_total)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id_usuario' => $id_usuario,
            ':direccion' => $direccion,
            ':telefono_entrega' => $telefono_entrega,
            ':descripcion_pedido' => $descripcion_pedido,
            ':valor_total' => $valor_total
        ]);
    }

    public function listarDomiciliosUsuario($id_usuario) {
        $sql = "SELECT * FROM domicilios WHERE id_usuario = :id_usuario ORDER BY fecha_pedido DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_usuario' => $id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarTodosDomicilios() {
        $sql = "SELECT d.*, u.nombre, u.correo FROM domicilios d
                JOIN usuarios u ON d.id_usuario = u.id_usuario
                ORDER BY d.fecha_pedido DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDomicilio($id_domicilio) {
        $sql = "SELECT * FROM domicilios WHERE id_domicilio = :id_domicilio";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_domicilio' => $id_domicilio]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarEstadoDomicilio($id_domicilio, $estado) {
        $sql = "UPDATE domicilios SET estado = :estado WHERE id_domicilio = :id_domicilio";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':estado' => $estado,
            ':id_domicilio' => $id_domicilio
        ]);
    }

    public function cancelarDomicilio($id_domicilio) {
        return $this->actualizarEstadoDomicilio($id_domicilio, 'cancelado');
    }

}
?>
