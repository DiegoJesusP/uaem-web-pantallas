<?php
require('./../fpdf/fpdf.php');
include('./../php/conexion.php');

// Clase PDF extendida con funciones personalizadas
class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        $this->Image('./../assets/img/3.jpg', 10, 6, 23);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Reporte de evaluación de asignaturas híbridas y virtuales', 0, 1, 'C');
        $this->Ln(10);
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
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
        
        // Cabecera
        foreach ($header as $col) {
            $this->Cell(60, 7, $col, 1, 0, 'C', true);
        }
        $this->Ln();
        
        // Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        
        // Datos
        foreach ($data as $row) {
            foreach ($row as $col) {
                $this->Cell(60, 6, $col, 1, 0, 'L');
            }
            $this->Ln();
        }
    }
}

// Crear una instancia de conexión
$conexion = new CConexion();
$conn = $conexion->conexionBD();

$numcontrol = 'CESARMP';  // Cambia este valor
$id_grupo = 443725;      // Cambia este valor
$acta_id = 882296;        // Cambia este valor

// Consulta SQL para obtener los datos
$consulta = $conn->prepare("SELECT COUNT(*) AS total_grupo FROM preguntav WHERE numcontrol = :numcontrol GROUP BY id_grupo");
$consulta->bindParam(':numcontrol', $numcontrol);
$consulta->execute();
$res = $consulta->fetchAll(PDO::FETCH_ASSOC);

$data = [];
foreach ($res as $fila) {
    $data[] = [$fila['total_grupo']];
}

// Crear el PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Títulos de las columnas
$header = ['TotalGrupos'];

// Imprimir la tabla
$pdf->FancyTable($header, $data);

$pdf->Output();
?>
