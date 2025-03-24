
<?php
include '../confi/conexion.php';

// Inicializar la conexión PDO
try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Verificar si el formulario se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $empresa = isset($_POST['empresa']) ? $_POST['empresa'] : '';
    $contacto = isset($_POST['contacto']) ? $_POST['contacto'] : '';
    $correo = isset($_POST['correo']) ? $_POST['correo'] : '';
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
    $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';

    // Validación del método de envío
    $envio = isset($_POST['envio']) ? $_POST['envio'] : '';

    // Verificaciones en la base de datos antes de la inserción
    $errores = [];

    // Verificar correo
    $sql = "SELECT correo FROM proveedores WHERE correo = :correo";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':correo', $correo);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $errores[] = "El correo electrónico ya está registrado.";
    }

    // Verificar teléfono
    $sql = "SELECT telefono FROM proveedores WHERE telefono = :telefono";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $errores[] = "El número de teléfono ya está registrado.";
    }

    // Verificar empresa
    $sql = "SELECT empresa FROM proveedores WHERE empresa = :empresa";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':empresa', $empresa);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $errores[] = "El nombre de la empresa ya está registrado.";
    }

    // Si hay errores, mostrarlos en el frontend usando JavaScript para la confirmación
    if (!empty($errores)) {
        echo "<script>
                var errores = " . json_encode($errores) . ";
                var mensaje = errores.join('\\n');
                if (confirm('¡Atención! Existen algunos errores: \\n' + mensaje + '\\n¿Desea continuar?')) {
                    // Si el usuario acepta, se procederá
                    alert('Continuando con la verificación.');
                } else {
                    // Si el usuario no acepta, se cancela el proceso
                    alert('Proceso cancelado.');
                }
              </script>";
    } else {
        // Insertar los datos en la base de datos
        $sql = "INSERT INTO proveedores (empresa, contacto, correo, telefono, direccion, envio) 
                VALUES (:empresa, :contacto, :correo, :telefono, :direccion, :envio)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':empresa', $empresa);
        $stmt->bindParam(':contacto', $contacto);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':envio', $envio);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Proveedor agregado con éxito!');
                    window.location.href = window.location.href;  // Redirige a la misma página
                 </script>";
        } else {
            echo "<p style='color:red;'>Error: " . $stmt->errorInfo()[2] . "</p>";
        }
    }

    $conexion = null;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        .container {
            width: 70%;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 28px;
            color: #b58900;
            /* Color dorado para subtítulos */
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            font-size: 16px;
        }

        input,
        select,
        textarea {
            padding: 12px;
            font-size: 16px;
            border: 2px solid #ddd;
            border-radius: 8px;
            background-color: #f1f1f1;
            color: #333;
            transition: border-color 0.3s ease;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #b58900;
            /* Borde dorado al enfocarse */
            outline: none;
        }

        label {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        input[type="submit"] {
            background-color: #b58900;
            /* Fondo dorado para el botón */
            color: white;
            padding: 15px 30px;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #9e7c00;
            /* Sombra dorada más oscura al hacer hover */
            transform: translateY(-2px);
            /* Efecto de elevación */
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #333333;
            color: #ffffff;
            margin-top: 40px;
            font-size: 14px;
        }

        /* Estilos para la vista móvil */
        @media (max-width: 768px) {
            .container {
                width: 90%;
            }

            header h1 {
                font-size: 32px;
            }

            h2 {
                font-size: 24px;
            }
        }

        /* Ocultar dinámicamente los campos */
        .dynamic-fields {
            display: none;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Agregar Proveedor</h2>
        <form action="../complementos/registrar_proveedores_dashboard.php" method="POST" onsubmit="return validarFormulario()">
            <div class="form-group">
                <label for="empresa">Nombre de la Empresa:</label>
                <input type="text" id="empresa" name="empresa" value="<?= isset($_POST['empresa']) ? htmlspecialchars($_POST['empresa']) : ''; ?>" placeholder="Ej. Joyería Luxor" required>
            </div>

            <div class="form-group">
                <label for="contacto">Nombre de Contacto:</label>
                <input type="text" id="contacto" name="contacto" value="<?= isset($_POST['contacto']) ? htmlspecialchars($_POST['contacto']) : ''; ?>" placeholder="Ej. Ricardo Moura" required>
            </div>

            <div class="form-group">
                <label for="correo">Correo Electrónico:</label>
                <input type="email" id="correo" name="correo" value="<?= isset($_POST['correo']) ? htmlspecialchars($_POST['correo']) : ''; ?>" placeholder="ejemplo@correo.com" required>
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" value="<?= isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : ''; ?>" placeholder="Ej. +123 4567-8900" required>
            </div>

            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <textarea id="direccion" name="direccion" rows="4" placeholder="Ej. Colonia Palmira, Tegucigalpa, Honduras." required><?= isset($_POST['direccion']) ? htmlspecialchars($_POST['direccion']) : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label for="envio">Método de Envío:</label>
                <select id="envio" name="envio" required>
                    <option value="Seleccion" <?= isset($_POST['envio']) && $_POST['envio'] == 'Seleccion' ? 'selected' : ''; ?>>Selecciona Método de Envío</option>
                    <option value="envio_estandar" <?= isset($_POST['envio']) && $_POST['envio'] == 'envio_estandar' ? 'selected' : ''; ?>>Envío Estándar</option>
                    <option value="envio_expres" <?= isset($_POST['envio']) && $_POST['envio'] == 'envio_expres' ? 'selected' : ''; ?>>Envío Expres</option>
                    <option value="recogida_tienda" <?= isset($_POST['envio']) && $_POST['envio'] == 'recogida_tienda' ? 'selected' : ''; ?>>Recogida en la Tienda</option>
                </select>
            </div>

            <div class="form-group">
                <input type="submit" value="Agregar Proveedor">
            </div>
        </form>
    </div>

<!-- Scripts para validaciones en tiempo real -->
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS y dependencias -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Validar que solo se ingresen números en el campo de teléfono
        $("#telefono").on("input", function() {
            let telefono = $(this).val();

            // Permitir solo números (elimina cualquier otro carácter)
            telefono = telefono.replace(/\D/g, "");

            // Actualiza el campo con el valor filtrado
            $(this).val(telefono);

            // Verifica si el campo está vacío
            if (telefono === "") {
                $("#telefonoError").text("El teléfono solo debe contener números.");
            } else {
                $("#telefonoError").text("");
            }
        });

        function validarFormulario() {
            // Muestra un mensaje de confirmación antes de enviar el formulario
            var confirmarEnvio = confirm("¿Está seguro de que desea enviar los datos?");
            if (!confirmarEnvio) {
                return false; // Si el usuario elige "No", no se envía el formulario
            }

            var metodoEnvio = document.getElementById('envio').value;
            if (metodoEnvio === 'Seleccion') {
                alert('Por favor, seleccione un método de envío.');
                return false;
            }

            return true; // Si todo es correcto, el formulario se envía
        }
    </script>
</body>

</html>