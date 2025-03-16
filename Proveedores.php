<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    // Verificar los datos del formulario
    $tipo_pago = $_POST['tipo_pago'];
    $envio = $_POST['envio'];
    
    // Si el tipo de pago es "Transferencia", hay que verificar también los datos de la transferencia
    if ($tipo_pago === 'Transferencia') {
        $numReferencia = $_POST['numReferencia'];
        $comprobanteDeposito = $_FILES['comprobanteDeposito'];
        
        // Procesar el archivo de comprobante de depósito
        // (Aquí podrías subir el archivo o guardarlo en una carpeta, dependiendo de tu necesidad)
    }

    // Guardar los datos del proveedor en la sesión o en una base de datos
    if (!isset($_SESSION['proveedores'])) {
        $_SESSION['proveedores'] = [];
    }
    
    $proveedor = [
        'tipo_pago' => $tipo_pago,
        'envio' => $envio,
        // Agregar otros datos aquí como el número de tarjeta o transferencia si es necesario
    ];

    $_SESSION['proveedores'][] = $proveedor;

    // Redirigir o mostrar un mensaje de éxito
    echo "Proveedor agregado con éxito";
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
            background-color: #b58900; /* Dorado */
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
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 8px 0 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="email"], input[type="number"], select, input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .producto-container {
            margin-top: 10px;
        }
        .producto-input {
            display: flex;
            margin-top: 10px;
        }
        .producto-input input {
            flex: 1;
            margin-right: 10px;
        }
        button {
            background-color: #b58900; /* Dorado */
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
        }
        button:hover {
            background-color: #cc7a00;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            text-decoration: none;
            color: #b58900;
        }
        a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: red;
            font-weight: bold;
        }
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
    </style>
</head>
<body>

<header>
    <h1>Gestión de Proveedores - Joyería</h1>
</header>

<div class="container">
    <!-- Mostrar mensaje de error -->
    <?php if (isset($error_message)): ?>
        <p class="error-message"><?= $error_message ?></p>
    <?php endif; ?>

    <!-- Formulario de Proveedor -->
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
            <!-- Agregar más países según sea necesario -->
        </select>
        <input type="text" name="telefono" id="telefono" placeholder="xxxx-xxxx" oninput="formatearTelefono()" required><br>
        
        <label>Dirección:</label>
        <input type="text" name="direccion" placeholder="Ej. Col. Palmira, Tegucigalpa, Honduras" required><br>
        
       <script>

// Función para agregar un campo de producto dinámicamente
function agregarProducto() {
  const productoInputs = document.getElementById('producto-inputs');
  
  // Crear el nuevo contenedor para los campos de producto
  const nuevoProducto = document.createElement('div');
  nuevoProducto.classList.add('producto-input');
  
  // Crear los campos de nombre del producto, precio, cantidad, y total
  nuevoProducto.innerHTML = `
      <input type="text" name="producto[]" placeholder="Ej. Anillo de oro" required>
      <input type="number" name="cantidad[]" placeholder="Cantidad" value="1" min="1" oninput="actualizarTotalProducto(this)" required>
      <input type="text" name="precio_display[]" placeholder="Precio unitario" onblur="formatearPrecio(this)" required>
      <input type="hidden" name="precio[]" value="">
      <span>Total: <span class="precio-total">0.00</span></span>
      <button type="button" onclick="eliminarProducto(this)" class="btn-eliminar">-</button>
  `;
  
  // Agregar el nuevo contenedor de producto a la lista de productos
  productoInputs.appendChild(nuevoProducto);

  // Mantener visible el botón "Añadir Producto"
  document.getElementById('btnAñadirProducto').style.display = 'inline-block';

  // Actualizar el total de la venta
  actualizarTotalVenta();
}

// Función para eliminar un producto
function eliminarProducto(button) {
  // Eliminar el contenedor del producto correspondiente
  const productoContenedor = button.parentElement;
  productoContenedor.remove();

  // Volver a mostrar el botón "Añadir Producto" si no hay productos
  if (document.querySelectorAll('.producto-input').length === 0) {
    document.getElementById('btnAñadirProducto').style.display = 'inline-block';
  }

  // Actualizar el total de la venta
  actualizarTotalVenta();
}

// Función para formatear el precio a moneda hondureña
function formatearPrecio(input) {
  let valorLimpio = input.value.replace(/[^\d.]/g, ''); // Limpiar caracteres no numéricos
  let numero = parseFloat(valorLimpio);
  
  if (!isNaN(numero)) {
    // Actualizar el valor oculto (para enviar el precio real)
    let hiddenInput = input.nextElementSibling;
    if (hiddenInput && hiddenInput.type === "hidden") {
      hiddenInput.value = numero;
    }
    
    // Formatear el input visible a moneda hondureña
    input.value = numero.toLocaleString('es-HN', {
      style: 'currency',
      currency: 'HNL',
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });
    
    // Actualizar el total del precio
    actualizarTotalProducto(input);
  }
}

// Función para actualizar el total de cada producto (cantidad * precio)
function actualizarTotalProducto(input) {
  const cantidad = input.parentElement.querySelector('input[name="cantidad[]"]').value;
  const precioUnitario = parseFloat(input.parentElement.querySelector('input[name="precio[]"]').value) || 0;
  const total = cantidad * precioUnitario;

  // Actualizar el total mostrado en la interfaz
  const precioTotal = input.parentElement.querySelector('.precio-total');
  precioTotal.textContent = total.toLocaleString('es-HN', {
    style: 'currency',
    currency: 'HNL',
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  });

  // Actualizar el total de la venta
  actualizarTotalVenta();
}

