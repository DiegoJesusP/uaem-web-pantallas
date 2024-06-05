<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Institucional</title>
    <link rel="stylesheet" href="./../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./../assets/css/styles.css">
    <link rel="stylesheet" href="./../assets/css/btn-regresar-styles.css">
    <link rel="stylesheet" href="./../assets/css/cards-sel-styles.css">
    <link rel="stylesheet" href="./../assets/css/select-styles.css">
</head>
<body style="background-color: #F6F6F6;">
    <div id="headerContainer"></div>
    
    <div class="container mt-4">
        <h1 style="text-align: center;"><img src="./../assets/img/calendario.png" alt="ubicacion" class="img-fluid icon alin">Resultado de la Institución</h1>
        <hr>
        <!-- Tipo informe (Cards Seleccion)-->
        <p><b>Seleccione el tipo de informe que desee consultar.</b></p>
        <div class="row">
            <div class="col-lg-2 mb-4">
                <div class="card custom-card-sel" onclick="selectCard(this)">
                    <div class="card-body">
                        <h6 class="card-title position-absolute top-50 start-50 translate-middle">INSTITUCIONAL</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 mb-4">
                <div class="card custom-card-sel" onclick="selectCard(this)">
                    <div class="card-body">
                        <h6 class="card-title position-absolute top-50 start-50 translate-middle">DES</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 mb-4">
                <div class="card custom-card-sel" onclick="selectCard(this)">
                    <div class="card-body">
                        <h6 class="card-title position-absolute top-50 start-50 translate-middle">NIVEL MEDIO</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 mb-4">
                <div class="card custom-card-sel" onclick="selectCard(this)">
                    <div class="card-body">
                        <h6 class="card-title position-absolute top-50 start-50 translate-middle">SUPERIOR</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 mb-4">
                <div class="card custom-card-sel" onclick="selectCard(this)">
                    <div class="card-body">
                        <h6 class="card-title position-absolute top-50 start-50 translate-middle">NIVEL SUPERIOR Y POSTGRADO</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 mb-4">
                <div class="card custom-card-sel" onclick="selectCard(this)">
                    <div class="card-body">
                        <h6 class="card-title position-absolute top-50 start-50 translate-middle">HISTORICO</h6>
                    </div>
                </div>
            </div>
        </div>
        <!-- Periodo (Barra busqueda)-->
        <p><b>Seleccione el periodo...</b></p>
        <div class="container-input">
            <select id="periodo-select" class="select-input">
                <option value="0">Seleccione el periodo</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
            </select>
            <svg fill="#000000" width="20px" height="20px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
                <path d="M790.588 1468.235c-373.722 0-677.647-303.924-677.647-677.647 0-373.722 303.925-677.647 677.647-677.647 373.723 0 677.647 303.925 677.647 677.647 0 373.723-303.924 677.647-677.647 677.647Zm596.781-160.715c120.396-138.692 193.807-319.285 193.807-516.932C1581.176 354.748 1226.428 0 790.588 0S0 354.748 0 790.588s354.748 790.588 790.588 790.588c197.647 0 378.24-73.411 516.932-193.807l516.028 516.142 79.963-79.963-516.142-516.028Z" fill-rule="evenodd"></path>
            </svg>
        </div>
        <hr>
        <!-- Confirmacion de seleccion en cards-->
        <div id="selected-card-info" class="bg-blue" style="border-radius: 20px;">
            <div id="titulo" class="header-text d-flex justify-content-center"></div>
        </div>
        <div id="selection-info" class="mt-4"></div>
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
        function selectCard(card) {
            // Deseleccionar todas las tarjetas
            var cards = document.querySelectorAll('.custom-card-sel');
            cards.forEach(function(c) {
                c.classList.remove('selected');
            });

            // Seleccionar la tarjeta clicada
            card.classList.add('selected');

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
            selectedCardInfo.innerHTML = `<h2>INFORME <span>${selectedText}</span> - <span>${selectedPeriodo}</span></h2>`;  // Añadir el nuevo contenido
        }

        document.addEventListener('DOMContentLoaded', function() {
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
        });

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
    </script>
    <script src="./../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
