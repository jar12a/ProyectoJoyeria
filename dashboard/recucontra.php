<?php
require_once '../confi/conexion.php';
require '../confi/PHPMailer.php';
require '../confi/SMTP.php';
require '../confi/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$email = $_GET['email'] ?? '';
$codigo = $_GET['codigo'] ?? '';
$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['password'])) {
    $password = $_POST['password'];

    // Verificar el código
    $stmt = $pdo->prepare("SELECT id FROM usuario WHERE correo = ? AND token = ?");
    $stmt->execute([$email, $codigo]);
    $user = $stmt->fetch();

    if ($user) {
        // Actualizar la contraseña
        $passwordHash = SHA1($password);
        $stmt = $pdo->prepare("UPDATE usuario SET password = ?, token = NULL WHERE correo = ?");
        $stmt->execute([$passwordHash, $email]);
        $success_message = "Contraseña actualizada correctamente.";

        // Enviar correo de confirmación
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'imperialgems057@gmail.com'; // Cambia esto por tu correo
            $mail->Password = 'xdjs xfjy csuf iatd'; // Cambia esto por tu contraseña de aplicación
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('imperialgems057@gmail.com', 'Imperial Gems');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Confirmación de cambio de contraseña';
            $mail->Body = "Estimado usuario,<br><br>Su contraseña ha sido actualizada correctamente.<br><br>Si no realizó este cambio, por favor contacte con nuestro soporte inmediatamente.<br><br>Saludos,<br>Imperial Gems";

            $mail->send();
        } catch (Exception $e) {
            $error_message = "Error al enviar el correo de confirmación: {$mail->ErrorInfo}";
        }

        // Redirigir al login
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'login.php';
                }, 2000);
              </script>";
    } else {
        $error_message = "Código inválido.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Restablecer Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function validarContraseñas() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const errorDiv = document.getElementById('passwordError');

            if (password !== confirmPassword) {
                errorDiv.textContent = "Las contraseñas no coinciden.";
                return false;
            } else if (password.length < 8) {
                errorDiv.textContent = "La contraseña debe tener al menos 8 caracteres.";
                return false;
            } else {
                errorDiv.textContent = "";
                return true;
            }
        }

        function actualizarContador() {
            const passwordInput = document.getElementById('password');
            const counter = document.getElementById('passwordCounter');
            counter.textContent = `${passwordInput.value.length}/8 caracteres`;
        }
    </script>
</head>
<body class="bg-primary d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="card shadow-lg border-0 rounded-lg" style="width: 400px;">
        <div class="card-header text-center">
            <h3 class="font-weight-light">Restablecer Contraseña</h3>
        </div>
        <div class="card-body">
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php elseif (!empty($success_message)): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php endif; ?>
            <form action="recucontra.php?email=<?php echo urlencode($email); ?>&codigo=<?php echo urlencode($codigo); ?>" method="POST" onsubmit="return validarContraseñas();">
                <div class="form-floating mb-3">
                    <input class="form-control" id="password" name="password" type="password" placeholder="Nueva contraseña" required minlength="8" oninput="actualizarContador()" />
                    <label for="password">Nueva Contraseña</label>
                    <small id="passwordCounter" class="form-text text-muted">0/8 caracteres</small>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" id="confirmPassword" name="confirmPassword" type="password" placeholder="Confirmar contraseña" required />
                    <label for="confirmPassword">Confirmar Contraseña</label>
                </div>
                <div id="passwordError" class="text-danger mb-3"></div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
                </div>
            </form>
        </div>
        <div class="card-footer text-center">
            <small class="text-muted">Ingrese y confirme su nueva contraseña.</small>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
