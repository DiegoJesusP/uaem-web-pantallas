<?php
include('conexion.php');

// Crear una instancia de la clase y obtener la conexión
$conexion = new CConexion();
$conn = $conexion->conexionBD();
/*

if (!$conn) {
    // Manejar la falta de conexión a la base de datos
    echo json_encode(['error' => 'Error en la conexión a la base de datos']);
    exit;
}

// Validar y obtener el nombre de usuario desde la solicitud POST
$numcontrol = filter_input(INPUT_POST, 'numcontrol', FILTER_SANITIZE_STRING);

if (empty($numcontrol)) {
    // Manejar el caso de que no se haya enviado un nombre de usuario
    echo json_encode(['error' => 'Por favor ingresa un nombre de usuario válido']);
    exit;
}

// Preparar y ejecutar la consulta
$query = "SELECT nombre_docente, numcontrol FROM virtuales WHERE numcontrol = :numcontrol";
$stmt = $conn->prepare($query);
$stmt->bindParam(':numcontrol', $numcontrol, PDO::PARAM_STR);
$stmt->execute();

// Obtener los resultados
$resultados = $stmt->fetch(PDO::FETCH_ASSOC);

// Retornar los resultados en formato JSON
header('Content-Type: application/json');
if ($resultados) {
    echo json_encode($resultados);
} else {
    // Manejar el caso de que el usuario no sea encontrado
    echo json_encode(['nombre_docente' => '', 'numcontrol' => 'Usuario no encontrado']);
}

*/
if ($conn) {
    // Preparar y ejecutar la consulta
    $query = "SELECT * FROM virtuales WHERE numcontrol = :numcontrol";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':numcontrol', $numcontrol, PDO::PARAM_STR);
    $numcontrol = 'FRORTIZ';
    $stmt->execute();

    // Obtener los resultados
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Mostrar los resultados
    foreach ($resultados as $fila) {
        echo "<br>";
        echo "Fuente: " . $fila['fuente'] . "<br>";
        echo "Acta ID: " . $fila['acta_id'] . "<br>";
        echo "ID Grupo: " . $fila['id_grupo'] . "<br>";
        echo "Nivel: " . $fila['nivel'] . "<br>";
        echo "Unidad: " . $fila['unidad'] . "<br>";
        echo "Carrera: " . $fila['carrera'] . "<br>";
        echo "Semestre: " . $fila['semestre'] . "<br>";
        echo "Grupo: " . $fila['grupo'] . "<br>";
        echo "Turno: " . $fila['turno'] . "<br>";
        echo "Materia: " . $fila['materia'] . "<br>";
        echo "NumControl: " . $fila['numcontrol'] . "<br>";
        echo "Apellido Paterno Docente: " . $fila['ap_paterno_docente'] . "<br>";
        echo "Apellido Materno Docente: " . $fila['ap_materno_docente'] . "<br>";
        echo "Nombre Docente: " . $fila['nombre_docente'] . "<br>";
        echo "Matricula: " . $fila['matricula'] . "<br>";
        echo "Sexo: " . $fila['sexo'] . "<br>";
        echo "Apellido Paterno Alumno: " . $fila['ap_paterno_alumno'] . "<br>";
        echo "Apellido Materno Alumno: " . $fila['ap_materno_alumno'] . "<br>";
        echo "Nombre Alumno: " . $fila['nombre_alumno'] . "<br>";
        echo "<hr>";
    }
}
?>


