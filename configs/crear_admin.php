<?php
// Llamar a la conexión
require_once "conexion.php";

try {
    // Instanciar clase para conexión
    $db = Database::connect();
    
    // Datos del usuario que deseas insertar
    $email = "valeri24@gmail.com";
    $nombre = "valeri";
    $documento = 1234;
    $telefono = 31182802;
    $rol = "admin";
    $passwordPlano = "admin123";

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

        echo "Administrador creado correctamente.";
    } else {
        echo "El administrador ya existe.";
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
