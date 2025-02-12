<?php
require_once 'database.php';

$db = new Database();
$productos = $db->getProducts(8);  // Obtener 8 productos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos - Imperial Gems</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Nuestros Productos</h1>
        <div class="row">
            <?php foreach($productos as $producto): ?>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="<?= $producto['Imagen'] ?? 'img/placeholder.jpg' ?>" class="card-img-top" alt="<?= htmlspecialchars($producto['Nombre']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($producto['Nombre']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($producto['Descripción']) ?></p>
                        <p class="card-text">Precio: $<?= number_format($producto['Precio'], 2) ?></p>
                        <a href="#" class="btn btn-primary">Añadir al Carrito</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
```

4. registro.php (Formulario de registro)
```php
<?php
require_once 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new Database();
    
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $telefono = $_POST['telefono'] ?? null;
    $direccion = $_POST['direccion'] ?? null;
    
    if ($db->registerUser($nombre, $correo, $contrasena, $telefono, $direccion)) {
        echo "Registro exitoso. Por favor inicie sesión.";
    } else {
        echo "Error en el registro.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Imperial Gems</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Registro de Usuario</h2>
        <form method="post">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="contrasena" name="contrasena" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono (Opcional)</label>
                <input type="tel" class="form-control" id="telefono" name="telefono">
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección (Opcional)</label>
                <textarea class="form-control" id="direccion" name="direccion"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Registrarse</button>
        </form>
    </div>
</body>
</html>
```