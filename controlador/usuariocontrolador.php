<?php
require_once "../configs/conexion.php";
require_once "../models/usuario.php";
class UsuarioController{

    private $modelusuario;

    public function __construct(){
        $this->modelusuario = new Usuario();
    }
public function validarusu() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $usuario = $this->modelusuario->login($_POST['email'], $_POST['password']);

        if ($usuario) {
            session_start();
            $_SESSION['usuario'] = $usuario;
            $_SESSION['rol'] = $usuario['rol']; // Guardamos el rol en la sesión
            
            // Redirigimos según el rol
            if ($usuario['rol'] === 'admin') {
                header("Location: ../views/html/perfil.php"); // Redirige al admin al perfil
            } else {
                header("Location: ../views/index.html"); // Redirige a usuarios normales al perfil
            }
            exit;
        } else {
            header("Location: ../views/html/iniciarsesion.php");
            exit;
        }

    } else {
        header("Location: ../views/html/iniciarsesion.php");
        exit;
    }
}


public function editarUsuario() {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar_usuario'])) {
        session_start();
        
        // Validar que el usuario esté logueado
        if (!isset($_SESSION['usuario'])) {
            header("Location: /restaurante/views/html/iniciarsesion.php");
            exit;
        }
        
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $documento = $_POST['documento'];
        $telefono = $_POST['telefono'];
        $rol = $_POST['rol'];
        
        // Validar permisos: solo admin o el usuario logueado pueden editar
        $es_admin = $_SESSION['usuario']['rol'] === 'admin';
        $es_propio_usuario = $_SESSION['usuario']['id_usuario'] == $id;
        
        if (!$es_admin && !$es_propio_usuario) {
            header("Location: /restaurante/views/html/perfil.php?error=sin_permiso");
            exit;
        }

        $this->modelusuario->actualizarUsuario($id, $nombre, $correo, $documento, $telefono, $rol);

        header("Location: /restaurante/views/html/perfil.php?editado=1");
        exit;
    }
}

public function registrarUsuario() {
    try {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Verificar que todos los campos necesarios existen
            $campos_requeridos = ['nombre', 'documento', 'telefono', 'email', 'password'];
            foreach ($campos_requeridos as $campo) {
                if (!isset($_POST[$campo])) {
                    throw new Exception("Campo requerido no encontrado: " . $campo);
                }
            }

            $nombre = trim($_POST['nombre']);
            $documento = trim($_POST['documento']);
            $telefono = trim($_POST['telefono']);
            $correo = trim($_POST['email']);
            $password = $_POST['password'];

            // Validaciones básicas
            if (empty($nombre) || empty($documento) || empty($telefono) || empty($correo) || empty($password)) {
                header("Location: ../views/html/registro.php?error=campos_vacios");
                exit;
            }

            // Validar email
            if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                header("Location: ../views/html/registro.php?error=email_invalido");
                exit;
            }

            // Validar que el documento sea numérico
            if (!is_numeric($documento)) {
                header("Location: ../views/html/registro.php?error=documento_invalido");
                exit;
            }

            // Intentar registrar el usuario
            if ($this->modelusuario->registrarUsuario($nombre, $documento, $telefono, $correo, $password)) {
                header("Location: ../views/html/iniciarsesion.php?registro=exitoso");
            } else {
                header("Location: ../views/html/registro.php?error=email_existe");
            }
            exit;
        }
    } catch (Exception $e) {
        // Registrar el error para depuración
        error_log("Error en registro de usuario: " . $e->getMessage());
        header("Location: ../views/html/registro.php?error=error_sistema");
        exit;
    }
}

public function eliminarUsuario() {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar_usuario'])) {
        session_start();
        
        // Validar que el usuario esté logueado
        if (!isset($_SESSION['usuario'])) {
            header("Location: /restaurante/views/html/iniciarsesion.php");
            exit;
        }
        
        // Solo admins pueden eliminar usuarios
        if ($_SESSION['usuario']['rol'] !== 'admin') {
            header("Location: /restaurante/views/html/perfil.php?error=sin_permiso");
            exit;
        }
        
        $id = $_POST['id'];
        
        // No permitir que un admin se elimine a sí mismo
        if ($_SESSION['usuario']['id_usuario'] == $id) {
            header("Location: /restaurante/views/html/perfil.php?error=no_puedes_eliminarte");
            exit;
        }
        
        $this->modelusuario->eliminarUsuario($id);
        
        header("Location: /restaurante/views/html/perfil.php?eliminado=1");
        exit;
    }
}

}
$objeto = new UsuarioController();

// Determinar qué acción realizar basado en los datos POST
if (isset($_POST['editar_usuario'])) {
    $objeto->editarUsuario();
} elseif (isset($_POST['eliminar_usuario'])) {
    $objeto->eliminarUsuario();
} elseif (isset($_POST['registrar'])) { // Verificamos si viene del formulario de registro
    $objeto->registrarUsuario();
} else {
    $objeto->validarusu();  // Para el inicio de sesión
}

?>