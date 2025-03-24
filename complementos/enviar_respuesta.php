<?php
require_once '../confi/conexion.php';
require '../confi/PHPMailer.php';
require '../confi/SMTP.php';
require '../confi/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'], $_POST['email'], $_POST['respuesta'])) {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $respuesta = $_POST['respuesta'];

    // Obtener el mensaje original del usuario
    $stmt = $pdo->prepare("SELECT mensaje FROM contactos WHERE id = ?");
    $stmt->execute([$id]);
    $mensajeOriginal = $stmt->fetchColumn();

    if ($mensajeOriginal) {
        // Enviar correo de respuesta
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
            $mail->Subject = 'Respuesta a tu mensaje';
            $mail->Body = "
                Estimado usuario,<br><br>
                Gracias por contactarnos. Aquí está nuestra respuesta a tu mensaje:<br><br>
                <b>Tu mensaje:</b><br>
                $mensajeOriginal<br><br>
                <b>Nuestra respuesta:</b><br>
                $respuesta<br><br>
                Saludos,<br>
                Imperial Gems
            ";

            $mail->send();
            echo "<script>alert('Respuesta enviada correctamente.'); window.location.href = 'tabla_mensajes.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Error al enviar la respuesta: {$mail->ErrorInfo}'); window.location.href = 'tabla_mensajes.php';</script>";
        }
    } else {
        echo "<script>alert('No se encontró el mensaje original.'); window.location.href = 'tabla_mensajes.php';</script>";
    }
} else {
    echo "<script>alert('Datos incompletos.'); window.location.href = 'tabla_mensajes.php';</script>";
}
?>
