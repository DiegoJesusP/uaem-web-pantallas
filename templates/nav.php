<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nav</title>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/css/nav-styles.css">
</head>
<body>
    <!-- NavBAR -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/evaluaciondocente.php">Evaluación Docente</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://sistemas2.dti.uaem.mx/evadocente/formacion/formacion/catalogo.php">Formación Docente</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://sistemas2.dti.uaem.mx/evadocente/formacion/formacion/doc_consulta.html">Documentos de Consulta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://sistemas2.dti.uaem.mx/evadocente/formacion/contacto.html">Contacto</a>
                    </li>
                </ul>
                <a class="navbar-brand ms-auto" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/index.php">UAEM</a>
            </div>
        </div>
    </nav>
    <script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>