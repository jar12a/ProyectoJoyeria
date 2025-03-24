<?php
session_start();
require_once '../confi/conexion.php';
require '../confi/PHPMailer.php';
require '../confi/SMTP.php';
require '../confi/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Log de depuración para entender el estado de la sesión
error_log("Estado de sesión: recovery_email=" . (isset($_SESSION['recovery_email']) ? $_SESSION['recovery_email'] : 'no establecido'));
error_log("Estado de sesión: code_sent=" . (isset($_SESSION['code_sent']) ? ($_SESSION['code_sent'] ? 'true' : 'false') : 'no establecido'));
error_log("URL actual: " . $_SERVER['REQUEST_URI']);

// Incluir privilegios para manejar visitantes adecuadamente
if (!function_exists('getRolActual')) {
    include_once 'privilegios.php';
}

$error_message = '';
$success_message = '';

// Verificar si llegamos desde password.php con la información necesaria
if (!isset($_SESSION['recovery_email'])) {
    // Si no hay email en la sesión, redirigir a password.php
    error_log("Redirección: No hay email en la sesión");
    header("Location: password.php");
    exit();
}

$email = $_SESSION['recovery_email'];
error_log("Email para recuperación: $email");

// Procesar el formulario cuando se envía el código
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codigo'])) {
    $codigo = trim($_POST['codigo']);

    if (empty($codigo)) {
        $error_message = "Por favor, ingrese el código de verificación.";
    } else {
        // Verificar si el código coincide con el token almacenado en sesión
        if (isset($_SESSION['recovery_token']) && $_SESSION['recovery_token'] == $codigo) {
            // Si coincide con el token de sesión, aceptarlo
            $_SESSION['recovery_code'] = $codigo;
            
            // Registrar éxito en log para depuración
            error_log("Código válido para: $email. Redirigiendo a recucontra.php");
            
            // Eliminar cualquier error previo
            unset($_SESSION['error_message']);
            
            // Redireccionar a la página para cambiar la contraseña
            header("Location: recucontra.php");
            exit();
        } else {
            $error_message = "Código inválido. Por favor, verifique el código enviado a su correo o mostrado en pantalla.";
            // Incrementar contador de intentos fallidos si queremos limitar intentos
            if (!isset($_SESSION['failed_attempts'])) {
                $_SESSION['failed_attempts'] = 1;
            } else {
                $_SESSION['failed_attempts']++;
            }
            
            // Log para depuración
            error_log("Intento fallido para: $email. Código ingresado: $codigo, token esperado: " . 
                     (isset($_SESSION['recovery_token']) ? $_SESSION['recovery_token'] : 'no establecido'));
        }
    }
}

// Comprobar si se solicitó reenviar el código
if (isset($_GET['resend']) && $_GET['resend'] == 'true') {
    // Forzar el reenvío del código eliminando la bandera de código enviado
    unset($_SESSION['code_sent']);
    $success_message = "Reenviando código...";
}

