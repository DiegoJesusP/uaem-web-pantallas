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
        $this->Rect(0, 0, $this->w, 30, 'F'); // Rectángulo lleno
        
        // Logo
        $this->Image('./../assets/img/LogoUAEMBlanco.png', 10, 3, 29);
        
        // Título
        $this->SetFont('Arial', 'B', 13);
        $this->SetTextColor(255, 255, 255); // Blanco
        $this->Cell(0, 5, utf8_decode("Reporte de evaluación de asignaturas híbridas y virtuales"), 0, 1, 'C');
        
        // Fondo gris para el subtítulo
        $this->SetFillColor(231, 230, 230); // Gris
        $this->Rect(0, $this->GetY()+10, $this->w, 13, 'F'); // Rectángulo lleno para subtítulo
        
        // Subtítulo
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(0, 0, 0); // Negro
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
    function Separador(){
        $this->SetFillColor(48, 83, 149);
        $this->Cell(189, 2, '', 'LR', 0, 'C', true);
        $this->Ln();
    }
    //
    function SeparadorT($title, $fillColor = [255, 255, 255]){
        $this->SetFillColor(225, 238, 218);
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
    function TablaInicio($dataI) {
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
        $this->Cell(70, 6, utf8_decode('Promedio:'), 'LR', 0, 'L', false);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(119, 6, utf8_decode('Valor estático con variable'), 'LR', 0, 'C', false);
        $this->Ln();
        
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
    function FancyTable($header, $data, $anchoColumnas, $numGrupos, $totalPorGrupo, $r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10, $r11, $r12, $r13, $r14, $r15, $r16, $r17, $r18, $r19, $r20, $r22) {
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

        // Función auxiliar para agregar tablas adicionales
        $this->addTable($anchoColumnas, ['Estudiantes participantes:'], $totalPorGrupo, [array_sum($totalPorGrupo)], $numGrupos);
        $this->addTable($anchoColumnas, ['Satisfacción de desempeño:'], $totalPorGrupo,[0], $numGrupos, true , [255, 255, 255]);
        $this->addTable($anchoColumnas, ['Expectativas cubiertas del curso:'], $totalPorGrupo,[0], $numGrupos, true);
        $this->addTable($anchoColumnas, ['Asesor en Línea (índice Global):'], [],[0], $numGrupos, true, [225, 238, 218]); // Verde
        $this->addTable($anchoColumnas, ['Diseño del Curso (índice Global):'], [],[0], $numGrupos, true, [255, 241, 204]); // Amarillo
        //
        $this->Separador();
        $this->SeparadorT($texto = 'Asesor en Línea', [225, 238, 218]);
        $this->addTable($anchoColumnas, ["Funciones del Asesor en Línea:"], $totalPorGrupo,[0], $numGrupos, true, [217, 217, 217]);
        $this->SetFont('Arial', 'B', 10);
        $this->addTable($anchoColumnas, ["-Dominio y desempeño del asesor:"], $totalPorGrupo,[0], $numGrupos, true);
        $this->SetFont('Arial', '', 10);
        $this->addTable($anchoColumnas, ["Dominio en el manejo de las aplicaciones y herramientas de la plataforma Moodle:"], $r1,['aaa'], $numGrupos, true);
        $this->addTable($anchoColumnas, ["Dominio disciplinar por parte del profesor en la asignatura:"], $r2,[0], $numGrupos, true);
        $this->addTable($anchoColumnas, ["Desempeño del asesor(a) como facilitador del aprendizaje a lo largo del curso:"], $r3,[0], $numGrupos, true);
        $this->SetFont('Arial', 'B', 10);
        $this->addTable($anchoColumnas, ["-Oportunidad en la retroalimentación y respuestas:"], $totalPorGrupo,[0], $numGrupos, true);
        $this->SetFont('Arial', '', 10);
        $this->addTable($anchoColumnas, ["Prontitud con que tu asesor respondió a tus dudas, preguntas o comentarios:"], $r4,[0], $numGrupos, true);
        $this->addTable($anchoColumnas, ["Prontitud de tu asesor en respuesta o aportación en los foros:"], $r5,[0], $numGrupos, true);
        $this->addTable($anchoColumnas, ["Prontitud de tu asesor para registrar tus calificaciónes en la plataforma:"], $r6,[0], $numGrupos, true);
        $this->SetFont('Arial', 'B', 10);
        $this->addTable($anchoColumnas, ["-Calidad de retroalimentación y respuesta:"], $totalPorGrupo,[0], $numGrupos, true);
        $this->SetFont('Arial', '', 10);
        $this->addTable($anchoColumnas, ["Calidad de las respuestas de tu asesor(a) a tus dudas, preguntas o comentarios:"], $r7,[0], $numGrupos, true);
        $this->addTable($anchoColumnas, ["Comentarios o argumentos emitidos por tu asesor(a) para justificar las calificaciones que obtuviste:"], $r8,[0], $numGrupos, true);
        $this->addTable($anchoColumnas, ["Promoción por parte del asesor en argumentar las participaciones en base a los comentarios:"], $r9,[0], $numGrupos, true);
        //
        $this->Separador();
        $this->SeparadorT($texto = 'Diseño del Curso', [255, 241, 204]);
        $this->addTable($anchoColumnas, ["Diseño y Calidad del Curso:"], $totalPorGrupo,[0], $numGrupos, true, [217, 217, 217]);
        $this->SetFont('Arial', 'B', 10);
        $this->addTable($anchoColumnas, ["-Diseño del Curso en claridad de contenidos:"], $totalPorGrupo,[0], $numGrupos, true);
        $this->addTable($anchoColumnas, ["-Diseño del curso en calidad de contenidos"], $totalPorGrupo,[0], $numGrupos, true);
        $this->SetFont('Arial', '', 10);
        $this->addTable($anchoColumnas, ["Calidad de contenidos temáticos incluidos en el curso:"], $r10,[0], $numGrupos, true);
        $this->addTable($anchoColumnas, ["Carga horaria declarada para este curso:"], $r11,[0], $numGrupos, true);
        $this->addTable($anchoColumnas, ["Pertenencia en el diseño de las actividades de aprendizaje en el curso:"], $r12,[0], $numGrupos, true);
        $this->SetFont('Arial', 'B', 10);
        $this->addTable($anchoColumnas, ["-Variedad de contenidos:"], $totalPorGrupo,[0], $numGrupos, true);
        $this->SetFont('Arial', '', 10);
        $this->addTable($anchoColumnas, ["Variedad de contenidos temáticos incluidos en el curso:"], $r13,[0], $numGrupos, true);
        $this->addTable($anchoColumnas, ["Variedad en el diseño de las actividades de aprendizaje incluidas en el curso:"], $r14,[0], $numGrupos, true);
        $this->SetFont('Arial', 'B', 10);
        $this->addTable($anchoColumnas, ["-Nivel de autonomía:"], $totalPorGrupo,[0], $numGrupos, true);
        $this->SetFont('Arial', '', 10);
        $this->addTable($anchoColumnas, ["Los materiales incluídos en el curso te permitieron aprender por si mismo(a) estímulando el interés por investigar y profundizar en conocimientos nuevos:"], $r15,[0], $numGrupos, true);
        $this->addTable($anchoColumnas, ["Comprensión integral de los contenidos curriculares de la materia:"], $r16,[0], $numGrupos, true);
        $this->SetFont('Arial', 'B', 10);
        $this->addTable($anchoColumnas, ["-Evaluación de contenidos:"], $totalPorGrupo,[0], $numGrupos, true);
        $this->addTable($anchoColumnas, ["-Utilidad de las herramientas de la plataforma Moodle:"], $totalPorGrupo,[0], $numGrupos, true);
        $this->addTable($anchoColumnas, ["-Diseño Gráfico del curso:"], $totalPorGrupo,[0], $numGrupos, true);
        $this->SetFont('Arial', '', 10);
        $this->addTable($anchoColumnas, ["Colores:"], $r17,[0], $numGrupos, true);
        $this->addTable($anchoColumnas, ["Ilustraciones(imágenes, Logotipos):"], $r18,[0], $numGrupos, true);
        $this->addTable($anchoColumnas, ["Tamaño y tipo de letra:"], $r19,[0], $numGrupos, true);
    }
    
    function addTable($anchoColumnas, $titulosTablas, $data, $total, $numGrupos, $useFillColor = true, $fillColor = [255, 255, 255]) {
        if ($useFillColor) {
            $this->SetFillColor(...$fillColor);
        }
        //$this->SetFont('Arial', 'B', 10);
    
        foreach ($titulosTablas as $j => $titulo) {
            // Mostrar el título de la tabla
            $this->Cell($anchoColumnas[0], 6, utf8_decode($titulo), 'LR', 0, 'L', $j % 2 == 0);
    
            // Mostrar los valores de $data para cada grupo
            for ($k = 1; $k <= $numGrupos; $k++) {
                $valor = isset($data[$k - 1]) ? $data[$k - 1] : '';
                $this->Cell($anchoColumnas[$k], 6, $valor, 'LR', 0, 'L', $j % 2 == 0);
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

// Conectar a la base de datos y obtener conexión
$conexion = new CConexion();
$conn = $conexion->conexionBD();

// Obtener parámetros GET
$numcontrol = obtenerParametroGET('numcontrol');
$periodo = obtenerParametroGET('periodo', 'No está definido "periodo"');
$anio = obtenerParametroGET('anio', 'No está definido "anio"');

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

// Obtener materias distintas
$consulta = $conn->prepare("SELECT DISTINCT materia FROM virtuales WHERE numcontrol = :numcontrol");
$consulta->bindParam(':numcontrol', $numcontrol);
$consulta->execute();
$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

$materias = array_column($resultados, 'materia');
$dataFromDb['materia'] = $materias;

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


$consulta = $conn->prepare("SELECT SUM(r1) AS totalr1, SUM(r2) AS totalr2, SUM(r3) AS totalr3, SUM(r4) AS totalr4, SUM(r5) AS totalr5, SUM(r6) AS totalr6, SUM(r7) AS totalr7, SUM(r8) AS totalr8, SUM(r9) AS totalr9, SUM(r10) AS totalr10, SUM(r11) AS totalr11, SUM(r12) AS totalr12, SUM(r13) AS totalr13, SUM(r14) AS totalr14, SUM(r15) AS totalr15, SUM(r16) AS totalr16, SUM(r17) AS totalr17, SUM(r18) AS totalr18, SUM(r19) AS totalr19, SUM(r20) AS totalr20, SUM(r22) AS totalr22
FROM preguntav
WHERE numcontrol = :numcontrol
GROUP BY id_grupo
ORDER BY id_grupo DESC");
$consulta->bindParam(':numcontrol', $numcontrol);
$consulta->execute();
$resSum = $consulta->fetchAll(PDO::FETCH_ASSOC);

foreach ($resSum as $sum){
    $r1[] = $sum['totalr1'] ?? 0;
    $r2[] = $sum['totalr2'] ?? 0;
    $r3[] = $sum['totalr3'] ?? 0;
    $r4[] = $sum['totalr4'] ?? 0;
    $r5[] = $sum['totalr5'] ?? 0;
    $r6[] = $sum['totalr6'] ?? 0;
    $r7[] = $sum['totalr7'] ?? 0;
    $r8[] = $sum['totalr8'] ?? 0;
    $r9[] = $sum['totalr9'] ?? 0;
    $r10[] = $sum['totalr10'] ?? 0;
    $r11[] = $sum['totalr11'] ?? 0;
    $r12[] = $sum['totalr12'] ?? 0;
    $r13[] = $sum['totalr13'] ?? 0;
    $r14[] = $sum['totalr14'] ?? 0;
    $r15[] = $sum['totalr15'] ?? 0;
    $r16[] = $sum['totalr16'] ?? 0;
    $r17[] = $sum['totalr17'] ?? 0;
    $r18[] = $sum['totalr18'] ?? 0;
    $r19[] = $sum['totalr19'] ?? 0;
    $r20[] = $sum['totalr20'] ?? 0;
    $r22[] = $sum['totalr22'] ?? 0;
}

// Crear el PDF
$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

$pdf->Separador();
$pdf->TablaInicio($dataFromDb);
$pdf->Separador();
$pdf->FancyTable($header, $dataS, $anchoColumnas, $numGrupos, $totalPorGrupo, $r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10, $r11, $r12, $r13, $r14, $r15, $r16, $r17, $r18, $r19, $r20, $r22);
$pdf->Separador();

$nombreArchivo = 'reporte_' . $numcontrol . '.pdf';
//$nombreArchivo, "D"
$pdf->Output($nombreArchivo, "I");

?>

