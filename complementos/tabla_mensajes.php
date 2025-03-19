<?php
require_once '../confi/conexion.php'; // Conexión a la base de datos

// Número de filas por página (por defecto 10)
$filasPorPagina = isset($_GET['filas']) ? (int)$_GET['filas'] : 10;
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($paginaActual - 1) * $filasPorPagina;

// Consulta para obtener el número total de mensajes
$totalMensajes = $pdo->query("SELECT COUNT(*) FROM contactos")->fetchColumn();
$totalPaginas = ceil($totalMensajes / $filasPorPagina);

// Consulta para obtener los datos de la tabla contactos con límite y desplazamiento
$query = "SELECT id, nombre, email, telefono, mensaje, fecha FROM contactos LIMIT $filasPorPagina OFFSET $offset";
$resultado = $pdo->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Mensajería <span class="badge bg-primary"><?php echo $totalMensajes; ?></span></h1>

    <!-- Selector de filas por página -->
    <form method="GET" class="mb-3">
        <label for="filas" class="form-label">Filas por página:</label>
        <select name="filas" id="filas" class="form-select" style="width: auto; display: inline-block;" onchange="this.form.submit()">
            <option value="5" <?php echo $filasPorPagina == 5 ? 'selected' : ''; ?>>5</option>
            <option value="10" <?php echo $filasPorPagina == 10 ? 'selected' : ''; ?>>10</option>
            <option value="20" <?php echo $filasPorPagina == 20 ? 'selected' : ''; ?>>20</option>
        </select>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Número</th>
                <th>Fecha</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($fila['email']); ?></td>
                    <td><?php echo htmlspecialchars($fila['telefono']); ?></td>
                    <td><?php echo htmlspecialchars($fila['fecha']); ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#verMensajeModal" 
                                data-id="<?php echo $fila['id']; ?>" 
                                data-mensaje="<?php echo htmlspecialchars($fila['mensaje']); ?>" 
                                data-email="<?php echo htmlspecialchars($fila['email']); ?>">
                            Ver Mensaje
                        </button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Paginación -->
    <nav>
        <ul class="pagination">
            <li class="page-item <?php echo $paginaActual <= 1 ? 'disabled' : ''; ?>">
                <a class="page-link" href="?pagina=<?php echo $paginaActual - 1; ?>&filas=<?php echo $filasPorPagina; ?>">Anterior</a>
            </li>
            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <li class="page-item <?php echo $paginaActual == $i ? 'active' : ''; ?>">
                    <a class="page-link" href="?pagina=<?php echo $i; ?>&filas=<?php echo $filasPorPagina; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?php echo $paginaActual >= $totalPaginas ? 'disabled' : ''; ?>">
                <a class="page-link" href="?pagina=<?php echo $paginaActual + 1; ?>&filas=<?php echo $filasPorPagina; ?>">Siguiente</a>
            </li>
        </ul>
    </nav>
</div>

<!-- Modal para ver mensaje -->
<div class="modal fade" id="verMensajeModal" tabindex="-1" aria-labelledby="verMensajeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verMensajeModalLabel">Mensaje</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="mensajeContenido"></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#responderModal">Responder</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para responder mensaje -->
<div class="modal fade" id="responderModal" tabindex="-1" aria-labelledby="responderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="responderModalLabel">Responder Mensaje</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="mensajeOriginal"></p>
                <form action="enviar_respuesta.php" method="POST">
                    <input type="hidden" name="id" id="mensajeId">
                    <input type="hidden" name="email" id="mensajeEmail">
                    <div class="mb-3">
                        <label for="respuesta" class="form-label">Tu Respuesta</label>
                        <textarea class="form-control" id="respuesta" name="respuesta" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar Respuesta</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const verMensajeModal = document.getElementById('verMensajeModal');
    verMensajeModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const mensaje = button.getAttribute('data-mensaje');
        const id = button.getAttribute('data-id');
        const email = button.getAttribute('data-email');

        document.getElementById('mensajeContenido').textContent = mensaje;
        document.getElementById('mensajeOriginal').textContent = mensaje;
        document.getElementById('mensajeId').value = id;
        document.getElementById('mensajeEmail').value = email;
    });
</script>
</body>
</html>