<?php

require_once './../library/fpdf/fpdf.php';

class PDF extends FPDF
{
    function Header()
    {
        // Encabezado de página
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('Encabezado del Documento'), 0, 1, 'C');
    }

    function Footer()
    {
        // Pie de página
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo(), 0, 0, 'C');
    }

    function Page1Content()
    {
        // Contenido de la página 1
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 10, utf8_decode('Contenido para la página 1.'), 0, 'L');
    }

    function Page2Content()
    {
        // Contenido de la página 2 (operación)
        $this->SetFont('Arial', '', 12);
        $resultado = 10 + 5; // Ejemplo de operación
        $this->MultiCell(0, 10, utf8_decode('Resultado de la operación: ' . $resultado), 0, 'L');
    }

    function Page3Content()
    {
        // Contenido de la página 3 (texto y operación)
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 10, utf8_decode('Texto para la página 3.'), 0, 'L');
        
        $resultado = 20 - 8; // Ejemplo de otra operación
        $this->MultiCell(0, 10, utf8_decode('Resultado de otra operación: ' . $resultado), 0, 'L');
    }

    function Page4Content()
    {
        // Contenido de la página 3 (texto y operación)
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 10, utf8_decode('aaaaaaaaaaaaaaaaaaaaaaaaaa'), 0, 'L');
        
        $resultado = 200 - 80; // Ejemplo de otra operación
        $this->MultiCell(0, 10, utf8_decode('Resultado de otra operación: ' . $resultado), 0, 'L');
    }
}

// CREACIÓN DEL OBJETO DE LA CLASE HEREDADA
$pdf = new PDF('L','mm',array(210, 260));
$pdf->AliasNbPages();

// Agregar páginas con contenido diferente
$pdf->AddPage();
$pdf->Page1Content();

$pdf->AddPage();
$pdf->Page2Content();

$pdf->AddPage();
$pdf->Page3Content();

$pdf->AddPage();
$pdf->Page4Content();

$pdf->Output();

?>
