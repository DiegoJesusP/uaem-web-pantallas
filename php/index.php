<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba de conexion</title>
</head>
<body>
    <h1>Conexion a la base de datos</h1>
    <?php
    include('conexion.php');
    $conexion = new CConexion();
$conn = $conexion->conexionBD();
    ?>
</body>
</html>
