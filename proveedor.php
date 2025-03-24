<?php
include 'confi/conexion.php';

// Verificar si el formulario se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $empresa = isset($_POST['empresa']) ? $_POST['empresa'] : '';
    $contacto = isset($_POST['contacto']) ? $_POST['contacto'] : '';
    $correo = isset($_POST['correo']) ? $_POST['correo'] : '';
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
    $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';
    $tipo_pago = isset($_POST['tipo_pago']) ? $_POST['tipo_pago'] : '';

    // Validación del método de envío
    $envio = isset($_POST['envio']) ? $_POST['envio'] : '';

    // Inicializar variables adicionales
    $direccionPagoEfectivo = '';
    $horarioPagoEfectivo = '';
    $banco = '';
    $numCuenta = '';
    $nombreTitular = '';
    $tipoCuenta = '';
    $correoPayPal = '';
    $confirmarCuentaPayPal = '';

    // Asignar valores según el tipo de pago
    if ($tipo_pago == 'efectivo') {
        $direccionPagoEfectivo = isset($_POST['direccion_pago_efectivo']) ? $_POST['direccion_pago_efectivo'] : '';
        $horarioPagoEfectivo = isset($_POST['horario_pago_efectivo']) ? $_POST['horario_pago_efectivo'] : '';
    } elseif ($tipo_pago == 'transferencia') {
        $banco = isset($_POST['banco']) ? $_POST['banco'] : '';
        $numCuenta = isset($_POST['numCuenta']) ? $_POST['numCuenta'] : '';
        $nombreTitular = isset($_POST['nombreTitular']) ? $_POST['nombreTitular'] : '';
        $tipoCuenta = isset($_POST['tipoCuenta']) ? $_POST['tipoCuenta'] : '';
    } elseif ($tipo_pago == 'paypal') {
        $correoPayPal = isset($_POST['correoPayPal']) ? $_POST['correoPayPal'] : '';
        $confirmarCuentaPayPal = isset($_POST['confirmarCuentaPayPal']) ? $_POST['confirmarCuentaPayPal'] : '';
    }

    // Verificaciones en la base de datos antes de la inserción
    $errores = [];

    // Verificar correo
    $sql = "SELECT correo FROM proveedores WHERE correo = '$correo'";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        $errores[] = "El correo electrónico ya está registrado.";
    }

    // Verificar teléfono
    $sql = "SELECT telefono FROM proveedores WHERE telefono = '$telefono'";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        $errores[] = "El número de teléfono ya está registrado.";
    }

    // Verificar número de cuenta bancaria
    if ($numCuenta != '') {
        $sql = "SELECT numCuenta FROM proveedores WHERE numCuenta = '$numCuenta'";
        $result = $conexion->query($sql);
        if ($result->num_rows > 0) {
            $errores[] = "El número de cuenta bancaria ya está registrado.";
        }
    }

    // Verificar correo PayPal
    if ($correoPayPal != '') {
        $sql = "SELECT correoPayPal FROM proveedores WHERE correoPayPal = '$correoPayPal'";
        $result = $conexion->query($sql);
        if ($result->num_rows > 0) {
            $errores[] = "El correo de PayPal ya está registrado.";
        }
    }

    // Verificar empresa
    $sql = "SELECT empresa FROM proveedores WHERE empresa = '$empresa'";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
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
        $sql = "INSERT INTO proveedores (empresa, contacto, correo, telefono, direccion, tipo_pago, envio, 
                direccionPagoEfectivo, horarioPagoEfectivo, banco, numCuenta, nombreTitular, tipoCuenta, 
                correoPayPal, confirmarCuentaPayPal) 
                VALUES ('$empresa', '$contacto', '$correo', '$telefono', '$direccion', '$tipo_pago', '$envio', 
                '$direccionPagoEfectivo', '$horarioPagoEfectivo', '$banco', '$numCuenta', '$nombreTitular', 
                '$tipoCuenta', '$correoPayPal', '$confirmarCuentaPayPal')";

        if ($conexion->query($sql) === TRUE) {
            echo "<script>
                    alert('Proveedor agregado con éxito!');
                    window.location.href = window.location.href;  // Redirige a la misma página
                 </script>";
        } else {
            echo "<p style='color:red;'>Error: " . $conexion->error . "</p>";
        }
    }

    $conexion->close();
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
        <form action="proveedor.php" method="POST" onsubmit="return validarFormulario()">
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
                <label for="tipo_pago">Tipo de Pago:</label>
                <select id="tipo_pago" name="tipo_pago" required onchange="showPaymentFields()">
                    <option value="Selecciona" <?= isset($_POST['tipo_pago']) && $_POST['tipo_pago'] == 'Selecciona' ? 'selected' : ''; ?>>Selecciona Tipo de Pago</option>
                    <option value="efectivo" <?= isset($_POST['tipo_pago']) && $_POST['tipo_pago'] == 'efectivo' ? 'selected' : ''; ?>>Efectivo</option>
                    <option value="transferencia" <?= isset($_POST['tipo_pago']) && $_POST['tipo_pago'] == 'transferencia' ? 'selected' : ''; ?>>Transferencia Bancaria</option>
                    <option value="paypal" <?= isset($_POST['tipo_pago']) && $_POST['tipo_pago'] == 'paypal' ? 'selected' : ''; ?>>PayPal</option>
                </select>
            </div>

            <div id="efectivo_fields" class="dynamic-fields" style="display: none;">
                <label for="direccion_pago_efectivo">Dirección de pago en efectivo:</label>
                <input type="text" name="direccion_pago_efectivo" id="direccion_pago_efectivo" value="<?= isset($_POST['direccion_pago_efectivo']) ? htmlspecialchars($_POST['direccion_pago_efectivo']) : ''; ?>" placeholder="Ej. Oficina principal">
                <br><br>
                <label for="horario_pago_efectivo">Horario de atención:</label>
                <input type="text" name="horario_pago_efectivo" id="horario_pago_efectivo" value="<?= isset($_POST['horario_pago_efectivo']) ? htmlspecialchars($_POST['horario_pago_efectivo']) : ''; ?>" placeholder="Ej. Lunes a Viernes, 9am - 5pm">
            </div>

            <div id="banco_fields" class="dynamic-fields" style="display: none;">
                <label for="banco">Selecciona el banco:</label>
                <select name="banco" id="banco">
                    <option value="Seleccion_ cuenta" <?= isset($_POST['banco']) && $_POST['banco'] == 'Seleccion_ cuenta' ? 'selected' : ''; ?>>Seleccione cuenta bancaria</option>
                    <option value="Banco Atlantida" <?= isset($_POST['banco']) && $_POST['banco'] == 'Banco Atlantida' ? 'selected' : ''; ?>>Banco Atlántida</option>
                    <option value="Bac Credomatic" <?= isset($_POST['banco']) && $_POST['banco'] == 'Bac Credomatic' ? 'selected' : ''; ?>>Bac Credomatic</option>
                    <option value="Ficohsa" <?= isset($_POST['banco']) && $_POST['banco'] == 'Ficohsa' ? 'selected' : ''; ?>>Ficohsa</option>
                </select>
                <br><br>

                <label for="numCuenta">Número de cuenta bancaria:</label>
                <input type="text" name="numCuenta" id="numCuenta" value="<?= isset($_POST['numCuenta']) ? htmlspecialchars($_POST['numCuenta']) : ''; ?>" placeholder="Ej. 123-456-789">
                <br><br>

                <label for="nombreTitular">Nombre del titular de la cuenta:</label>
                <input type="text" name="nombreTitular" id="nombreTitular" value="<?= isset($_POST['nombreTitular']) ? htmlspecialchars($_POST['nombreTitular']) : ''; ?>" placeholder="Ej. Pedro Pérez">
                <br><br>

                <label for="tipoCuenta">Tipo de cuenta:</label>
                <select name="tipoCuenta" id="tipoCuenta">
                    <option value="Seleccionetipocuenta" <?= isset($_POST['tipoCuenta']) && $_POST['tipoCuenta'] == 'Seleccionetipocuenta' ? 'selected' : ''; ?>>Seleccione tipo de cuenta</option>
                    <option value="corriente" <?= isset($_POST['tipoCuenta']) && $_POST['tipoCuenta'] == 'corriente' ? 'selected' : ''; ?>>Corriente</option>
                    <option value="ahorro" <?= isset($_POST['tipoCuenta']) && $_POST['tipoCuenta'] == 'ahorro' ? 'selected' : ''; ?>>Ahorro</option>
                </select>
            </div>

            <div id="paypal_fields" class="dynamic-fields" style="display: none;">
                <label for="correoPayPal">Correo electrónico de PayPal:</label>
                <input type="email" name="correoPayPal" id="correoPayPal" value="<?= isset($_POST['correoPayPal']) ? htmlspecialchars($_POST['correoPayPal']) : ''; ?>" placeholder="ejemplo@paypal.com">
                <br><br>

                <label for="confirmarCuentaPayPal">Confirmación de cuenta PayPal:</label>
                <select name="confirmarCuentaPayPal" id="confirmarCuentaPayPal">
                    <option value="Seleccioneverificacion" <?= isset($_POST['confirmarCuentaPayPal']) && $_POST['confirmarCuentaPayPal'] == 'Seleccioneverificacion' ? 'selected' : ''; ?>>Seleccione Verificación</option>
                    <option value="verificada" <?= isset($_POST['confirmarCuentaPayPal']) && $_POST['confirmarCuentaPayPal'] == 'verificada' ? 'selected' : ''; ?>>Verificada</option>
                    <option value="no_verificada" <?= isset($_POST['confirmarCuentaPayPal']) && $_POST['confirmarCuentaPayPal'] == 'no_verificada' ? 'selected' : ''; ?>>No verificada</option>
                </select>
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
        function showPaymentFields() {
            var tipoPago = document.getElementById('tipo_pago').value;
            document.getElementById('efectivo_fields').style.display = (tipoPago === 'efectivo') ? 'block' : 'none';
            document.getElementById('banco_fields').style.display = (tipoPago === 'transferencia') ? 'block' : 'none';
            document.getElementById('paypal_fields').style.display = (tipoPago === 'paypal') ? 'block' : 'none';
        }
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

            var tipoPago = document.getElementById('tipo_pago').value;
            if (tipoPago === 'Selecciona') {
                alert('Por favor, seleccione un tipo de pago.');
                return false;
            }

            var metodoEnvio = document.getElementById('envio').value;
            if (metodoEnvio === 'Seleccion') {
                alert('Por favor, seleccione un método de envío.');
                return false;
            }

            // Validaciones para los campos según el tipo de pago
            if (tipoPago === 'efectivo') {
                var direccionPagoEfectivo = document.getElementById('direccion_pago_efectivo').value;
                var horarioPagoEfectivo = document.getElementById('horario_pago_efectivo').value;
                if (direccionPagoEfectivo === '') {
                    alert('Por favor, ingrese la dirección de pago en efectivo.');
                    return false;
                }
                if (horarioPagoEfectivo === '') {
                    alert('Por favor, ingrese el horario de atención para el pago en efectivo.');
                    return false;
                }
            }

            if (tipoPago === 'transferencia') {
                var banco = document.getElementById('banco').value;
                var numCuenta = document.getElementById('numCuenta').value;
                if (banco === 'Seleccion_ cuenta') {
                    alert('Por favor, seleccione un banco.');
                    return false;
                }
                if (numCuenta === '') {
                    alert('Por favor, ingrese el número de cuenta bancaria.');
                    return false;
                }
            }

            if (tipoPago === 'paypal') {
                var correoPayPal = document.getElementById('correoPayPal').value;
                var confirmarCuentaPayPal = document.getElementById('confirmarCuentaPayPal').value;
                if (correoPayPal === '') {
                    alert('Por favor, ingrese el correo electrónico de PayPal.');
                    return false;
                }
                if (confirmarCuentaPayPal === 'Seleccioneverificacion') {
                    alert('Por favor, seleccione la verificación de la cuenta PayPal.');
                    return false;
                }
            }

            return true; // Si todo es correcto, el formulario se envía
        }

        document.addEventListener('DOMContentLoaded', function() {
            showPaymentFields();
        });
    </script>
</body>

</html>