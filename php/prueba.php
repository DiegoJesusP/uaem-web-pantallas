<?php
include('conexion.php');

// Crear una instancia de la clase y obtener la conexión
$conexion = new CConexion();
$conn = $conexion->conexionBD();

if ($conn) {
    // Preparar y ejecutar la consulta
    $query = "SELECT * FROM prueba";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Obtener los resultados
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Mostrar los resultados
    foreach ($resultados as $fila) {
        echo "<br>";
        echo "Nombre: " . $fila['texto'] . "<br>";
        echo "<hr>";
    }
}

?>
