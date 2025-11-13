<?php
require_once __DIR__ . "/../configs/conexion.php";



class Usuario {

    private $db;
    
    public function __construct() {
        $this->db = Database::connect();
    }
                                                                                         
    public function obtenerUsuario($email) {
        $sql = "SELECT * FROM usuarios WHERE correo = :correo LIMIT 1";
        $consul = $this->db->prepare($sql);
        $consul->execute([":correo" => $email]);

        return $consul->fetch(PDO::FETCH_ASSOC);
    }

    public function login($email, $pass) {
        $usuario = $this->obtenerUsuario($email);
        if ($usuario && password_verify($pass, $usuario['password'])) {
            return $usuario;
        }
        return false;
    }
  

    public function listarUsuarios() {
        $sql = "SELECT id_usuario, nombre, correo, documento, telefono, password, rol FROM usuarios";
        $stmt  = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function listarUsuarioId($id){
        $sql = "SELECT * FROM usuarios WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    

    public function actualizarUsuario($id, $nombre, $correo, $documento, $telefono, $rol) {
        $sql = "UPDATE usuarios 
                SET nombre = :nombre, correo = :correo, documento = :documento, telefono = :telefono, rol = :rol
                WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':correo' => $correo,
            ':documento' => $documento,
            ':telefono' => $telefono,
            ':rol' => $rol,
            ':id' => $id
        ]);
    }

    public function registrarUsuario($nombre, $documento, $telefono, $correo, $password) {
        // Verificar si el correo ya existe
        if ($this->obtenerUsuario($correo)) {
            return false;
        }

        // Hash de la contraseña
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Insertar nuevo usuario
        $sql = "INSERT INTO usuarios (rol, nombre, documento, telefono, correo, password) 
                VALUES ('usuario', :nombre, :documento, :telefono, :correo, :password)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':documento' => $documento,
            ':telefono' => $telefono,
            ':correo' => $correo,
            ':password' => $password_hash
        ]);
    }

}
?>