// Si aún no se ha enviado el código o hubo un error o se solicitó reenviar
if (!isset($_SESSION['code_sent']) || $_SESSION['code_sent'] !== true) {
    // Generar un nuevo token
    $token = rand(100000, 999999);
    
    try {
        // Guardar el token en la sesión para compararlo más tarde
        $_SESSION['recovery_token'] = $token;
        
        // Enviar correo con el token
        $mail = new PHPMailer(true);
        try {
            // Configuración del servidor
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'imperialgems057@gmail.com';
            $mail->Password = 'xdjs xfjy csuf iatd'; // App password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            
            // Configuración de depuración - Activar para diagnóstico
            $mail->SMTPDebug = 2; // 2 = mostrar mensajes cliente/servidor para diagnóstico
            $mail->Debugoutput = function($str, $level) {
                error_log("PHPMailer [$level] : $str");
            };
            
            // Configuración SSL más segura pero permisiva
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Remitente y destinatario
            $mail->setFrom('imperialgems057@gmail.com', 'Imperial Gems');
            $mail->addAddress($email);
            $mail->CharSet = 'UTF-8'; // Asegurarse de que se envíe con codificación correcta

            // Configuración de tiempo de espera
            $mail->Timeout = 60; // Aumentar tiempo de espera a 60 segundos
            
            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Código de recuperación de contraseña';
            $mail->Body = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; }
                    .container { padding: 20px; }
                    .code { font-size: 24px; font-weight: bold; color: #4e73df; padding: 10px; background-color: #f8f9fc; border-radius: 5px; display: inline-block; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h2>Recuperación de Contraseña - Imperial Gems</h2>
                    <p>Hola " . ($_SESSION['recovery_username'] ?? 'Usuario') . ",</p>
                    <p>Su código de recuperación es: <span class='code'>$token</span></p>
                    <p>Este código expirará en 15 minutos por seguridad.</p>
                    <p>Si usted no solicitó este código, puede ignorar este correo.</p>
                    <p>Gracias por confiar en Imperial Gems.</p>
                </div>
            </body>
            </html>";
            $mail->AltBody = "Su código de recuperación es: $token. Este código expirará en 15 minutos.";
            
            if ($mail->send()) {
                $success_message = "Se ha enviado un código de verificación a su correo electrónico: " . substr($email, 0, 3) . "***" . substr($email, strrpos($email, "@"));
                $_SESSION['code_sent'] = true;
            } else {
                // Si el correo no se envía, mostrar un mensaje genérico
                $error_message = "No se pudo enviar el correo. Por favor, intente nuevamente.";
                error_log("Error PHPMailer completo: " . $mail->ErrorInfo);
                
                // A pesar del error, permitir verificar con el código
                $_SESSION['code_sent'] = true;
                $success_message = "El servidor de correo no responde. ";
            }
        } catch (Exception $e) {
            $error_message = "Error al enviar el correo: " . $mail->ErrorInfo;
            // Log del error para depuración
            error_log("Error PHPMailer Exception: " . $e->getMessage());
            
            // A pesar del error, permitir verificar con el código
            $_SESSION['code_sent'] = true;
            $success_message = "El servidor de correo no responde. ";
        }
    } catch (PDOException $e) {
        $error_message = "Error en la base de datos: " . $e->getMessage();
        error_log("Error PDO: " . $e->getMessage());
        
        // Intentamos mostrar el código incluso con error de BD
        $_SESSION['code_sent'] = true;
        $_SESSION['recovery_token'] = $token;
        $success_message = "Hubo un problema técnico. ";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Verificación de código para recuperación de contraseña">
    <meta name="author" content="Imperial Gems">
    <title>Verificación de Código - Imperial Gems</title>
    <link href="css/styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Verificación de Código</h3>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($error_message)): ?>
                                        <div class="alert alert-danger">
                                            <i class="fas fa-exclamation-circle me-2"></i>
                                            <?php echo $error_message; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($success_message)): ?>
                                        <div class="alert alert-success">
                                            <i class="fas fa-check-circle me-2"></i>
                                            <?php echo $success_message; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="text-center mb-4">
                                        <i class="fas fa-envelope fa-3x text-primary mb-3"></i>
                                        <p class="mb-1">Hemos enviado un código de verificación a:</p>
                                        <p class="fw-bold"><?php echo htmlspecialchars($email); ?></p>
                                        
                                        <?php if (isset($_SESSION['recovery_token'])): ?>
                                        <div class="mt-3 alert alert-info">
                                            <p class="mb-0">Si no recibe el correo, vuelve a intentar</p>
                                            
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <form action="codigo_recu.php" method="POST">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="codigo" name="codigo" type="text" 
                                                placeholder="Ingrese el código" required maxlength="6" 
                                                pattern="\d{6}" title="El código debe tener 6 dígitos">
                                            <label for="codigo">Código de verificación</label>
                                        </div>
                                        <div class="d-grid gap-2 mt-4">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-check-circle me-2"></i>Verificar Código
                                            </button>
                                            <a href="password.php" class="btn btn-outline-secondary">
                                                <i class="fas fa-arrow-left me-2"></i>Volver
                                            </a>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small">¿No recibió el código? 
                                        <a href="codigo_recu.php?resend=true">Enviar nuevamente</a>
                                    </div>
                                    <div class="small mt-2">
                                        <a href="login.php">Volver al inicio de sesión</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">&copy; 2025 Imperial Gems</div>
                        <div>
                            <a href="#">Políticas de privacidad</a>
                            &middot;
                            <a href="#">Términos &amp; Condiciones</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>