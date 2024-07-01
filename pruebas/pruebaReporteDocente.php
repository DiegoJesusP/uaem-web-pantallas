<?php
ob_start();
?>

<?php
$numcontrol = '';
$periodo = '';
$anio = 0;

if (isset($_GET['numcontrol'])) {
    $numcontrol = htmlspecialchars($_GET['numcontrol']);
} else {
    $numcontrol = 'No está definido "numcontrol"';
}
if (isset($_GET['periodo'])) {
    $periodo = htmlspecialchars($_GET['periodo']);
} else {
    $periodo = 'No está definido "periodo"';
}
if (isset($_GET['anio'])) {
    $anio = htmlspecialchars($_GET['anio']);
} else {
    $anio = 'No está definido "anio"';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReporteDocente</title>
    <link rel="stylesheet" href="./../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./../assets/css/styles.css">
    <style>
        .bg-blue {
            background-color: #305395;
            padding: 1%;
            color: #FFFFFF;
        }
        .separador {
            background-color: #305395;
            padding: 1%;
            color: #FFFFFF;
        }
        .separador-asesor {
            background-color: #e1eeda;
            color: #000000;
        }
        .separador-disenio {
            background-color: #fff1cc;
            color: #000000;
        }
        .header-logo {
            width: 100%;
            max-width: 130px;
        }
    </style>
</head>
<body>
    <header class="bg-blue">
        <div class="container">
            <div class="row g-0 text-center d-flex justify-content-center align-items-center">
                <div class="col-12 col-md-2 order-md-1 mb-2 mb-md-0">
                    <div class="header-image">
                        <a href="http://localhost/ejemplo/uaem-web-pantallas/index.html">
                            <img src="./../assets/img/LogoUAEMBlanco.png" alt="UAEM - Universidad - Morelos" class="img-fluid header-logo">
                        </a>
                    </div>
                </div>
                
                <div class="col-12 col-md-10 order-md-2">
                    <div class="header-text text-center">
                        <h3>Reporte de evaluación de asignaturas híbridas y virtuales</h3>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div style="background-color: #e6e6e6;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4 class="text-center">Opinión de estudiantes</h4>
                    <?php echo "<h5 class='text-center'>Periodo: $periodo $anio</h5>"; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
    <div class="separador"></div>
        <table class="table table-bordered">
            <tbody>
                <?php
                include('./../php/conexion.php');
                $conexion = new CConexion();
                $conn = $conexion->conexionBD();

                $consulta = $conn->prepare("SELECT * FROM virtuales WHERE numcontrol = :numcontrol");
                $consulta->bindParam(':numcontrol', $numcontrol);
                $consulta->execute();
                $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

                $unidad = convertirTexto($resultado['unidad']);
                $nombreDocente = convertirTexto($resultado['nombre_docente'] . " " . $resultado['ap_paterno_docente'] . " " . $resultado['ap_materno_docente']);
                // Datos para llenar la tabla
                if ($resultado) {
                    // Datos para llenar la tabla
                    $data = [
                        ["Unidad Académica:", $unidad],
                        ["Modalidad:", "Por definir"],
                        ["Datos Generales:", "Indice (Global)"],
                        ["Promedio:", "Por definir"],
                        ["Asesor(a):", $nombreDocente],
                    ];
                
                    // Generar las filas de la tabla
                    foreach ($data as $row) {
                        echo "<tr>";
                        echo "<td style='width: 20%;'>{$row[0]}</td>";
                        echo "<td style='width: 80%;'><b>{$row[1]}</b></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No se encontraron resultados</td></tr>";
                }

                $consulta = $conn->prepare("SELECT DISTINCT materia FROM virtuales WHERE numcontrol = :numcontrol");
                $consulta->bindParam(':numcontrol', $numcontrol);
                $consulta->execute();
                $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

                $materias = [];
                foreach ($resultados as $resultado) {
                    $materias[] = $resultado['materia'];
                }

                $dataFromDb['materia'] = $materias;

                if($resultados){
                    echo "<tr><td style='width: 20%;'>Curso(s):</td>";
                    echo "<td style='width: 80%;'>";
                    foreach ($materias as $materia) {
                        echo "<b>$materia</b><br> ";
                    }
                    echo "</td></tr>";
                } else {
                    echo "<tr><td colspan='2'>No se encontraron resultados</td></tr>";
                }
                //
                //
                ?>
            </tbody>
        </table>
        <div class="separador"></div>
        <table class="table table-bordered">
            <tbody>
                <?php
                $consulta = $conn->prepare("SELECT DISTINCT grupo, semestre, id_grupo FROM virtuales WHERE numcontrol = :numcontrol");
                $consulta->bindParam(':numcontrol', $numcontrol);
                $consulta->execute();
                $resultadosGrupos = $consulta->fetchAll(PDO::FETCH_ASSOC);

                $grupos = [];
                $idgrupos = [];
                foreach ($resultadosGrupos as $resultadoGrupo) {
                    $grupos[] = $resultadoGrupo['grupo'] . " " . $resultadoGrupo['semestre'];
                    $idgrupos[] = $resultadoGrupo['id_grupo'];
                }

                $header = ['Grupo(s):'];
                $numGrupos = count($grupos);
                foreach ($grupos as $grupo) {
                    $header[] = $grupo;
                }
                $header[] = 'Total';

                $anchoColumnas = [];
                $anchoFijo = 70; 
                $anchoVariable = 189 - $anchoFijo; 
                $anchoGrupos = $anchoVariable / ($numGrupos + 1); 
                $anchoColumnas[] = $anchoFijo;
                for ($i = 0; $i < $numGrupos; $i++) {
                    $anchoColumnas[] = $anchoGrupos;
                }
                $anchoColumnas[] = $anchoGrupos;

                if ($resultadosGrupos) {
                    echo "<tr>";
                    for ($i = 0; $i < count($header); $i++) {
                        echo "<td style='width: {$anchoColumnas[$i]}px;'>";
                        echo $header[$i];
                        echo "</td>";
                    }
                    echo "</tr>";
                } else {
                    echo "<tr><td colspan='2'>No se encontraron resultados</td></tr>";
                }

                $consulta = $conn->prepare("SELECT COUNT(*) AS total_grupo FROM preguntav WHERE numcontrol = :numcontrol GROUP BY id_grupo");
                $consulta->bindParam(':numcontrol', $numcontrol);
                $consulta->execute();
                $res = $consulta->fetchAll(PDO::FETCH_ASSOC);

                $total = 0;
                $totalPorGrupo = [];
                foreach ($res as $fila) {
                    $totalPorGrupo[] = $fila['total_grupo'];
                    $total += $fila['total_grupo'];
                }

                $totalPorSatisfaccion = [1, 0, 1]; // Ejemplo de datos
                $totalPorExpectativa = [2, 0, 2]; // Ejemplo de datos

                $totalSatisfaccion = array_sum($totalPorSatisfaccion);
                $totalExpectativa = array_sum($totalPorExpectativa);

                $data = [
                    ["Estudiantes participantes:", $totalPorGrupo, $total],
                    ["Satisfacción de desempeño:", $totalPorSatisfaccion, $totalSatisfaccion],
                    ["Expectativas cubiertas del curso:", $totalPorExpectativa, $totalExpectativa],
                ];
            
                // Generar las filas de la tabla
                foreach ($data as $row) {
                    echo "<tr>";
                    for ($i = 0; $i < count($header); $i++) {
                        echo "<td style='width: {$anchoColumnas[$i]}px;'>";
                        if ($i == 0) {
                            echo $row[0];
                        } elseif ($i <= count($row[1])) {
                            echo $row[1][$i - 1];
                        } else {
                            echo $row[2];
                        }
                        echo "</td>";
                    }
                    echo "</tr>";
                }
                //
                $totalPorAsesor = [1, 1, 1]; // Ejemplo de datos
                $totalPorDisenio = [2, 2, 2]; // Ejemplo de datos

                $totalAsesor = array_sum($totalPorAsesor);
                $totalDisenio = array_sum($totalPorDisenio);

                $data = [
                    ["Asesor en Línea (índice Global):", $totalPorAsesor, $totalAsesor],
                    ["Diseño del Curso (índice Global):", $totalPorDisenio, $totalDisenio],
                ];
            
                // Generar las filas de la tabla
                foreach ($data as $row) {
                    echo "<tr>";
                    for ($i = 0; $i < count($header); $i++) {
                        echo "<td style='width: {$anchoColumnas[$i]}px;'>";
                        if ($i == 0) {
                            echo $row[0];
                        } elseif ($i <= count($row[1])) {
                            echo $row[1][$i - 1];
                        } else {
                            echo $row[2];
                        }
                        echo "</td>";
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="separador"></div>
        <div class="separador-asesor">
            <h5 class="text-center">Asesor en Línea</h5>
        </div>
        <table class="table table-bordered">
            <tbody>
                <?php
                $totalPorFunciones = [1, 1, 1]; // Ejemplo de datos
                $totalFunciones = array_sum($totalPorFunciones);

                $totalPorDominio = [1, 6, 1]; // Ejemplo de datos
                $totalDomino = array_sum($totalPorDominio);

                $totalPorR1 = [1, 1, 7]; // Ejemplo de datos
                $totalR1 = array_sum($totalPorR1);

                $totalPorR2 = [9, 1, 1]; // Ejemplo de datos
                $totalR2 = array_sum($totalPorR2);

                $totalPorR3 = [1, 1, 1]; // Ejemplo de datos
                $totalR3 = array_sum($totalPorR3);

                $totalPorR4 = [2, 2, 2]; // Ejemplo de datos
                $totalR4 = array_sum($totalPorR4);

                $totalPorR5 = [3, 3, 3]; // Ejemplo de datos
                $totalR5 = array_sum($totalPorR5);

                $totalPorR6 = [4, 4, 4]; // Ejemplo de datos
                $totalR6 = array_sum($totalPorR6);

                $totalPorR7 = [5, 5, 5]; // Ejemplo de datos
                $totalR7 = array_sum($totalPorR7);

                $totalPorR8 = [6, 6, 6]; // Ejemplo de datos
                $totalR8 = array_sum($totalPorR8);

                $totalPorR9 = [7, 7, 7]; // Ejemplo de datos
                $totalR9 = array_sum($totalPorR9);

                $totalPorOportunidad = [1, 1, 1]; // Ejemplo de datos
                $totalOportunidad = array_sum($totalPorOportunidad);

                $totalPorCalidad = [1, 1, 1]; // Ejemplo de datos
                $totalCalidad = array_sum($totalPorCalidad);

                $data = [
                    ["Funciones del Asesor en Línea:", $totalPorFunciones, $totalFunciones],
                    ["-Dominio y desempeño del asesor:", $totalPorDominio, $totalDomino],
                    ["Dominio en el manejo de las aplicaciones y herramientas de la plataforma Moodle:", $totalPorR1, $totalR1],
                    ["Dominio disciplinar por parte del profesor en la asignatura:", $totalPorR2, $totalR2],
                    ["Desempeño del asesor(a) como facilitador del aprendizaje a lo largo del curso:", $totalPorR3, $totalR3],
                    ["-Oportunidad en la retroalimentación y respuestas:", $totalPorOportunidad, $totalOportunidad],
                    ["Prontitud con que tu asesor respondió a tus dudas, preguntas o comentarios:", $totalPorR4, $totalR4],
                    ["Prontitud de tu asesor en respuesta o aportación en los foros:", $totalPorR5, $totalR5],
                    ["Prontitud de tu asesor para registrar tus calificaciónes en la plataforma:", $totalPorR6, $totalR6],
                    ["-Calidad de retroalimentación y respuesta:", $totalPorCalidad, $totalCalidad],
                    ["Calidad de las respuestas de tu asesor(a) a tus dudas, preguntas o comentarios:", $totalPorR7, $totalR7],
                    ["Comentarios o argumentos emitidos por tu asesor(a) para justificar las calificaciones que obtuviste:", $totalPorR8, $totalR8],
                    ["Promoción por parte del asesor en argumentar las patticipaciones en base a los comentarios", $totalPorR9, $totalR9]
                ];
            
                // Generar las filas de la tabla
                foreach ($data as $row) {
                    echo "<tr>";
                    for ($i = 0; $i < count($header); $i++) {
                        echo "<td style='width: {$anchoColumnas[$i]}px;'>";
                        if ($i == 0) {
                            echo $row[0];
                        } elseif ($i <= count($row[1])) {
                            echo $row[1][$i - 1];
                        } else {
                            echo $row[2];
                        }
                        echo "</td>";
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="separador-disenio">
            <h5 class="text-center">Diseño del Curso</h5>
        </div>
        <table class="table table-bordered">
            <tbody>
                <?php
                $totalPorFunciones = [1, 1, 1]; // Ejemplo de datos
                $totalFunciones = array_sum($totalPorFunciones);

                $totalPorDominio = [1, 6, 1]; // Ejemplo de datos
                $totalDomino = array_sum($totalPorDominio);

                $totalPorR1 = [1, 1, 7]; // Ejemplo de datos
                $totalR1 = array_sum($totalPorR1);

                $totalPorR2 = [9, 1, 1]; // Ejemplo de datos
                $totalR2 = array_sum($totalPorR2);

                $totalPorR3 = [1, 1, 1]; // Ejemplo de datos
                $totalR3 = array_sum($totalPorR3);

                $totalPorR4 = [2, 2, 2]; // Ejemplo de datos
                $totalR4 = array_sum($totalPorR4);

                $totalPorR5 = [3, 3, 3]; // Ejemplo de datos
                $totalR5 = array_sum($totalPorR5);

                $totalPorR6 = [4, 4, 4]; // Ejemplo de datos
                $totalR6 = array_sum($totalPorR6);

                $totalPorR7 = [5, 5, 5]; // Ejemplo de datos
                $totalR7 = array_sum($totalPorR7);

                $totalPorR8 = [6, 6, 6]; // Ejemplo de datos
                $totalR8 = array_sum($totalPorR8);

                $totalPorR9 = [7, 7, 7]; // Ejemplo de datos
                $totalR9 = array_sum($totalPorR9);

                $totalPorOportunidad = [1, 1, 1]; // Ejemplo de datos
                $totalOportunidad = array_sum($totalPorOportunidad);

                $totalPorCalidad = [1, 1, 1]; // Ejemplo de datos
                $totalCalidad = array_sum($totalPorCalidad);

                $data = [
                    ["Funciones del Asesor en Línea:", $totalPorFunciones, $totalFunciones],
                    ["-Dominio y desempeño del asesor:", $totalPorDominio, $totalDomino],
                    ["Dominio en el manejo de las aplicaciones y herramientas de la plataforma Moodle:", $totalPorR1, $totalR1],
                    ["Dominio disciplinar por parte del profesor en la asignatura:", $totalPorR2, $totalR2],
                    ["Desempeño del asesor(a) como facilitador del aprendizaje a lo largo del curso:", $totalPorR3, $totalR3],
                    ["-Oportunidad en la retroalimentación y respuestas:", $totalPorOportunidad, $totalOportunidad],
                    ["Prontitud con que tu asesor respondió a tus dudas, preguntas o comentarios:", $totalPorR4, $totalR4],
                    ["Prontitud de tu asesor en respuesta o aportación en los foros:", $totalPorR5, $totalR5],
                    ["Prontitud de tu asesor para registrar tus calificaciónes en la plataforma:", $totalPorR6, $totalR6],
                    ["-Calidad de retroalimentación y respuesta:", $totalPorCalidad, $totalCalidad],
                    ["Calidad de las respuestas de tu asesor(a) a tus dudas, preguntas o comentarios:", $totalPorR7, $totalR7],
                    ["Comentarios o argumentos emitidos por tu asesor(a) para justificar las calificaciones que obtuviste:", $totalPorR8, $totalR8],
                    ["Promoción por parte del asesor en argumentar las patticipaciones en base a los comentarios", $totalPorR9, $totalR9]
                ];
            
                // Generar las filas de la tabla
                foreach ($data as $row) {
                    echo "<tr>";
                    for ($i = 0; $i < count($header); $i++) {
                        echo "<td style='width: {$anchoColumnas[$i]}px;'>";
                        if ($i == 0) {
                            echo $row[0];
                        } elseif ($i <= count($row[1])) {
                            echo $row[1][$i - 1];
                        } else {
                            echo $row[2];
                        }
                        echo "</td>";
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        
    </div>

    <script src="./../js/bootstrap.bundle.min.js"></script>
    <?php
    function convertirTexto($texto) {
        // Convertir el texto a minúsculas con soporte para UTF-8
        $texto = mb_strtolower($texto, 'UTF-8');
        // Convertir la primera letra de cada palabra a mayúscula con soporte para UTF-8
        $texto = mb_convert_case($texto, MB_CASE_TITLE, 'UTF-8');
        return $texto;
    }
    ?>
</body>
</html>


<?php
$html = ob_get_clean();
//echo $html;

require_once './../library/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('letter');
//papel en horizontal
//$dompdf->setPaper('A4', 'landscape');

$dompdf->render();
$nombrepdf = 'Reporte '.$nombreDocente.'.pdf';
$dompdf->stream($nombrepdf, array('Attachment' => false));

?>