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
//
$query = "SELECT
    acta_id,
    unidad,
    carrera,
    materia,
    COUNT(DISTINCT numcontrol) AS total_alumnos,
    COUNT(DISTINCT grupo) AS total_grupos,
    COUNT(DISTINCT numcontrol) AS total_docentes
FROM
    virtuales
GROUP BY
    acta_id, unidad, carrera, materia;";
$stmt = $conn->prepare($query);
$stmt->execute();

// Obtener los resultados
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

$unidad_totales = [];
$acta_id = [];
$datosEsc = [];

// Procesar resultados
foreach ($resultados as $fila) {
    $acta_id[] = $fila['acta_id'];
    $acta = $fila['acta_id'];
    $unidad = $fila['unidad'];
    $carrera = $fila['carrera'];
    $materia = $fila['materia'];
    $total_alumnos = $fila['total_alumnos'];
    $total_grupos = $fila['total_grupos'];
    $total_docentes = $fila['total_docentes'];

    // Acumular el total de alumnos por unidad
    if (!isset($unidad_totales[$unidad])) {
        $unidad_totales[$unidad] = 0;
    }
    $unidad_totales[$unidad] += $total_alumnos;

    // Consulta adicional dentro del bucle
    $queryAsesor = "WITH asesor_en_linea AS (
        SELECT
            acta_id,
            (r7 + r8 + r10 + r2 + r4 + r9 + r3 + r5 + r6) AS calificacion
        FROM
            preguntav
    )
    SELECT
        acta_id,
        AVG(calificacion) AS promedio_calificacion
    FROM
        asesor_en_linea
    WHERE
        acta_id = :acta_id
    GROUP BY
        acta_id;";

    $stmtAsesor = $conn->prepare($queryAsesor); // Preparar la consulta
    $stmtAsesor->bindParam(':acta_id', $acta, PDO::PARAM_STR); // Enlazar el parámetro
    $stmtAsesor->execute(); // Ejecutar la consulta
    $resultadosAsesor = $stmtAsesor->fetchAll(PDO::FETCH_ASSOC); // Obtener los resultados

    // Asegurar que hay resultados antes de intentar acceder a ellos
    $promAsesor = isset($resultadosAsesor[0]['promedio_calificacion']) ? $resultadosAsesor[0]['promedio_calificacion'] : null;
    ////////
    $queryDisenio = "WITH calificaciones AS (
    SELECT
        acta_id,
        (
            SELECT AVG(value::numeric)
            FROM unnest(string_to_array(r21, ',')) AS value
            WHERE value ~ '^\d+(\.\d+)?$'
        ) AS promedio_r21,
        r12 + r18 + r15 + r13 + r17 + r16 + r20 + r14 AS suma_atributos_sin_promedio
    FROM
        preguntav
    ),
    calificaciones_con_promedio AS (
        SELECT
            acta_id,
            promedio_r21,
            suma_atributos_sin_promedio + promedio_r21 AS suma_atributos
        FROM
            calificaciones
    )
    SELECT
        acta_id,
        AVG(suma_atributos) AS promedio_calificacion
    FROM
        calificaciones_con_promedio
    where
        acta_id = :acta_id
    GROUP BY
        acta_id;";

    $stmtDisenio = $conn->prepare($queryDisenio); // Preparar la consulta
    $stmtDisenio->bindParam(':acta_id', $acta, PDO::PARAM_STR); // Enlazar el parámetro
    $stmtDisenio->execute(); // Ejecutar la consulta
    $resultadosDisenio = $stmtDisenio->fetchAll(PDO::FETCH_ASSOC); // Obtener los resultados

    // Asegurar que hay resultados antes de intentar acceder a ellos
    $promDisenio = isset($resultadosDisenio[0]['promedio_calificacion']) ? $resultadosDisenio[0]['promedio_calificacion'] : null;

    $promT = ($promAsesor + $promDisenio) / 2;
    // Almacenar los datos en el array
    $datosEsc[] = [$acta, $unidad, $carrera, $materia, &$unidad_totales[$unidad], $total_grupos, $total_docentes, number_format($promAsesor, 1), number_format($promDisenio, 1), number_format($promT, 1)];
}


// Mostrar los resultados
foreach ($datosEsc as $index => $item) {
    echo "Posición {$index}: ". implode(", ", $item) . "<br>";
}

//
$arrMH = [];
$arrMV = [];
$cont = 0;
foreach ($acta_id as $acta_id) {
    $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
    $consulta->bindParam(':acta_id', $acta_id, PDO::PARAM_STR);
    $consulta->execute();
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        $datoArr = $datosEsc[$cont];
        if ($resultado['modalidad'] == 'H') {
            $arrMH[] = $datoArr;
        } else if ($resultado['modalidad'] == 'V') {
            $arrMV[] = $datoArr;
        }
    }
    $cont++;
}

echo "<br>";
echo "Modalidad Híbrida: <br>";
foreach ($arrMH as $index => $item) {
    echo "Posición {$index}: ". implode(", ", $item) . "<br>";
}
echo "<br>";
echo "Modalidad Virtual: <br>";
foreach ($arrMV as $index => $item) {
    echo "Posición {$index}: ". implode(", ", $item) . "<br>";
}
//
function abreviarPrimeraPalabra($texto) {
    $texto = mb_strtoupper($texto, 'UTF-8');
    $palabras = explode(' ', $texto);
    $abreviatura = mb_substr($palabras[0], 0, 1, 'UTF-8') . '.';
    $resultado = $abreviatura . ' ' . implode(' ', array_slice($palabras, 1));
    return $resultado;
}

// Ejemplo de uso:
echo "<br>";
echo "<br>";
$arreglo = ["ESCUELA DE ESTUDIOS SUPERIORES DE ATLATLAHUCAN", "Instituto de ciencias de la educación"];
$txt1 = "ESCUELA DE";
$txt2 = "Instituto de ciencias de la educación";
echo $txt1 . " === " . abreviarPrimeraPalabra($arreglo[0]). "<br>"; // E. DE ESTUDIOS SUPERIORES DE ATLATLAHUCAN
echo $txt2 . " === " . abreviarPrimeraPalabra($txt2); // I. CIENCIAS DE LA EDUCACION


?>
