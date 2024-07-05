<?php
require('./../library/fpdf/fpdf.php');
include('./../php/conexion.php');

function convertirTexto($texto) {
    // Convertir el texto a minúsculas con soporte para UTF-8
    $texto = mb_strtolower($texto, 'UTF-8');
    // Convertir la primera letra de cada palabra a mayúscula con soporte para UTF-8
    $texto = mb_convert_case($texto, MB_CASE_TITLE, 'UTF-8');
    return $texto;
}

// Clase PDF
class PDF extends FPDF{
    // Cabecera del pdf
    function Header(){
        // Background color
        $this->SetFillColor(48, 83, 149); // Azul
        $this->SetDrawColor(48, 83, 149); // Azul
        $this->Rect(10, 10, $this->w - 21, 20, 'DF'); // Rectángulo lleno
        //$this->Ln(0);
        
        // Logo
        $this->Image('./../assets/img/LogoUAEMBlanco.png', 13, 12, 25);
        
        // Título
        $this->SetFont('Arial', 'B', 13);
        $this->SetTextColor(255, 255, 255); // Blanco
        $this->Cell(0, 20, utf8_decode("Reporte de evaluación de asignaturas híbridas y virtuales"), 0, 1, 'C');
        
        // Fondo gris para el subtítulo
        $this->SetFillColor(231, 230, 230); // Gris
        $this->Rect(10, $this->GetY(), $this->w -21, 13, 'DF'); // Rectángulo lleno para subtítulo
        
        // Subtítulo
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(0, 0, 0); // Negro
        $this->setY(20);
        $this->Cell(0, 29, utf8_decode("Opinión de Estudiantes"), 0, 1, 'C');
        
        // Obtener el valor del período desde el parámetro GET
        if (isset($_GET['periodo'])) {
            $periodo = htmlspecialchars($_GET['periodo']);
        } else {
            $periodo = 'No está definido "periodo"';
        }
        if (isset($_GET['anio'])) {
            $anio = htmlspecialchars($_GET['anio']);
        } else {
            $anio = 'No está definido "anio"';
        }
        
        // Mostrar el valor del período de manera dinámica
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, -18, 'Periodo: ' . $periodo . " " . $anio, 0, 1, 'C');
        
