<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes Docente</title>
    <link rel="Shortcut Icon" href="http://localhost/ejemplo/uaem-web-pantallas/assets/img/uaem.ico" type="image/x-icon">
    <link rel="stylesheet" href="http://localhost/ejemplo/uaem-web-pantallas/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://localhost/ejemplo/uaem-web-pantallas/assets/css/styles.css">
    <link rel="stylesheet" href="http://localhost/ejemplo/uaem-web-pantallas/assets/css/btn-regresar-styles.css">
</head>
<body>
    <div class="container">
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
        <div style="margin-bottom: 20px;" class="row">
            <div class="col-12 d-flex justify-content-start d-none d-md-flex">
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
        <?php
        include('./../php/conexion.php');
        $conexion = new CConexion();
        $conn = $conexion->conexionBD();

        if ($_SERVER["REQUEST_METHOD"] == "GET") {

            // Prepara la consulta SQL
            $consulta = $conn->prepare("SELECT * FROM preguntav WHERE numcontrol = :numcontrol AND id_grupo = :id_grupo AND acta_id = :acta_id");
            // Vincula los parámetros
            $consulta->bindParam(':numcontrol', $numcontrol);
            $consulta->bindParam(':id_grupo', $id_grupo);
            $consulta->bindParam(':acta_id', $acta_id);
            // Ejecuta la consulta
            $consulta->execute();

            // Obtiene los resultados
            $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
            // Muestra los resultados
            echo "c:";
            foreach ($resultado as $fila) {
                echo "<hr>";
                echo "<p>respuesta 1: " . $fila['r1'] . "</p>";
                echo "<p>respuesta 2: " . $fila['r2'] . "</p>";
                echo "<p>respuesta 3: " . $fila['r3'] . "</p>";
                echo "<p>respuesta 4: " . $fila['r4'] . "</p>";
                echo "<p>respuesta 5: " . $fila['r5'] . "</p>";
                echo "<p>respuesta 6: " . $fila['r6'] . "</p>";
                echo "<p>respuesta 7: " . $fila['r7'] . "</p>";
                echo "<p>respuesta 8: " . $fila['r8'] . "</p>";
                echo "<p>respuesta 9: " . $fila['r9'] . "</p>";
                echo "<p>respuesta 10: " . $fila['r10'] . "</p>";
                echo "<p>respuesta 11: " . $fila['r11'] . "</p>";
                echo "<p>respuesta 12: " . $fila['r12'] . "</p>";
                echo "<p>respuesta 13: " . $fila['r13'] . "</p>";
                echo "<p>respuesta 14: " . $fila['r14'] . "</p>";
                echo "<p>respuesta 15: " . $fila['r15'] . "</p>";
                echo "<p>respuesta 16: " . $fila['r16'] . "</p>";
                echo "<p>respuesta 17: " . $fila['r17'] . "</p>";
                echo "<p>respuesta 18: " . $fila['r18'] . "</p>";
                echo "<p>respuesta 19: " . $fila['r19'] . "</p>";
                echo "<p>respuesta 20: " . $fila['r20'] . "</p>";
                echo "<p>respuesta 21: " . $fila['r21'] . "</p>";
                echo "<p>respuesta 22: " . $fila['r22'] . "</p>";
                echo "<p>respuesta 23: " . $fila['r23'] . "</p>";
                // Aquí puedes mostrar más campos según sea necesario
            }
            echo "<hr>";
            echo "hola -.-";
        }
        echo "buenas criaturitas";
        ?>
    </div>
</body>
</html>
