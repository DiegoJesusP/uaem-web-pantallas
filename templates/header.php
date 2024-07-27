<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/css/header-styles.css">
</head>
<body>
    <header class="bg-blue py-2">
        <div class="container">
            <div class="row g-0 text-center d-flex justify-content-center align-items-center">
                <div class="col-12 col-md-2 order-md-1 mb-2 mb-md-0 mb-3">
                    <div class="header-image">
                        <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/index.php">
                            <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/img/LogoUAEMBlanco.png" alt="UAEM - Universidad - Morelos" class="img-fluid header-logo">
                        </a>
                    </div>
                </div>
                
                <div class="col-12 col-md-8 order-md-2">
                    <div class="header-text text-center">
                        <h3 class="mb-2">Universidad Autónoma del Estado de Morelos</h3>
                        <h4 class="mb-1">Secretaría Académica</h4>
                        <h4 class="mb-0">Dirección General de Educación Superior</h4>
                    </div>
                </div>
                <div class="col-12 col-md-2 order-md-3">
                    <div class="header-image">
                        <a href="https://www.uaem.mx/">
                            <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/img/TextoLogoUAEMBlanco.png" alt="UAEM" class="img-fluid header-logo">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
