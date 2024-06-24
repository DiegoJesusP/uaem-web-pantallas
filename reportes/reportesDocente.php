<?php
require('./../fpdf/fpdf.php');
include('./../php/conexion.php');

// Clase PDF extendida con funciones personalizadas
/*
'L': Alinea el texto a la izquierda.
'C': Centra el texto.
'R': Alinea el texto a la derecha.
*/
class PDF extends FPDF
{
    // Cabecera de página
    function Header(){
    // Background color
    $this->SetFillColor(48, 83, 149); // Blue color in RGB
    $this->Rect(0, 0, $this->w, 30, 'F'); // Draw filled rectangle
    
    // Logo
    $this->Image('./../assets/img/LogoUAEMBlanco.png', 10, 3, 29);
    
    // Title
    $this->SetFont('Arial', 'B', 13 );
    $this->SetTextColor(255, 255, 255); // White color
    $this->Cell(0, 5, utf8_decode("Reporte de evaluación de asignaturas híbridas y virtuales"), 0, 1, 'C');
    
    // Grey background for subtitle
    $this->SetFillColor(231, 230, 230); // Grey color in RGB
    $this->Rect(0, $this->GetY()+10, $this->w, 13, 'F'); // Draw filled rectangle for subtitle
    
    // Subtitle
    $this->SetFont('Arial', 'B', 10);
    $this->SetTextColor(0, 0, 0); // Black color
    $this->Cell(0, 29, utf8_decode("Opinión de Estudiantes"), 0, 1, 'C');

    // Obtener el valor del período desde el parámetro GET
    if (isset($_GET['periodo'])) {
        $periodo = htmlspecialchars($_GET['periodo']);
    } else {
        $periodo = 'No esta definido "periodo"';
    }
    if (isset($_GET['anio'])) {
        $anio = htmlspecialchars($_GET['anio']);
    }else {
        $periodo = 'No esta definido "anio"';
    }

    // Mostrar el valor del período de manera dinámica
    $this->SetFont('Arial', '', 10);
    $this->Cell(0, -18, 'Periodo: ' . $periodo. " " .$anio, 0, 1, 'C');
    
    $this->Ln(12);
    }


    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo() . ' / {nb}', 0, 0, 'C');
    }

    // Función para crear la tabla de datos
    function FancyTable($header, $data)
    {
        // Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(255, 255, 255); // Color azul en RGB
        $this->SetTextColor(000);
        $this->SetDrawColor(48, 83, 149); // Color azul en RGB
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
        // Cabecera
        $w = array(63, 63, 63); // Ajustamos el ancho de las columnas para dos columnas -- 63, 63, 63
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        }
        $this->Ln();
        // Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Datos
        $fill = false;
        $row_count = 0;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Ln();
            $fill = !$fill;
            $row_count++;
            // Añadir un espacio distintivo cada 23 preguntas
            if ($row_count % 22 == 0) {
                $this->Cell(array_sum($w), 0, '', 'T');
                $this->Ln(5); // Espacio de 5 unidades de altura
            }
        }
        // Línea de cierre
        $this->Cell(array_sum($w), 0, '', 'T');
    }

    //
    function TablaInicio($dataI)
{
    // Colores, ancho de línea y fuente en negrita
    $this->SetFillColor(48, 83, 149); // Color azul en RGB
    $this->SetTextColor(255);
    $this->SetDrawColor(48, 83, 149); // Color azul en RGB
    $this->SetLineWidth(.3);
    $this->SetFont('', 'B', 10);

    // Restauración de colores y fuentes
    $this->SetFillColor(224, 235, 255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Datos estáticos combinados con datos de la base de datos
    $this->SetFont('Arial', '', 10);
    $this->Cell(63, 6, utf8_decode('Unidad academica:'), 'LR', 0, 'L', false);
    $this->SetFont('Arial', 'B', 10);
    $this->Cell(126, 6, utf8_decode($dataI['unidad']), 'LR', 0, 'C', false);
    $this->Ln();
    $this->SetFont('Arial', '', 10);
    $this->Cell(63, 6, utf8_decode('Datos Generales:'), 'LR', 0, 'L', true);
    $this->SetFont('Arial', 'B', 10);
    $this->Cell(126, 6, utf8_decode('Indice (Global)'), 'LR', 0, 'C', true);
    $this->Ln();
    $this->SetFont('Arial', '', 10);
    $this->Cell(63, 6, utf8_decode('Promedio:'), 'LR', 0, 'L', false);
    $this->SetFont('Arial', 'B', 10);
    $this->Cell(126, 6, utf8_decode('Valor estático con variable'), 'LR', 0, 'C', false);
    $this->Ln();
    $this->SetFont('Arial', '', 10);
    $this->Cell(63, 6, utf8_decode('Nombre:'), 'LR', 0, 'L', true);
    $this->SetFont('Arial', 'B', 10);
    $this->Cell(126, 6, utf8_decode($dataI['nombre_docente']. " " . $dataI['ap_paterno_docente'] . " " . $dataI['ap_materno_docente']), 'LR', 0, 'C', true);
    $this->Ln();
    $this->SetFont('Arial', '', 10);
    $this->Cell(63, 6, utf8_decode('Materia:'), 'LR', 0, 'L', false);
    $this->Ln(); // Salto de línea para empezar en una nueva fila

    // Si $dataI['materia'] es un arreglo
    foreach ($dataI['materia'] as $materia) {
        $this->Cell(63, 6, '', 'LR', 0, 'L', false);
        $this->Cell(126, 6, utf8_decode($materia), 'LR', 0, 'L', false);
        $this->Ln();
    }


    // Línea de cierre
    $this->Cell(189, 0, '', 'T');
    $this->Ln(1);
}
}

