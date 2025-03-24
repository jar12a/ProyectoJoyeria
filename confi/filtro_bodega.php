<?php
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