<?php

require_once './../library/fpdf/fpdf.php';

class PDF extends FPDF{

    function Header(){
        // Logos
        $this->Image('./../assets/img/LogoUAEMcolor.png', 25, 10, 35);
        $this->Image('./../assets/img/LogoUAEMcolor.png', 235, 10, 35);
        
        // Título
        $this->SetFont('Arial', 'B', 13);
        $this->SetTextColor(53, 95, 143); // 
        $this->Cell(0, 5, utf8_decode("Universidad Autónoma del Estado de Morelos"), 0, 1, 'C');
        $this->Ln(2);
        $this->Cell(0, 5, utf8_decode("Secretaria Académica"), 0, 1, 'C');
        $this->Ln(2);
        $this->Cell(0, 5, utf8_decode("Dirección de Educación Superior"), 0, 1, 'C');

        
        $this->Ln(12);
    }

    function Footer(){
        $this->SetY(-15);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . ' / {nb}', 0, 0, 'C');
    }

    function Portada(){
        $xIni = 90;
        $xsegundo = 150;
        $xIniCuadro = 50;
        $YIniCuadro = 60;
        //Primera fila
        $this->SetFillColor(223, 237, 240);
        $this->Rect($xIniCuadro, $YIniCuadro, 10, 10, 'F');
        $this->SetFillColor(227, 238, 242);
        $this->Rect(($xIniCuadro+10), $YIniCuadro, 10, 10, 'F');
        $this->SetFillColor(229, 240, 242);
        $this->Rect(($xIniCuadro+20), $YIniCuadro, 10, 10, 'F');
        $this->SetFillColor(232, 242, 244);
        $this->Rect(($xIniCuadro+30), $YIniCuadro, 10, 10, 'F');
        $this->SetFillColor(212, 229, 236);
        $this->Rect(($xIniCuadro+40), $YIniCuadro, 10, 10, 'F');
        //Segunda fila
        $this->SetFillColor(222, 236, 239);
        $this->Rect($xIniCuadro, ($YIniCuadro+10), 10, 10, 'F');
        $this->SetFillColor(42, 132, 158);
        $this->Rect(($xIniCuadro+10), ($YIniCuadro+10), 10, 10, 'F');
        $this->SetFillColor(229, 239, 241);
        $this->Rect(($xIniCuadro+20), ($YIniCuadro+10), 10, 10, 'F');
        $this->SetFillColor(212, 229, 236);
        $this->Rect(($xIniCuadro+30), ($YIniCuadro+10), 10, 10, 'F');
        $this->SetFillColor(169, 206, 215);
        $this->Rect(($xIniCuadro+40), ($YIniCuadro+10), 10, 10, 'F');
        //Terce fila
        $this->SetFillColor(222, 236, 239);
        $this->Rect($xIniCuadro, ($YIniCuadro+20), 10, 10, 'F');
        $this->SetFillColor(227, 238, 242);
        $this->Rect(($xIniCuadro+10), ($YIniCuadro+20), 10, 10, 'F');
        $this->SetFillColor(212, 229, 236);
        $this->Rect(($xIniCuadro+20), ($YIniCuadro+20), 10, 10, 'F');
        $this->SetFillColor(169, 206, 215);
        $this->Rect(($xIniCuadro+30), ($YIniCuadro+20), 10, 10, 'F');
        $this->SetFillColor(42, 132, 158);
        $this->Rect(($xIniCuadro+40), ($YIniCuadro+20), 10, 10, 'F');
        //Cuart fila
        $this->SetFillColor(223, 237, 240);
        $this->Rect($xIniCuadro, ($YIniCuadro+30), 10, 10, 'F');
        $this->SetFillColor(226, 237, 241);
        $this->Rect(($xIniCuadro+10), ($YIniCuadro+30), 10, 10, 'F');
        $this->SetFillColor(169, 206, 215);
        $this->Rect(($xIniCuadro+20), ($YIniCuadro+30), 10, 10, 'F');
        $this->SetFillColor(232, 242, 244);
        $this->Rect(($xIniCuadro+30), ($YIniCuadro+30), 10, 10, 'F');
        $this->SetFillColor(235, 243, 246);
        $this->Rect(($xIniCuadro+40), ($YIniCuadro+30), 10, 10, 'F');
        //
        $this->Ln(19);
        $this->SetFillColor(232, 242, 244);
        $this->Cell($xIni, 10, utf8_decode(''), 0, 0, 'R');
        $this->Cell($xsegundo, 10, utf8_decode(''), 0, 0, 'R', true);
        $this->Ln();
        $this->SetFillColor(48, 132, 156);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell($xIni, 10, utf8_decode(''), 0, 0, 'R');
        $this->Cell($xsegundo, 10, utf8_decode('Reporte Institucional de Evaluación del Desempeño Docente'), 0, 0, 'R', true);
        $this->Ln();
        $this->SetFont('Arial', '', 14);
        $this->Cell($xIni, 10, utf8_decode(''), 0, 0, 'R');
        $this->Cell($xsegundo, 10, utf8_decode('Modalidad híbrida y/o virtual'), 0, 0, 'R', true);
        $this->Ln();
        $this->SetFillColor(235, 243, 246);
        $this->Cell($xIni, 10, utf8_decode(''), 0, 0, 'R');
        $this->Cell($xsegundo, 10, utf8_decode(''), 0, 0, 'R', true);
        $this->Ln();
    }

    function Page2Content()
    {
        // Contenido de la página 2 (operación)
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 12);
        $resultado = 10 + 5; // Ejemplo de operación
        $this->MultiCell(0, 10, utf8_decode('Resultado de la operación: ' . $resultado), 0, 'L');
    }

    function Page3Content()
    {
        // Contenido de la página 3 (texto y operación)
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 10, utf8_decode('Texto para la página 3.'), 0, 'L');
        
        $resultado = 20 - 8; // Ejemplo de otra operación
        $this->MultiCell(0, 10, utf8_decode('Resultado de otra operación: ' . $resultado), 0, 'L');
    }

    function Page4Content()
    {
        // Contenido de la página 3 (texto y operación)
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 10, utf8_decode('aaaaaaaaaaaaaaaaaaaaaaaaaa'), 0, 'C');
        
        $resultado = 200 - 80; // Ejemplo de otra operación
        $this->MultiCell(0, 10, utf8_decode('Resultado de otra operación: ' . $resultado), 0, 'L');
    }
}


$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();

// Agregar páginas con contenido diferente
$pdf->AddPage();
$pdf->Portada();

$pdf->AddPage();
$pdf->Page2Content();

$pdf->AddPage();
$pdf->Page3Content();

$pdf->AddPage();
$pdf->Page4Content();

$pdf->Output();

?>
