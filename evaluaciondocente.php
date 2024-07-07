<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluación Docente</title>
    <link rel="Shortcut Icon" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/ejemplo/uaem-web-pantallas/assets/img/uaem.ico" type="image/x-icon">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/ejemplo/uaem-web-pantallas/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/ejemplo/uaem-web-pantallas/assets/css/styles.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/ejemplo/uaem-web-pantallas/assets/css/cards-evadocente-styles.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/ejemplo/uaem-web-pantallas/assets/css/footer-styles.css">
</head>
<body style="background-color: #F6F6F6;">
    <div id="headerContainer"></div>
    <!-- NavBAR -->
    <div id="navContainer"></div>
    <!-- Body -->
    <div class="container">
        <div class="row">
    
            <!-- Vertical Navigation -->
            <div class="col-lg-2">
                <ul class="list-unstyled vertical-nav">
                    <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/ejemplo/uaem-web-pantallas/evaluaciondocente.php" class="btn btn-block my-1 custom-btn-lateral">Instrumento de evaluación docente</a></li>
                    <li><a href="http://sistemas2.dti.uaem.mx/evadocente/formacion/evaluacion/cronograma.html" class="btn btn-block my-1 custom-btn-lateral">Cronograma</a></li>
                    <li><a href="http://sistemas2.dti.uaem.mx/evadocente/formacion/evaluacion/fechas.php" class="btn btn-block my-1 custom-btn-lateral">Fechas de aplicación</a></li>
                    <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/ejemplo/uaem-web-pantallas/resultados.php" class="btn btn-block my-1 custom-btn-lateral">Reporte de Resultados</a></li>
                    <li><a href="http://sistemas2.dti.uaem.mx/evadocente/formacion/evaluacion/monitoreo.html" class="btn btn-block my-1 custom-btn-lateral">Monitoreo</a></li>
                </ul>
            </div>            
            <!-- Main Content -->
            <div class="col-lg-10 d-flex flex-column">
                <section id="instrumento">
                    <h1 class="mt-3"><img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/ejemplo/uaem-web-pantallas/assets/img/instrumento.png" alt="ubicacion" class="img-fluid icon"> Instrumento de evaluación docente</h1>
                    <hr>
                    <div class="content-section">
                        <p>En este proceso de Evaluación y Formación Docente, se considera una vertiente amplia que reconoce al personal académico como sujeto crítico, auto-reflexivo y participativo, mediador y facilitador de experiencias para estimular y facilitar el aprendizaje de los estudiantes, que a partir de su participación en los procesos de evaluación y formación, realiza un ejercicio que lo conduce a comprender, reflexionar y mejorar su actividad académica para la transformación de los procesos.</p>
                        <br>
                        <p>De esta manera, se parte de considerar <b>el proceso de la evaluación docente, como un ejercicio reflexivo de su práctica, a través de medios valorativos que permitan detectar debilidades y reconocer fortalezas.</b> Sus principios descansan en términos de orientación formativa, participativa, humanista, multidimensional y multireferencial, hacia la búsqueda e inmersión de fuentes de apoyo para su propio perfeccionamiento.</p>
                        <div class="container-fluid">
                            <div class="row text-center">
                                <div class="col-12 col-md-6  text-white p-1">
                                    <div style="background-color: #41538F; color: #ffffff; border-radius: 65px 0 0 0;"><h2>Si usted es Docente</h2></div>
                                    <div class="p-4" style="background-color: #7a91db;">
                                        <div class="card custom-card">
                                            <div class="card-body">
                                                <h5 class="card-title">Autoevaluación Docente</h5>
                                                <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/ejemplo/uaem-web-pantallas/assets/img/docente.png" class="card-img-top mb-3" alt="Docente">
                                                <p class="card-text">Si usted es docente, haga clic en el siguiente botón</p>
                                                <a href="http://sistemas2.dti.uaem.mx/evadocente/formacion/evaluacion/evaluaciond.php" class="btn" style="background-color: #41538F; color: #ffffff;">Entrar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6  text-white p-1">
                                    <div style="background-color: #f38620; color: #ffffff; border-radius: 0 65px 0 0;"><h2>Si eres Estudiante</h2></div>
                                    <div class="p-4" style="background-color: #eeb178;">
                                        <div class="card custom-card">
                                            <div class="card-body">
                                                <h5 class="card-title">Opinión de Estudiantes</h5>
                                                <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/ejemplo/uaem-web-pantallas/assets/img/alumno.png" class="card-img-top mb-3" alt="Estudiante">
                                                <p class="card-text">Si eres estudiante, haz clic en el siguiente botón</p>
                                                <a href="http://sistemas2.dti.uaem.mx/evadocente/formacion/evaluacion/evaluacione.php" class="btn" style="background-color: #f18117; color: #ffffff;">Entrar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    
    <div id="footerContainer"></div>
    <!-- Scripts -->
    <script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/ejemplo/uaem-web-pantallas/assets/js/bootstrap.bundle.min.js"></script>
    <script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/ejemplo/uaem-web-pantallas/assets/js/loadHeader.js"></script>
    <script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/ejemplo/uaem-web-pantallas/assets/js/loadFooter.js"></script>
    <script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/ejemplo/uaem-web-pantallas/assets/js/loadNav.js"></script>
    <script>
            function redirectToInstitucion() {
        window.location.href = 'http://<?php echo $_SERVER['HTTP_HOST']; ?>/ejemplo/uaem-web-pantallas/reportes/institucion.php';
    }
    </script>
</body>
</html>
