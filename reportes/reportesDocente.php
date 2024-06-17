<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes Docente</title>
    <link rel="Shortcut Icon" href="http://localhost/ejemplo/uaem-web-pantallas/assets/img/uaem.ico" type="image/x-icon">
</head>
<body>
    <?php
    $numcontrol = '';
    $id_grupo = 0;
    $acta_id = 0;
    $periodo = '';
    $anio = 0;

    if (isset($_GET['numcontrol'])) {
        $numcontrol = htmlspecialchars($_GET['numcontrol']);
        echo "$numcontrol<br>";
    } else {
        echo "No se ha proporcionado un número de control.<br>";
    }

    if (isset($_GET['id_grupo'])) {
        $id_grupo = htmlspecialchars($_GET['id_grupo']);
        echo "$id_grupo<br>";
    } else {
        echo "No se ha proporcionado un id_grupo.<br>";
    }

    if (isset($_GET['acta_id'])) {
        $acta_id = htmlspecialchars($_GET['acta_id']);
        echo "$acta_id<br>";
    } else {
        echo "No se ha proporcionado un acta_id.<br>";
    }

    if (isset($_GET['periodo'])) {
        $periodo = htmlspecialchars($_GET['periodo']);
        echo "$periodo<br>";
    } else {
        echo "No se ha proporcionado un periodo.<br>";
    }

    if (isset($_GET['anio'])) {
        $anio = htmlspecialchars($_GET['anio']);
        echo "$anio<br>";
    } else {
        echo "No se ha proporcionado un año.<br>";
    }
    ?>
    <div style="margin-bottom: 20px;" class="row align-items-center">
        <div class="col-12 col-md-8">
            <b>Seleccione un reporte individual...</b>
        </div>
        <div class="col-12 col-md-4 d-flex justify-content-end d-none d-md-flex">
            <button class="button" onclick="location.href='http://localhost/ejemplo/uaem-web-pantallas/reportes/resultadosdocente.php?numcontrol=<?php echo $numcontrol; ?>&id_grupo=<?php echo $id_grupo; ?>&acta_id=<?php echo $acta_id; ?>&periodo=<?php echo urlencode($periodo); ?>&anio=<?php echo $anio; ?>';">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"></path>
                </svg>
                <div class="text-btn">Regresar</div>
            </button>
        </div>
    </div>
    <h2>reportesDocente PHP</h2>
    <p>Aqui se generaria un reporte en php, pero luego trabajamos en ello</p>
</body>
</html>
