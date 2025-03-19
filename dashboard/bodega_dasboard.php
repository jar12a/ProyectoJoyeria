<?php
include "../confi/session_start.php";
// consultas sql
include '../confi/conexion.php'; // crea la conexion con la base de datos

// Obtener los valores de los filtros si existen
$categoria_filtro = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$material_filtro = isset($_GET['material']) ? $_GET['material'] : '';

// Construir la consulta SQL con los filtros
$sql_productos = "SELECT p.ID_Producto, p.Nombre, c.Nombre AS Categoria, p.Descripción, p.Stock, p.Precio, p.Material, p.Imagen 
                  FROM producto p
                  JOIN categoría c ON p.ID_Categoría = c.ID_categoría
                  WHERE 1=1";

if ($categoria_filtro) {
    $sql_productos .= " AND c.ID_categoría = :categoria_filtro";
}

if ($material_filtro) {
    $sql_productos .= " AND p.Material = :material_filtro";
}

$stmt_productos = $pdo->prepare($sql_productos);

if ($categoria_filtro) {
    $stmt_productos->bindParam(':categoria_filtro', $categoria_filtro, PDO::PARAM_STR);
}

if ($material_filtro) {
    $stmt_productos->bindParam(':material_filtro', $material_filtro, PDO::PARAM_STR);
}

$stmt_productos->execute();

$sql_categorias = "SELECT ID_categoría, Nombre FROM categoría";
$stmt_categorias = $pdo->query($sql_categorias);

if (!$stmt_categorias) {
    die("Error en la consulta de categorías: " . $pdo->errorInfo()[2]);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    include "../complementos/head_html.php";
    ?>
</head>

<body class="sb-nav-fixed">
    <?php
    include "../complementos/dashboard_head.php";
    ?>

    <!--Barra de navegación -->
    <div id="layoutSidenav">
        <?php
        include "../complementos/dashboard_menu.php";
        ?>
        <!--//Agregar todo para el cuerpo-->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Bodega</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="principal.php">Menú</a></li>
                        <li class="breadcrumb-item active">Bienvenido a la bodega</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">
                            <p class="mb-0">
                                Bienvenido a la bodega
                                <?php
                                include "../bodega/bodega.php"; // Corrige la ruta del archivo

                                ?>
                            </p>
                        </div>
                    </div>

                </div>
            </main>
            <?php
            include "../complementos/footer_dashboard.php";
            ?>
        </div>
    </div>
    </div>
    <?php
    include "../confi/cierre_sesion.php";
    ?>
</body>

</html>