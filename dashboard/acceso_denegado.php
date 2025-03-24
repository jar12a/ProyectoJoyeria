<?php
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
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Acceso Denegado - Imperial Gems</title>
    <link href="css/styles_dashboard" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <?php include '../complementos/head.php'; ?>
</head>
<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header bg-danger text-white">
                                    <h3 class="text-center font-weight-light my-4">
                                        <i class="fas fa-exclamation-triangle me-2"></i>Acceso Denegado
                                    </h3>
                                </div>
                                <div class="card-body text-center">
                                    <div class="mb-4">
                                        <img src="https://media.giphy.com/media/3h2AeAOj83j7slRkyW/giphy.gif" alt="Acceso Denegado" style="width: 150px; height: auto;">
                                    </div>
                                    <h4>Lo sentimos, <?php echo htmlspecialchars($nombre_usuario); ?></h4>
                                    <p class="lead">No tienes permiso para acceder a esta página.</p>
                                    <p>Por favor, regresa a la página principal correspondiente a tu rol.</p>
                                    <div class="mt-4">
                                        <a href="<?php echo htmlspecialchars($pagina_inicio); ?>" class="btn btn-primary">
                                            <i class="fas fa-home me-2"></i>Ir a mi página principal
                                        </a>
                                    </div>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small">
                                        Si crees que esto es un error, por favor contacta al administrador.
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
                        <div class="text-muted">Copyright &copy; Imperial Gems 2024</div>
                        <div>
                            <a href="#">Políticas de Privacidad</a>
                            &middot;
                            <a href="#">Términos &amp; Condiciones</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>
</html> 