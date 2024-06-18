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
        $w = array(95, 95); // Ajustamos el ancho de las columnas para dos columnas
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
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Línea de cierre
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

// Crear una instancia de conexión
$conexion = new CConexion();
$conn = $conexion->conexionBD();

$numcontrol = 'ABARROSO';  // Cambia este valor
$id_grupo = 443725;      // Cambia este valor
$acta_id = 882296;        // Cambia este valor

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
foreach ($resultado as $fila) {
    for ($i = 1; $i <= 23; $i++) {
        $data[] = ['Pregunta ' . $i, $fila['r' . $i]];
    }
}

// Crear el PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Títulos de las columnas
$header = ['Pregunta', 'Respuesta'];

// Imprimir la tabla
$pdf->FancyTable($header, $data);

$pdf->Output();
?>
