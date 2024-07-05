<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados Docente</title>
    <link rel="Shortcut Icon" href="http://localhost/ejemplo/uaem-web-pantallas/assets/img/uaem.ico" type="image/x-icon">
    <link rel="stylesheet" href="http://localhost/ejemplo/uaem-web-pantallas/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://localhost/ejemplo/uaem-web-pantallas/assets/css/styles.css">
    <link rel="stylesheet" href="http://localhost/ejemplo/uaem-web-pantallas/assets/css/btn-regresar-styles.css">
    <link rel="stylesheet" href="http://localhost/ejemplo/uaem-web-pantallas/assets/css/cards-styles.css">
    <style>
    .textB {
        font-family: 'Ubuntu';font-size: 22px;
    }
    </style>
</head>
<body style="background-color: #F6F6F6;">
    <div id="headerContainer"></div>
    <div class="container textB">
        <h1 style="text-align: center;" class="mt-3 mb-3"><img src="http://localhost/ejemplo/uaem-web-pantallas/assets/img/encuesta_f.png" alt="ubicacion" class="img-fluid icon alin" style="width: 64px; height: 64px;">Resultados del Docente</h1>
        
        <hr>
        <div class="col-12 d-flex justify-content-end">
            <a href="./../docs/pruebapdf.pdf" target="_blank" style="color: red; margin-bottom: 10px;">Instructivo<img src="http://localhost/ejemplo/uaem-web-pantallas/assets/img/libro.png" alt="ubicacion" class="img-fluid icon alin" style="width: 47px; height: 50px;"></a>
        </div>
        <?php
        $numcontrol = '';
        $periodo = '';
        $anio = '';

        if (isset($_GET['numcontrol'])) {
            $numcontrol = htmlspecialchars($_GET['numcontrol']);
        } else {
            echo "No se ha proporcionado un número de control.<br>";
        }

        if (isset($_GET['periodo'])) {
            $periodo = htmlspecialchars($_GET['periodo']);
        } else {
            echo "No se ha proporcionado un periodo.<br>";
        }

        if (isset($_GET['anio'])) {
            $anio = htmlspecialchars($_GET['anio']);
        } else {
            echo "No se ha proporcionado un año.<br>";
        }
        ?>
        <div id="selected-card-info" class="bg-blue" style="border-radius: 20px;">
            <div class="header-text text-center">
                <h2 class="mb-3">REPORTE INDIVIDUAL</h2>
                <?php
                echo "<h2 class='mb-3'>PERIODO: ${periodo} ${anio}</h2>";
                ?>
            </div>
        </div>
        <div style="margin-top: 20px;">
            <?php
            include('./../php/conexion.php');
            $conexion = new CConexion();
            $conn = $conexion->conexionBD();

            $consulta = $conn->prepare("SELECT numcontrol, nombre_docente, ap_paterno_docente, ap_materno_docente FROM virtuales WHERE numcontrol = :numcontrol");
            // Vincula los parámetros
            $consulta->bindParam(':numcontrol', $numcontrol);
            // Ejecuta la consulta
            $consulta->execute();
        
            // Obtiene los resultados
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        
            // Muestra los resultados
            if ($resultado) {
            echo "<p>Nombre del docente: <b><span id='nombredocente'><b>" . $resultado['nombre_docente'] . " " . $resultado['ap_paterno_docente'] . " " . $resultado['ap_materno_docente'] .  "</b></span></b></p>";
            echo "<p>Núm. de reportes: <b><span id='numreportes'> </span></b></p>";
            } else {
                echo "<div class='container text-center'><p>No se encontraron resultados para el usuario SADCE: <b>$numcontrol</b></p></div>";
            }
            ?>
        </div>
        <hr>
        <div style="margin-bottom: 20px;" class="row align-items-center">
            <div class="col-12 col-md-8">
                <b>Seleccione un reporte individual...</b>
            </div>
            <div class="col-12 col-md-4 d-flex justify-content-end d-none d-md-flex">
                <button class="button" onclick="location.href='http://localhost/ejemplo/uaem-web-pantallas/reportes/docente.php';">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"></path>
                    </svg>
                    <div class="text-btn">Regresar</div>
                </button>
            </div>
        </div>
        <?php
    //cards de reportes
    /*
    SELECT matricula
    FROM preguntav
    WHERE numcontrol = :numcontrol 
    AND (
    (:periodo = 'Enero a Junio' AND EXTRACT(MONTH FROM fecha) BETWEEN 1 AND 6) OR
    (:periodo = 'Agosto a Diciembre' AND EXTRACT(MONTH FROM fecha) BETWEEN 8 AND 12)
    );
    */
    $consulta = $conn->prepare("SELECT matricula
    FROM preguntav
    WHERE numcontrol = :numcontrol 
    AND (
    (:periodo = 'Enero a Junio' AND EXTRACT(MONTH FROM fecha) BETWEEN 1 AND 6) OR
    (:periodo = 'Agosto a Diciembre' AND EXTRACT(MONTH FROM fecha) BETWEEN 8 AND 12)
    )");
    $consulta->bindParam(':numcontrol', $numcontrol);
    $consulta->bindParam(':periodo', $periodo);
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $matriculas = array();

    if ($resultado) {
        foreach ($resultado as $fila) {
            $matriculas[] = $fila['matricula'];
        }
    }
    
    /*
    SELECT DISTINCT unidad, nivel, numcontrol, id_grupo, acta_id
    FROM virtuales
    WHERE matricula = :matriculas;
    */

    if (!empty($matriculas) && !empty($numcontrol)) {
        // Crear una cadena de placeholders para las matrículas en la consulta
        $placeholders = str_repeat('?,', count($matriculas) - 1) . '?';
    
        // Consulta SQL para obtener unidad y nivel basado en las matrículas y numcontrol
        $sql = "SELECT unidad, nivel, numcontrol, id_grupo, acta_id
                FROM virtuales
                WHERE numcontrol = ? AND matricula IN ($placeholders)";
    
        // Preparar la consulta
        $consulta = $conn->prepare($sql);
    
        // Vincular el numcontrol y las matrículas como parámetros
        $params = array_merge([$numcontrol], $matriculas);
        $consulta->execute($params);
    
        // Obtener el resultado de la consulta
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    
        // Agrupar los resultados por acta_id e id_grupo
        $agrupados = [];
        foreach ($resultado as $fila) {
            $clave = $fila['acta_id'] . '-' . $fila['id_grupo'];
            if (!isset($agrupados[$clave])) {
                $agrupados[$clave] = [
                    'unidad' => $fila['unidad'],
                    'nivel' => $fila['nivel'],
                    'numcontrol' => $fila['numcontrol'],
                    'id_grupo' => $fila['id_grupo'],
                    'acta_id' => $fila['acta_id'],
                    'numcontrol_igual' => true
                ];
            } else {
                // Verificar si numcontrol es igual
                if ($agrupados[$clave]['numcontrol'] !== $fila['numcontrol']) {
                    $agrupados[$clave]['numcontrol_igual'] = false;
                }
            }
        }
    
        // Contador de cards
        $contador_cards = 0;
    
        // Generar las cards
        if (!empty($agrupados)) {
            echo "<div class='row d-flex'>";
            foreach ($agrupados as $clave => $grupo) {
                if ($grupo['numcontrol_igual']) { // Validación de numcontrol igual
                    echo "<div class='col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4'>";
                    echo "<div class='card' style='width: 18rem; cursor: pointer;'>";
                    echo "<div class='card-body text-center'>";
                    echo "<h5 class='card-title'>Unidad académica: <br><b>" . $grupo['unidad'] . "</b> <br>Nivel educativo: <br><b>" . $grupo['nivel'] . "</b><br><p>" . $grupo['numcontrol'] . "</p></h5>";
                    echo "<a href='http://localhost/ejemplo/uaem-web-pantallas/reportes/reportesdocente.php' data-numcontrol='" . $grupo['numcontrol'] . "' class='btn btn-primary consultar-reporte'>Consultar Reporte(s)</a>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
    
                    // Incrementar contador de cards
                    $contador_cards++;
                }
            }
            echo "</div>";
        } else {
            echo "<div class='d-flex justify-content-center'>";
            echo "<p>No se encontró al usuario</p>";
            echo "</div>";
        }
        
        echo "
        <script>
            var contadorCards = $contador_cards;
            document.getElementById('numreportes').innerHTML = contadorCards;
        </script>";
    }
    
    
    
    
    
    /*solo para comprobar las matriculas
    echo "<ul>";
    $cont = 1;
    foreach ($matriculas as $matricula) {
        echo "<li>$cont: $matricula</li>";
        $cont ++;
    }
    echo "</ul>";
    */
    
    ?>
    </div>
    
    <!-- Botón regresar 
    <div class="fixed-button-container">
        <a href="http://localhost/ejemplo/uaem-web-pantallas/reportes/docente.php" class="button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"></path>
            </svg>
            <div class="text"><h5>Regresar</h5></div>
        </a>
    </div>
    <div class="row d-flex">
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4">
                <div class="card" style="width: 18rem; cursor: pointer;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Modalidad: <br><b>${modalidad}</b></h5>
                        <p class="card-text">Periodo de Evaluación: <br><b>${periodo}</b></p>
                        <a href="http://localhost/ejemplo/uaem-web-pantallas/reportes/reportesdocente.php" class="btn btn-primary">Generar</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4">
                <div class="card" style="width: 18rem; cursor: pointer;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Modalidad: <br><b>${modalidad}</b></h5>
                        <p class="card-text">Periodo de Evaluación: <br><b>${periodo}</b></p>
                        <a href="http://localhost/ejemplo/uaem-web-pantallas/reportes/reportesdocente.php" class="btn btn-primary">Generar</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4">
                <div class="card" style="width: 18rem; cursor: pointer;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Modalidad: <br><b>${modalidad}</b></h5>
                        <p class="card-text">Periodo de Evaluación: <br><b>${periodo}</b></p>
                        <a href="http://localhost/ejemplo/uaem-web-pantallas/reportes/reportesdocente.php" class="btn btn-primary">Generar</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4">
                <div class="card" style="width: 18rem; cursor: pointer;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Modalidad: <br><b>${modalidad}</b></h5>
                        <p class="card-text">Periodo de Evaluación: <br><b>${periodo}</b></p>
                        <a href="http://localhost/ejemplo/uaem-web-pantallas/reportes/reportesdocente.php" class="btn btn-primary">Generar</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4">
                <div class="card" style="width: 18rem; cursor: pointer;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Modalidad: <br><b>${modalidad}</b></h5>
                        <p class="card-text">Periodo de Evaluación: <br><b>${periodo}</b></p>
                        <a href="http://localhost/ejemplo/uaem-web-pantallas/reportes/reportesdocente.php" class="btn btn-primary">Generar</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4">
                <div class="card" style="width: 18rem; cursor: pointer;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Modalidad: <br><b>${modalidad}</b></h5>
                        <p class="card-text">Periodo de Evaluación: <br><b>${periodo}</b></p>
                        <a href="http://localhost/ejemplo/uaem-web-pantallas/reportes/reportesdocente.php" class="btn btn-primary">Generar</a>
                    </div>
                </div>
            </div> 
        </div>
    -->
    <script>
            //
            document.addEventListener('DOMContentLoaded', function() {
    var buttons = document.querySelectorAll('.consultar-reporte');
    buttons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            var numcontrol = button.getAttribute('data-numcontrol');
            var id_grupo = button.getAttribute('data-id_grupo');
            var acta_id = button.getAttribute('data-acta_id');
            var periodo = '<?php echo $periodo; ?>';
            var anio = '<?php echo $anio; ?>'; 
            window.location.href = 'http://localhost/ejemplo/uaem-web-pantallas/reportes/reportesdocente.php?numcontrol=' + numcontrol + '&periodo=' + encodeURIComponent(periodo) + '&anio=' + anio;
        });
    });
});
//

    </script>
    <script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/ejemplo/uaem-web-pantallas/js/bootstrap.bundle.min.js"></script>
    <script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/ejemplo/uaem-web-pantallas/assets/js/loadHeader.js"></script>
</body>
</html>
