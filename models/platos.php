<?php
require_once __DIR__ . "/../configs/conexion.php";

class Menu {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function RegistrarPlato($nombre, $descripcion, $precio, $imagen, $disponible) {
        $sql = "INSERT INTO menu (nombre, descripcion, precio, imagen, disponible)
                VALUES (:nombre, :descripcion, :precio, :imagen, :disponible)";
        $res = $this->db->prepare($sql);
        $res->bindParam(":nombre", $nombre);
        $res->bindParam(":descripcion", $descripcion);
        $res->bindParam(":precio", $precio);
        $res->bindParam(":imagen", $imagen);
        $res->bindParam(":disponible", $disponible);
        return $res->execute();
    }

    public function ListarPlatos() {
        $sql = "SELECT * FROM menu";
        $res = $this->db->query($sql);
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

   
    public function EditarPlato($id, $nombre, $descripcion, $precio, $imagen, $disponible) {
        $sql = "UPDATE menu 
                SET nombre=:nombre, descripcion=:descripcion, precio=:precio,
                    imagen=:imagen, disponible=:disponible
                WHERE id=:id";
        $res = $this->db->prepare($sql);
        $res->bindParam(":id", $id);
        $res->bindParam(":nombre", $nombre);
        $res->bindParam(":descripcion", $descripcion);
        $res->bindParam(":precio", $precio);
        $res->bindParam(":imagen", $imagen);
        $res->bindParam(":disponible", $disponible);
        return $res->execute();
    }

    public function EliminarPlato($id) {
        $sql = "DELETE FROM menu WHERE id = :id";
        $res = $this->db->prepare($sql);
        $res->bindParam(":id", $id);
        return $res->execute();
    }


    public function ObtenerPlato($id) {
        $sql = "SELECT * FROM menu WHERE id = :id";
        $res = $this->db->prepare($sql);
        $res->bindParam(":id", $id);
        $res->execute();
        return $res->fetch(PDO::FETCH_ASSOC);
    }
}
?>
