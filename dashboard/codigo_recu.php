<?php
require_once '../confi/conexion.php';
require '../confi/PHPMailer.php';
require '../confi/SMTP.php';
require '../confi/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$email = $_GET['email'] ?? '';
$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codigo'], $_POST['email'])) {
    $codigo = trim($_POST['codigo']);
    $email = trim($_POST['email']);

    // Verificar si el código es válido
    $stmt = $pdo->prepare("SELECT id FROM usuario WHERE correo = ? AND token = ?");
    $stmt->execute([$email, $codigo]);
    $user = $stmt->fetch();

    if ($user) {
        // Redirigir a la página para cambiar la contraseña
        header("Location: recucontra.php?email=" . urlencode($email) . "&codigo=" . urlencode($codigo));
        exit();
    } else {
        $error_message = "Código inválido. Por favor, verifica el código enviado a tu correo.";
    }
}

if ($email && empty($error_message)) {
    // Generar y guardar el token
    $token = rand(100000, 999999);
    $stmt = $pdo->prepare("UPDATE usuario SET token = ? WHERE correo = ?");
    $stmt->execute([$token, $email]);

    // Enviar el correo con el token
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'imperialgems057@gmail.com';
        $mail->Password = 'xdjs xfjy csuf iatd';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('imperialgems057@gmail.com', 'Imperial Gems');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Código de recuperación de contraseña';
        $mail->Body = "Su código de recuperación es: <b>$token</b>";

        $mail->send();
        $success_message = "Código enviado al correo.";
    } catch (Exception $e) {
        $error_message = "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Código de Recuperación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-primary d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="card shadow-lg border-0 rounded-lg" style="width: 400px;">
        <div class="card-header text-center">
            <h3 class="font-weight-light">Código de Recuperación</h3>
        </div>
        <div class="card-body">
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php elseif (!empty($success_message)): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php endif; ?>
            <form action="codigo_recu.php" method="POST">
                <div class="form-floating mb-3">
                    <input class="form-control" id="codigo" name="codigo" type="text" placeholder="Ingrese el código" required />
                    <label for="codigo">Código de verificación</label>
                </div>
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>" />
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Verificar Código</button>
                </div>
            </form>
        </div>
        <div class="card-footer text-center">
            <small class="text-muted">Ingrese el código enviado a su correo.</small>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
