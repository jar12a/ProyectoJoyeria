<?php

// Configuración de la base de datos
$host = 'localhost';  // Dirección del servidor de base de datos
$dbname = 'sistema_gestion';  // Nombre de la base de datos
$username = 'root';  // Usuario de la base de datos
$password = "";  // Contraseña del usuario

// Crear la cadena de conexión (DSN)
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

// Intentar establecer la conexión
try {
    // Crear una instancia de PDO para la conexión
    $pdo = new PDO($dsn, $username, $password);
    
    // Configurar PDO para lanzar excepciones en caso de error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si hay un error de conexión, mostrarlo
    die("Error al conectar con la base de datos: " . $e->getMessage());
}

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si los campos existen en $_POST
    if (isset($_POST['usuario'], $_POST['nombre'], $_POST['correo'], $_POST['password'], $_POST['passwordConfirm'])) {
        // Recibir los datos del formulario
        $usuario = $_POST['usuario'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $password = $_POST['password'];
        $passwordConfirm = $_POST['passwordConfirm'];

        // Verificar que las contraseñas coincidan
        if ($password !== $passwordConfirm) {
            echo "Las contraseñas no coinciden.";
        } else {
            // Verificar si el usuario o correo ya existen
            $stmt = $pdo->prepare("SELECT id, usuario, correo FROM usuario WHERE usuario = ? OR correo = ?");
            $stmt->execute([$usuario, $correo]);
            $existingUser = $stmt->fetch();

            if ($existingUser) {
                // Si el usuario o correo existe, determinar cuál
                if ($existingUser['usuario'] == $usuario) {
                    echo "El usuario ya existe.";
                } elseif ($existingUser['correo'] == $correo) {
                    echo "El correo ya existe.";
                }
            } else {
                // Encriptar la contraseña
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                // Definir idRol como 4
                $idRol = 4;

                // Preparar la consulta SQL para insertar los datos
                $sql = "INSERT INTO usuario (usuario, password, nombre, idRol, correo) VALUES (?, ?, ?, ?, ?)";

                // Preparar la declaración
                $stmt = $pdo->prepare($sql);

                // Ejecutar la declaración con los valores recibidos
                try {
                    $stmt->execute([$usuario, $passwordHash, $nombre, $idRol, $correo]);
                    header("Location: login.php");
                    exit; // Asegura que el script se detenga después de la redirección
                } catch (PDOException $e) {
                    echo "Error al registrar el usuario: " . $e->getMessage();
                }
            }
        }
    } else {
        echo "Por favor, complete todos los campos.";
    }
}
?>
