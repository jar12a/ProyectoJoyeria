<?php
// Script de prueba para envío de correos
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cargar las clases de PHPMailer
require 'confi/PHPMailer.php';
require 'confi/SMTP.php';
require 'confi/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Función para log
function logMessage($message) {
    echo $message . "<br>";
    
    // También guardar en archivo
    $logDir = 'logs';
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    $logFile = $logDir . '/test_email.log';
    file_put_contents($logFile, date('Y-m-d H:i:s') . " - " . $message . PHP_EOL, FILE_APPEND);
}

// Verificar si se envió el formulario
if (isset($_POST['email'])) {
    $testEmail = $_POST['email'];
    $method = $_POST['method'] ?? 'phpmailer';
    
    logMessage("Iniciando prueba de envío a: $testEmail usando método: $method");
    
    // Información del servidor y credenciales
    $smtp_host = 'smtp.gmail.com';
    $smtp_username = 'imperialgems057@gmail.com';
    $smtp_password = $_POST['password'];
    $smtp_port = 587;
    $smtp_secure = 'tls';
    
    if ($method == 'phpmailer') {
        // Método 1: PHPMailer
        try {
            $mail = new PHPMailer(true);
            
            // Habilitar debug
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->Debugoutput = function($str, $level) {
                logMessage("Debug: $str");
            };
            
            // Configuración del servidor
            $mail->isSMTP();
            $mail->Host = $smtp_host;
            $mail->SMTPAuth = true;
            $mail->Username = $smtp_username;
            $mail->Password = $smtp_password;
            $mail->SMTPSecure = $smtp_secure;
            $mail->Port = $smtp_port;
            $mail->CharSet = 'UTF-8';
            
            // Opciones adicionales para TLS
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            
            // Remitente y destinatario
            $mail->setFrom($smtp_username, 'Imperial Gems Test');
            $mail->addAddress($testEmail);
            
            // Contenido
            $mail->isHTML(true);
            $mail->Subject = 'Prueba de correo desde Imperial Gems';
            $mail->Body = '
                <div style="font-family: Arial, sans-serif; padding: 20px;">
                    <h2>Prueba de Correo Electrónico</h2>
                    <p>Este es un mensaje de prueba enviado a las ' . date('H:i:s') . '</p>
                    <p>Si estás viendo esto, el sistema de correo funciona correctamente.</p>
                </div>';
            
            // Enviar correo
            $result = $mail->send();
            logMessage("Resultado PHPMailer: " . ($result ? "Éxito" : "Fallo"));
            
        } catch (Exception $e) {
            logMessage("Error PHPMailer: " . $e->getMessage());
        }
    } else if ($method == 'mail') {
        // Método 2: PHP mail() nativo
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: Imperial Gems Test <$smtp_username>" . "\r\n";
        
        $subject = 'Prueba de correo (mail nativo) desde Imperial Gems';
        $message = '
            <div style="font-family: Arial, sans-serif; padding: 20px;">
                <h2>Prueba de Correo Electrónico (mail nativo)</h2>
                <p>Este es un mensaje de prueba enviado a las ' . date('H:i:s') . '</p>
                <p>Si estás viendo esto, el sistema de correo funciona correctamente.</p>
            </div>';
        
        $result = mail($testEmail, $subject, $message, $headers);
        logMessage("Resultado mail() nativo: " . ($result ? "Éxito" : "Fallo"));
    }
    
    // Mostrar un mensaje de confirmación
    echo '<div style="background-color: #f8f9fa; padding: 20px; margin-top: 20px; border-radius: 5px;">';
    echo '<h3>Prueba completada</h3>';
    echo '<p>Por favor, verifica tu bandeja de entrada (y carpeta de spam) para ver si el mensaje llegó.</p>';
    echo '<p><a href="test_email.php">Volver al formulario de prueba</a></p>';
    echo '</div>';
    
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba de Envío de Correo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .test-container { background-color: white; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="test-container p-4 p-md-5">
            <h1 class="text-center mb-4">Prueba de Envío de Correo</h1>
            
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i> Esta herramienta te ayudará a diagnosticar problemas con el envío de correos electrónicos.
            </div>
            
            <form method="post" action="">
                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico de destino:</label>
                    <input type="email" class="form-control" id="email" name="email" required 
                           placeholder="Ingresa tu dirección de correo electrónico">
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña de aplicación de Gmail:</label>
                    <input type="password" class="form-control" id="password" name="password" required 
                           value="xdjs xfjy csuf iatd" placeholder="Contraseña de aplicación de Gmail">
                    <div class="form-text">
                        La contraseña actual es: <code>xdjs xfjy csuf iatd</code>. Cámbiala si has generado una nueva.
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label d-block">Método de envío:</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="method" id="phpmailer" value="phpmailer" checked>
                        <label class="form-check-label" for="phpmailer">PHPMailer (SMTP)</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="method" id="mail" value="mail">
                        <label class="form-check-label" for="mail">PHP mail() nativo</label>
                    </div>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-paper-plane me-2"></i> Enviar correo de prueba
                    </button>
                </div>
            </form>
            
            <div class="mt-4">
                <h5>Información de diagnóstico:</h5>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        PHP Version
                        <span class="badge bg-primary rounded-pill"><?php echo phpversion(); ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        OpenSSL
                        <span class="badge bg-<?php echo extension_loaded('openssl') ? 'success' : 'danger'; ?> rounded-pill">
                            <?php echo extension_loaded('openssl') ? 'Habilitado' : 'No disponible'; ?>
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        mail() function
                        <span class="badge bg-<?php echo function_exists('mail') ? 'success' : 'danger'; ?> rounded-pill">
                            <?php echo function_exists('mail') ? 'Disponible' : 'No disponible'; ?>
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        SMTP Host
                        <span>smtp.gmail.com:587</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Remitente
                        <span>imperialgems057@gmail.com</span>
                    </li>
                </ul>
                
                <div class="alert alert-warning">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i> Posibles problemas y soluciones:</h6>
                    <ol class="mb-0">
                        <li>La contraseña de aplicación de Gmail ha expirado. <a href="https://myaccount.google.com/apppasswords" target="_blank">Generar una nueva</a>.</li>
                        <li>El servidor de correo bloquea las conexiones salientes por el puerto 587.</li>
                        <li>Gmail ha bloqueado el envío por considerar el intento como "menos seguro".</li>
                        <li>Problemas con las extensiones de PHP necesarias para el envío de correos.</li>
                    </ol>
                </div>
                
                <div class="mt-3 text-center">
                    <a href="dashboard/login.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Volver al login
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 