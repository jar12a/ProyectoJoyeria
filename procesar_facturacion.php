<?php
require_once 'conexion.php';

session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['ID_Usuario'])) {
    header('Location: login.html');
    exit();
}

class Facturacion {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function crearPedido($usuario_id, $total) {
        try {
            $this->pdo->beginTransaction();
            
            // Insertar el pedido
            $sql = "INSERT INTO pedido (Fecha, Total, ID_Usuario) VALUES (NOW(), :total, :usuario_id)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':total' => $total,
                ':usuario_id' => $usuario_id
            ]);
            
            $pedido_id = $this->pdo->lastInsertId();
            
            // Insertar los detalles del pedido
            foreach ($_SESSION['carrito'] as $producto) {
                $sql = "INSERT INTO detalle_pedido (ID_Pedido, ID_Producto, Cantidad, Subtotal, Total) 
                        VALUES (:pedido_id, :producto_id, :cantidad, :subtotal, :total)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                    ':pedido_id' => $pedido_id,
                    ':producto_id' => $producto['id'],
                    ':cantidad' => $producto['cantidad'],
                    ':subtotal' => $producto['precio'] * $producto['cantidad'],
                    ':total' => ($producto['precio'] * $producto['cantidad']) * 1.15 // Incluyendo impuestos
                ]);
                
                // Actualizar el stock
                $sql = "UPDATE producto SET Stock = Stock - :cantidad WHERE ID_Producto = :producto_id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                    ':cantidad' => $producto['cantidad'],
                    ':producto_id' => $producto['id']
                ]);
            }
            
            $this->pdo->commit();
            return true;
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }
    
    public function procesarPago($metodo_pago, $total) {
        // Aquí iría la lógica de procesamiento de pago según el método seleccionado
        switch ($metodo_pago) {
            case 'tarjeta':
                // Integración con pasarela de pago para tarjetas
                break;
            case 'paypal':
                // Integración con PayPal
                break;
            case 'transferencia':
                // Generar información de transferencia
                break;
        }
    }
}

// Procesar el formulario de facturación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $facturacion = new Facturacion($pdo);
    
    $total = $_POST['total'];
    $metodo_pago = $_POST['metodo_pago'];
    
    // Procesar el pago
    if ($facturacion->procesarPago($metodo_pago, $total)) {
        // Crear el pedido
        if ($facturacion->crearPedido($_SESSION['ID_Usuario'], $total)) {
            // Limpiar el carrito
            unset($_SESSION['carrito']);
            
            // Redireccionar a página de confirmación
            header('Location: confirmacion.html');
            exit();
        }
    }
    
    // Si algo falla, redireccionar con error
    header('Location: facturacion.html?error=1');
    exit();
}
?>