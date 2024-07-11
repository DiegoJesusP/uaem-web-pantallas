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

    function setFooterText($text, $periodo) {
        $this->footerText = $text;
        $this->footerPeriodo = $periodo;
    }

    function Footer(){
        $this->SetY(-15);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 10, utf8_decode($this->footerText), 0, 1, 'L');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(0, -10, utf8_decode($this->footerPeriodo), 0, 0, 'C');
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, -10, utf8_decode('Página | ') . $this->PageNo(), 0, 0, 'R');
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
        $this->Ln(50);
        //
        $this->SetFillColor(74, 172, 197);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(($xIni + $xsegundo), 10, utf8_decode('Periodo de Evaluación'), 0, 0, 'R');
        $this->Ln();
        //
        $this->SetTextColor(255, 255, 255);
        $this->SetDrawColor(28, 68, 79);
        $this->Cell($xsegundo+25, 10, utf8_decode(''), 0, 0, 'R');
        $this->Cell($xIni-25, 10, utf8_decode($this->footerPeriodo), 1, 0, 'R', true);
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
    function addTable($anchoColumnas, $titulosTablas, $data, $total, $numGrupos, $useFillColor = true, $fillColor = [255, 255, 255]) {
        if ($useFillColor) {
            $this->SetFillColor(...$fillColor);
        }
        //$this->SetFont('Arial', 'B', 10);
    
        foreach ($titulosTablas as $j => $titulo) {
            // Mostrar el título de la tabla
            //MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]])
            $this->MultiCell($anchoColumnas[0], 6, utf8_decode($titulo), 1, 'L', $j % 2 == 0);
            $this->SetXY($this->GetX() + $anchoColumnas[0], $this->GetY() - 6);
            // Mostrar los valores de $data para cada grupo
            for ($k = 1; $k <= $numGrupos; $k++) {
                $valor = isset($data[$k - 1]) ? $data[$k - 1] : '';
                $this->Cell($anchoColumnas[$k], 6, $valor, 1, 0, 'C', $j % 2 == 0);
            }
        }

        foreach($total as $j => $titulo) {
            // Celda vacía para $total
            $this->Cell($anchoColumnas[$numGrupos + 1], 6, $titulo, 1, 0, 'L', $j % 2 == 0);
            $this->Ln();
        }
    
        // Línea de cierre
        $this->Cell(array_sum($anchoColumnas), 0, '', 'T');
        $this->Ln();
    }
}
//
function obtenerParametroGET($nombre, $default = 'No definido') {
    return isset($_GET[$nombre]) ? htmlspecialchars($_GET[$nombre]) : $default;
}
// Obtener parámetros GET
$periodo = obtenerParametroGET('periodo', 'No está definido "periodo"');
$anio = obtenerParametroGET('anio', 'No está definido "anio"');
//

$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
//
$pdf->setFooterText('Reporte Institucional de Evaluación del Desempeño Docente', ($periodo . ' ' . $anio));
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
