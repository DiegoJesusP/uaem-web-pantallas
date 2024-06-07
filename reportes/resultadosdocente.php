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
        font-family: 'Aleo';font-size: 22px;
    }
    </style>
</head>
<body>
    <div id="headerContainer"></div>
    <div class="container textB">
        <h1 style="text-align: center;" class="mt-3 mb-3"><img src="http://localhost/ejemplo/uaem-web-pantallas/assets/img/encuesta_f.png" alt="ubicacion" class="img-fluid icon alin" style="width: 64px; height: 64px;">Resultados del Docente</h1>
        
        <hr>
        <div class="col-12 d-flex justify-content-end">
            <a href="#" style="color: red; margin-bottom: 10px;">Instructivo<img src="http://localhost/ejemplo/uaem-web-pantallas/assets/img/libro.png" alt="ubicacion" class="img-fluid icon alin" style="width: 47px; height: 50px;"></a>
        </div>
        <div id="selected-card-info" class="bg-blue" style="border-radius: 20px;">
            <div class="header-text text-center">
                <h2 class="mb-3">REPORTE INDIVIDUAL</h2>
                <h2 class="mb-3">PERIODO: Agosto-Diciembre 2023</h2>
            </div>
        </div>
        <div style="margin-top: 20px;">
            <p>Nombre del docente: <b><span id="nombredocente"></span></b></p>
            <p>Núm. de reportes: <b><span id="numreportes"></span></b></p>
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
    </div>
    <!-- Botón regresar 
    <div class="fixed-button-container">
        <a href="http://localhost/ejemplo/uaem-web-pantallas/reportes/docente.php" class="button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"></path>
            </svg>
            <div class="text"><h5>Regresar</h5></div>
        </a>
    </div>-->
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
