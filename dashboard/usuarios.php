<?php
include '../complementos/confi/conexion.php';

$sql = "SELECT id, usuario, nombre, telefono, direccion, correo FROM usuario";
$result = $conn->query($sql);

$usuarios = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }
}
$conn->close();

echo json_encode($usuarios);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>
<body>

    <div class="card-body">
        <table id="datatablesSimple" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Correo</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se insertarán los datos dinámicamente -->
            </tbody>
        </table>
    </div>

    <script>
    $(document).ready(function() {
        $.ajax({
            url: 'usuarios.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                let tabla = $('#datatablesSimple tbody');
                tabla.empty();

                data.forEach(usuario => {
                    let fila = `<tr>
                        <td>${usuario.id}</td>
                        <td>${usuario.usuario}</td>
                        <td>${usuario.nombre}</td>
                        <td>${usuario.telefono}</td>
                        <td>${usuario.direccion}</td>
                        <td>${usuario.correo}</td>
                    </tr>`;
                    tabla.append(fila);
                });

                // Inicializar DataTables
                $('#datatablesSimple').DataTable();
            },
            error: function(xhr, status, error) {
                console.error("Error al obtener los datos: ", error);
            }
        });
    });
    </script>

</body>
</html>


