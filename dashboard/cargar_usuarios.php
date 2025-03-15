<?php
include "../confi/conexion.php"; // Asegúrate de que la ruta es correcta

// Verificar si los datos existen antes de procesarlos
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    // Obtener los datos del formulario para actualizar el usuario
    $id = $_POST['id'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password']; // La contraseña se encriptará en sha1
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];

    // Verificar si la contraseña ha sido modificada
    if (empty($password)) {
        // Si no se modificó la contraseña, usamos la contraseña actual (no la cambiamos)
        $updateQuery = "UPDATE usuario SET 
                            usuario = :usuario, 
                            nombre = :nombre, 
                            telefono = :telefono, 
                            direccion = :direccion, 
                            correo = :correo, 
                            idRol = (SELECT id FROM rol WHERE Rol = :rol) 
                        WHERE id = :id";
    } else {
        // Si la contraseña ha sido modificada, la encriptamos y la actualizamos
        $hashedPassword = sha1($password);
        $updateQuery = "UPDATE usuario SET 
                            usuario = :usuario, 
                            password = :password, 
                            nombre = :nombre, 
                            telefono = :telefono, 
                            direccion = :direccion, 
                            correo = :correo, 
                            idRol = (SELECT id FROM rol WHERE Rol = :rol) 
                        WHERE id = :id";
    }

    try {
        $stmt = $pdo->prepare($updateQuery);
        $params = [
            ':id' => $id,
            ':usuario' => $usuario,
            ':nombre' => $nombre,
            ':telefono' => $telefono,
            ':direccion' => $direccion,
            ':correo' => $correo,
            ':rol' => $rol
        ];

        if (!empty($password)) {
            // Si la contraseña fue modificada, añadirla a los parámetros
            $params[':password'] = $hashedPassword;
        }

        $stmt->execute($params);

        // Redirigir o devolver una respuesta de éxito
        echo 'success';  // Este es un ejemplo, podrías enviar algún mensaje o redirigir

    } catch (PDOException $e) {
        // En caso de error, devolver un mensaje de error
        echo 'error';
    }
}
?>