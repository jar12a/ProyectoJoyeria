<?php 
session_start();

// Definir el tiempo de inactividad (30 segundos para dar tiempo al usuario)
$tiempo_inactividad = 30;

if (isset($_SESSION['LAST_ACTIVITY'])) {
    $tiempo_transcurrido = time() - $_SESSION['LAST_ACTIVITY'];

    if ($tiempo_transcurrido > $tiempo_inactividad) {
        session_unset();
        session_destroy();
        header("Location: logout.php");
        exit();
    }
}

$_SESSION['LAST_ACTIVITY'] = time();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema con Auto Logout</title>
    
</head>
<body>



</body>
</html>