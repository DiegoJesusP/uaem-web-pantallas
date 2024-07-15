<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected_card = isset($_POST['selected_card']) ? $_POST['selected_card'] : 'No seleccionado';
    $selected_periodo = isset($_POST['periodo']) ? $_POST['periodo'] : 'No seleccionado';
} else {
    $selected_card = 'No seleccionado';
    $selected_periodo = 'No seleccionado';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Institucional</title>
    <link rel="Shortcut Icon" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/img/uaem.ico" type="image/x-icon">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/css/styles.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/css/btn-regresar-styles.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/css/cards-sel-styles.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/css/select-styles.css">
    <style>
    .textB {
        font-family: 'Ubuntu';font-size: 22px;
    }
    .hidden {
        display: none;
    }
    .card a{
    background-color: #204C87;
    }
    .card a:hover{
        background-color: #001D7D;
    }
    .btnStyle button{
        background-color: #204C87;
        color: white;
    }
    .btnStyle button:hover{
        background-color: #001D7D;
        color: white;
        cursor: pointer;
    }
    
    </style>
</head>
<body style="background-color: #F6F6F6;">
    <div id="headerContainer"></div>
    
    <div class="container mt-4 textB">
        <h1 style="text-align: center;"><img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/img/calendario.png" alt="ubicacion" class="img-fluid icon alin">Resultado de la Institución</h1>
        <hr>
        <!-- Tipo informe (Cards Seleccion)-->
         <form method="post">
            <div class="form-group">
                <?php
                $informe = ['INSTITUCIONAL', 'DES', 'NIVEL MEDIO', 'NIVEL SUPERIOR Y POSTGRADO', 'HISTORICO'];

                ?>
                <p><b>Seleccione el tipo de informe que desee consultar.</b></p>
                <div class="container">
                    <div class="row justify-content-center">
                        <?php
                        foreach ($informe as $i) {
                            echo "<div class='col-lg-2 mb-4'>";
                            echo "<div class='card custom-card-sel' onclick='selectCard(this);selectPHP(\"$i\")'>";
                            echo "<div class='card-body'>";
                            echo "<h6 class='card-title position-absolute top-50 start-50 translate-middle'>$i</h6>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>
                <!-- DB -->
                 
                <?php
                include('./../php/conexion.php');
                $conexion = new CConexion();
                $conn = $conexion->conexionBD();

                $consulta = $conn->prepare("SELECT
                EXTRACT(YEAR FROM fecha) AS anio
                FROM preguntav
                GROUP BY EXTRACT(YEAR FROM fecha)
                ORDER BY anio");
                // Ejecuta la consulta
                $consulta->execute();

                // Obtiene los resultados
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                        
                
                ?>
                <!-- Periodo (Barra busqueda)-->
                <p id="periodo-label"><b>Seleccione el periodo...</b></p>
                <div class="row align-items-center">
                    <div class="container-input col-12 col-md-4 mb-3" id="periodo-container">
                        <select id="periodo-select" class="select-input" name="periodo" required>
                            <option value="0">Seleccione el periodo</option>
                            <?php
                                if ($resultado){
                                    foreach($resultado as $resultado){
                                        if ($resultado['anio'] != 0){
                                            echo "<option value='".$resultado['anio']."'>".$resultado['anio']."</option>";
                                        }
                                    }
                                }
                            ?>
                        </select>
                        <svg fill="#000000" width="50px" height="20px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
                            <path d="M790.588 1468.235c-373.722 0-677.647-303.924-677.647-677.647 0-373.722 303.925-677.647 677.647-677.647 373.723 0 677.647 303.925 677.647 677.647 0 373.723-303.924 677.647-677.647 677.647Zm596.781-160.715c120.396-138.692 193.807-319.285 193.807-516.932C1581.176 354.748 1226.428 0 790.588 0S0 354.748 0 790.588s354.748 790.588 790.588 790.588c197.647 0 378.24-73.411 516.932-193.807l516.028 516.142 79.963-79.963-516.142-516.028Z" fill-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="col-12 col-md-8 col-sm-12 d-flex justify-content-end btnStyle">
                        <input type="hidden" style="width: 10px;" name="selected_card" id="selected_card" value="">
                        <button type="submit" class="btn col-4 col-md-3" id="consultar-btn">Consultar</button>
                    </div>                
                </div>
            </div>
        </form>
        <?php
        
        ?>
        <!-- -->
        <hr>
        <!-- Confirmacion de seleccion en cards-->
        <div id="selected-card-info" class="bg-blue" style="border-radius: 20px;">
            <div id="titulo" class="header-text d-flex justify-content-center">
            <?php
                echo "<h2>".$selected_card. " - " .$selected_periodo."</h2>";
                ?>
            </div>
        </div>
        <div style="margin-bottom: 20px; margin-top: 20px;" class="row align-items-center">
            <div class="col-12 col-md-8">
                <p>Seleccione un informe...</p>
            </div>
            <div class="col-12 col-md-4 d-flex justify-content-end d-none d-md-flex">
                <button class="button" onclick="location.href='http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/resultados.php';">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"></path>
                    </svg>
                    <div class="text-btn">Regresar</div>
                </button>
            </div>
        </div>
        <div id="selection-info" class="mt-4"></div>
        <div class="mt-4">
        <?php
        switch ($selected_card){
            case 'INSTITUCIONAL':
                $consulta = $conn->prepare("SELECT DISTINCT
    EXTRACT(YEAR FROM fecha) AS anio,
    CASE
        WHEN EXTRACT(MONTH FROM fecha) BETWEEN 1 AND 6 THEN 'Enero a Junio'
        WHEN EXTRACT(MONTH FROM fecha) BETWEEN 8 AND 12 THEN 'Agosto a Diciembre'
        ELSE 'Otro'
    END AS periodo
FROM
    preguntav
WHERE
    EXTRACT(YEAR FROM fecha) = :anio
GROUP BY
    EXTRACT(YEAR FROM fecha),
    CASE
        WHEN EXTRACT(MONTH FROM fecha) BETWEEN 1 AND 6 THEN 'Enero a Junio'
        WHEN EXTRACT(MONTH FROM fecha) BETWEEN 8 AND 12 THEN 'Agosto a Diciembre'
        ELSE 'Otro'
    END
ORDER BY
    anio, periodo");
            // Ejecuta la consulta
            $consulta->bindParam(':anio', $selected_periodo);
            $consulta->execute();
            $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    
            if ($resultado) {
                echo "<div class='row d-flex'>";
                foreach ($resultado as $fila) {
                    echo "<div class='col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4'>";
                    echo "<div class='card' style='width: 18rem; cursor: pointer;'>";
                    echo "<div class='card-body text-center'>";
                    echo "<h5 class='card-title'>Periodo de Evaluación: <br><b>" . $fila['periodo'] . "</b> <br><b>" . $fila['anio'] . "</b></h5>";
                    echo "<a href='http://localhost/ejemplo/uaem-web-pantallas/reportes/reportesInstitucional.php' data-selected_card='" . $selected_card . "' data-periodo='" . $fila['periodo'] . "' data-anio='" . $selected_periodo . "' class='btn btn-primary consultar-reporte'>Consultar Reporte(s)</a>";
                    //echo "<a href='http://localhost/ejemplo/uaem-web-pantallas/reportes/reportesInstitucional.php' class='btn btn-primary consultar-reporte'>Consultar Reporte(s)</a>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<div class='d-flex justify-content-center'>";
                echo "<p>No se encontró el periodo.</p>";
                echo "</div>";
            }
                break;
            case 'DES':
                echo "<div class='d-flex justify-content-center'>";
                echo "<p>Este sistema no esta validado para $selected_card</p>";
                echo "</div>";
                break;
            case 'NIVEL MEDIO':
                echo "<div class='d-flex justify-content-center'>";
                echo "<p>Este sistema no esta validado para $selected_card</p>";
                echo "</div>";
                break;
            case 'NIVEL SUPERIOR Y POSTGRADO':
                echo "<div class='d-flex justify-content-center'>";
                echo "<p>Este sistema no esta validado para $selected_card</p>";
                echo "</div>";
                break;
            case 'HISTORICO':
                echo "<div class='d-flex justify-content-center'>";
                echo "<p>Este sistema no esta validado para $selected_card</p>";
                echo "</div>";         
                break;
            default:
                echo "<div class='d-flex justify-content-center'>";
                echo "<p>Cada Cuando se muestra esto?</p>";
                echo "</div>";
                break;
        }
        ?>
        </div>
    </div>

    <script>
         function selectPHP(cardName) {
            document.getElementById('selected_card').value = cardName;
        }
        function selectCard(card) {
            // Deseleccionar todas las tarjetas
            var cards = document.querySelectorAll('.custom-card-sel');
            cards.forEach(function(c) {
                c.classList.remove('selected');
            });

            // Seleccionar la tarjeta clicada
            card.classList.add('selected');

            // Mostrar el campo de periodo
            document.getElementById('periodo-label').classList.remove('hidden');
            document.getElementById('periodo-container').classList.remove('hidden');

            // Obtener el texto de la tarjeta seleccionada
            var selectedText = card.querySelector('.card-title').innerText;

            // Obtener el texto del periodo seleccionado
            var periodoSelect = document.getElementById('periodo-select');
            var selectedPeriodo = periodoSelect.options[periodoSelect.selectedIndex].text;

            // Actualizar el elemento con el texto seleccionado
            document.getElementById('selection-info').innerText = 'Seleccionaste: ' + selectedText + ' - ' + selectedPeriodo;

            // Limpiar el contenido anterior y crear un nuevo div
            const selectedCardInfo = document.getElementById('titulo');
            selectedCardInfo.innerHTML = '';  // Limpiar el contenido anterior
            selectedCardInfo.innerHTML = `<h2><span>${selectedText}</span> - <span>${selectedPeriodo}</span></h2>`;  // Añadir el nuevo contenido
        }

        // Agregar evento change al select para actualizar el texto seleccionado cuando se cambie el periodo
        document.getElementById('periodo-select').addEventListener('change', function() {
            var selectedCard = document.querySelector('.custom-card-sel.selected');
            if (selectedCard) {
                selectCard(selectedCard);
            } else {
                var periodoSelect = document.getElementById('periodo-select');
                var selectedPeriodo = periodoSelect.options[periodoSelect.selectedIndex].text;
                document.getElementById('selection-info').innerText = 'Seleccionaste: Ninguno - ' + selectedPeriodo;
                const selectedCardInfo = document.getElementById('titulo');
                selectedCardInfo.innerHTML = `<h2>INFORME <span>Ninguno</span> - <span>${selectedPeriodo}</span></h2>`;
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
    var buttons = document.querySelectorAll('.consultar-reporte');
    
        buttons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                var numcontrol = button.getAttribute('data-numcontrol');
                var periodo = button.getAttribute('data-periodo');
                var anio = button.getAttribute('data-anio');
                window.location.href = 'http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/reportes/reportesInstitucional.php?selected_card=' + selected_card + '&periodo=' + encodeURIComponent(periodo) + '&anio=' + anio;
            });
        });
    });
    </script>
    <script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/js/bootstrap.bundle.min.js"></script>
    <script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/uaem-web-pantallas/assets/js/loadHeader.js"></script>
</body>
</html>