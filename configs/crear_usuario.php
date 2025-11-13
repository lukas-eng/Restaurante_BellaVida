<?php
// Llamar a la conexión
require_once "conexion.php";

try {
    // Instanciar clase para conexión
    $db = Database::connect();
    
    // Datos del usuario que deseas insertar
    $email = "lukasnino4@gmail.com";
    $nombre = "Lucas";
    $documento = 1021313933;
    $telefono = 3123341426;
    $rol = "admin";
    $passwordPlano = "2222";

    // Consultar si el usuario ya existe
    $consulta = $db->prepare("SELECT * FROM usuarios WHERE correo = :correo");
    $consulta->execute([":correo" => $email]);

    if (!$consulta->fetch()) {
        // Si no existe, se inserta
        $passwordHash = password_hash($passwordPlano, PASSWORD_BCRYPT);

        $sql = "INSERT INTO usuarios (rol, nombre, documento, telefono, correo, password) 
                VALUES (:rol, :nombre, :documento, :telefono, :correo, :password)";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ":rol" => $rol,
            ":nombre" => $nombre,
            ":documento" => $documento,
            ":telefono" => $telefono,
            ":correo" => $email,
            ":password" => $passwordHash
        ]);

        echo "Usuario creado correctamente.";
    } else {
        echo "El administrador ya existe.";
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
