<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
</head>
<body>
    <h1>Welcome to Principal Page</h1>
    <script type="text/javascript" src="javascript.js"></script>

    <?php include 'FuncionesPHP.php'   ?>
    <button onclick="ejecutar('<?php mostrar_dato('Datos Salientes'); ?>')" type="button">Button</button>
    <div id="content"></div>

</body>
</html>