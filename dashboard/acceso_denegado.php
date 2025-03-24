<?php
// Iniciar sesión si no está iniciada
session_start();

// Asegurarse de que hay una sesión activa
if (!isset($_SESSION['id']) || !isset($_SESSION['idRol'])) {
    // Si no hay sesión activa, redirigir al login
    header("Location: login.php");
    exit();
}

// Definición de roles (debe coincidir con privilegios.php)
define('ROL_ADMIN', 1);    // Rol de administrador
define('ROL_VENDEDOR', 2); // Rol de vendedor
define('ROL_CLIENTE', 3);  // Rol de cliente

// Función para determinar la página de inicio según el rol
function paginaInicio($rol) {
    switch ($rol) {
        case ROL_ADMIN:
            return "admin.php";
        case ROL_VENDEDOR:
            return "vendedor.php";
        case ROL_CLIENTE:
            return "../index.php";
        default:
            return "../index.php";
    }
}

$rol_usuario = $_SESSION['idRol']; // Rol del usuario
$nombre_usuario = $_SESSION['nombre']; // Nombre del usuario
$pagina_inicio = paginaInicio($rol_usuario); // Obtener página de inicio según rol
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Acceso denegado" />
    <meta name="author" content="Imperial Gems" />
    <title>Acceso Denegado - Imperial Gems</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        .error-container {
            text-align: center;
            padding: 50px 0;
        }
        .error-icon {
            font-size: 5rem;
            color: #dc3545;
            margin-bottom: 20px;
        }
        .countdown {
            font-weight: bold;
            color: #dc3545;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header bg-danger text-white">
                        <h3 class="text-center font-weight-light my-2">Acceso Denegado</h3>
                    </div>
                    <div class="card-body">
                        <div class="error-container">
                            <div class="error-icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <h2>No tienes permiso para acceder a esta página</h2>
                            <p class="mb-4">Lo sentimos, pero no tienes los privilegios necesarios para acceder a este recurso.</p>
                            
                            <?php if(isset($_SESSION['id'])): ?>
                                <p>Serás redirigido a tu página principal en <span id="countdown" class="countdown">5</span> segundos.</p>
                                <div class="mt-3">
                                    <a href="<?php 
                                    if(isset($_SESSION['idRol']) && $_SESSION['idRol'] == 1) {
                                        echo 'principal.php';
                                    } else if(isset($_SESSION['idRol']) && $_SESSION['idRol'] == 2) {
                                        echo 'principal.php';
                                    } else {
                                        echo '../index.php';
                                    }
                                    ?>" class="btn btn-primary">Ir a página principal</a>
                                </div>
                            <?php else: ?>
                                <p>Debes iniciar sesión para acceder al sistema.</p>
                                <div class="mt-3">
                                    <a href="login.php" class="btn btn-primary">Iniciar Sesión</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-footer text-center py-3">
                        <div class="small"><a href="../index.php">Regresar a la página principal</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php if(isset($_SESSION['id'])): ?>
    <script>
        // Cuenta regresiva y redirección
        let tiempoRestante = 5;
        const intervalo = setInterval(() => {
            tiempoRestante--;
            document.getElementById('countdown').textContent = tiempoRestante;
            
            if (tiempoRestante <= 0) {
                clearInterval(intervalo);
                window.location.href = '<?php 
                    if(isset($_SESSION['idRol']) && $_SESSION['idRol'] == 1) {
                        echo 'principal.php';
                    } else if(isset($_SESSION['idRol']) && $_SESSION['idRol'] == 2) {
                        echo 'principal.php';
                    } else {
                        echo '../index.php';
                    }
                ?>';
            }
        }, 1000);
    </script>
    <?php endif; ?>
</body>
</html> 