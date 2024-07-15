<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluación Docente</title>
    <link rel="Shortcut Icon" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/img/uaem.ico" type="image/x-icon">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/css/styles.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/css/cards-evadocente-styles.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/css/footer-styles.css">
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
                    <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/evaluaciondocente.php" class="btn btn-block my-1 custom-btn-lateral">Instrumento de evaluación docente</a></li>
                    <li><a href="http://sistemas2.dti.uaem.mx/evadocente/formacion/evaluacion/cronograma.html" class="btn btn-block my-1 custom-btn-lateral">Cronograma</a></li>
                    <li><a href="http://sistemas2.dti.uaem.mx/evadocente/formacion/evaluacion/fechas.php" class="btn btn-block my-1 custom-btn-lateral">Fechas de aplicación</a></li>
                    <li><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/resultados.php" class="btn btn-block my-1 custom-btn-lateral">Reporte de Resultados</a></li>
                    <li><a href="http://sistemas2.dti.uaem.mx/evadocente/formacion/evaluacion/monitoreo.html" class="btn btn-block my-1 custom-btn-lateral">Monitoreo</a></li>
                </ul>
            </div>            
            <!-- Main Content -->
            <div class="col-lg-10 d-flex flex-column">
                <section id="reporte">
                    <h1 class="mt-3"><img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/img/resultados.png" alt="ubicacion" class="img-fluid icon">Reporte de Resultados</h1>
                    <hr>
                    <div class="content-section">
                        <p>Los reportes se elaboran en tres niveles:</p>
                        <ul>
                            <li><b>Institucional:</b> análisis cuantitativo general de los resultados de evaluación del desempeño docente; por nivel educativo, unidad académica y dimensión de evaluación.</li>
                            <br>
                            <li><strong>Unidad académica:</strong> análisis cuantitativo de los resultados obtenidos por los trabajadores universitarios que integran la plantilla docente adscrita a una unidad académica, el reporte incluye resultados por programa educativo.</li>
                            <br>
                            <li><strong>Individual:</strong> análisis cuantitativo que comprende un marco de referencia institucional sobre los resultados de la UAEM, del nivel educativo, en el que fue evaluado, de su unidad académica y un promedio global de las asignaturas en las que fue evaluado su desempeño docente. Este reporte es de carácter estrictamente confidencial.</li>
                        </ul>
                    </div>
                    <div class="container-fluid">
                        <div class="row text-center">
                            <div class="col-12 col-md-6 text-white p-4">
                                <div class="card mb-4 custom-card">
                                    <h5 class="card-title">INSTITUCIÓN</h5>
                                    <div class="card-body">
                                        <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/img/resultado_escuela.png" class="card-img-top" alt="Descripción de la imagen 2">
                                        <p class="card-text">Resultados de la institución.</p>
                                        <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/reportes/institucion.php" class="btn btn-primary" onclick="redirectToInstitucion()">Entrar</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 text-white p-4">
                                <div class="card mb-4 custom-card">
                                    <h5 class="card-title">DOCENTE</h5>
                                    <div class="card-body">
                                        <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/img/resultado_docente.png" class="card-img-top" alt="Descripción de la imagen 2">
                                        <p class="card-text">Resultados del docente.</p>
                                        <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/reportes/docente.php" class="btn btn-primary">Entrar</a>
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
    <script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/js/bootstrap.bundle.min.js"></script>
    <script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/js/loadHeader.js"></script>
    <script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/js/loadFooter.js"></script>
    <script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/js/loadNav.js"></script>
    <script>
            function redirectToInstitucion() {
        window.location.href = 'http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/reportes/institucion.php';
    }
    </script>
</body>
</html>
