<!DOCTYPE html>
<html lang="es">
<head>
  <title>Iniciar Sesión - Restaurante</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
          <h3 class="card-title mb-0">Iniciar Sesión</h3>
        </div>
        <div class="card-body">
          <?php if(isset($_GET['registro']) && $_GET['registro'] == 'exitoso'): ?>
            <div class="alert alert-success">
              Registro exitoso. Por favor inicia sesión.
            </div>
          <?php endif; ?>
          
          <form action="../../controlador/usuariocontrolador.php" method="POST">
            <div class="mb-3">
              <label for="email" class="form-label">Correo electrónico:</label>
              <input type="email" class="form-control" id="email" placeholder="ejemplo@correo.com" name="email" required>
            </div>
            <div class="mb-3">
              <label for="pwd" class="form-label">Contraseña:</label>
              <input type="password" class="form-control" id="pwd" placeholder="Ingresa tu contraseña" name="password" required>
            </div>
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
              <a href="registro.php" class="btn btn-success btn-block">¿No tienes cuenta? Regístrate</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
