<?php
include('Conexion/conexion.php');  // Conectar con la base de datos

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    // Recoger los datos del formulario
    $empresa = $_POST['empresa'];
    $contacto = $_POST['contacto'];
    $correo = $_POST['correo'];
    $telefono = $_POST['codigo_pais'] . $_POST['telefono']; // Concatenar código de país y teléfono
    $direccion = $_POST['direccion'];
    $tipo_pago = $_POST['tipo_pago'];
    $envio = $_POST['envio'];

    // Aquí puedes agregar los campos específicos del tipo de pago
    $tipo_pago_data = [];

    if ($tipo_pago === 'Transferencia') {
        $tipo_pago_data['banco'] = $_POST['bancoTransferencia'];
        $tipo_pago_data['numCuenta'] = $_POST['numCuentaTransferencia'];
        $tipo_pago_data['nombreTitular'] = $_POST['nombreTitularTransferencia'];
        $tipo_pago_data['tipoCuenta'] = $_POST['tipoCuentaTransferencia'];
    } elseif ($tipo_pago === 'Efectivo') {
        $tipo_pago_data['direccionPagoEfectivo'] = $_POST['direccionPagoEfectivo'];
        $tipo_pago_data['horarioPagoEfectivo'] = $_POST['horarioPagoEfectivo'];
    } elseif ($tipo_pago === 'PayPal') {
        $tipo_pago_data['correoPayPal'] = $_POST['correoPayPal'];
        $tipo_pago_data['confirmarCuentaPayPal'] = $_POST['confirmarCuentaPayPal'];
    }

    // Preparar la consulta SQL para insertar en la base de datos
    $sql = "INSERT INTO proveedores (empresa, contacto, correo, telefono, direccion, tipo_pago, envio, tipo_pago_data) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Preparar la sentencia
    $stmt = $conexion->prepare($sql);

    // Convertir los datos del pago en un JSON para guardarlo en la base de datos
    $tipo_pago_data_json = json_encode($tipo_pago_data);

    // Asociar los parámetros a la sentencia preparada
    $stmt->bind_param('ssssssss', $empresa, $contacto, $correo, $telefono, $direccion, $tipo_pago, $envio, $tipo_pago_data_json);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Proveedor agregado con éxito.";
    } else {
        echo "Error al agregar proveedor: " . $stmt->error;
    }

    // Cerrar la sentencia
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Proveedores - Joyería</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }
    header {
      background-color: #b58900;
      color: white;
      padding: 15px;
      text-align: center;
    }
    h2 {
      color: #333;
    }
    .container {
      width: 80%;
      margin: 20px auto;
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    form {
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin: 8px 0 5px;
      font-weight: bold;
    }
    input[type="text"],
    input[type="email"],
    input[type="number"],
    select,
    input[type="submit"] {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border-radius: 4px;
      border: 1px solid #ddd;
    }
    button {
      background-color: #b58900;
      color: white;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
      border-radius: 4px;
    }
    button:hover {
      background-color: #cc7a00;
    }
    .error-message {
      color: red;
      font-weight: bold;
    }
    /* Estilos para la lista de proveedores */
    .proveedores-list {
      max-height: 150px;
      overflow-y: auto;
      margin-top: 10px;
    }
    .proveedor-item {
      padding: 8px;
      background-color: #f9f9f9;
      margin-bottom: 5px;
      cursor: pointer;
    }
    .proveedor-item:hover {
      background-color: #ececec;
    }
    .proveedor-info {
      margin-top: 20px;
      padding: 10px;
      background-color: #f9f9f9;
      border-radius: 4px;
    }
    /* Estilos para productos */
    .producto-container {
      margin-top: 10px;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
    }
    .producto-input {
      display: flex;
      align-items: center;
      margin-top: 10px;
      margin-bottom: 10px;
    }
    .producto-input input {
      margin-right: 10px;
    }
    .btn-eliminar {
      background-color: #f44336;
      border: none;
      color: white;
      padding: 5px 10px;
      cursor: pointer;
      font-size: 16px;
      border-radius: 50%;
    }
    .btn-eliminar:hover {
      background-color: #d32f2f;
    }
    .precio-total {
      font-weight: bold;
      color: #4CAF50;
    }
    .total-container {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: 10px;
      width: 100%;
    }
    #totalVenta {
      font-weight: bold;
      color: #000;
      font-size: 18px;
    }
  </style>
  
  <script>
    function validarFormulario() {
      // Aquí puedes agregar tus validaciones.
      // Por ahora, simplemente retorna true para permitir el envío del formulario.
      return true;
    }
  </script>

