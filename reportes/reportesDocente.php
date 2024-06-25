<?php
require('./../fpdf/fpdf.php');
include('./../php/conexion.php');

// Clase PDF extendida con funciones personalizadas
class PDF extends FPDF
{
    // Cabecera de página
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
        $this->SetFont('Arial', 'B', 10);
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
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . ' / {nb}', 0, 0, 'C');
    }
    
    // Función para crear la tabla de datos principal y las tablas adicionales
    function FancyTable($header, $data, $anchoColumnas, $numGrupos) {
        // Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(255, 255, 255); // Blanco
        $this->SetTextColor(0, 0, 0); // Negro
        $this->SetDrawColor(48, 83, 149); // Azul
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
        
        // Cabecera dinámica
        foreach ($header as $i => $title) {
            $this->Cell($anchoColumnas[$i], 7, $title, 1, 0, 'C', true);
        }
        $this->Ln();
        
        // Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255); // Azul claro
        $this->SetTextColor(0);
        $this->SetFont('');
        $fill = false;
        
        // Datos principales (grupos y total)
        foreach ($data as $row) {
            for ($i = 0; $i < count($header); $i++) {
                $this->Cell($anchoColumnas[$i], 6, utf8_decode($row[$i]), 'LR', 0, 'L', $fill);
            }
            $this->Ln();
            $fill = !$fill;
        }
        
        // Línea de cierre de la tabla principal
        $this->Cell(array_sum($anchoColumnas), 0, '', 'T');
        $this->Ln();
        
        // Tablas adicionales alineadas con las columnas dinámicas
        $titulosTablas = [
            'Estudiantes participantes:',
            'Satisfacción de desempeño:',
            'Expectativas cubiertas del curso:',
            'Asesor en Línea (índice Global):',
            'Diseño del Curso (índice Global):'
        ];
        
        $this->SetFont('Arial', 'B', 10);
        foreach ($titulosTablas as $j => $titulo) {
            $this->Cell($anchoColumnas[0], 6, utf8_decode($titulo), 'LR', 0, 'L', $j % 2 == 0);
            for ($k = 1; $k <= $numGrupos; $k++) {
                $this->Cell($anchoColumnas[$k], 6, '', 'LR', 0, 'L', false); // Celdas vacías para alinear
            }
            $this->Cell($anchoColumnas[$numGrupos + 1], 6, '', 'LR', 0, 'L', false); // Celda vacía para alinear con total
            $this->Ln();
        }
    }
    
    // Función para crear la tabla de inicio con datos estáticos
    function TablaInicio($dataI)
    {
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
        $this->Cell(60, 6, utf8_decode('Unidad académica:'), 'LR', 0, 'L', false);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(129, 6, utf8_decode($dataI['unidad']), 'LR', 0, 'C', false);
        $this->Ln();
        
        $this->SetFont('Arial', '', 10);
        $this->Cell(60, 6, utf8_decode('Datos Generales:'), 'LR', 0, 'L', true);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(129, 6, utf8_decode('Índice (Global)'), 'LR', 0, 'C', true);
        $this->Ln();
        
        $this->SetFont('Arial', '', 10);
        $this->Cell(60, 6, utf8_decode('Promedio:'), 'LR', 0, 'L', false);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(129, 6, utf8_decode('Valor estático con variable'), 'LR', 0, 'C', false);
        $this->Ln();
        
        $this->SetFont('Arial', '', 10);
        $this->Cell(60, 6, utf8_decode('Asesor(a):'), 'LR', 0, 'L', true);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(129, 6, utf8_decode($dataI['nombre_docente']. " " . $dataI['ap_paterno_docente'] . " " . $dataI['ap_materno_docente']), 'LR', 0, 'C', true);
        $this->Ln();
        
        $this->SetFont('Arial', '', 10);
        $this->Cell(60, 6, utf8_decode('Curso(s):'), 'LR', 0, 'L', false);
        $this->Ln(); // Salto de línea para empezar en una nueva fila
        
        // Si $dataI['materia'] es un arreglo
        foreach ($dataI['materia'] as $materia) {
            $this->Cell(60, 6, '', 'LR', 0, 'L', false);
            $this->Cell(129, 6, utf8_decode($materia), 'LR', 0, 'L', false);
            $this->Ln(); // Salto de línea después de cada materia
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
$grupo = [];

if (isset($_GET['numcontrol'])) {
    $numcontrol = htmlspecialchars($_GET['numcontrol']);
} else {
    $periodo = 'No está definido "numcontrol"';
}

if (isset($_GET['periodo'])) {
    $periodo = htmlspecialchars($_GET['periodo']);
} else {
    $periodo = 'No está definido "periodo"';
}

if (isset($_GET['anio'])) {
    $anio = htmlspecialchars($_GET['anio']);
} else {
    $periodo = 'No está definido "anio"';
}

// Consulta SQL para obtener los datos
$consulta = $conn->prepare("SELECT * FROM virtuales WHERE numcontrol = :numcontrol");
$consulta->bindParam(':numcontrol', $numcontrol);
$consulta->execute();
$resultado = $consulta->fetch(PDO::FETCH_ASSOC);

$dataFromDb = [
    'nombre_docente' => $resultado['nombre_docente'] ?? 'No definido',
    'ap_paterno_docente' => $resultado['ap_paterno_docente'] ?? 'No definido',
    'ap_materno_docente' => $resultado['ap_materno_docente'] ?? 'No definido',
    'unidad' => $resultado['unidad'] ?? 'No definido',
    'materia' => [] // Array para almacenar las materias
];

$consulta = $conn->prepare("SELECT DISTINCT materia FROM virtuales WHERE numcontrol = :numcontrol");
$consulta->bindParam(':numcontrol', $numcontrol);
$consulta->execute();
$resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

$materias = [];
foreach ($resultados as $resultado) {
    $materias[] = $resultado['materia'];
}

$dataFromDb['materia'] = $materias;

// Consulta SQL para obtener los datos de preguntav
$consulta = $conn->prepare("SELECT * FROM preguntav WHERE numcontrol = :numcontrol AND id_grupo = :id_grupo AND acta_id = :acta_id");
$consulta->bindParam(':numcontrol', $numcontrol);
$consulta->bindParam(':id_grupo', $id_grupo);
$consulta->bindParam(':acta_id', $acta_id);
$consulta->execute();
$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

$dataS = [];
foreach ($resultado as $fila) {
    for ($i = 1; $i <= 22; $i++) {
        $dataS[] = ['Pregunta ' . $i, $fila['r' . $i]];
    }
}

$consulta = $conn->prepare("SELECT DISTINCT grupo, semestre FROM virtuales WHERE numcontrol = :numcontrol");
$consulta->bindParam(':numcontrol', $numcontrol);
$consulta->execute();
$resultadosGrupos = $consulta->fetchAll(PDO::FETCH_ASSOC);

$grupos = [];
foreach ($resultadosGrupos as $resultadoGrupo) {
    $grupos[] = $resultadoGrupo['grupo'] . " " . $resultadoGrupo['semestre'];
}

$header = ['Grupo(s):'];
$numGrupos = count($grupos);
foreach ($grupos as $grupo) {
    $header[] = $grupo;
}
$header[] = 'Total';

$anchoColumnas = [];
$anchoFijo = 60; // Ancho fijo para la primera columna (Grupos)
$anchoVariable = 189 - $anchoFijo; // Ancho total disponible menos el ancho de la columna fija
$anchoGrupos = $anchoVariable / ($numGrupos + 1); // Distribuir el ancho entre las columnas de grupos y la columna Total
$anchoColumnas[] = $anchoFijo;
for ($i = 0; $i < $numGrupos; $i++) {
    $anchoColumnas[] = $anchoGrupos;
}
$anchoColumnas[] = $anchoGrupos; // Ancho para la columna Total

// Crear el PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

$pdf->TablaInicio($dataFromDb);
$pdf->FancyTable($header, $dataS, $anchoColumnas, $numGrupos);

$pdf->Output();

?>

