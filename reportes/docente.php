<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Docente</title>
    <link rel="Shortcut Icon" href="http://localhost/ejemplo/uaem-web-pantallas/assets/img/uaem.ico" type="image/x-icon">
    <link rel="stylesheet" href="http://localhost/ejemplo/uaem-web-pantallas/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://localhost/ejemplo/uaem-web-pantallas/assets/css/styles.css">
    <link rel="stylesheet" href="http://localhost/ejemplo/uaem-web-pantallas/assets/css/btn-regresar-styles.css">
    <link rel="stylesheet" href="http://localhost/ejemplo/uaem-web-pantallas/assets/css/search-styles.css">
    <link rel="stylesheet" href="http://localhost/ejemplo/uaem-web-pantallas/assets/css/buttons-search-styles.css">
    <link rel="stylesheet" href="http://localhost/ejemplo/uaem-web-pantallas/assets/css/cards-styles.css">
    
    <style>
    .textB {
        font-family: 'Aleo';font-size: 22px;
    }
    </style>
</head>
<body style="background-color: #F6F6F6;">
    <div id="headerContainer"></div>
    <div class="container mt-4 min-vh-100 textB">
        <h1 style="text-align: center;"><img src="http://localhost/ejemplo/uaem-web-pantallas/assets/img/encuesta.png" alt="ubicacion" class="img-fluid icon alin" style="width: 64px; height: 64px;">Resultados del Docente</h1>
        <hr>
        <div class="container text-center">
            <h5 class="textB">Nombre de usuario SADCE</h5>
            <form method="post" action="">
                <div class="row row-cols-auto justify-content-center">
                    <div class="col">
                        <input type="text" placeholder="Nombre de usuario" name="usadce" class="shadow input" id="usernameInput" required>
                    </div>
                    <div class="col">
                        <button class="boton-buscar shadow" id="usadceButton" name="usadceButton" onclick="buscarUsuario(event)" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div id="error-message" style="color: red;"></div>
            </form>
        </div>
        <hr>
        
        <div id="selected-card-info" class="textB" style="border-radius: 20px; background-color: #001660; padding: 10px 0;">
            <div class="textB header-text text-center">
                <h2>Datos generales del docente</h2>
            </div>
        </div>
        <div style="margin-top: 20px;">
        <?php
        include('./../php/conexion.php');
        $conexion = new CConexion();
        $conn = $conexion->conexionBD();
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usadce = htmlspecialchars($_POST['usadce']);
            //echo "<div class='container text-center'><p><b>Usuario SADCE:</b> $usadce</p></div>";
            
            // Prepara la consulta SQL
            $consulta = $conn->prepare("SELECT numcontrol, nombre_docente, ap_paterno_docente, ap_materno_docente FROM virtuales WHERE numcontrol = :numcontrol");
            // Vincula los parámetros
            $consulta->bindParam(':numcontrol', $usadce);
            // Ejecuta la consulta
            $consulta->execute();
            
            // Obtiene los resultados
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            
            // Muestra los resultados
            /*
            <div style="margin-top: 20px;">
            <p>Nombre Docente: <b><span id="nombredocente"></span></b></p>
            <p>Usuario SADCE: <b><span id="usuarioSadce"></span></b></p>
            </div>
            */
            if ($resultado) {
                echo "<div class='container'>";
                echo "<p><b>Nombre del docente:</b> " . $resultado['nombre_docente'] . " " . $resultado['ap_paterno_docente'] . " " . $resultado['ap_materno_docente'] .  "</p>";
                echo "<p><b>Usuario SADCE:</b> " . $resultado['numcontrol'] . "</p>";
                echo "</div>";
            } else {
                echo "<div class='container text-center'><p>No se encontraron resultados para el usuario SADCE: <b>$usadce</b></p></div>";
            }
            //$conn = null;
        }

        if ($usadce){
            $consultaCard = $conn->prepare("SELECT
                numcontrol,
                EXTRACT(YEAR FROM fecha) AS año,
                CASE
                    WHEN EXTRACT(MONTH FROM fecha) BETWEEN 1 AND 6 THEN 'Enero a Junio'
                    WHEN EXTRACT(MONTH FROM fecha) BETWEEN 8 AND 12 THEN 'Agosto a Diciembre'
                    ELSE 'Otro'
                END AS periodo,
                COUNT(*) AS total_respuestas
            FROM
                preguntav
            WHERE
                numcontrol = :numcontrol
            GROUP BY
                numcontrol,
                EXTRACT(YEAR FROM fecha),
                CASE
                    WHEN EXTRACT(MONTH FROM fecha) BETWEEN 1 AND 6 THEN 'Enero a Junio'
                    WHEN EXTRACT(MONTH FROM fecha) BETWEEN 8 AND 12 THEN 'Agosto a Diciembre'
                    ELSE 'Otro'
                END
            ORDER BY
                año, periodo");
                $consultaCard->bindParam(':numcontrol', $usadce);
        }

        /*
        SELECT
    numcontrol,
    EXTRACT(YEAR FROM fecha) AS año,
    CASE
        WHEN EXTRACT(MONTH FROM fecha) BETWEEN 1 AND 6 THEN 'Enero a Junio'
        WHEN EXTRACT(MONTH FROM fecha) BETWEEN 8 AND 12 THEN 'Agosto a Diciembre'
        ELSE 'Otro'
    END AS periodo,
    COUNT(*) AS total_respuestas
FROM
    preguntav
WHERE
    numcontrol = 'AARGOTE'
GROUP BY
    numcontrol,
    EXTRACT(YEAR FROM fecha),
    CASE
        WHEN EXTRACT(MONTH FROM fecha) BETWEEN 1 AND 6 THEN 'Enero a Junio'
        WHEN EXTRACT(MONTH FROM fecha) BETWEEN 8 AND 12 THEN 'Agosto a Diciembre'
        ELSE 'Otro'
    END
ORDER BY
    año, periodo;
        */
        ?>
        </div>
        <hr>
        <div style="margin-bottom: 20px;" class="row align-items-center">
            <div class="col-12 col-md-8">
                <p>Seleccione el periodo de evaluación...</p>
            </div>
            <div class="col-12 col-md-4 d-flex justify-content-end d-none d-md-flex">
                <button class="button" onclick="location.href='http://localhost/ejemplo/uaem-web-pantallas/resultados.html';">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"></path>
                    </svg>
                    <div class="text-btn">Regresar</div>
                </button>
            </div>
        </div>
        <!-- 
        <a href="http://localhost/ejemplo/uaem-web-pantallas/evaluaciondocente.html#reporte" class="button">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"></path>
                    </svg>
                    <div class="text"><h5>Regresar</h5></div>
                </a>
        
        Cards
        <div class="row d-flex">
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4">
                <div class="card" style="width: 18rem; cursor: pointer;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Modalidad: <br><b>${modalidad}</b></h5>
                        <p class="card-text">Periodo de Evaluación: <br><b>${periodo}</b></p>
                        <a href="http://localhost/ejemplo/uaem-web-pantallas/reportes/resultadosdocente.php" class="btn btn-primary">Consultar Reporte(s)</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4">
                <div class="card" style="width: 18rem; cursor: pointer;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Modalidad: <br><b>${modalidad}</b></h5>
                        <p class="card-text">Periodo de Evaluación: <br><b>${periodo}</b></p>
                        <a href="http://localhost/ejemplo/uaem-web-pantallas/reportes/resultadosdocente.php" class="btn btn-primary">Consultar Reporte(s)</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4">
                <div class="card" style="width: 18rem; cursor: pointer;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Modalidad: <br><b>${modalidad}</b></h5>
                        <p class="card-text">Periodo de Evaluación: <br><b>${periodo}</b></p>
                        <a href="http://localhost/ejemplo/uaem-web-pantallas/reportes/resultadosdocente.php" class="btn btn-primary">Consultar Reporte(s)</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4">
                <div class="card" style="width: 18rem; cursor: pointer;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Modalidad: <br><b>${modalidad}</b></h5>
                        <p class="card-text">Periodo de Evaluación: <br><b>${periodo}</b></p>
                        <a href="http://localhost/ejemplo/uaem-web-pantallas/reportes/resultadosdocente.php" class="btn btn-primary">Consultar Reporte(s)</a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4">
                <div class="card" style="width: 18rem; cursor: pointer;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Modalidad: <br><b>${modalidad}</b></h5>
                        <p class="card-text">Periodo de Evaluación: <br><b>${periodo}</b></p>
                        <a href="http://localhost/ejemplo/uaem-web-pantallas/reportes/resultadosdocente.php" class="btn btn-primary">Consultar Reporte(s)</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4">
                <div class="card" style="width: 18rem; cursor: pointer;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Modalidad: <br><b>${modalidad}</b></h5>
                        <p class="card-text">Periodo de Evaluación: <br><b>${periodo}</b></p>
                        <a href="http://localhost/ejemplo/uaem-web-pantallas/reportes/resultadosdocente.php" class="btn btn-primary">Consultar Reporte(s)</a>
                    </div>
                </div>
            </div>
            <div class=" col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4">
                <div class="card" style="width: 18rem; cursor: pointer;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Modalidad: <br><b>${modalidad}</b></h5>
                        <p class="card-text">Periodo de Evaluación: <br><b>${periodo}</b></p>
                        <a href="http://localhost/ejemplo/uaem-web-pantallas/reportes/resultadosdocente.php" class="btn btn-primary">Consultar Reporte(s)</a>
                    </div>
                </div>
            </div>
        </div>-->
    </div>
    </div>
    <div id="footerEvaContainer"></div>
    <script>
    function buscarUsuario() {
        var username = document.getElementById('usernameInput').value;
        
        // Validar que se haya ingresado un nombre de usuario antes de enviar la solicitud
        if (username.trim() === '') {
            document.getElementById('error-message').innerText = 'Por favor ingresa un nombre de usuario.';
            return;
        }

        // Limpiar mensajes de error previos
        document.getElementById('error-message').innerText = '';

    }
</script>
    <script src="http://localhost/ejemplo/uaem-web-pantallas/assets/js/loadHeader.js"></script>
    <script src="http://localhost/ejemplo/uaem-web-pantallas/assets/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="http://localhost/ejemplo/uaem-web-pantallas/assets/js/loadFooterEva.js"></script> -->
</body>
</html>