// Función para actualizar el total de la venta (suma de todos los productos)
function actualizarTotalVenta() {
  let totalVenta = 0;

  // Sumar todos los precios de los productos
  const productos = document.querySelectorAll('.producto-input');
  productos.forEach(producto => {
    const totalProducto = parseFloat(producto.querySelector('.precio-total').textContent.replace(/[^\d.-]/g, '')) || 0;
    totalVenta += totalProducto;
  });

  // Mostrar el total de la venta
  document.getElementById('totalVenta').textContent = totalVenta.toLocaleString('es-HN', {
    style: 'currency',
    currency: 'HNL',
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  });
}


</script>

<style>
  /* Estilo para los productos y el botón de eliminar */
  .producto-input {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
  }

  .producto-input input {
    margin-right: 10px;
  }

  .btn-eliminar {
    background-color: #f44336; /* Color rojo */
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
    color: #4CAF50; /* Verde */
  }

  /* Estilo para el contenedor de productos y total */
  .producto-container {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
  }

  .producto-inputs {
    margin-bottom: 20px;
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

<div class="producto-container">
  <label>Producto(s) y Precio:</label>
  <div id="producto-inputs">
    <div class="producto-input">
      <!-- Aquí se agregarán los productos -->
    </div>
  </div>
  <button type="button" onclick="agregarProducto()" id="btnAñadirProducto">Añadir Producto</button>
<br>
<!-- Contenido adicional como Tipo de pago, método de envío, etc. -->
 
<label>Tipo de pago:</label>
<select name="tipo_pago" id="tipoPago" required onchange="mostrarCamposPago()">
  <option value="Efectivo">Efectivo</option>
  <option value="Tarjeta">Tarjeta</option>
  <option value="Transferencia">Transferencia Bancaria</option>
</select><br>

<!-- Espacios dinámicos para cada tipo de pago -->
<div id="camposTarjeta" style="display: none;">
  <label for="numTarjeta">Número de Tarjeta:</label>
  <input type="text" name="numTarjeta" id="numTarjeta" placeholder="Número de tarjeta" required><br>

  <label for="fechaExp">Fecha de Expiración:</label>
  <input type="text" name="fechaExp" id="fechaExp" placeholder="MM/AA" required><br>

  <label for="cvv">CVV:</label>
  <input type="text" name="cvv" id="cvv" placeholder="CVV" required><br>
</div>

<div id="camposTransferencia" style="display: none;">
  <p><strong>Cuentas Bancarias Ficticias:</strong></p>
  <ul>
    <li><strong>Banco Atlántida</strong>: 123-456-7890</li>
    <li><strong>BAC Credomatic</strong>: 987-654-3210</li>
    <li><strong>Ficohsa</strong>: 555-666-7777</li>
  </ul>

  <label for="numReferencia">Número de Referencia:</label>
  <input type="text" name="numReferencia" id="numReferencia" placeholder="Número de referencia" required><br>

  <label for="comprobanteDeposito">Comprobante de Depósito:</label>
  <input type="file" name="comprobanteDeposito" id="comprobanteDeposito" required><br>
</div>

<label>Método de envío:</label>
<select name="envio" required>
  <option value="Envío estándar">Envío estándar</option>
  <option value="Envío exprés">Envío exprés</option>
  <option value="Recogida en tienda">Recogida en tienda</option>
</select><br>

<button type="submit" name="add">Agregar Proveedor</button>

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
  // Función para formatear el teléfono (sin cambios)
  function formatearTelefono() {
    const telefonoInput = document.getElementById('telefono');
    const codigoPais = document.getElementById('codigo_pais').value;
    let telefono = telefonoInput.value.replace(/[^\d]/g, '');
    if (codigoPais === "+504" && telefono.length > 4) {
      telefono = telefono.replace(/(\d{4})(\d{4})/, '$1-$2');
    } else if (codigoPais === "+1" && telefono.length > 6) {
      telefono = telefono.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
    } else if (codigoPais === "+52" && telefono.length > 4) {
      telefono = telefono.replace(/(\d{4})(\d{4})/, '$1-$2');
    }
    telefonoInput.value = telefono;
  }

  // Función para formatear el precio a moneda hondureña al perder el foco
  function formatearPrecio(input) {
    let valorLimpio = input.value.replace(/[^\d.]/g, ''); // Limpiar caracteres no numéricos
    let numero = parseFloat(valorLimpio);
    
    if (!isNaN(numero)) {
      // Actualizar el valor oculto (para enviar el precio real)
      let hiddenInput = input.nextElementSibling;
      if (hiddenInput && hiddenInput.type === "hidden") {
        hiddenInput.value = numero;
      }
      
      // Formatear el input visible a moneda hondureña
      input.value = numero.toLocaleString('es-HN', {
        style: 'currency',
        currency: 'HNL',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });
    }
  }

  // Función para mostrar los campos de pago dinámicamente según la selección
  function mostrarCamposPago() {
    const tipoPago = document.getElementById('tipoPago').value;
    
    // Ocultar todos los campos
    document.getElementById('camposTarjeta').style.display = 'none';
    document.getElementById('camposTransferencia').style.display = 'none';

    // Mostrar solo los campos correspondientes al tipo de pago seleccionado
    if (tipoPago === 'Tarjeta') {
      document.getElementById('camposTarjeta').style.display = 'block';
    } else if (tipoPago === 'Transferencia') {
      document.getElementById('camposTransferencia').style.display = 'block';
    }
  }

  // Llamar a la función al cargar la página para asegurarse de que los campos estén bien inicializados
  document.addEventListener('DOMContentLoaded', mostrarCamposPago);
</script>


</body>
</html>