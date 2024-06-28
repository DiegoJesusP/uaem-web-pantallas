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
                    <h3 class="text-center">Opinión de estudiantes</h3>
                    <?php echo "<h4 class='text-center'>Periodo: $periodo $anio</h4>"; ?>
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
                        echo "<b>* $materia</b><br> ";
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
    /*
    foreach($idgrupos as $idgrupo){
                    $consulta = $conn->prepare("SELECT COUNT(*) AS total_grupo FROM preguntav WHERE numcontrol = :numcontrol AND id_grupo = :id_grupo GROUP BY id_grupo");
                    $consulta->bindParam(':numcontrol', $numcontrol);
                    $consulta->bindParam(':id_grupo', $idgrupo);
                    $consulta->execute();
                    $res = $consulta->fetchAll(PDO::FETCH_ASSOC);

                    $data = [];
                    foreach ($res as $fila) {
                        $data[] = [$fila['total_grupo']];
                    }

                    $total = 0;
                    foreach ($data as $row) {
                        $total += $row[0];
                    }

                    $data[] = [$total];

                    echo "<tr>";
                    for ($i = 0; $i < count($header); $i++) {
                        echo "<td style='width: {$anchoColumnas[$i]}px;'>";
                        if ($i == 0) {
                            echo $header[$i];
                        } else {
                            echo $data[$i - 1][0];
                        }
                        echo "</td>";
                    }
                    echo "</tr>";
                }
    */
    ?>
</body>
</html>