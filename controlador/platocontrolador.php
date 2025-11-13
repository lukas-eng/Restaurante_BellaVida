<?php
require_once __DIR__ . "/../models/platos.php";

class PlatoController {
    private $model;

    public function __construct() {
        $this->model = new Menu();
    }

    public function Registrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $disponible = $_POST['disponible'];

            $imagen = $_FILES['imagen']['name'];
            $ruta = __DIR__ . "/../views/img/" . basename($imagen);
            move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);

            $this->model->RegistrarPlato($nombre, $descripcion, $precio, $imagen, $disponible);
            header("Location: ../views/html/menu.php");
            exit();
        }
    }

    public function Listar() {
        return $this->model->ListarPlatos();
    }

    public function Actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['idplato'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $disponible = $_POST['disponible'];

            $imagen = $_FILES['imagen']['name'] ?: $_POST['imagen_actual'];
            if (!empty($_FILES['imagen']['tmp_name'])) {
                $ruta = __DIR__ . "/../views/img/" . basename($imagen);
                move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);
            }

            $this->model->EditarPlato($id, $nombre, $descripcion, $precio, $imagen, $disponible);
            header("Location: ../views/html/menu.php");
            exit();
        }
    }

    public function Eliminar($id) {
        $this->model->EliminarPlato($id);
        header("Location: ../views/html/menu.php");
        exit();
    }
}


$controller = new PlatoController();

if (isset($_GET['eliminar'])) {
    $controller->Eliminar($_GET['eliminar']);
} elseif (isset($_POST['accion']) && $_POST['accion'] === 'registrar') {
    $controller->Registrar();
} elseif (isset($_POST['accion']) && $_POST['accion'] === 'actualizar') {
    $controller->Actualizar();
}
?>

