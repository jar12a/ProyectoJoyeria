<?php
require_once 'config.php';

class Database {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    // Función para obtener productos
    public function getProducts($limit = 10) {
        $query = "SELECT * FROM Producto LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Función para obtener categorías
    public function getCategories() {
        $query = "SELECT * FROM Categoría";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Función para insertar un nuevo usuario
    public function registerUser($nombre, $correo, $contrasena, $telefono = null, $direccion = null) {
        // Hashear la contraseña
        $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);
        
        // Insertar en tabla Login
        $login_query = "INSERT INTO Login (Correo, Contraseña) VALUES (?, ?)";
        $login_stmt = $this->conn->prepare($login_query);
        $login_stmt->bind_param("ss", $correo, $hashed_password);
        $login_stmt->execute();
        $login_id = $this->conn->insert_id;

        // Insertar en tabla Usuario (asumiendo rol de cliente por defecto)
        $user_query = "INSERT INTO Usuario (Nombre, Correo, Contraseña, Teléfono, Dirección, ID_Login, ID_Rol) 
                       VALUES (?, ?, ?, ?, ?, ?, 2)";
        $user_stmt = $this->conn->prepare($user_query);
        $user_stmt->bind_param("sssssi", $nombre, $correo, $hashed_password, $telefono, $direccion, $login_id);
        
        return $user_stmt->execute();
    }

    // Función para login
    public function login($correo, $contrasena) {
        $query = "SELECT * FROM Usuario WHERE Correo = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            // Verificar contraseña
            if (password_verify($contrasena, $user['Contraseña'])) {
                return $user;
            }
        }
        
        return false;
    }
}
?>