</head>
<body>
  <header>
    <h1>Gestión de Proveedores - Joyería</h1>
  </header>
  <div class="container">
    <!-- Mostrar mensaje de error si existe -->
    <?php if (isset($error_message)): ?>
      <p class="error-message"><?= $error_message ?></p>
    <?php endif; ?>

    <!-- Formulario de Proveedor en un solo form -->
    <h2>Formulario de Proveedor</h2>
    <form method="POST" action="" onsubmit="return validarFormulario()">
      <label>Nombre de la empresa:</label>
      <input type="text" name="empresa" placeholder="Ej. Joyería El Oro" required><br>
      
      <label>Nombre de proveedor:</label>
      <input type="text" name="contacto" placeholder="Ej. Juan Pérez" required><br>
      
      <label>Correo electrónico:</label>
      <input type="email" name="correo" placeholder="ejemplo@correo.com" required><br>
      
      <label>Teléfono:</label>
      <select name="codigo_pais" id="codigo_pais" onchange="formatearTelefono()" required>
        <option value="+504">Honduras (+504)</option>
        <option value="+1">EE. UU. (+1)</option>
        <option value="+52">México (+52)</option>
      </select>
      <input type="text" name="telefono" id="telefono" placeholder="xxxx-xxxx" oninput="formatearTelefono()" required><br>
      
      <label>Dirección:</label>
      <input type="text" name="direccion" placeholder="Ej. Col. Palmira, Tegucigalpa, Honduras" required><br>
      
      <div class="producto-container">
        <label>Producto(s) y Precio:</label>
        <div id="producto-inputs">
          <div class="producto-input">
            <!-- Aquí se agregarán los productos dinámicamente -->
          </div>
        </div>
        <button type="button" onclick="agregarProducto()" id="btnAñadirProducto">Añadir Producto</button>
      </div>
      <br>
      
      <label>Tipo de pago:</label>
      <select name="tipo_pago" id="tipoPago" required onchange="mostrarCamposPago()">
        <option value="Efectivo">Efectivo</option>
        <option value="Transferencia">Transferencia Bancaria</option>
        <option value="PayPal">Depósito en PayPal</option>
      </select><br>
      
      <!-- Campos dinámicos para cada tipo de pago -->
      <div id="camposEfectivo" style="display: none;">
        <label for="direccionPagoEfectivo">Dirección de pago en efectivo:</label>
        <input type="text" name="direccionPagoEfectivo" id="direccionPagoEfectivo" placeholder="Ingresa la dirección" required><br>
        <label for="horarioPagoEfectivo">Horario de atención:</label>
        <input type="text" name="horarioPagoEfectivo" id="horarioPagoEfectivo" placeholder="Ej. Lunes a Viernes, 9am a 6pm" required><br>
      </div>
      
      <div id="camposTransferencia" style="display: none;">
        <label for="bancoTransferencia">Selecciona el banco:</label>
        <select name="bancoTransferencia" id="bancoTransferencia" required>
          <option value="Banco Atlántida">Banco Atlántida</option>
          <option value="BAC Credomatic">BAC Credomatic</option>
          <option value="Ficohsa">Ficohsa</option>
        </select><br>
        <label for="numCuentaTransferencia">Número de cuenta bancaria:</label>
        <input type="text" name="numCuentaTransferencia" id="numCuentaTransferencia" placeholder="Número de cuenta" required><br>
        <label for="nombreTitularTransferencia">Nombre del titular de la cuenta:</label>
        <input type="text" name="nombreTitularTransferencia" id="nombreTitularTransferencia" placeholder="Nombre completo" required><br>
        <label for="tipoCuentaTransferencia">Tipo de cuenta:</label>
        <select name="tipoCuentaTransferencia" id="tipoCuentaTransferencia" required>
          <option value="Corriente">Corriente</option>
          <option value="Ahorros">Ahorros</option>
        </select><br>
      </div>
      
      <div id="camposPayPal" style="display: none;">
        <label for="correoPayPal">Correo electrónico de PayPal:</label>
        <input type="email" name="correoPayPal" id="correoPayPal" placeholder="email@paypal.com" required><br>
        <label for="confirmarCuentaPayPal">Confirmación de cuenta PayPal:</label>
        <select name="confirmarCuentaPayPal" id="confirmarCuentaPayPal" required>
          <option value="Verificada">Verificada</option>
          <option value="No verificada">No verificada</option>
        </select><br>
      </div>
      
      <label>Método de envío:</label>
      <select name="envio" required>
        <option value="Envío estándar">Envío estándar</option>
        <option value="Envío exprés">Envío exprés</option>
        <option value="Recogida en tienda">Recogida en tienda</option>
      </select><br>
      
      <!-- Botón de envío del formulario -->
      <button type="submit" name="add">Agregar Proveedor</button>
    </form>

    <!-- Lista de Proveedores -->
    <h2>Lista de Proveedores</h2>
    <?php if (isset($_SESSION['proveedores']) && count($_SESSION['proveedores']) > 0): ?>
      <div class="proveedores-list">
        <?php foreach ($_SESSION['proveedores'] as $index => $proveedor): ?>
          <div class="proveedor-item" onclick="mostrarProveedor(<?= $index ?>)">
            <?= $proveedor['empresa'] ?>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="proveedor-info" id="proveedor-info">
        <!-- Aquí se mostrará la información del proveedor seleccionado -->
      </div>
    <?php else: ?>
      <p>No hay proveedores registrados.</p>
    <?php endif; ?>
  </div>

  <script>
    // Función para agregar un producto dinámicamente
    function agregarProducto() {
      const productoInputs = document.getElementById('producto-inputs');
      const nuevoProducto = document.createElement('div');
      nuevoProducto.classList.add('producto-input');
      nuevoProducto.innerHTML = `
          <input type="text" name="producto[]" placeholder="Ej. Anillo de oro" required>
          <input type="number" name="cantidad[]" placeholder="Cantidad" value="1" min="1" oninput="actualizarTotalProducto(this)" required>
          <input type="text" name="precio_display[]" placeholder="Precio unitario" onblur="formatearPrecio(this)" required>
          <input type="hidden" name="precio[]" value="">
          <span>Total: <span class="precio-total">0.00</span></span>
          <button type="button" onclick="eliminarProducto(this)" class="btn-eliminar">-</button>
      `;
      productoInputs.appendChild(nuevoProducto);
      document.getElementById('btnAñadirProducto').style.display = 'inline-block';
      actualizarTotalVenta();
    }

    // Función para eliminar un producto
    function eliminarProducto(button) {
      const productoContenedor = button.parentElement;
      productoContenedor.remove();
      if (document.querySelectorAll('.producto-input').length === 0) {
        document.getElementById('btnAñadirProducto').style.display = 'inline-block';
      }
      actualizarTotalVenta();
    }

    // Función para formatear el precio a moneda hondureña
    function formatearPrecio(input) {
      let valorLimpio = input.value.replace(/[^\d.]/g, '');
      let numero = parseFloat(valorLimpio);
      if (!isNaN(numero)) {
        let hiddenInput = input.nextElementSibling;
        if (hiddenInput && hiddenInput.type === "hidden") {
          hiddenInput.value = numero;
        }
        input.value = numero.toLocaleString('es-HN', {
          style: 'currency',
          currency: 'HNL',
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        });
        actualizarTotalProducto(input);
      }
    }

    // Función para actualizar el total de cada producto (cantidad * precio)
    function actualizarTotalProducto(input) {
      const cantidad = input.parentElement.querySelector('input[name="cantidad[]"]').value;
      const precioUnitario = parseFloat(input.parentElement.querySelector('input[name="precio[]"]').value) || 0;
      const total = cantidad * precioUnitario;
      const precioTotal = input.parentElement.querySelector('.precio-total');
      precioTotal.textContent = total.toLocaleString('es-HN', {
        style: 'currency',
        currency: 'HNL',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });
      actualizarTotalVenta();
    }

    // Función para actualizar el total de la venta
    function actualizarTotalVenta() {
      let totalVenta = 0;
      const productos = document.querySelectorAll('.producto-input');
      productos.forEach(producto => {
        const totalProducto = parseFloat(producto.querySelector('.precio-total').textContent.replace(/[^\d.-]/g, '')) || 0;
        totalVenta += totalProducto;
      });
      document.getElementById('totalVenta').textContent = totalVenta.toLocaleString('es-HN', {
        style: 'currency',
        currency: 'HNL',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });
    }

    // Función para mostrar los campos de pago según la selección
    function mostrarCamposPago() {
      const tipoPago = document.getElementById('tipoPago').value;
      document.getElementById('camposEfectivo').style.display = 'none';
      document.getElementById('camposTransferencia').style.display = 'none';
      document.getElementById('camposPayPal').style.display = 'none';
      
      if (tipoPago === 'Efectivo') {
        document.getElementById('camposEfectivo').style.display = 'block';
      } else if (tipoPago === 'Transferencia') {
        document.getElementById('camposTransferencia').style.display = 'block';
      } else if (tipoPago === 'PayPal') {
        document.getElementById('camposPayPal').style.display = 'block';
      }
    }

    // Inicializar campos de pago al cargar la página
    document.addEventListener('DOMContentLoaded', mostrarCamposPago);
  </script>
</body>
</html>
