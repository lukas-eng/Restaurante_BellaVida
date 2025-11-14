<?php
// Iniciar sesión para mensajes de error
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Formulario de Registro</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">

        <div class="card shadow-lg">
          <div class="card-header bg-primary text-white text-center">
            <h4>Registro de Usuario</h4>
          </div>
          <div class="card-body">
            <form action="../../controlador/usuariocontrolador.php" method="POST">
              <?php if(isset($_GET['error'])): ?>
                <div class="alert alert-danger">
                  <?php
                    switch($_GET['error']) {
                      case 'campos_vacios':
                        echo "Por favor complete todos los campos";
                        break;
                      case 'email_invalido':
                        echo "Por favor ingrese un email válido";
                        break;
                      case 'email_existe':
                        echo "Este email ya está registrado";
                        break;
                      case 'documento_invalido':
                        echo "El documento debe contener solo números";
                        break;
                      case 'error_sistema':
                        echo "Error en el sistema. Por favor intente más tarde";
                        break;
                    }
                  ?>
                </div>
              <?php endif; ?>

              <!-- Nombre -->
              <div class="mb-3">
                <label for="nombre" class="form-label">Nombre completo</label>
                <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Escribe tu nombre" required>
              </div>

              <!-- documento -->
              <div class="mb-3">
                <label for="documento" class="form-label">Documento</label>
                <input type="text" name="documento" class="form-control" id="documento" placeholder="Número de documento" required>
              </div>

              <!-- Email -->
              <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="ejemplo@correo.com" required>
              </div>

              <!-- telefono -->
              <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="tel" name="telefono" class="form-control" id="telefono" placeholder="+57" required>
              </div>

              <!-- Contraseña -->
              <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Crea una contraseña" required>
              </div>

              <!-- Botón -->
              <div class="d-grid gap-2">
                <button type="submit" name="registrar" class="btn btn-success">Registrarse</button>
                <a href="iniciarsesion.php" class="btn btn-outline-primary">¿Ya tienes cuenta? Inicia sesión</a>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
