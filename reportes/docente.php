<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Docente</title>
    <link rel="stylesheet" href="./../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./../assets/css/styles.css">
    <link rel="stylesheet" href="./../assets/css/btn-regresar-styles.css">
    <link rel="stylesheet" href="./../assets/css/search-styles.css">
    <link rel="stylesheet" href="./../assets/css/buttons-search-styles.css">
    <link rel="stylesheet" href="./../assets/css/cards-styles.css">
</head>
<body style="background-color: #F6F6F6;">
    <div id="headerContainer"></div>
    <div class="container mt-4 min-vh-100">
        <h1 style="text-align: center;"><img src="./../assets/img/encuesta.png" alt="ubicacion" class="img-fluid icon alin" style="width: 64px; height: 64px;">Resultados del Docente</h1>
        <hr>
        <div class="container text-center">
            <h5>Nombre de usuario SADCE</h5>
            <div class="row row-cols-auto justify-content-center">
                <div class="col">
                    <input type="text" placeholder="Nombre de usuario" name="text" class="shadow input">
                </div>
                <div class="col">
                    <button class="boton-buscar shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <hr>
        <div id="selected-card-info" class="bg-blue" style="border-radius: 20px;">
            <div class="header-text text-center">
                <h2 class="mb-3">Datos generales del docente</h2>
            </div>
        </div>
        <p>Nombre Docente:</p>
        <p>Usuario Sadce:</p>
        <hr>
        <p>Seleccione el periodo de evaluacion</p>
        <div class="row d-flex justify-content-center">
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4">
                <div class="card" style="width: 18rem; cursor: pointer;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Modalidad: <br><b>${modalidad}</b></h5>
                        <p class="card-text">Periodo de Evaluación: <br><b>${periodo}</b></p>
                        <a href="./resultadosdocente.html" class="btn btn-primary">Consultar Reporte(s)</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4">
                <div class="card" style="width: 18rem; cursor: pointer;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Modalidad: <br><b>${modalidad}</b></h5>
                        <p class="card-text">Periodo de Evaluación: <br><b>${periodo}</b></p>
                        <a href="./resultadosdocente.html" class="btn btn-primary">Consultar Reporte(s)</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4">
                <div class="card" style="width: 18rem; cursor: pointer;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Modalidad: <br><b>${modalidad}</b></h5>
                        <p class="card-text">Periodo de Evaluación: <br><b>${periodo}</b></p>
                        <a href="./resultadosdocente.html" class="btn btn-primary">Consultar Reporte(s)</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4">
                <div class="card" style="width: 18rem; cursor: pointer;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Modalidad: <br><b>${modalidad}</b></h5>
                        <p class="card-text">Periodo de Evaluación: <br><b>${periodo}</b></p>
                        <a href="./resultadosdocente.html" class="btn btn-primary">Consultar Reporte(s)</a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4">
                <div class="card" style="width: 18rem; cursor: pointer;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Modalidad: <br><b>${modalidad}</b></h5>
                        <p class="card-text">Periodo de Evaluación: <br><b>${periodo}</b></p>
                        <a href="./resultadosdocente.html" class="btn btn-primary">Consultar Reporte(s)</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4">
                <div class="card" style="width: 18rem; cursor: pointer;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Modalidad: <br><b>${modalidad}</b></h5>
                        <p class="card-text">Periodo de Evaluación: <br><b>${periodo}</b></p>
                        <a href="./resultadosdocente.html" class="btn btn-primary">Consultar Reporte(s)</a>
                    </div>
                </div>
            </div>
            <div class=" col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4">
                <div class="card" style="width: 18rem; cursor: pointer;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Modalidad: <br><b>${modalidad}</b></h5>
                        <p class="card-text">Periodo de Evaluación: <br><b>${periodo}</b></p>
                        <a href="./resultadosdocente.html" class="btn btn-primary">Consultar Reporte(s)</a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <!-- botton regresar -->
    <div class="fixed-button-container d-none d-md-block d-xl-block d-xxl-block">
        <a href="./../evaluaciondocente.html#reporte" class="button">
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
        fetch('./../templates/footer.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('footerContainer').innerHTML = data;
            });
    </script>
    <script src="./../js/bootstrap.bundle.min.js"></script>
</body>
</html>
