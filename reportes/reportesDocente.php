<?php
require('./../fpdf/fpdf.php');
include('./../php/conexion.php');

// Clase PDF extendida con funciones personalizadas
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
    $this->Cell(0, 5, 'Reporte de evaluacion de asignaturas hibridas y virtuales', 0, 1, 'C');
    
    // Grey background for subtitle
    $this->SetFillColor(231, 230, 230); // Grey color in RGB
    $this->Rect(0, $this->GetY()+10, $this->w, 13, 'F'); // Draw filled rectangle for subtitle
    
    // Subtitle
    $this->SetFont('Arial', 'B', 10);
    $this->SetTextColor(0, 0, 0); // Black color
    $this->Cell(0, 29, 'Opinion de Estudiantes', 0, 1, 'C');

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
    
    $this->Ln(18);
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
        $this->SetFillColor(48, 83, 149); // Color azul en RGB
        $this->SetTextColor(255);
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
    $this->Cell(63, 6, 'Unidad academica:', 'LR', 0, 'L', false);
    $this->Cell(126, 6, $dataI['unidad'], 'LR', 0, 'L', false);
    $this->Ln();
    $this->Cell(63, 6, 'Datos Generales:', 'LR', 0, 'L', true);
    $this->Cell(126, 6, 'Indice (Global)', 'LR', 0, 'L', true);
    $this->Ln();
    $this->Cell(63, 6, 'Promedio:', 'LR', 0, 'L', false);
    $this->Cell(126, 6, 'Valor estatico con variable', 'LR', 0, 'L', false);
    $this->Ln();
    $this->Cell(63, 6, 'Nombre:', 'LR', 0, 'L', true);
    $this->Cell(126, 6, $dataI['nombre_docente'], 'LR', 0, 'L', true);
    $this->Ln();
    $this->Cell(63, 6, 'Materia:', 'LR', 0, 'L', false);
    $this->Cell(126, 6, $dataI['materia'], 'LR', 0, 'L', false);
    $this->Ln();

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

if (isset($_GET['numcontrol'])) {
    $numcontrol = htmlspecialchars($_GET['numcontrol']);
}else {
    $periodo = 'No esta definido "numcontrol"';
}

if (isset($_GET['id_grupo'])) {
    $id_grupo = htmlspecialchars($_GET['id_grupo']);
}else {
    $periodo = 'No esta definido';
}

if (isset($_GET['acta_id'])) {
    $acta_id = htmlspecialchars($_GET['acta_id']);
}else {
    $periodo = 'No esta definido "id_grupo"';
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
$consulta = $conn->prepare("SELECT numcontrol, nombre_docente, ap_paterno_docente, ap_materno_docente, unidad, materia  FROM virtuales WHERE numcontrol = :numcontrol");
// Vincula los parámetros
$consulta->bindParam(':numcontrol', $numcontrol);
// Ejecuta la consulta
$consulta->execute();
// Obtiene los resultados
$resultado = $consulta->fetch(PDO::FETCH_ASSOC);

$dataFromDb = [
    'nombre_docente' => $resultado['nombre_docente'] ?? 'No definido',
    'ap_paterno_docente' => $resultado['ap_paterno_docente'] ?? 'No definido',
    'ap_materno_docente' => $resultado['ap_materno_docente'] ?? 'No definido',
    'unidad' => $resultado['unidad'] ?? 'No definido',
    'materia' => $resultado['materia'] ?? 'No definido'
];
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
$header = ['Grupos:', 'B', 'Respuesta'];
//$headerI = ['Prueba', 'Prueba'];

// Imprimir la tabla
$pdf->TablaInicio($dataFromDb);
$pdf->FancyTable($header, $data);

$pdf->Output();

?>