        $this->Ln(12);
    }
    // Pie de página
    function Footer(){
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . ' / {nb}', 0, 0, 'C');
    }
    //
    function Separador(){
        $this->SetFillColor(48, 83, 149);
        $this->Cell(189, 2, '', 'LR', 0, 'C', true);
        $this->Ln();
    }
    //
    function SeparadorT($title, $fillColor = [255, 255, 255]){
        $this->SetFillColor(48, 83, 149);
        if ($fillColor) {
            $this->SetFillColor(...$fillColor);
        }
        if ($title) {
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(189, 6, utf8_decode($title), 'LR', 0, 'C', true);
        }
        $this->Ln();
    }
    //
    function TablaInicio($dataI, $promedioI) {
        // Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(48, 83, 149); // Azul
        $this->SetTextColor(255);
        $this->SetDrawColor(48, 83, 149); // Azul
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B', 10);
        
        // Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255); // Azul claro
        $this->SetTextColor(0);
        $this->SetFont('');
        
        // Datos estáticos combinados con datos de la base de datos
        $this->SetFont('Arial', '', 10);
        $this->Cell(70, 6, utf8_decode('Unidad Académica:'), 'LR', 0, 'L', true);
        $this->SetFont('Arial', 'B', 10);
        $unidadAcademica = convertirTexto($dataI['unidad']);
        $this->Cell(119, 6, utf8_decode($unidadAcademica), 'LR', 0, 'C', true);
        $this->Ln();
    
        $this->SetFont('Arial', '', 10);
        $this->Cell(70, 6, utf8_decode('Modalidad:'), 'LR', 0, 'L', false);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(119, 6, utf8_decode('modalidad que se obtiene de la base de datos'), 'LR', 0, 'C', false);
        $this->Ln();
        
        $this->SetFont('Arial', '', 10);
        $this->Cell(70, 6, utf8_decode('Datos Generales:'), 'LR', 0, 'L', true);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(119, 6, utf8_decode('Índice (Global)'), 'LR', 0, 'C', true);
        $this->Ln();
        
        $this->SetFont('Arial', '', 10);
        $this->Cell(70, 8, utf8_decode('Promedio:'), 'LR', 0, 'L', false);
        $this->SetFillColor(237, 237, 237); // Azul claro
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(119, 8, utf8_decode($promedioI), 'LR', 0, 'C', true);
        $this->Ln();
        $this->SetFillColor(224, 235, 255); // Azul claro
        $this->SetFont('Arial', '', 10);
        $this->Cell(70, 6, utf8_decode('Asesor(a):'), 'LR', 0, 'L', true);
        $this->SetFont('Arial', 'B', 10);
        $nombreDocente = convertirTexto($dataI['nombre_docente'] . " " . $dataI['ap_paterno_docente'] . " " . $dataI['ap_materno_docente']);
        $this->Cell(119, 6, utf8_decode($nombreDocente), 'LR', 0, 'C', true);
        $this->Ln();
        
        // Si $dataI['materia'] es un arreglo
        $aux = 0;
        foreach ($dataI['materia'] as $materia) {
            $this->SetFont('Arial', '', 10);
            if ($aux != 0){
                $this->Cell(70, 6, '', 'LR', 0, 'L', false);
            } else {
                $this->Cell(70, 6, utf8_decode('Curso(s):'), 'LR', 0, 'L', false);
            }
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(119, 6, utf8_decode($materia), 'LR', 0, 'C', false);
            $this->Ln(); // Salto de línea después de cada materia
            $aux++;
        }
    
        // Línea de cierre
        $this->Cell(189, 0, '', 'T');
        $this->Ln();
    }
    //
    function FancyTable($header, $data, $anchoColumnas, $numGrupos, $totalPorGrupo, $aux, $r1, $tr1, $r2, $tr2, $r3, $tr3, $r4, $tr4, $r5, $tr5, $r6, $tr6, $r7, $tr7, $r8, $tr8, $r9, $tr9, $r10, $tr10, $r11, $tr11, $r12, $tr12, $r13, $tr13, $r14, $tr14, $r15, $tr15, $r16, $tr16, $r17, $tr17, $r18, $tr18, $r19, $tr19, $r20, $tr20, $r22, $tr22, $sumDom, $dom, $sumDom1, $dom1, $sumDom2, $dom2, $sumDom3, $dom3, $sumDom4, $dom4, $sumDom5, $dom5, $sumDom6, $dom6, $asesor, $asesorL, $diseno, $disenoC, $r21Colores, $r21Ilustraciones, $r21Tamanio, $tr21Colores, $tr21Ilustraciones, $tr21Tamanio, $sumDom7, $dom7) {
        // Configuración inicial de colores, ancho de línea y fuente en negrita
        $this->SetFillColor(255, 255, 255); // Blanco
        $this->SetTextColor(0, 0, 0); // Negro
        $this->SetDrawColor(48, 83, 149); // Azul
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
    
        // Cabecera dinámica
        foreach ($header as $i => $title) {
            $this->Cell($anchoColumnas[$i], 7, $title, 1, 0, 'L', true);
        }
        $this->Ln();
    
        // Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255); // Azul claro
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = false;
    
        // Datos principales (grupos y total)
        foreach ($data as $row) {
            foreach ($header as $i => $col) {
                $this->Cell($anchoColumnas[$i], 6, utf8_decode($row[$i]), 'LR', 0, 'L', $fill);
            }
            $this->Ln();
            $fill = !$fill;
        }
    
        // Línea de cierre de la tabla principal
        $this->Cell(array_sum($anchoColumnas), 0, '', 'T');
        $this->Ln();


        $totalInstrumentos = array_sum($totalPorGrupo);
        // Función auxiliar para agregar tablas adicionales
        $this->addTable($anchoColumnas, ['Estudiantes participantes:'], $totalPorGrupo, [array_sum($totalPorGrupo)], $numGrupos, true);
        $this->addTable($anchoColumnas, ['Satisfacción de desempeño:'], $r1,[$tr1], $numGrupos, true , [255, 255, 255]);
        $this->addTable($anchoColumnas, ['Expectativas cubiertas del curso:'], $r22,[$tr22], $numGrupos, true);
        $this->addTable($anchoColumnas, ['Asesor en Línea (índice Global):'], $asesor,[$asesorL], $numGrupos, true, [225, 238, 218]); // Verde
        $this->addTable($anchoColumnas, ['Diseño del Curso (índice Global):'], $diseno,[$disenoC], $numGrupos, true, [255, 241, 204]); // Amarillo
        //$r7, $r8, $r10, $r2, $r4, $r9, $r3, $r5, $r6
        $this->Separador();
        $this->SeparadorT($texto = 'Asesor en Línea', [225, 238, 218]);
        $this->addTable($anchoColumnas, ["Funciones del Asesor en Línea:"], $asesor,[$asesorL], $numGrupos, true, [217, 217, 217]);
        $this->SetFont('Arial', 'B', 10);
        $this->addTable($anchoColumnas, ["-Dominio y desempeño del asesor:"], $sumDom,[$dom], $numGrupos, true);
        $this->SetFont('Arial', '', 10);
        $this->addTable($anchoColumnas, ["Dominio en el manejo de las aplicaciones y herramientas de la plataforma Moodle:"], $r7,[$tr7], $numGrupos, true);
        $this->addTable($anchoColumnas, ["Dominio disciplinar por parte del profesor en la asignatura:"], $r8,[$tr8], $numGrupos, true);
        $this->addTable($anchoColumnas, ["Desempeño del asesor(a) como facilitador del aprendizaje a lo largo del curso:"], $r10,[$tr10], $numGrupos, true);
        $this->SetFont('Arial', 'B', 10);
        $this->addTable($anchoColumnas, ["-Oportunidad en la retroalimentación y respuestas:"], $sumDom1,[$dom1], $numGrupos, true);
        $this->SetFont('Arial', '', 10);
        $this->addTable($anchoColumnas, ["Prontitud con que tu asesor respondió a tus dudas, preguntas o comentarios:"], $r2,[$tr2], $numGrupos, true);
        $this->addTable($anchoColumnas, ["Prontitud de tu asesor en respuesta o aportación en los foros:"], $r4,[$tr4], $numGrupos, true);
        $this->addTable($anchoColumnas, ["Prontitud de tu asesor para registrar tus calificaciónes en la plataforma:"], $r9,[$tr9], $numGrupos, true);
        $this->SetFont('Arial', 'B', 10);
        $this->addTable($anchoColumnas, ["-Calidad de retroalimentación y respuesta:"], $sumDom2,[$dom2], $numGrupos, true);
        $this->SetFont('Arial', '', 10);
        $this->addTable($anchoColumnas, ["Calidad de las respuestas de tu asesor(a) a tus dudas, preguntas o comentarios:"], $r3,[$tr3], $numGrupos, true);
        $this->addTable($anchoColumnas, ["Comentarios o argumentos emitidos por tu asesor(a) para justificar las calificaciones que obtuviste:"], $r5,[$tr5], $numGrupos, true);
        $this->addTable($anchoColumnas, ["Promoción por parte del asesor en argumentar las participaciones en base a los comentarios:"], $r6,[$tr6], $numGrupos, true);
        
        //$r12, $r18, $r15, $r13, $r17, $r16, $r20, $r14, $r21Colores, $r21Ilustraciones, $r21Tamanio

        $this->Separador();
        $this->SeparadorT($texto = 'Diseño del Curso', [255, 241, 204]);
        $this->addTable($anchoColumnas, ["Diseño y Calidad del Curso:"], $diseno,[$disenoC], $numGrupos, true, [217, 217, 217]);
        $this->SetFont('Arial', 'B', 10);
        $this->addTable($anchoColumnas, ["-Diseño del Curso en claridad de contenidos:"], $sumDom3,[$dom3], $numGrupos, true);
        $this->SetFont('Arial', '', 10);
        $this->addTable($anchoColumnas, ["Calidad de contenidos temáticos incluidos en el curso:"], $r12,[$tr12], $numGrupos, true);
        $this->addTable($anchoColumnas, ["Carga horaria declarada para este curso:"], $r18,[$tr18], $numGrupos, true);
        $this->addTable($anchoColumnas, ["Pertenencia en el diseño de las actividades de aprendizaje en el curso:"], $r15,[$tr15], $numGrupos, true);
        $this->SetFont('Arial', 'B', 10);
        $this->addTable($anchoColumnas, ["-Variedad de contenidos:"], $sumDom4,[$dom4], $numGrupos, true);
        $this->SetFont('Arial', '', 10);
        $this->addTable($anchoColumnas, ["Variedad de contenidos temáticos incluidos en el curso:"], $r13,[$tr13], $numGrupos, true);
        $this->addTable($anchoColumnas, ["Variedad en el diseño de las actividades de aprendizaje incluidas en el curso:"], $r17,[$tr17], $numGrupos, true);
        $this->SetFont('Arial', 'B', 10);
        $this->addTable($anchoColumnas, ["-Nivel de autonomía:"], $sumDom5,[$dom5], $numGrupos, true);
        $this->SetFont('Arial', '', 10);
        $this->addTable($anchoColumnas, ["Los materiales incluídos en el curso te permitieron aprender por si mismo(a) estímulando el interés por investigar y profundizar en conocimientos nuevos:"], $r16,[$tr16], $numGrupos, true);
        $this->addTable($anchoColumnas, ["Comprensión integral de los contenidos curriculares de la materia:"], $r20,[$tr20], $numGrupos, true);
        $this->SetFont('Arial', 'B', 10);
        $this->addTable($anchoColumnas, ["-Evaluación de contenidos:"], $sumDom6,[$dom6], $numGrupos, true);
        $this->SetFont('Arial', '', 10);
        $this->addTable($anchoColumnas, ["Utilidad de las herramientas de la plataforma Moodle:"], $r14,[$tr14], $numGrupos, true);
        $this->SetFont('Arial', 'B', 10);
        $this->addTable($anchoColumnas, ["-Diseño Gráfico del curso:"], $sumDom7,[$dom7], $numGrupos, true);
        $this->SetFont('Arial', '', 10);
        $this->addTable($anchoColumnas, ["Colores:"], $r21Colores,[$tr21Colores], $numGrupos, true);
        $this->addTable($anchoColumnas, ["Ilustraciones(imágenes, Logotipos):"], $r21Ilustraciones,[$tr21Ilustraciones], $numGrupos, true);
        $this->addTable($anchoColumnas, ["Tamaño y tipo de letra:"], $r21Tamanio,[$tr21Tamanio], $numGrupos, true);
    }
    //
    function addTable($anchoColumnas, $titulosTablas, $data, $total, $numGrupos, $useFillColor = true, $fillColor = [255, 255, 255]) {
        if ($useFillColor) {
            $this->SetFillColor(...$fillColor);
        }
        //$this->SetFont('Arial', 'B', 10);
    
        foreach ($titulosTablas as $j => $titulo) {
            // Mostrar el título de la tabla
            $this->MultiCell($anchoColumnas[0], 6, utf8_decode($titulo), 'LR', 0, 'L', $j % 2 == 0);
            $this->SetXY($this->GetX() + $anchoColumnas[0], $this->GetY() - 6);
            // Mostrar los valores de $data para cada grupo
            for ($k = 1; $k <= $numGrupos; $k++) {
                $valor = isset($data[$k - 1]) ? $data[$k - 1] : '';
                $this->Cell($anchoColumnas[$k], 6, $valor, 'LR', 0, 'C', $j % 2 == 0);
            }
        }

        foreach($total as $j => $titulo) {
            // Celda vacía para $total
            $this->Cell($anchoColumnas[$numGrupos + 1], 6, $titulo, 'LR', 0, 'L', $j % 2 == 0);
            $this->Ln();
        }
    
        // Línea de cierre
        $this->Cell(array_sum($anchoColumnas), 0, '', 'T');
        $this->Ln();
    }

}