// Crear una instancia de conexión
$conexion = new CConexion();
$conn = $conexion->conexionBD();

$numcontrol = '';
$id_grupo = 0;
$acta_id = 0;
$periodo = '';
$anio = 0;
$grupo=[];

if (isset($_GET['numcontrol'])) {
    $numcontrol = htmlspecialchars($_GET['numcontrol']);
}else {
    $periodo = 'No esta definido "numcontrol"';
}

if (isset($_GET['periodo'])) {
    $periodo = htmlspecialchars($_GET['periodo']);
}else {
    $periodo = 'No esta definido "periodo"';
}

if (isset($_GET['anio'])) {
    $anio = htmlspecialchars($_GET['anio']);
}else {
    $periodo = 'No esta definido "anio"';
}
//--
$consulta = $conn->prepare("SELECT * FROM virtuales WHERE numcontrol = :numcontrol");
// Vincula los parámetros
$consulta->bindParam(':numcontrol', $numcontrol);
// Ejecuta la consulta
$consulta->execute();
// Obtiene los resultados
$resultado = $consulta->fetch(PDO::FETCH_ASSOC);
//select distinct materia from virtuales where numcontrol = :numcontrol;
$dataFromDb = [
    'nombre_docente' => $resultado['nombre_docente'] ?? 'No definido',
    'ap_paterno_docente' => $resultado['ap_paterno_docente'] ?? 'No definido',
    'ap_materno_docente' => $resultado['ap_materno_docente'] ?? 'No definido',
    'unidad' => $resultado['unidad'] ?? 'No definido',
    'materia' => [] // Crear un espacio para almacenar las materias -> No hacer caso 'materia' => $resultado['materia'] ?? 'No definido',
];

$consulta = $conn->prepare("SELECT DISTINCT materia FROM virtuales WHERE numcontrol = :numcontrol");
$consulta->bindParam(':numcontrol', $numcontrol);
$consulta->execute();
$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

$materias = [];
foreach ($resultados as $resultado) {
    $materias[] = $resultado['materia'];
}

// Ahora agregamos las materias al arreglo $dataFromDb
$dataFromDb['materia'] = $materias;

//--
// Consulta SQL para obtener los datos
$consulta = $conn->prepare("SELECT * FROM preguntav WHERE numcontrol = :numcontrol AND id_grupo = :id_grupo AND acta_id = :acta_id");
$consulta->bindParam(':numcontrol', $numcontrol);
$consulta->bindParam(':id_grupo', $id_grupo);
$consulta->bindParam(':acta_id', $acta_id);
$consulta->execute();

// Obtiene los resultados
$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

// Organizar los datos obtenidos en un array
$data = [];
$dataS = [];
foreach ($resultado as $fila) {
    for ($i = 1; $i <= 22; $i++) {
        $dataS[] = ['Pregunta ' . $i, $fila['r' . $i]];
    }
}

// Crear el PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Títulos de las columnas
$header = ['Grupos:', 'B', 'Total'];
//$headerI = ['Prueba', 'Prueba'];

// Imprimir la tabla
$pdf->TablaInicio($dataFromDb);
$pdf->FancyTable($header, $data);

$pdf->Output();

?>
