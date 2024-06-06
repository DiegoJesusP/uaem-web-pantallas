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
</head>
<body>
    <div id="headerContainer"></div>
    <div class="container">
        
        <h1 class="mt-5">Resultados Docente</h1>
        
        <hr>
        <a>Instructivo</a>
        <div id="selected-card-info" class="bg-blue" style="border-radius: 20px;">
            <div class="header-text text-center">
                <h2 class="mb-3">REPORTE INDIVIDUAL</h2>
                <h2 class="mb-3">PERIODO: Agosto-Diciembre 2023</h2>
            </div>
        </div>
        <p>Nombre del docente:</p>
       
        <p>Núm. de reportes</p>
        <hr>
        <p>reporte Individual</p>
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-4">
                <div class="card" style="width: 18rem; cursor: pointer;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Modalidad: <br><b>${modalidad}</b></h5>
                        <p class="card-text">Periodo de Evaluación: <br><b>${periodo}</b></p>
                        <a href="http://localhost/ejemplo/uaem-web-pantallas/reportes/reportesDocente.php" class="btn btn-primary">Generar</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-4">
                <div class="card" style="width: 18rem; cursor: pointer;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Modalidad: <br><b>${modalidad}</b></h5>
                        <p class="card-text">Periodo de Evaluación: <br><b>${periodo}</b></p>
                        <a href="http://localhost/ejemplo/uaem-web-pantallas/reportes/reportesDocente.php" class="btn btn-primary">Generar</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-4">
                <div class="card" style="width: 18rem; cursor: pointer;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Modalidad: <br><b>${modalidad}</b></h5>
                        <p class="card-text">Periodo de Evaluación: <br><b>${periodo}</b></p>
                        <a href="http://localhost/ejemplo/uaem-web-pantallas/reportes/reportesDocente.php" class="btn btn-primary">Generar</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-4">
                <div class="card" style="width: 18rem; cursor: pointer;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Modalidad: <br><b>${modalidad}</b></h5>
                        <p class="card-text">Periodo de Evaluación: <br><b>${periodo}</b></p>
                        <a href="http://localhost/ejemplo/uaem-web-pantallas/reportes/reportesDocente.php" class="btn btn-primary">Generar</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-4">
                <div class="card" style="width: 18rem; cursor: pointer;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Modalidad: <br><b>${modalidad}</b></h5>
                        <p class="card-text">Periodo de Evaluación: <br><b>${periodo}</b></p>
                        <a href="http://localhost/ejemplo/uaem-web-pantallas/reportes/reportesDocente.php" class="btn btn-primary">Generar</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-4">
                <div class="card" style="width: 18rem; cursor: pointer;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Modalidad: <br><b>${modalidad}</b></h5>
                        <p class="card-text">Periodo de Evaluación: <br><b>${periodo}</b></p>
                        <a href="http://localhost/ejemplo/uaem-web-pantallas/reportes/reportesDocente.php" class="btn btn-primary">Generar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Botón regresar -->
    <div class="fixed-button-container">
        <a href="./docente.html" class="button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"></path>
            </svg>
            <div class="text"><h5>Regresar</h5></div>
        </a>
    </div>
    <script>
        fetch('./../templates/header.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('headerContainer').innerHTML = data;
            });
        fetch('./templates/footer.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('footerContainer').innerHTML = data;
            });
    </script>
    <script src="./../js/bootstrap.bundle.min.js"></script>
</body>
</html>
