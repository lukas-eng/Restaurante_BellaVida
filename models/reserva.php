<?php
require_once __DIR__ . "/../configs/conexion.php";

class Reserva {

    private $db;
    
    public function __construct() {
        $this->db = Database::connect();
    }

    public function crearReserva($id_usuario, $fecha_evento, $numero_personas, $descripcion) {
        $sql = "INSERT INTO reservas (id_usuario, fecha_evento, numero_personas, descripcion) 
                VALUES (:id_usuario, :fecha_evento, :numero_personas, :descripcion)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id_usuario' => $id_usuario,
            ':fecha_evento' => $fecha_evento,
            ':numero_personas' => $numero_personas,
            ':descripcion' => $descripcion
        ]);
    }

    public function listarReservasUsuario($id_usuario) {
        $sql = "SELECT * FROM reservas WHERE id_usuario = :id_usuario ORDER BY fecha_evento DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_usuario' => $id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarTodasReservas() {
        $sql = "SELECT r.*, u.nombre, u.correo, u.telefono FROM reservas r
                JOIN usuarios u ON r.id_usuario = u.id_usuario
                ORDER BY r.fecha_evento DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerReserva($id_reserva) {
        $sql = "SELECT * FROM reservas WHERE id_reserva = :id_reserva";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_reserva' => $id_reserva]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarEstadoReserva($id_reserva, $estado) {
        $sql = "UPDATE reservas SET estado = :estado WHERE id_reserva = :id_reserva";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':estado' => $estado,
            ':id_reserva' => $id_reserva
        ]);
    }

    public function cancelarReserva($id_reserva) {
        return $this->actualizarEstadoReserva($id_reserva, 'cancelada');
    }

}
?>