function obtenerParametroGET($nombre, $default = 'No definido') {
    return isset($_GET[$nombre]) ? htmlspecialchars($_GET[$nombre]) : $default;
}
// Obtener parámetros GET
$numcontrol = obtenerParametroGET('numcontrol');
$periodo = obtenerParametroGET('periodo', 'No está definido "periodo"');
$anio = obtenerParametroGET('anio', 'No está definido "anio"');

$error = '';
$tipoError = 'error';
if ($numcontrol != 'No definido "numcontrol"' || $periodo != 'No está definido "periodo"' || $anio != 'No está definido "anio"') {
    try {
        // Conectar a la base de datos y obtener conexión
            try {
                $conexion = new CConexion();
                $conn = $conexion->conexionBD();
            } catch (PDOException $exp) {
                $tipoError = 'No se pudo conectar a la base de datos';
            }
        
            try{
            // Consulta SQL para obtener los datos de virtuales
            $consulta = $conn->prepare("SELECT * FROM virtuales WHERE numcontrol = :numcontrol");
            $consulta->bindParam(':numcontrol', $numcontrol);
            $consulta->execute();
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        
            // Asignar valores a partir de la consulta
            $dataFromDb = [
                'nombre_docente' => $resultado['nombre_docente'] ?? 'No definido',
                'ap_paterno_docente' => $resultado['ap_paterno_docente'] ?? 'No definido',
                'ap_materno_docente' => $resultado['ap_materno_docente'] ?? 'No definido',
                'unidad' => $resultado['unidad'] ?? 'No definido',
                'materia' => [] // Array para almacenar las materias
            ];
            } catch (PDOException $exp) {
                $tipoError = 'No se pudo obtener los datos de la base de datos para esta consulta (SELECT * FROM virtuales WHERE numcontrol = :numcontrol)';
            }
        
            try{
            // Obtener materias distintas
            $consulta = $conn->prepare("SELECT DISTINCT materia FROM virtuales WHERE numcontrol = :numcontrol");
            $consulta->bindParam(':numcontrol', $numcontrol);
            $consulta->execute();
            $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
        
            $materias = array_column($resultados, 'materia');
            $dataFromDb['materia'] = $materias;
        
            } catch (PDOException $exp) {
                $tipoError = 'No se pudo obtener los datos de la base de datos para esta consulta (SELECT DISTINCT materia FROM virtuales WHERE numcontrol = :numcontrol)';
            }
        
            try{
            // Consulta SQL para obtener datos de preguntav
            $consulta = $conn->prepare("SELECT * FROM preguntav WHERE numcontrol = :numcontrol AND id_grupo = :id_grupo AND acta_id = :acta_id");
            $consulta->bindParam(':numcontrol', $numcontrol);
            $consulta->bindParam(':id_grupo', $id_grupo);
            $consulta->bindParam(':acta_id', $acta_id);
            $consulta->execute();
            $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        
            // Procesamiento de datos de preguntav
            $dataS = [];
            foreach ($resultado as $fila) {
                for ($i = 1; $i <= 22; $i++) {
                    $dataS[] = ['Pregunta ' . $i, $fila['r' . $i]];
                }
            }
            } catch (PDOException $exp) {
                $tipoError = 'No se pudo obtener los datos de la base de datos para esta consulta (SELECT * FROM preguntav WHERE numcontrol = :numcontrol AND id_grupo = :id_grupo AND acta_id = :acta_id)';
            }
        
            try{
            // Consulta SQL para obtener el total por grupo
            $consulta = $conn->prepare("SELECT id_grupo, COUNT(*) AS total_grupo 
            FROM preguntav 
            WHERE numcontrol = :numcontrol 
            GROUP BY id_grupo 
            ORDER BY id_grupo DESC");
            $consulta->bindParam(':numcontrol', $numcontrol);
            $consulta->execute();
            $res = $consulta->fetchAll(PDO::FETCH_ASSOC);
            // Obtener totales por grupo
            $totalPorGrupo = array_column($res, 'total_grupo');
        
            } catch (PDOException $exp) {
                $tipoError = 'No se pudo obtener los datos de la base de datos para esta consulta (SELECT id_grupo, COUNT(*) AS total_grupo FROM preguntav WHERE numcontrol = :numcontrol GROUP BY id_grupo ORDER BY id_grupo DESC)';
            }
        
            try{
            // Consulta SQL para obtener grupos distintos
            $consulta = $conn->prepare("SELECT DISTINCT grupo, semestre, id_grupo 
            FROM virtuales 
            WHERE numcontrol = :numcontrol 
            ORDER BY id_grupo DESC");
            $consulta->bindParam(':numcontrol', $numcontrol);
            $consulta->execute();
            $resultadosGrupos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        
            // Procesamiento de grupos
            $header = ['Grupo(s):'];
            $grupos = [];
            $idgrupos = [];
            foreach ($resultadosGrupos as $resultadoGrupo) {
                $grupos[] = $resultadoGrupo['grupo'] . " " . $resultadoGrupo['semestre'];
                $idgrupos[] = $resultadoGrupo['id_grupo'];
                $header[] = $resultadoGrupo['grupo'] . " " . $resultadoGrupo['semestre'];
            }
            $header[] = 'Total';
        
            $numGrupos = count($grupos);
            // Calcular anchos de columnas dinámicamente
            $anchoColumnas = [];
            $anchoFijo = 70; // Ancho fijo para la primera columna (Grupos)
            $anchoVariable = 189 - $anchoFijo; // Ancho total disponible menos el ancho de la columna fija
            $anchoGrupos = $anchoVariable / ($numGrupos + 1); // Distribuir el ancho entre las columnas de grupos y la columna Total
            $anchoColumnas[] = $anchoFijo;
            for ($i = 0; $i < $numGrupos; $i++) {
                $anchoColumnas[] = $anchoGrupos;
            }
            $anchoColumnas[] = $anchoGrupos; // Ancho para la columna Total
            //
            // 
            } catch (PDOException $exp) {
                $tipoError = 'No se pudo obtener los datos de la base de datos para esta consulta (SELECT DISTINCT grupo, semestre, id_grupo FROM virtuales WHERE numcontrol = :numcontrol ORDER BY id_grupo DESC)';
            }
        
            $totalInstrumentos = array_sum($totalPorGrupo);
            
            try{
            //
            $consulta = $conn->prepare("SELECT SUM(r1) AS totalr1, SUM(r2) AS totalr2, SUM(r3) AS totalr3, SUM(r4) AS totalr4, SUM(r5) AS totalr5, SUM(r6) AS totalr6, SUM(r7) AS totalr7, SUM(r8) AS totalr8, SUM(r9) AS totalr9, SUM(r10) AS totalr10, SUM(r11) AS totalr11, SUM(r12) AS totalr12, SUM(r13) AS totalr13, SUM(r14) AS totalr14, SUM(r15) AS totalr15, SUM(r16) AS totalr16, SUM(r17) AS totalr17, SUM(r18) AS totalr18, SUM(r19) AS totalr19, SUM(r20) AS totalr20, SUM(r22) AS totalr22
            FROM preguntav
            WHERE numcontrol = :numcontrol
            GROUP BY id_grupo
            ORDER BY id_grupo DESC");
            $consulta->bindParam(':numcontrol', $numcontrol);
            $consulta->execute();
            $resSum = $consulta->fetchAll(PDO::FETCH_ASSOC);
        
        
            $aux = 0;
        
            foreach ($resSum as $index => $sum){
                $valor = $totalPorGrupo[$index];
                $r1[] = number_format(($sum['totalr1'] / $valor),2) * 10;
                $r2[] = number_format(($sum['totalr2'] / $valor),2) * 10;
                $r3[] = number_format(($sum['totalr3'] / $valor),2) * 10;
                $r4[] = number_format(($sum['totalr4'] / $valor),2) * 10;
                $r5[] = number_format(($sum['totalr5'] / $valor),2) * 10;
                $r6[] = number_format(($sum['totalr6'] / $valor),2) * 10;
                $r7[] = number_format(($sum['totalr7'] / $valor),2) * 10;
                $r8[] = number_format(($sum['totalr8'] / $valor),2) * 10;
                $r9[] = number_format(($sum['totalr9'] / $valor),2) * 10;
                $r10[] = number_format(($sum['totalr10'] / $valor),2) * 10;
                $r11[] = number_format(($sum['totalr11'] / $valor),2) * 10;
                $r12[] = number_format(($sum['totalr12'] / $valor),2) * 10;
                $r13[] = number_format(($sum['totalr13'] / $valor),2) * 10;
                $r14[] = number_format(($sum['totalr14'] / $valor),2) * 10;
                $r15[] = number_format(($sum['totalr15'] / $valor),2) * 10;
                $r16[] = number_format(($sum['totalr16'] / $valor),2) * 10;
                $r17[] = number_format(($sum['totalr17'] / $valor),2) * 10;
                $r18[] = number_format(($sum['totalr18'] / $valor),2) * 10;
                $r19[] = number_format(($sum['totalr19'] / $valor),2) * 10;
                $r20[] = number_format(($sum['totalr20'] / $valor),2) * 10;
                $r22[] = number_format(($sum['totalr22'] / $valor),2) * 10;
                $aux++;
            }
            } catch (PDOException $exp) {
                $tipoError = 'No se pudo obtener los datos de la base de datos para esta consulta (SELECT SUM(r1) AS totalr1, SUM(r2) AS totalr2, SUM(r3) AS totalr3, SUM(r4) AS totalr4, SUM(r5) AS totalr5, SUM(r6) AS totalr6, SUM(r7) AS totalr7, SUM(r8) AS totalr8, SUM(r9) AS totalr9, SUM(r10) AS totalr10, SUM(r11) AS totalr11, SUM(r12) AS totalr12, SUM(r13) AS totalr13, SUM(r14) AS totalr14, SUM(r15) AS totalr15, SUM(r16) AS totalr16, SUM(r17) AS totalr17, SUM(r18) AS totalr18, SUM(r19) AS totalr19, SUM(r20) AS totalr20, SUM(r22) AS totalr22 FROM preguntav WHERE numcontrol = :numcontrol GROUP BY id_grupo ORDER BY id_grupo DESC)';
            }
            //
            try{
                //    
                $consulta = $conn->prepare("SELECT id_grupo, r21 FROM preguntav WHERE numcontrol = :numcontrol
                ORDER BY id_grupo DESC");
                $consulta->bindParam(':numcontrol', $numcontrol);
                $consulta->execute();
                $res21 = $consulta->fetchAll(PDO::FETCH_ASSOC);
        
                foreach ($res21 as $index => $sum){
                    $texR21[] = $sum['r21'] ?? '0,0,0,0';
                    $idR21[] = $sum['id_grupo'];
                }
            } catch (PDOException $exp) {
                $tipoError = 'No se pudo obtener los datos de la base de datos para esta consulta (SELECT id_grupo, r21 FROM preguntav WHERE numcontrol = :numcontrol AND id_grupo = :id_grupo ORDER BY id_grupo DESC)';
            }
            //operaciones para obtener los promedios
            try{
                //Promedio por fila y columna
                if ($aux != 0){
                    $tr1 = number_format((array_sum($r1) / $aux) , 1); // Satisfacción de desempeño promedio por pregunta
                    $tr22 = number_format((array_sum($r22) / $aux) , 1);
                    
                    //Asesor en linea - $r7, $r8, $r10, $r2, $r4, $r9, $r3, $r5, $r6
                    $tr7 = number_format((array_sum($r7) / $aux) , 1); // es la p1
                    $tr8 = number_format((array_sum($r8) / $aux) , 1); // es la p2
                    $tr10 = number_format((array_sum($r10) / $aux) , 1); // es la p3
                    $sumDoma = [];
                    $sumDom = [];
                    $dom = 0;
                    for ($i = 0; $i < $aux; $i++){
                        $sumDoma = (($r7[$i] + $r8[$i] + $r10[$i])/3);
                        $sumDom[] = number_format($sumDoma, 1);
                    }
                    $dom = number_format((array_sum($sumDom) / count($sumDom)), 1);
        
                    //----------------
                    $tr2 = number_format((array_sum($r2) / $aux) , 1); // es la p4
                    $tr4 = number_format((array_sum($r4) / $aux) , 1); // es la p5
                    $tr9 = number_format((array_sum($r9) / $aux) , 1); // es la p6
                    $sumDoma1 = [];
                    $sumDom1 = [];
                    $dom1 = 0;
                    for ($i = 0; $i < $aux; $i++){
                        $sumDoma1 = (($r2[$i] + $r4[$i] + $r9[$i])/3);
                        $sumDom1[] = number_format($sumDoma1, 1);
                    }
                    $dom1 = number_format((array_sum($sumDom1) / count($sumDom1)), 1);
        
                    //----------------
                    $tr3 = number_format((array_sum($r3) / $aux) , 1); // es la p7
                    $tr5 = number_format((array_sum($r5) / $aux) , 1); // es la p8
                    $tr6 = number_format((array_sum($r6) / $aux) , 1); // es la p9
                    $sumDoma2 = [];
                    $sumDom2 = [];
                    $dom2 = 0;
                    for ($i = 0; $i < $aux; $i++){
                        $sumDoma2 = (($r3[$i] + $r5[$i] + $r6[$i])/3);
                        $sumDom2[] = number_format($sumDoma2, 1);
                    }
                    $dom2 = number_format((array_sum($sumDom2) / count($sumDom2)), 1);
        
                    //----------------
                    //Diseño del curso
                    $tr12 = number_format((array_sum($r12) / $aux) , 1); // es la p10 --Diseño del curso
                    $tr18 = number_format((array_sum($r18) / $aux) , 1); // es la p11 --Diseño del curso
                    $tr15 = number_format((array_sum($r15) / $aux) , 1); // es la p12 --Diseño del curso
                    $sumDoma3 = [];
                    $sumDom3 = [];
                    $dom3 = 0;
                    for ($i = 0; $i < $aux; $i++){
                        $sumDoma3 = (($r12[$i] + $r18[$i] + $r15[$i])/3);
                        $sumDom3[] = number_format($sumDoma3, 1);
                    }
                    $dom3 = number_format((array_sum($sumDom3) / count($sumDom3)), 1);
        
                    //----------------
                    $tr13 = number_format((array_sum($r13) / $aux) , 1); // es la p13 --Diseño del curso
                    $tr17 = number_format((array_sum($r17) / $aux) , 1); // es la p14 --Diseño del curso
                    $sumDoma4 = [];
                    $sumDom4 = [];
                    $dom4 = 0;
                    for ($i = 0; $i < $aux; $i++){
                        $sumDoma4 = (($r13[$i] + $r17[$i])/2);
                        $sumDom4[] = number_format($sumDoma4, 1);
                    }
                    $dom4 = number_format((array_sum($sumDom4) / count($sumDom4)), 1);
        
                    //----------------
                    $tr16 = number_format((array_sum($r16) / $aux) , 1); // es la p15 --Diseño del curso
                    $tr20 = number_format((array_sum($r20) / $aux) , 1); // es la p16 --Diseño del curso 
                    $sumDoma5 = [];
                    $sumDom5 = [];
                    $dom5 = 0;
                    for ($i = 0; $i < $aux; $i++){
                        $sumDoma5 = (($r16[$i] + $r20[$i])/2);
                        $sumDom5[] = number_format($sumDoma5, 1);
                    }
                    $dom5 = number_format((array_sum($sumDom5) / count($sumDom5)), 1);
        
                    //----------------
                    $tr14 = number_format((array_sum($r14) / $aux) , 1); //utilidad de herramientas Moddle
                    $sumDoma6 = [];
                    $sumDom6 = [];
                    $dom6 = 0;
                    for ($i = 0; $i < $aux; $i++){
                        $sumDoma6 = ($r14[$i]);
                        $sumDom6[] = number_format($sumDoma6, 1);
                    }
                    $dom6 = number_format((array_sum($sumDom6) / count($sumDom6)), 1);
        
                    //----------------
                    $tr11 = number_format((array_sum($r11) / $aux) , 1);
                    $tr19 = number_format((array_sum($r19) / $aux) , 1);
        
                    //=======================================================================================================
                    
                    $contTemp = 0;
                    foreach ($idgrupos as $id) {
                        $total = $totalPorGrupo[$contTemp];
                        $respColores = 0;
                        $respIlustraciones = 0;
                        $respNavegacion = 0; //este es el que no voy a usar
                        $respTamanio = 0;
        
                        for ($i = 0; $i < $total; $i++) {
                            if (empty($texR21[$i])) {
                                $texR21[$i] = '0,0,0,0';
                            }
                            $valores = explode(',', $texR21[$i]);
                            // Asegurarse de que cada valor esté presente y no sea nulo, de lo contrario asignar 0
                            $valor1 = isset($valores[0]) ? (int)$valores[0] : 0;
                            $respColores += $valor1;
                            
                            $valor2 = isset($valores[1]) ? (int)$valores[1] : 0;
                            $respIlustraciones += $valor2;
                            
                            $valor3 = isset($valores[2]) ? (int)$valores[2] : 0;
                            $respNavegacion += $valor3;
                                
                            $valor4 = isset($valores[3]) ? (int)$valores[3] : 0;
                            $respTamanio += $valor4;
                        }
                            
                        // Asegurarse de que se trate como flotante antes de formatear
                        $r21Colores[] = (float) number_format($respColores / $total, 2) * 10;
                        $r21Ilustraciones[] = (float) number_format($respIlustraciones / $total, 2) * 10;
                        $r21Navegacion[] = (float) number_format($respNavegacion / $total, 2) * 10;
                        $r21Tamanio[] = (float) number_format($respTamanio / $total, 2) * 10;
                        $contTemp++;
                    }
            
                        // Calcular los promedios y asegurarse de que los valores son numericos
                    $tr21Colores = (float) number_format((array_sum($r21Colores) / $aux), 1);
                    $tr21Ilustraciones = (float) number_format((array_sum($r21Ilustraciones) / $aux), 1);
                    $tr21Navegacion = (float) number_format((array_sum($r21Navegacion) / $aux), 1);
                    $tr21Tamanio = (float) number_format((array_sum($r21Tamanio) / $aux), 1);
            
                    $sumDoma7 = [];
                    $sumDom7 = [];
                    $dom7 = 0;
            
                    for ($i = 0; $i < $aux; $i++) {
                        // Asegurarse de que los valores son numéricos antes de operar
                        $sumDoma7 = (($r21Colores[$i] + $r21Ilustraciones[$i] + $r21Tamanio[$i]) / 3);
                        $sumDom7[] = (float) number_format($sumDoma7, 1);
                    }
            
                    // Calcular el promedio final y asegurarse de que los valores son numéricos
                    $dom7 = (float) number_format((array_sum($sumDom7) / count($sumDom7)), 1);
                    
        
                    //************************
                    //************************
        
                    //Diseño del curso - $r12, $r18, $r15, $r13, $r17, $r16, $r20, $r14, $r21Colores, $r21Ilustraciones, $r21Tamanio
                    $disenoa = [];
                    $diseno = [];
                    $disenoC = 0;
                    for ($i= 0; $i < $aux; $i++){
                        $disenoa = (($sumDom3[$i] + $sumDom4[$i] + $sumDom5[$i] + $sumDom6[$i] + $sumDom7[$i])/5);
                        $diseno[] = number_format($disenoa, 1);
                    }
                    $disenoC = number_format((array_sum($diseno) / count($diseno)), 1);
                    
                    //Asesor en linea - $r7, $r8, $r10, $r2, $r4, $r9, $r3, $r5, $r6
                    $asesora = [];
                    $asesor = [];
                    $asesorL = 0;
                    for ($i = 0; $i < $aux; $i++){
                        $asesora = (($sumDom[$i] + $sumDom1[$i] + $sumDom2[$i])/3);
                        $asesor[] = number_format($asesora, 1);
                    }
                    $asesorL = number_format((array_sum($asesor) / count($asesor)), 1);
        
                    //Promedio total
                    $Promedio = array_merge($asesor, $diseno);
                    $PromedioT = number_format(( array_sum($Promedio) / count($Promedio)) , 1);
                } else {
                    //
                    $r1 = 0;
                    $r22 = 0;
                    $r7 = 0;
                    $r8 = 0;
                    $r10 = 0;
                    $r2 = 0;
                    $r4 = 0;
                    $r9 = 0;
                    $r3 = 0;
                    $r5 = 0;
                    $r6 = 0;
                    $r12 = 0;
                    $r18 = 0;
                    $r15 = 0;
                    $r13 = 0;
                    $r17 = 0;
                    $r16 = 0;
                    $r20 = 0;
                    $r14 = 0;
                    $r11 = 0;
                    $r19 = 0;
                    //
                    $tr1 = 0;
                    $tr22 = 0;
                    $tr7 = 0;
                    $tr8 = 0;
                    $tr10 = 0;
                    $tr2 = 0;
                    $tr4 = 0;
                    $tr9 = 0;
                    $tr3 = 0;
                    $tr5 = 0;
                    $tr6 = 0;
                    $tr12 = 0;
                    $tr18 = 0;
                    $tr15 = 0;
                    $tr13 = 0;
                    $tr17 = 0;
                    $tr16 = 0;
                    $tr20 = 0;
                    $tr14 = 0;
                    $tr11 = 0;
                    $tr19 = 0;
                    //
                    $r21Colores = 0;
                    $r21Ilustraciones = 0;
                    $r21Tamanio = 0;
                    $tr21Colores = 0;
                    $tr21Ilustraciones = 0;
                    $tr21Tamanio = 0;
                    $sumDom7 = 0;
                    $dom7 =0;
                    //
                    $valores = [];
                    $valor1 = [];
                    $valor2 = [];
                    $valor3 = [];
                    $valor4 = [];
                    $r21Colores = [];
                    $r21Ilustraciones = [];
                    $r21Navegacion = [];
                    $r21Tamanio = [];
                    //
                    $dom = 0;
                    $dom1 = 0;
                    $dom2 = 0;
                    $dom3 = 0;
                    $dom4 = 0;
                    $dom5 = 0;
                    $dom6 = 0;
                    //
                    $sumDom = 0;
                    $sumDom1 = 0;
                    $sumDom2 = 0;
                    $sumDom3 = 0;
                    $sumDom4 = 0;
                    $sumDom5 = 0;
                    $sumDom6 = 0;
                    //
                    $diseno = 0;
                    $asesor = 0;
                    //
                    $asesorL = 0;
                    $disenoC = 0;
                    $PromedioT = 0;
                    
                }
            }catch (PDOException $exp) {
                $tipoError = 'Algo fallo al momento de hacer los calculos';
            }
        
        } catch (Exception $e) {
            $tipoError = 'No deberías ver este mensaje. Si lo ves, es porque algo salió mal. Vuelva a intentarlo más tarde.';
        }
} else {
    $error = 'Faltan datos por proporcionar.';
    $tipoError = 'Por favor, proporcione regrese a la pagina anterior y pruebe de nuevo';
}
// Crear el PDF
$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

if ($error != 'Faltan datos por proporcionar.' && $tipoError != 'Por favor, proporcione regrese a la pagina anterior y pruebe de nuevo') {
    $pdf->Separador();
    $pdf->TablaInicio($dataFromDb, $PromedioT);
    $pdf->Separador();
    $pdf->FancyTable($header, $dataS, $anchoColumnas, $numGrupos, $totalPorGrupo, $aux, $r1, $tr1, $r2, $tr2, $r3, $tr3, $r4, $tr4, $r5, $tr5, $r6, $tr6, $r7, $tr7, $r8, $tr8, $r9, $tr9, $r10, $tr10, $r11, $tr11, $r12, $tr12, $r13, $tr13, $r14, $tr14, $r15, $tr15, $r16, $tr16, $r17, $tr17, $r18, $tr18, $r19, $tr19, $r20, $tr20, $r22, $tr22, $sumDom, $dom, $sumDom1, $dom1, $sumDom2, $dom2, $sumDom3, $dom3, $sumDom4, $dom4, $sumDom5, $dom5, $sumDom6, $dom6, $asesor, $asesorL, $diseno, $disenoC, $r21Colores, $r21Ilustraciones, $r21Tamanio, $tr21Colores, $tr21Ilustraciones, $tr21Tamanio, $sumDom7, $dom7);
    $pdf->Separador();
} else {
    $pdf->Cell(0, 10, utf8_decode($error), 0, 1, 'C');
    $pdf->Cell(0, 10, utf8_decode($tipoError), 0, 1, 'C');
}



$nombreArchivo = 'Reporte Individual ' . $numcontrol .' '. $periodo.' '. $anio .'.pdf';
//$nombreArchivo, "D"
$pdf->Output($nombreArchivo, "I");

?>