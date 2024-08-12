<?php

require_once './../library/fpdf/fpdf.php';
include('./../php/conexion.php');

function abreviarPrimeraPalabra($texto) {
    $texto = mb_strtoupper($texto, 'UTF-8');
    $palabras = explode(' ', $texto);
    $abreviatura = mb_substr($palabras[0], 0, 1, 'UTF-8') . '.';
    $resultado = $abreviatura . ' ' . implode(' ', array_slice($palabras, 1));
    return $resultado;
}

class PDF extends FPDF{
    var $pageNumbers = array();
    function Header(){
        // Logos
        $this->Image('./../assets/img/LogoUAEMcolor.png', 25, 5, 35);
        //$this->Image('./../assets/img/LogoUAEMcolor.png', 235, 5, 35);
        
        // Título
        $this->SetFont('Arial', 'B', 13);
        $this->SetTextColor(53, 95, 143); // 
        $this->Cell(0, 5, utf8_decode("Universidad Autónoma del Estado de Morelos"), 0, 1, 'C');
        $this->Ln(2);
        $this->Cell(0, 5, utf8_decode("Secretaria Académica"), 0, 1, 'C');
        $this->Ln(2);
        $this->Cell(0, 5, utf8_decode("Dirección General de Educación Superior"), 0, 1, 'C');

        
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
        $xSeg = 150;
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
        $this->Cell($xSeg, 10, utf8_decode(''), 0, 0, 'R', true);
        $this->Ln();
        $this->SetFillColor(48, 132, 156);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell($xIni, 10, utf8_decode(''), 0, 0, 'R');
        $this->Cell($xSeg, 10, utf8_decode('Reporte Institucional de Evaluación del Desempeño Docente'), 0, 0, 'R', true);
        $this->Ln();
        $this->SetFont('Arial', '', 14);
        $this->Cell($xIni, 10, utf8_decode(''), 0, 0, 'R');
        $this->Cell($xSeg, 10, utf8_decode('Modalidad híbrida y/o virtual'), 0, 0, 'R', true);
        $this->Ln();
        $this->SetFillColor(235, 243, 246);
        $this->Cell($xIni, 10, utf8_decode(''), 0, 0, 'R');
        $this->Cell($xSeg, 10, utf8_decode(''), 0, 0, 'R', true);
        $this->Ln(50);
        //
        $this->SetFillColor(74, 172, 197);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(($xIni + $xSeg), 10, utf8_decode('Periodo de Evaluación'), 0, 0, 'R');
        $this->Ln();
        //
        $this->SetTextColor(255, 255, 255);
        $this->SetDrawColor(28, 68, 79);
        $this->Cell($xSeg+30, 10, utf8_decode(''), 0, 0, 'R');
        $this->Cell($xIni-30, 10, utf8_decode($this->footerPeriodo), 1, 0, 'R', true);
        $this->Ln();
    }

    function Indice(){
        $xIni = 250;
        $xSeg = 20;
        // Contenido de la página 2 (operación)
        $this->SetFillColor(220, 228, 241);
        $this->SetTextColor(23, 55, 94);
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(($xIni + $xSeg), 10, utf8_decode('Contenido'), 1, 1, 'C');
        $this->SetFont('Arial', '', 15);
        $this->Cell(($xIni + $xSeg), 10, utf8_decode('Reporte de Evaluación Del Desempeño Docente, asignaturas híbridas y/o virtuales'), 1, 1, 'C', true);
        
        $anchoColumnas = [];
        $anchoColumnas[] = $xIni; // texto
        $anchoColumnas[] = $xSeg; // numero
        $num = [1, 2, 3, 4];
        $this->SetFont('Arial', 'B', 12);
        $this->AddIndice($anchoColumnas, ["I. Resultado Institucional. Modalidad y dimensiones de evaluación."], $num[0], true); 
        $this->AddIndice($anchoColumnas, ["II. Resultado Institucional. Modalidad, dimensiones de evaluación y de dimensión."], $num[1], true, [220, 228, 241]); 
        $this->AddIndice($anchoColumnas, ["III. Desglose de resultados. Dimensiones de evaluación, unidad académica, programa educativo y asignatura:\n     * Modalidad Híbrida"], $num[2], true); 
        $this->AddIndice($anchoColumnas, ["IV. Desglose de resultados. Dimensiones de evaluación, unidad académica, programa educativo y asignatura:\n      * Modalidad Virtual"], $num[3], true, [220, 228, 241]); 
    }

    function AddIndice($anchoColumnas, $titulosTablas, $data, $useFillColor = true, $fillColor = [255, 255, 255]) {
        if ($useFillColor) {
            $this->SetFillColor(...$fillColor);
        }
        //
        foreach ($titulosTablas as $j => $titulo) {
            //
            $x = $this->GetX();
            $y = $this->GetY();
            // Mostrar el título de la tabla
            //MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]])
            $this->MultiCell($anchoColumnas[0], 10, utf8_decode($titulo), 1, 'L', $j % 2 == 0);
            $this->SetXY($this->GetX() + $anchoColumnas[0], $this->GetY() - 10);
            $this->MultiCell($anchoColumnas[1], 10, $data, 1, 'C', $j % 2 == 0);
        }
        // Línea de cierre
        $this->Cell(array_sum($anchoColumnas), 0, '', 'T');
        $this->Ln();
    }

    function Page1Content($MHU, $MVU, $MH, $MV, $MHG, $MVG, $MHA, $MVA, $MHE, $MVE, $MHInstr, $MVInstr, $PHAsesor, $PVAsesor, $PHDisenio, $PVDisenio){
        $this->pageNumbers[] = $this->PageNo();
        // Contenido de la página 3 (texto y operación)
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 10, utf8_decode('l. Resultado Institucional. Modalidad y dimensiones de evaluación.'), 0, 'L');
        //CREACION DE TABLAS
        //
        $separador = 10;
        $tamanioAltoColumna = 5;
        $subTitulos = [
            "\n \n \n",                         //1
            "Unidades académicas evaluadas",    //2
            "Unidades curriculares evaluadas",  //3
            "\nGrupos evaluados",               //4
            "\nAsesores evaluados*",            //5
            "\nEstudiantes registrados",        //6
            "\nEstudiantes participantes",      //7
            "\nInstrumentos Aplicados",         //8
            "1) Funciones del asesor en línea", //9
            "2) Diseño y calidad del curso",    //10
            "\nPromedio\ntotal"                 //11
        ];
        $divisionTitulo = 277 / count($subTitulos);
        $medidas = [($divisionTitulo), ($divisionTitulo * 7), ($divisionTitulo * 3)];
        //
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', 'B', 12);
        $this->AddTableHeaderMan($medidas, ($tamanioAltoColumna + 2), ['', 'Participantes', 'Dimensiones de evaluación'], true, [220, 228, 241]);
        //
        //
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 10);
        $this->AddTableSubT($tamanioAltoColumna, $subTitulos, true, [217, 217, 217]);
        $this->Ln($separador);
        //
        $this->SetFont('Arial', '', 10);
        $ER = ($MHE + $MVE);
        $EP = ($MHE + $MVE);
        $ESP = $ER - $EP;
        $promIA = (($PHAsesor + $PVAsesor)>0)?number_format(($PHAsesor + $PVAsesor) / 2, 1):0;
        $promID = (($PHDisenio + $PVDisenio)>0)?number_format(($PHDisenio + $PVDisenio) / 2, 1):0;
        $promI = (($promIA + $promID)>0)?number_format(($promIA + $promID) / 2, 1):0;
        $resultadoInstitucional = [
            "Resultado institucional**",
            "\n". ($MHU + $MVU), 
            "\n". ($MH + $MV), 
            "\n". ($MHG + $MVG), 
            "\n". ($MHA + $MVA), 
            "\n". $ER, 
            "\n". $EP, 
            "\n". ($MHInstr + $MVInstr), 
            "\n". $promIA, //
            "\n". $promID, //
            "\n". $promI
        ];
        $this->AddTableBodyPage($tamanioAltoColumna, $resultadoInstitucional, true, [217, 217, 217]);
        $this->SetFont('Arial', '', 10);
        $this->Ln($separador);
        $promHib = (($PHAsesor + $PHDisenio)>0)?number_format(($PHAsesor + $PHDisenio) / 2, 1):0;
        $modalidadHibrida = [
            "Modalidad híbrida",
            "\n". $MHU, 
            "\n". $MH,
            "\n". $MHG, 
            "\n". $MHA, 
            "\n". $MHE, 
            "\n". $MHE, 
            "\n". $MHInstr, 
            "\n". $PHAsesor, //
            "\n". $PHDisenio, //
            "\n". $promHib
        ];
        $this->AddTableBodyPage($tamanioAltoColumna, $modalidadHibrida, true, [217, 217, 217]);
        $this->Ln($separador);
        $promVirt = (($PVAsesor + $PVDisenio)>0)?number_format(($PVAsesor + $PVDisenio) / 2, 1):0;
        $modalidadVirtual = [
            "Modalidad virtual",
            "\n". $MVU, 
            "\n". $MV,  
            "\n". $MVG, 
            "\n". $MVA, 
            "\n". $MVE, 
            "\n". $MVE, 
            "\n". $MVInstr, 
            "\n". $PVAsesor, //
            "\n". $PVDisenio, //
            "\n". $promVirt
        ];
        $this->AddTableBodyPage($tamanioAltoColumna, $modalidadVirtual, true, [217, 217, 217]);
        $this->Ln($separador);
        //
        $this->SetTextColor(38, 71, 114);
        //
        if ($promI > 0 && $promHib > 0 && $promVirt > 0) {
        $data = array('Institucional' => $promI, 'Híbrida' => $promHib, 'Virtual' => $promVirt);

        $this->Ln(6);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('Resultado Institucional y Modalidad'), 1, 1, 'C');
        $this->Ln(3);

        $this->SetFont('Arial', '', 10);
        $valX = $this->GetX();
        $valY = $this->GetY();

        $this->SetXY(90, $valY);
        
        $tData = array_sum($data);
        $coloresRGB = $this->ColoresAleatorios($tData);
        $col1=array(250, 192, 144);
        $col2=array(147, 205, 221);
        $col3=array(217, 150, 148);
        //PieChart = $w, $h, $data, $format, $colors=null
        //$this->PieChart(100, 35, $data, '%l (%p)', $coloresRGB);
        $this->PieChart(100, 35, $data, '%l (%p)', array($col1,$col2,$col3));
        $this->SetXY($valX, $valY + 30);
        //**** */
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 10, utf8_decode('Gráfico 1. Resultado institucional y modalidad.'), 0, 'R');
        }
        $this->MultiCell(0, 6, utf8_decode('**El resultado institucional refiere al índice global de los resultados de evaluaciól docente de los programas educativos de las unidades académicas participantes por modalidad.'), 0, 'L');
        $this->MultiCell(0, 6, utf8_decode('*Total de asesores participantes son contabilizados como registros únicos.'), 0, 'L');
        //
        $this->AddPage();
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('Resultado institucional por modalidad y dimensiones de evaluación'), 1, 1, 'C');
        //
        if($promIA > 0 && $promID > 0 && $PHAsesor > 0 && $PHDisenio > 0 && $PVAsesor > 0 && $PVDisenio > 0 && $ER > 0 && $EP > 0 && $ESP > 0){
        $this->Ln(4);
        $this->SetFont('Arial', 'I', 13);
        $this->Cell(0, 5, utf8_decode('Resultado Institucional'), 0, 1, 'C');
        $this->Ln(3);
        $valX = $this->GetX();
        $valY = $this->GetY();
        $dataInstitucional = array('Funciones del asesor' => $promIA, 'Diseño y calidad del curso' => $promID);
        $this->BarDiagram(200, 30, $dataInstitucional, '%l : %v (%p)', array(250, 192, 144));
        $this->SetXY($valX, $valY + 30);
        //****  */
        $this->Ln(3);
        $this->SetFont('Arial', 'I', 13);
        $this->Cell(0, 5, utf8_decode('Modalidad Híbrida'), 0, 1, 'C');
        $this->Ln(3);
        $valX = $this->GetX();
        $valY = $this->GetY();
        $dataHibrida = array('Funciones del asesor' => $PHAsesor, 'Diseño y calidad del curso' => $PHDisenio);
        $this->BarDiagram(200, 30, $dataHibrida, '%l : %v (%p)', array(147, 205, 221));
        $this->SetXY($valX, $valY + 30);
        //**** */
        $this->Ln(3);
        $this->SetFont('Arial', 'I', 13);
        $this->Cell(0, 5, utf8_decode('Modalidad Virtual'), 0, 1, 'C');
        $this->Ln(3);
        $valX = $this->GetX();
        $valY = $this->GetY();
        $dataVirtual = array('Funciones del asesor' => $PVAsesor, 'Diseño y calidad del curso' => $PVDisenio);
        $this->BarDiagram(200, 30, $dataVirtual, '%l : %v (%p)', array(217, 150, 148));
        $this->SetXY($valX, $valY + 30);
        //
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 10, utf8_decode('Gráfico 2. Resultado Institucional por modalidad y dimensiones de evaluación.'), 0, 'R');
        //
        $this->AddPage();
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('Nivel de Participación de Estudiantes'), 1, 1, 'C');
        //
        $this->Ln(4);
        $this->SetFont('Arial', 'I', 13);
        $this->Cell(0, 5, utf8_decode('Número de Estudiantes'), 0, 1, 'C');
        $this->Ln(3);
        $valX = $this->GetX();
        $valY = $this->GetY();
        $dataEstudiantes = array('Registrados en sistema' => $ER, 'Participantes' => $EP, 'Sin participación' => $ESP);
        $this->BarDiagram(200, 60, $dataEstudiantes, '%l : %v (%p)', array(79, 129, 189));
        $this->SetXY($valX, $valY + 70);
        //
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 10, utf8_decode('Gráfico 3. Nivel de participación de estudiantes.'), 0, 'R');
        }
        //
    }

    function Page2Content($MHE, $MVE, $MHInstr, $MVInstr, $PHOportunidad, $PVOportunidad, $PHCalidad, $PVCalidad, $PHDominio, $PVDominio, $PHDclaridad, 
        $PVDclaridad, $PHDcalidad, $PVDcalidad, $PHDvariedad, $PVDvariedad, $PHDutilidad, $PVDutilidad, $PHDautonomia, $PVDautonomia, $PHDcontenidos, $PVDcontenidos,
        $PHDgrafico, $PVDgrafico){
        //
        $this->pageNumbers[] = $this->PageNo();
        // Contenido de la página 3 (texto y operación)
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 10, utf8_decode('II. Resultado Institucional. Modalidad, dimensiones de evaluación y de dimensión.'), 0, 'L');
        $separador = 10;
        $tamanioAltoColumna = 5;
        $subTitulos = [
            "\n \n \n",
            "\nEstudiantes participantes", 
            "\nInstrumentos aplicados", 
            "Oportunidad en la retroalimentación y respuesta", 
            "Calidad de retroalimentación y respuesta", 
            "Dominio y desempeño del asesor en línea", 
            "\nPromedio total de dimensión"
        ];
        $divisionTitulo = 277 / count($subTitulos);
        $medidas = [($divisionTitulo * 3), ($divisionTitulo * 4)];
        //
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 15);
        $this->AddTableHeaderMan($medidas, ($tamanioAltoColumna + 5), ['', 'Desglose Dimensiones de evaluación'], true, [191, 191, 191]);
        $this->SetFont('Arial', 'B', 12);
        $this->AddTableHeaderMan($medidas, ($tamanioAltoColumna + 3), ['', 'Dimensión: Funciones del asesor en línea'], true, [255, 229, 153]);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 11);
        $this->AddTableSubT($tamanioAltoColumna, $subTitulos, true, [242, 242, 242]);
        $this->Ln($separador);
        $EP = ($MHE + $MVE);
        $IA = ($MHInstr + $MVInstr);
        $promHib = (($PHOportunidad + $PHCalidad + $PHDominio)>0)?number_format(($PHOportunidad + $PHCalidad + $PHDominio) / 3, 1):0;
        $modalidadHibrida = [
            "\nModalidad híbrida",
            "\n". $MHE, 
            "\n". $MHInstr, 
            "\n". $PHOportunidad, 
            "\n". $PHCalidad, 
            "\n". $PHDominio, 
            "\n". $promHib
        ];
        $this->AddTableBodyPage2($tamanioAltoColumna, $modalidadHibrida, true, [255, 229, 153]);
        $this->Ln($separador);
        $promVirt = (($PVOportunidad + $PVCalidad + $PVDominio)>0)?number_format(($PVOportunidad + $PVCalidad + $PVDominio) / 3, 1):0;
        $modalidadVirtual = [
            "\nModalidad virtual",
            "\n". $MVE, 
            "\n". $MVInstr, 
            "\n". $PVOportunidad, 
            "\n". $PVCalidad, 
            "\n". $PVDominio, 
            "\n". $promVirt
        ];
        $this->AddTableBodyPage2($tamanioAltoColumna, $modalidadVirtual, true, [255, 229, 153]);
        $this->Ln($separador);
        $this->SetFont('Arial', 'B', 11);
        $promInstOportunidad = (($PHOportunidad + $PVOportunidad)>0)?number_format(($PHOportunidad + $PVOportunidad) / 2, 1):0;
        $promInstCalidad = (($PHCalidad + $PVCalidad)>0)?number_format(($PHCalidad + $PVCalidad) / 2, 1):0;
        $promInstDominio = (($PHDominio + $PVDominio)>0)?number_format(($PHDominio + $PVDominio) / 2, 1):0;
        $promInst = (($promInstOportunidad + $promInstCalidad + $promInstDominio)>0)?number_format(($promInstOportunidad + $promInstCalidad + $promInstDominio) / 3, 1):0;
        $modalidadInstitucional = [
            "Resultado Institucional",
            "\n". $EP, 
            "\n". $IA, 
            "\n". $promInstOportunidad, 
            "\n". $promInstCalidad, 
            "\n". $promInstDominio, 
            "\n". $promInst
        ];
        $this->AddTableBodyPage2($tamanioAltoColumna, $modalidadInstitucional, true, [255, 229, 153]);
        $this->Ln($separador);
        //
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', '', 12);
        //--
        if ($promInstOportunidad > 0 && $PHOportunidad > 0 && $PVOportunidad > 0 && $promInstCalidad > 0 && $PHcalidad > 0 && $PVCalidad > 0 && $promInstDominio > 0 && $PHDominio > 0 && $PVDominio > 0) {
        $this->Ln(6);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('Dimensión: Funciones del Asesor en Línea'), 1, 1, 'C');
        $this->Ln(5);

        $this->SetFont('Arial', 'I', 13);
        $this->Cell(0, 5, utf8_decode('Prontitud de retroalimentación y respuesta'), 0, 1, 'C');
        $this->Ln(2);
        $this->SetFont('Arial', '', 10);

        $data = array('Institucional' => $promInstOportunidad, 'Híbrida' => $PHOportunidad, 'Virtual' => $PVOportunidad);
        $valX = $this->GetX();
        $valY = $this->GetY();

        $this->SetXY(90, $valY);
        
        $tData = array_sum($data);
        $coloresRGB = $this->ColoresAleatorios($tData);
        $col1=array(155, 187, 89);
        $col2=array(79, 129, 189);
        $col3=array(192, 80, 77);
        //PieChart = $w, $h, $data, $format, $colors=null
        //$this->PieChart(100, 35, $data, '%l (%p)', $coloresRGB);
        $this->PieChart(100, 35, $data, '%l (%p)', array($col1,$col2,$col3));
        $this->SetXY($valX, $valY + 80);
        //**** */
        $this->SetFont('Arial', 'I', 13);
        $this->Cell(0, 5, utf8_decode('Calidad de retroalimentación y respuesta'), 0, 1, 'C');
        $this->Ln(2);
        $this->SetFont('Arial', '', 10);

        $data = array('Institucional' => $promInstCalidad, 'Híbrida' => $PHCalidad, 'Virtual' => $PVCalidad);
        $valX = $this->GetX();
        $valY = $this->GetY();

        $this->SetXY(90, $valY);
        
        $tData = array_sum($data);
        $coloresRGB = $this->ColoresAleatorios($tData);
        $col1=array(155, 187, 89);
        $col2=array(79, 129, 189);
        $col3=array(192, 80, 77);
        //PieChart = $w, $h, $data, $format, $colors=null
        //$this->PieChart(100, 35, $data, '%l (%p)', $coloresRGB);
        $this->PieChart(100, 35, $data, '%l (%p)', array($col1,$col2,$col3));
        $this->SetXY($valX, $valY + 40);
        //**** */
        $this->SetFont('Arial', 'I', 13);
        $this->Cell(0, 5, utf8_decode('Dominio y desempeño del asesor en línea'), 0, 1, 'C');
        $this->Ln(2);
        $this->SetFont('Arial', '', 10);

        $data = array('Institucional' => $promInstDominio, 'Híbrida' => $PHDominio, 'Virtual' => $PVDominio);
        $valX = $this->GetX();
        $valY = $this->GetY();

        $this->SetXY(90, $valY);
        
        $tData = array_sum($data);
        $coloresRGB = $this->ColoresAleatorios($tData);
        $col1=array(155, 187, 89);
        $col2=array(79, 129, 189);
        $col3=array(192, 80, 77);
        //PieChart = $w, $h, $data, $format, $colors=null
        //$this->PieChart(100, 35, $data, '%l (%p)', $coloresRGB);
        $this->PieChart(100, 35, $data, '%l (%p)', array($col1,$col2,$col3));
        $this->SetXY($valX, $valY + 40);
        //**** */
        $this->SetFont('Arial', 'I', 13);
        $this->Cell(0, 5, utf8_decode('Promedio total de dimensión'), 0, 1, 'C');
        $this->Ln(2);
        $this->SetFont('Arial', '', 10);

        $data = array('Institucional' => $promInstCalidad, 'Híbrida' => $PHCalidad, 'Virtual' => $PVCalidad);
        $valX = $this->GetX();
        $valY = $this->GetY();

        $this->SetXY(90, $valY);
        
        $tData = array_sum($data);
        $coloresRGB = $this->ColoresAleatorios($tData);
        $col1=array(250, 192, 144);
        $col2=array(147, 205, 221);
        $col3=array(217, 150, 148);
        //PieChart = $w, $h, $data, $format, $colors=null
        //$this->PieChart(100, 35, $data, '%l (%p)', $coloresRGB);
        $this->PieChart(100, 35, $data, '%l (%p)', array($col1,$col2,$col3));
        $this->SetXY($valX, $valY + 35);
        //**** */
        //
        
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 10, utf8_decode('Gráfico 4. Resultado Institucional, Modalidad, dimensiones de evaluación y desglose de dimensión: Funciones del asesor en línea.'), 0, 'R');
        $this->SetFont('Arial', '', 12);
        }
        //
        $this->AddPage();
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', '', 12);

        $separador = 10;
        $tamanioAltoColumna = 5;
        $subTitulos = [
            "\n \n \n",
            "\nEstudiantes participantes", 
            "\nInstrumentos aplicados", 
            "Diseño del curso en claridad", 
            "Diseño del curso en calidad", 
            "\nVariedad de contenidos", 
            "Utilidad de la plataforma Moodle", 
            "\n\nAutonomía", 
            "Evaluación de contenidos",
            "Diseño gráfico del curso",
            "Promedio total de dimensión"
        ];
        $divisionTitulo = 277 / count($subTitulos);
        $medidas = [($divisionTitulo * 3), ($divisionTitulo * 8)];
        //
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 15);
        $this->AddTableHeaderMan($medidas, ($tamanioAltoColumna + 5), ['', 'Desglose Dimensiones de evaluación'], true, [191, 191, 191]);
        $this->SetFont('Arial', 'B', 12);
        $this->AddTableHeaderMan($medidas, ($tamanioAltoColumna + 3), ['', 'Dimensión: Diseño y calidad del curso'], true, [244, 176, 131]);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 11);
        $this->AddTableSubT($tamanioAltoColumna, $subTitulos, true, [242, 242, 242]);
        $this->Ln($separador);
        $promHib = (($PHDclaridad + $PHDcalidad + $PHDvariedad + $PHDutilidad + $PHDautonomia + $PHDcontenidos + $PHDgrafico)>0)?number_format(($PHDclaridad + $PHDcalidad + $PHDvariedad + $PHDutilidad + $PHDautonomia + $PHDcontenidos + $PHDgrafico) / 7, 1):0;
        $modalidadHibrida = [
            "Modalidad híbrida",
            "\n". $MHE, 
            "\n". $MHInstr, 
            "\n". $PHDclaridad, 
            "\n". $PHDcalidad, 
            "\n". $PHDvariedad, 
            "\n". $PHDutilidad, 
            "\n". $PHDautonomia, 
            "\n". $PHDcontenidos, 
            "\n". $PHDgrafico, 
            "\n". $promHib
        ];
        $this->AddTableBodyPage2($tamanioAltoColumna, $modalidadHibrida, true, [244, 176, 131]);
        $this->Ln($separador);
        $promVirt = (($PVDclaridad + $PVDcalidad + $PVDvariedad + $PVDutilidad + $PVDautonomia + $PVDcontenidos + $PVDgrafico)>0)?number_format(($PVDclaridad + $PVDcalidad + $PVDvariedad + $PVDutilidad + $PVDautonomia + $PVDcontenidos + $PVDgrafico) / 7, 1):0;
        $modalidadVirtual = [
            "Modalidad virtual",
            "\n". $MVE, 
            "\n". $MVInstr, 
            "\n". $PVDclaridad, 
            "\n". $PVDcalidad, 
            "\n". $PVDvariedad, 
            "\n". $PVDutilidad, 
            "\n". $PVDautonomia, 
            "\n". $PVDcontenidos, 
            "\n". $PVDgrafico, 
            "\n". $promVirt
        ];
        $this->AddTableBodyPage2($tamanioAltoColumna, $modalidadVirtual, true, [244, 176, 131]);
        $this->Ln($separador);
        $this->SetFont('Arial', 'B', 11);
        $promInstDclaridad = (($PHDclaridad + $PVDclaridad)>0)?number_format(($PHDclaridad + $PVDclaridad) / 2, 1):0;
        $promInstDcalidad = (($PHDcalidad + $PVDcalidad)>0)?number_format(($PHDcalidad + $PVDcalidad) / 2, 1):0;
        $promInstDvariedad = (($PHDvariedad + $PVDvariedad)>0)?number_format(($PHDvariedad + $PVDvariedad) / 2, 1):0;
        $promInstDutilidad = (($PHDutilidad + $PVDutilidad)>0)?number_format(($PHDutilidad + $PVDutilidad) / 2, 1):0;
        $promInstDautonomia = (($PHDautonomia + $PVDautonomia)>0)?number_format(($PHDautonomia + $PVDautonomia) / 2, 1):0;
        $promInstDcontenidos = (($PHDcontenidos + $PVDcontenidos)>0)?number_format(($PHDcontenidos + $PVDcontenidos) / 2, 1):0;
        $promInstDgrafico = (($PHDgrafico + $PVDgrafico)>0)?number_format(($PHDgrafico + $PVDgrafico) / 2, 1):0;
        $sumaPromInst = ($promInstDclaridad + $promInstDcalidad + $promInstDvariedad + $promInstDutilidad + $promInstDautonomia + $promInstDcontenidos + $promInstDgrafico);
        $promInst = (($sumaPromInst)>0)?number_format(($sumaPromInst) / 7, 1):0;
        $modalidadInstitucional = [
            "Resultado Institucional",
            "\n". $EP, 
            "\n". $IA, 
            "\n". $promInstDclaridad, 
            "\n". $promInstDcalidad, 
            "\n". $promInstDvariedad, 
            "\n". $promInstDutilidad, 
            "\n". $promInstDautonomia, 
            "\n". $promInstDcontenidos, 
            "\n". $promInstDgrafico, 
            "\n". $promInst
        ];
        $this->AddTableBodyPage2($tamanioAltoColumna, $modalidadInstitucional, true, [244, 176, 131]);
        $this->Ln($separador);

        $this->Ln(6);
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('Dimensión: Diseño y calidad del curso'), 1, 1, 'C');
        $this->Ln(5);
        // 
        $this->SetFont('Arial', 'I', 13);
        $this->Cell(0, 5, utf8_decode('Diseño del curso en claridad de contenidos'), 0, 1, 'C');
        $this->Ln(2);
        $this->SetFont('Arial', '', 10);

        if($promInstDclaridad > 0 && $PHDclaridad > 0 && $PVDclaridad > 0 && $promInstDcalidad > 0 && $PHDcalidad > 0 && $PVDcalidad > 0 && $promInstDvariedad > 0 && $PHDvariedad > 0 && $PVDvariedad > 0 && $promInstDutilidad > 0 && $PHDutilidad > 0 && $PVDutilidad > 0 && $promInstDautonomia > 0 && $PHDautonomia > 0 && $PVDautonomia > 0 && $promInstDcontenidos > 0 && $PHDcontenidos > 0 && $PVDcontenidos > 0 && $promInstDgrafico > 0 && $PHDgrafico > 0 && $PVDgrafico > 0){
        $data = array('Institucional' => $promInstDclaridad, 'Híbrida' => $PHDclaridad, 'Virtual' => $PVDclaridad); //1
        $valX = $this->GetX();
        $valY = $this->GetY();

        $this->SetXY(90, $valY);
        
        $tData = array_sum($data);
        $coloresRGB = $this->ColoresAleatorios($tData);
        $col1=array(155, 187, 89);
        $col2=array(79, 129, 189);
        $col3=array(192, 80, 77);
        //PieChart = $w, $h, $data, $format, $colors=null
        //$this->PieChart(100, 35, $data, '%l (%p)', $coloresRGB);
        $this->PieChart(100, 35, $data, '%l (%p)', array($col1,$col2,$col3));
        $this->SetXY($valX, $valY + 80);
        //**** */ 1
        $this->SetFont('Arial', 'I', 13);
        $this->Cell(0, 5, utf8_decode('Diseño del curso en calidad de contenidos'), 0, 1, 'C');
        $this->Ln(2);
        $this->SetFont('Arial', '', 10);

        $data = array('Institucional' => $promInstDcalidad, 'Híbrida' => $PHDcalidad, 'Virtual' => $PVDcalidad); //2
        $valX = $this->GetX();
        $valY = $this->GetY();

        $this->SetXY(90, $valY);
        
        $tData = array_sum($data);
        $coloresRGB = $this->ColoresAleatorios($tData);
        $col1=array(155, 187, 89);
        $col2=array(79, 129, 189);
        $col3=array(192, 80, 77);
        //PieChart = $w, $h, $data, $format, $colors=null
        //$this->PieChart(100, 35, $data, '%l (%p)', $coloresRGB);
        $this->PieChart(100, 35, $data, '%l (%p)', array($col1,$col2,$col3));
        $this->SetXY($valX, $valY + 40);
        //**** */ 2
        $this->SetFont('Arial', 'I', 13);
        $this->Cell(0, 5, utf8_decode('Variedad de contenidos'), 0, 1, 'C');
        $this->Ln(2);
        $this->SetFont('Arial', '', 10);

        $data = array('Institucional' => $promInstDvariedad, 'Híbrida' => $PHDvariedad, 'Virtual' => $PVDvariedad); //3
        $valX = $this->GetX();
        $valY = $this->GetY();

        $this->SetXY(90, $valY);
        
        $tData = array_sum($data);
        $coloresRGB = $this->ColoresAleatorios($tData);
        $col1=array(155, 187, 89);
        $col2=array(79, 129, 189);
        $col3=array(192, 80, 77);
        //PieChart = $w, $h, $data, $format, $colors=null
        //$this->PieChart(100, 35, $data, '%l (%p)', $coloresRGB);
        $this->PieChart(100, 35, $data, '%l (%p)', array($col1,$col2,$col3));
        $this->SetXY($valX, $valY + 40);
        //**** */ 3
        $this->SetFont('Arial', 'I', 13);
        $this->Cell(0, 5, utf8_decode('Utilidad de la plataforma Moodle'), 0, 1, 'C');
        $this->Ln(2);
        $this->SetFont('Arial', '', 10);

        $data = array('Institucional' => $promInstDutilidad, 'Híbrida' => $PHDutilidad, 'Virtual' => $PVDutilidad); //4
        $valX = $this->GetX();
        $valY = $this->GetY();

        $this->SetXY(90, $valY);
        
        $tData = array_sum($data);
        $coloresRGB = $this->ColoresAleatorios($tData);
        $col1=array(155, 187, 89);
        $col2=array(79, 129, 189);
        $col3=array(192, 80, 77);
        //PieChart = $w, $h, $data, $format, $colors=null
        //$this->PieChart(100, 35, $data, '%l (%p)', $coloresRGB);
        $this->PieChart(100, 35, $data, '%l (%p)', array($col1,$col2,$col3));
        $this->SetXY($valX, $valY + 80);
        //**** */ 4
        $this->SetFont('Arial', 'I', 13);
        $this->Cell(0, 5, utf8_decode('Autonomía '), 0, 1, 'C');
        $this->Ln(2);
        $this->SetFont('Arial', '', 10);

        $data = array('Institucional' => $promInstDautonomia, 'Híbrida' => $PHDautonomia, 'Virtual' => $PVDautonomia); //5
        $valX = $this->GetX();
        $valY = $this->GetY();

        $this->SetXY(90, $valY);
        
        $tData = array_sum($data);
        $coloresRGB = $this->ColoresAleatorios($tData);
        $col1=array(155, 187, 89);
        $col2=array(79, 129, 189);
        $col3=array(192, 80, 77);
        //PieChart = $w, $h, $data, $format, $colors=null
        //$this->PieChart(100, 35, $data, '%l (%p)', $coloresRGB);
        $this->PieChart(100, 35, $data, '%l (%p)', array($col1,$col2,$col3));
        $this->SetXY($valX, $valY + 40);
        //**** */ 5
        $this->SetFont('Arial', 'I', 13);
        $this->Cell(0, 5, utf8_decode('Evaluación de contenidos'), 0, 1, 'C');
        $this->Ln(2);
        $this->SetFont('Arial', '', 10);

        $data = array('Institucional' => $promInstDcontenidos, 'Híbrida' => $PHDcontenidos, 'Virtual' => $PVDcontenidos); //6
        $valX = $this->GetX();
        $valY = $this->GetY();

        $this->SetXY(90, $valY);
        
        $tData = array_sum($data);
        $coloresRGB = $this->ColoresAleatorios($tData);
        $col1=array(155, 187, 89);
        $col2=array(79, 129, 189);
        $col3=array(192, 80, 77);
        //PieChart = $w, $h, $data, $format, $colors=null
        //$this->PieChart(100, 35, $data, '%l (%p)', $coloresRGB);
        $this->PieChart(100, 35, $data, '%l (%p)', array($col1,$col2,$col3));
        $this->SetXY($valX, $valY + 40);
        //**** */ 6
        $this->SetFont('Arial', 'I', 13);
        $this->Cell(0, 5, utf8_decode('Diseño gráfico del curso'), 0, 1, 'C');
        $this->Ln(2);
        $this->SetFont('Arial', '', 10);

        $data = array('Institucional' => $promInstDgrafico, 'Híbrida' => $PHDgrafico, 'Virtual' => $PVDgrafico); //7
        $valX = $this->GetX();
        $valY = $this->GetY();

        $this->SetXY(90, $valY);
        
        $tData = array_sum($data);
        $coloresRGB = $this->ColoresAleatorios($tData);
        $col1=array(155, 187, 89);
        $col2=array(79, 129, 189);
        $col3=array(192, 80, 77);
        //PieChart = $w, $h, $data, $format, $colors=null
        //$this->PieChart(100, 35, $data, '%l (%p)', $coloresRGB);
        $this->PieChart(100, 35, $data, '%l (%p)', array($col1,$col2,$col3));
        $this->SetXY($valX, $valY + 80);
        //**** */ 7
        $this->SetFont('Arial', 'I', 13);
        $this->Cell(0, 5, utf8_decode('Promedio total de dimensión'), 0, 1, 'C');
        $this->Ln(2);
        $this->SetFont('Arial', '', 10);

        $data = array('Institucional' => $promInstDgrafico, 'Híbrida' => $PHDgrafico, 'Virtual' => $PVDgrafico); //8
        $valX = $this->GetX();
        $valY = $this->GetY();

        $this->SetXY(90, $valY);
        
        $tData = array_sum($data);
        $coloresRGB = $this->ColoresAleatorios($tData);
        $col1=array(250, 192, 144);
        $col2=array(147, 205, 221);
        $col3=array(217, 150, 148);
        //PieChart = $w, $h, $data, $format, $colors=null
        //$this->PieChart(100, 35, $data, '%l (%p)', $coloresRGB);
        $this->PieChart(100, 35, $data, '%l (%p)', array($col1,$col2,$col3));
        $this->SetXY($valX, $valY + 40);
        //**** */ 8
        //
        $this->MultiCell(0, 10, utf8_decode('Gráfico 5. Resultado Institucional. Modalidad , dimensiones de evaluación y desglose de dimensión: Diseño y calidad del curso.'), 0, 'R');
        }
    }

    function Page3Content($arrMH){
        $this->pageNumbers[] = $this->PageNo();
        //
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 10, utf8_decode('III. Desglose de resultados. Dimensiones de evaluación, unidad académica, programa educativo y asignatura: Modalidad Híbrida.'), 0, 'L');
        //
        $separador = 10;
        $tamanioAltoColumna = 5;
        $subTitulos = [
            "\n\nUnidad Académica",                         //1
            "\n\nPrograma Educativo",    //2
            "\nUnidad de aprendizaje curricular",  //3
            "\nEstudiante*",               //4
            "\nNumero de grupos",            //5
            "\nAsesores evaluados",        //6
            "\n1)Funcion del asesor",      //7
            "2)Diseño y calidad del curso",         //8
            "Promedio total de evaluación"                //11
        ];
        $divisionTitulo = 277 / count($subTitulos);
        $medidas = [($divisionTitulo), ($divisionTitulo * 7), ($divisionTitulo * 3)];
        //
        //
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 10);
        $this->AddTableSubTC($tamanioAltoColumna, $subTitulos, true, [252, 228, 214]);
        $this->Ln($separador);
        //
        $this->SetFont('Arial', '', 8);
        $this->AddTableBodyTC($tamanioAltoColumna, $arrMH, true, [252, 228, 214]);
        //
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 6, utf8_decode('*Total de estudiantes participantes son contabilizados.'), 0, 'L');
        //
    }

    function Page4Content($arrMV){
        $this->pageNumbers[] = $this->PageNo();
        //
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 10, utf8_decode('IV. Desglose de resultados. Dimensiones de evaluación, unidad académica, programa educativo y asignatura: Modalidad Virtual.'), 0, 'L');
        //
        $separador = 10;
        $tamanioAltoColumna = 5;
        $subTitulos = [
            "\n\nUnidad Académica",                         //1
            "\n\nPrograma Educativo",    //2
            "\nUnidad de aprendizaje curricular",  //3
            "\nEstudiante*",               //4
            "\nNumero de grupos",            //5
            "\nAsesores evaluados",        //6
            "\n1)Funcion del asesor",      //7
            "2)Diseño y calidad del curso",         //8
            "Promedio total de evaluación"                //11
        ];
        $divisionTitulo = 277 / count($subTitulos);
        $medidas = [($divisionTitulo), ($divisionTitulo * 7), ($divisionTitulo * 3)];
        //
        //
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 10);
        $this->AddTableSubTC($tamanioAltoColumna, $subTitulos, true, [252, 228, 214]);
        $this->Ln($separador);
        //
        $this->SetFont('Arial', '', 8);
        $this->AddTableBodyTC($tamanioAltoColumna, $arrMV, true, [252, 228, 214]);
        //
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 6, utf8_decode('*Total de estudiantes participantes son contabilizados.'), 0, 'L');
        //
    }

    function AddTable($anchoColumnas, $titulosTablas, $data, $total, $numGrupos, $useFillColor = true, $fillColor = [255, 255, 255]) {
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

    function AddTableHeader($tam, $tamY, $titulosTablas, $useFillColor = true, $fillColor = [255, 255, 255]){
        if ($useFillColor) {
            $this->SetFillColor(...$fillColor);
        }
        //$this->Cell(93, 10, utf8_decode('o'), 1, 0, 'C', true);
        $tamanio = 277 - $tam;
        $numColumnas = $tamanio / (count($titulosTablas)-1);
        $tamColumna = $tamanio - $numColumnas;
        
        foreach ($titulosTablas as $j => $titulo) {
            // Mostrar el título de la tabla
            //MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]])
            $this->Cell(($j == 0)? $tam : $numColumnas, $tamY, utf8_decode($titulo), 1, 0, 'C', ($j == 0)? false : true);
        }
        $this->Ln();
    }

    function AddTableHeaderMan($tam, $tamY, $titulosTablas, $useFillColor = true, $fillColor = [255, 255, 255]){
        if ($useFillColor) {
            $this->SetFillColor(...$fillColor);
        }
        
        foreach ($titulosTablas as $j => $titulo) {
            // Mostrar el título de la tabla
            //MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]])
            $this->Cell($tam[$j], $tamY, utf8_decode($titulo), ($j == 0)? false : true, 0, 'C', ($j == 0)? false : true);
        }
        $this->Ln();
    }

    function AddTableSubT($tamY, $titulosTablas, $useFillColor = true, $fillColor = [255, 255, 255]){
        if ($useFillColor) {
            $this->SetFillColor(...$fillColor);
        }
        $tamColumna = 277 / count($titulosTablas);
        foreach ($titulosTablas as $j => $titulo) {
            // Guardar la posición actual
            $x = $this->GetX();
            $y = $this->GetY();

            // Mostrar el título de la tabla
            //MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]])
            $this->MultiCell($tamColumna, $tamY, utf8_decode($titulo), ($j == 0)? false : true, 'C', ($j == 0)? false : true);

            // Volver a la posición original y ajustar X para la próxima columna
            $this->SetXY($x + $tamColumna, $y);
        }
        $this->Ln();
    }

    function AddTableBodyPage($tamY, $titulosTablas, $useFillColor = true, $fillColor = [255, 255, 255]){
        if ($useFillColor) {
            $this->SetFillColor(...$fillColor);
        }
        $color = count($titulosTablas) -1;
        $tamColumna = 277 / count($titulosTablas);
        foreach ($titulosTablas as $j => $titulo) {
            // Guardar la posición actual
            $x = $this->GetX();
            $y = $this->GetY();
            if ($j == $color) {
                $this->SetFillColor(255, 192, 0);
            }
            // Mostrar el título de la tabla
            //MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]])
            $this->MultiCell($tamColumna, $tamY, utf8_decode($titulo), 1, 'C', ($j == 0 || $j == $color)? true : false);

            // Volver a la posición original y ajustar X para la próxima columna
            $this->SetXY($x + $tamColumna, $y);
        }
    }

    function AddTableBodyPage2($tamY, $titulosTablas, $useFillColor = true, $fillColor = [255, 255, 255]){
        if ($useFillColor) {
            $this->SetFillColor(...$fillColor);
        }
        $color = count($titulosTablas) -1;
        $tamColumna = 277 / count($titulosTablas);
        foreach ($titulosTablas as $j => $titulo) {
            // Guardar la posición actual
            $x = $this->GetX();
            $y = $this->GetY();
            // Mostrar el título de la tabla
            //MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]])
            $this->MultiCell($tamColumna, $tamY, utf8_decode($titulo), 1, 'C', ($j == 0)? true : false);

            // Volver a la posición original y ajustar X para la próxima columna
            $this->SetXY($x + $tamColumna, $y);
        }
    }

    function AddTableSubTC($tamY, $titulosTablas, $useFillColor = true, $fillColor = [255, 255, 255]){
        if ($useFillColor) {
            $this->SetFillColor(...$fillColor);
        }
        $tamColumna = 277 / count($titulosTablas);
        foreach ($titulosTablas as $j => $titulo) {
            // Guardar la posición actual
            $x = $this->GetX();
            $y = $this->GetY();
            
            switch ($j){
                case 0:
                    $ext = 20.4;
                    $this->MultiCell($tamColumna + $ext, $tamY, utf8_decode($titulo), true, 'C', true);
                    $this->SetXY($x + $tamColumna + $ext, $y);
                    break;
                case 1:
                    $ext = 20.4;
                    $this->MultiCell($tamColumna + $ext, $tamY, utf8_decode($titulo), true, 'C', true);
                    $this->SetXY($x + $tamColumna + $ext, $y);
                    break;
                case 2:
                    $ext = 20.4;
                    $this->MultiCell($tamColumna + $ext, $tamY, utf8_decode($titulo), true, 'C', true);
                    $this->SetXY($x + $tamColumna + $ext, $y);
                    break;
                default:
                    $ext = 10.2;
                    $this->MultiCell($tamColumna - $ext, $tamY, utf8_decode($titulo), true, 'C', true);
                    $this->SetXY($x + $tamColumna - $ext, $y);
                    break;
            }
        }
        $this->Ln();
    }

    function AddTableBodyTC($tamY, $datosEsc, $useFillColor = true, $fillColor = [255, 255, 255]){
        if ($useFillColor) {
            $this->SetFillColor(...$fillColor);
        }
    
        foreach ($datosEsc as $fila) {
            $tamColumna = 277 / count($fila); // Asume que cada fila tiene la misma cantidad de columnas
            foreach ($fila as $j => $titulo) {
                // Guardar la posición actual
                $x = $this->GetX();
                $y = $this->GetY();
                
                switch ($j) {
                    case 0:
                        $ext = 20.4;
                        // Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])
                        $this->Cell($tamColumna + $ext, $tamY, utf8_decode($titulo), 1, 0, 'L', ($j % 2 == 0)? true : false);
                        //$this->SetXY($x + $tamColumna + $ext, $y);
                        break;
                    case 1:
                        $ext = 20.4;
                        $this->Cell($tamColumna + $ext, $tamY, utf8_decode($titulo), 1, 0, 'L', ($j % 2 == 0)? true : false);
                        //$this->SetXY($x + $tamColumna + $ext, $y);
                        break;
                    case 2:
                        $ext = 20.4;
                        $this->Cell($tamColumna + $ext, $tamY, utf8_decode($titulo), 1, 0, 'L', ($j % 2 == 0)? true : false);
                        //$this->SetXY($x + $tamColumna + $ext, $y);
                        break;
                    default:
                        $ext = 10.2;
                        $this->Cell($tamColumna - $ext, $tamY, utf8_decode($titulo), 1, 0, 'C', ($j % 2 == 0)? true : false);
                        //$this->SetXY($x + $tamColumna - $ext, $y);
                        break;
                }
            }
            $this->Ln(); // Agrega una nueva línea después de cada fila
        }
    }

    function Sector($xc, $yc, $r, $a, $b, $style='FD', $cw=true, $o=90){
        $d0 = $a - $b;
        if($cw){
            $d = $b;
            $b = $o - $a;
            $a = $o - $d;
        }else{
            $b += $o;
            $a += $o;
        }
        while($a<0)
            $a += 360;
        while($a>360)
            $a -= 360;
        while($b<0)
            $b += 360;
        while($b>360)
            $b -= 360;
        if ($a > $b)
            $b += 360;
        $b = $b/360*2*M_PI;
        $a = $a/360*2*M_PI;
        $d = $b - $a;
        if ($d == 0 && $d0 != 0)
            $d = 2*M_PI;
        $k = $this->k;
        $hp = $this->h;
        if (sin($d/2))
            $MyArc = 4/3*(1-cos($d/2))/sin($d/2)*$r;
        else
            $MyArc = 0;
        //first put the center
        $this->_out(sprintf('%.2F %.2F m',($xc)*$k,($hp-$yc)*$k));
        //put the first point
        $this->_out(sprintf('%.2F %.2F l',($xc+$r*cos($a))*$k,(($hp-($yc-$r*sin($a)))*$k)));
        //draw the arc
        if ($d < M_PI/2){
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                        $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                        $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                        $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                        $xc+$r*cos($b),
                        $yc-$r*sin($b)
                        );
        }else{
            $b = $a + $d/4;
            $MyArc = 4/3*(1-cos($d/8))/sin($d/8)*$r;
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                        $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                        $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                        $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                        $xc+$r*cos($b),
                        $yc-$r*sin($b)
                        );
            $a = $b;
            $b = $a + $d/4;
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                        $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                        $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                        $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                        $xc+$r*cos($b),
                        $yc-$r*sin($b)
                        );
            $a = $b;
            $b = $a + $d/4;
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                        $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                        $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                        $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                        $xc+$r*cos($b),
                        $yc-$r*sin($b)
                        );
            $a = $b;
            $b = $a + $d/4;
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a),
                        $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a),
                        $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2),
                        $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2),
                        $xc+$r*cos($b),
                        $yc-$r*sin($b)
                        );
        }
        //terminate drawing
        if($style=='F')
            $op='f';
        elseif($style=='FD' || $style=='DF')
            $op='b';
        else
            $op='s';
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3 ){
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c',
            $x1*$this->k,
            ($h-$y1)*$this->k,
            $x2*$this->k,
            ($h-$y2)*$this->k,
            $x3*$this->k,
            ($h-$y3)*$this->k));
    }
    //
    var $legends;
    var $wLegend;
    var $sum;
    var $NbVal;

    function PieChart($w, $h, $data, $format, $colors=null){
        $this->SetFont('Courier', '', 10);
        $this->SetLegends($data,$format);

        $XPage = $this->GetX();
        $YPage = $this->GetY();
        $margin = 2;
        $hLegend = 5;
        $radius = min($w - $margin * 4 - $hLegend - $this->wLegend, $h - $margin * 2);
        $radius = floor($radius / 2);
        $XDiag = $XPage + $margin + $radius;
        $YDiag = $YPage + $margin + $radius;
        if($colors == null) {
            for($i = 0; $i < $this->NbVal; $i++) {
                $gray = $i * intval(255 / $this->NbVal);
                $colors[$i] = array($gray,$gray,$gray);
            }
        }

        //Sectors
        $this->SetLineWidth(0.2);
        $angleStart = 0;
        $angleEnd = 0;
        $i = 0;
        foreach($data as $val) {
            $angle = ($val * 360) / doubleval($this->sum);
            if ($angle != 0) {
                $angleEnd = $angleStart + $angle;
                $this->SetFillColor($colors[$i][0],$colors[$i][1],$colors[$i][2]);
                $this->Sector($XDiag, $YDiag, $radius, $angleStart, $angleEnd);
                $angleStart += $angle;
            }
            $i++;
        }

        //Legends
        $this->SetFont('Arial', 'B', 10);
        $x1 = $XPage + 2 * $radius + 4 * $margin;
        $x2 = $x1 + $hLegend + $margin;
        $y1 = $YDiag - $radius + (2 * $radius - $this->NbVal*($hLegend + $margin)) / 2;
        for($i=0; $i<$this->NbVal; $i++) {
            $this->SetFillColor($colors[$i][0],$colors[$i][1],$colors[$i][2]);
            $this->Rect($x1, $y1, $hLegend, $hLegend, 'DF');
            $this->SetXY($x2,$y1);
            $this->Cell(0,$hLegend,utf8_decode($this->legends[$i]));
            $y1+=$hLegend + $margin;
        }
    }

    function BarDiagram($w, $h, $data, $format, $color=null, $maxVal=0, $nbDiv=4){
        $this->SetFont('Courier', '', 10);
        $this->SetLegends($data,$format);

        $XPage = $this->GetX();
        $YPage = $this->GetY();
        $margin = 2;
        $YDiag = $YPage + $margin;
        $hDiag = floor($h - $margin * 2);
        $XDiag = $XPage + $margin * 2 + $this->wLegend;
        $lDiag = floor($w - $margin * 3 - $this->wLegend);
        if($color == null)
            $color=array(155,155,155);
        if ($maxVal == 0) {
            $maxVal = max($data);
        }
        $valIndRepere = ceil($maxVal / $nbDiv);
        $maxVal = $valIndRepere * $nbDiv;
        $lRepere = floor($lDiag / $nbDiv);
        $lDiag = $lRepere * $nbDiv;
        $unit = $lDiag / $maxVal;
        $hBar = floor($hDiag / ($this->NbVal + 1));
        $hDiag = $hBar * ($this->NbVal + 1);
        $eBaton = floor($hBar * 80 / 100);

        $this->SetLineWidth(0.2);
        $this->Rect($XDiag, $YDiag, $lDiag, $hDiag);

        $this->SetFont('Arial', '', 10);
        $this->SetFillColor($color[0],$color[1],$color[2]);
        $i=0;
        foreach($data as $val) {
            //Bar
            $xval = $XDiag;
            $lval = (int)($val * $unit);
            $yval = $YDiag + ($i + 1) * $hBar - $eBaton / 2;
            $hval = $eBaton;
            $this->Rect($xval, $yval, $lval, $hval, 'DF');
            //Legend
            $this->SetXY(0, $yval);
            $this->Cell($xval - $margin, $hval, utf8_decode($this->legends[$i]),0,0,'R');
            $i++;
        }

        //Scales
        for ($i = 0; $i <= $nbDiv; $i++) {
            $xpos = $XDiag + $lRepere * $i;
            $this->Line($xpos, $YDiag, $xpos, $YDiag + $hDiag);
            $val = $i * $valIndRepere;
            $xpos = $XDiag + $lRepere * $i - $this->GetStringWidth($val) / 2;
            $ypos = $YDiag + $hDiag - $margin;
            $this->Text($xpos, $ypos, $val);
        }
    }

    function SetLegends($data, $format){
        $this->legends=array();
        $this->wLegend=0;
        $this->sum=array_sum($data);
        $this->NbVal=count($data);
        foreach($data as $l=>$val)
        {
            $p=sprintf('%.2f',$val/$this->sum*100).'%';
            $legend=str_replace(array('%l','%v','%p'),array($l,$val,$p),$format);
            $this->legends[]=$legend;
            $this->wLegend=max($this->GetStringWidth($legend),$this->wLegend);
        }
    }

    function ColoresAleatorios($tData) {
        $addColores = [];
        for ($i = 0; $i < $tData; $i++) {
            $valor1 = rand(150, 240);
            $valor2 = rand(150, 240);
            $valor3 = rand(150, 240);
            $addColores[] = array($valor1, $valor2, $valor3);
        }
    
        // Retornar los valores como un array
        return $addColores;
    }
    
    function PaginaPueba(){
        $this->Cell(0, 10, utf8_decode('Página de prueba'), 0, 1);
        $paginasObtenidas = [];
        foreach ($this->pageNumbers as $pageNumber) {
            $this->Cell(0, 5, 'paginas obtenidas directo: ' . $pageNumber, 0, 1);
            $paginasObtenidas[] = $pageNumber;
        }
        $this->Cell(0, 10, utf8_decode('Paginas del arreglo'), 0, 1);
        foreach ($paginasObtenidas as $pagina) {
            $this->Cell(0, 5, 'pagina: ' . $pagina, 0, 1);
        }
    }

    function IndiceData($pages){
        $xIni = 250;
        $xSeg = 20;
        // Contenido de la página 2 (operación)
        $this->SetFillColor(220, 228, 241);
        $this->SetTextColor(23, 55, 94);
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(($xIni + $xSeg), 10, utf8_decode('Contenido'), 1, 1, 'C');
        $this->SetFont('Arial', '', 15);
        $this->Cell(($xIni + $xSeg), 10, utf8_decode('Reporte de Evaluación Del Desempeño Docente, asignaturas híbridas y/o virtuales'), 1, 1, 'C', true);
        
        $anchoColumnas = [];
        $anchoColumnas[] = $xIni; // texto
        $anchoColumnas[] = $xSeg; // numero
        $num = 2;
        $this->SetFont('Arial', 'B', 12);
        $this->AddIndice($anchoColumnas, ["I. Resultado Institucional. Modalidad y dimensiones de evaluación."], $this->pageNumbers[0], true); 
        $this->AddIndice($anchoColumnas, ["II. Resultado Institucional. Modalidad, dimensiones de evaluación y de dimensión."], $this->pageNumbers[1], true, [220, 228, 241]); 
        $this->AddIndice($anchoColumnas, ["III. Desglose de resultados: dimensiones de evaluación, unidad académica, programa educativo y asignatura - Híbrida"], $this->pageNumbers[2], true); 
        $this->AddIndice($anchoColumnas, ["IV. Desglose de resultados: dimensiones de evaluación, unidad académica, programa educativo y asignatura - Virtual"], $this->pageNumbers[3], true, [220, 228, 241]); 
        //
    }
}
//
function obtenerParametroGET($nombre, $default = 'No definido') {
    return isset($_GET[$nombre]) ? htmlspecialchars($_GET[$nombre]) : $default;
}
// Obtener parámetros GET
$periodo = obtenerParametroGET('periodo', 'Sin definir "periodo"');
$anio = obtenerParametroGET('anio', 'Sin definir "anio"');
//
$error = '';
$tipoError = 'error';

try {
    $conexion = new CConexion();
    $conn = $conexion->conexionBD();
    // CONSULTA UNIDADES ACADEMICAS
    $MHU = 0;
    $MVU = 0;
    $consulta = $conn->prepare("WITH ranked_units AS (
    SELECT
        acta_id,
        unidad,
        ROW_NUMBER() OVER (PARTITION BY unidad ORDER BY acta_id DESC) AS rn
    FROM
        virtuales
    )
    SELECT
        acta_id,
        unidad
    FROM
        ranked_units
    WHERE
        rn = 1
    ORDER BY
        acta_id DESC;");
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    
    $arr_acta = [];
    $arr_unidad = [];
    
    foreach ($resultado as $value) {
        $arr_acta[] = $value['acta_id'] ?? '';
        $arr_unidad[] = $value['unidad'] ?? '';
    }
    
    foreach ($arr_acta as $value) {
        $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
        $consulta->bindParam(':acta_id', $value, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    
        if ($resultado) {
            if ($resultado['modalidad'] == 'H') {
                $MHU++;
            } else if ($resultado['modalidad'] == 'V') {
                $MVU++;
            }
        }
    }
    // CONSULTA MODALIDAD
    $consulta = $conn->prepare("SELECT DISTINCT acta_id, unidad FROM virtuales ORDER BY acta_id DESC;");
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    $arr_acta = [];
    $arr_unidad = [];
    foreach ($resultado as $value) {
        $arr_acta[] = $value['acta_id'] ?? '';
        $arr_unidad[] = $value['unidad'] ?? '';
    }
    $MH = 0;
    $MV = 0;
    foreach ($arr_acta as $value) {
        $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
        $consulta->bindParam(':acta_id', $value, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            if ($resultado['modalidad'] == 'H') {
                $MH++;
            } else if ($resultado['modalidad'] == 'V') {
                $MV++;
            }
        }
    }
    // CONSULTA GRUPOS
    $consulta = $conn->prepare("WITH ranked_units AS (
    SELECT
        acta_id,
        grupo,
        ROW_NUMBER() OVER (PARTITION BY grupo ORDER BY acta_id DESC) AS rn
    FROM
        virtuales
    )
    SELECT
        acta_id,
        grupo
    FROM
        ranked_units
    WHERE
        rn = 1
    ORDER BY
        acta_id DESC;");
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    $arr_acta = [];
    $arr_grupo = [];
    foreach ($resultado as $value) {
        $arr_acta[] = $value['acta_id'] ?? '';
        $arr_grupo[] = $value['grupo'] ?? '';
    }
    $MHG = 0;
    $MVG = 0;
    foreach ($arr_acta as $value) {
        $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
        $consulta->bindParam(':acta_id', $value, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            if ($resultado['modalidad'] == 'H') {
                $MHG++;
            } else if ($resultado['modalidad'] == 'V') {
                $MVG++;
            }
        }
    }
    // CONSULTA ASESORES
    $MHA = 0;
    $MVA = 0;
    $consulta = $conn->prepare("WITH ranked_units AS (
    SELECT
        acta_id,
        numcontrol,
        ROW_NUMBER() OVER (PARTITION BY numcontrol ORDER BY acta_id DESC) AS rn
    FROM
        virtuales
    )
    SELECT
        acta_id,
        numcontrol
    FROM
        ranked_units
    WHERE
        rn = 1
    ORDER BY
        acta_id DESC;");
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    
    $arr_acta = [];
    $arr_unidad = [];
    
    foreach ($resultado as $value) {
        $arr_acta[] = $value['acta_id'] ?? '';
        $arr_unidad[] = $value['unidad'] ?? '';
    }
    
    foreach ($arr_acta as $value) {
        $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
        $consulta->bindParam(':acta_id', $value, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    
        if ($resultado) {
            if ($resultado['modalidad'] == 'H') {
                $MHA++;
            } else if ($resultado['modalidad'] == 'V') {
                $MVA++;
            }
        }
    }
    // CONSULTA ESTUDIANTES
    $MHE = 0;
    $MVE = 0;
    $consulta = $conn->prepare("WITH ranked_units AS (
    SELECT
        acta_id,
        matricula,
        ROW_NUMBER() OVER (PARTITION BY matricula ORDER BY acta_id DESC) AS rn
    FROM
        virtuales
    )
    SELECT
        acta_id,
        matricula
    FROM
        ranked_units
    WHERE
        rn = 1
    ORDER BY
        acta_id DESC;");
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    
    $arr_acta = [];
    $arr_unidad = [];
    
    foreach ($resultado as $value) {
        $arr_acta[] = $value['acta_id'] ?? '';
        $arr_unidad[] = $value['unidad'] ?? '';
    }
    
    foreach ($arr_acta as $value) {
        $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
        $consulta->bindParam(':acta_id', $value, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    
        if ($resultado) {
            if ($resultado['modalidad'] == 'H') {
                $MHE++;
            } else if ($resultado['modalidad'] == 'V') {
                $MVE++;
            }
        }
    }
    // CONSULTA INSTRUMENTOS
    $MHInstr = 0;
    $MVInstr = 0;
    $consulta = $conn->prepare("SELECT DISTINCT acta_id FROM virtuales;");
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    
    $arr_acta = [];
    
    foreach ($resultado as $value) {
        $arr_acta[] = $value['acta_id'] ?? '';
    }
    
    foreach ($arr_acta as $value) {
        $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
        $consulta->bindParam(':acta_id', $value, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    
        if ($resultado) {
            if ($resultado['modalidad'] == 'H') {
                $MHInstr++;
            } else if ($resultado['modalidad'] == 'V') {
                $MVInstr++;
            }
        }
    }
    // CONSULTA PROMEDIOS ASESOR EN LINEA
    $MHAsesor = 0;
    $MVAsesor = 0;
    $contH = 0;
    $contV = 0;
    $consulta = $conn->prepare("
    WITH calificaciones AS (
        SELECT
            acta_id,
            (r7 + r8 + r10 + r2 + r4 + r9 + r3 + r5 + r6) AS calificacion
        FROM
            preguntav
    )
    SELECT
        acta_id,
        AVG(calificacion) AS promedio_calificacion
    FROM
        calificaciones
    GROUP BY
        acta_id
    ");
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $arr_acta = [];
    $arr_promedio = [];

    foreach ($resultado as $value) {
        $arr_acta[] = $value['acta_id'];
        $arr_promedio[$value['acta_id']] = $value['promedio_calificacion']; 
    }

    foreach ($arr_acta as $acta_id) {
        $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
        $consulta->bindParam(':acta_id', $acta_id, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $promedio_calificacion = $arr_promedio[$acta_id] ?? 0; 

            if ($resultado['modalidad'] == 'H') {
                $MHAsesor += $promedio_calificacion;
                $contH++;
            } else if ($resultado['modalidad'] == 'V') {
                $MVAsesor += $promedio_calificacion;
                $contV++;
            }
        }
    }

    $PHAsesor = number_format($contH > 0 ? $MHAsesor / $contH : 0, 1);
    $PVAsesor = number_format($contV > 0 ? $MVAsesor / $contV : 0, 1);
    // CONSULTA PROMEDIOS DISENIO Y CALIDAD
    $MHDisenio = 0;
    $MVDisenio  = 0;
    $contH = 0;
    $contV = 0;
    $consulta = $conn->prepare("WITH calificaciones AS (
    SELECT
        acta_id,
        (
            SELECT AVG(value::numeric)
            FROM unnest(string_to_array(r21, ',')) AS value
            WHERE value ~ '^\d+(\.\d+)?$'
        ) AS promedio_r21,
        r12 + r18 + r15 + r13 + r17 + r16 + r20 + r14 AS suma_atributos_sin_promedio
    FROM
        preguntav
    ),
    calificaciones_con_promedio AS (
        SELECT
            acta_id,
            promedio_r21,
            suma_atributos_sin_promedio + promedio_r21 AS suma_atributos
        FROM
            calificaciones
    )
    SELECT
        acta_id,
        AVG(suma_atributos) AS promedio_calificacion
    FROM
        calificaciones_con_promedio
    GROUP BY
        acta_id;");
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $arr_acta = [];
    $arr_promedio = [];

    foreach ($resultado as $value) {
        $arr_acta[] = $value['acta_id'];
        $arr_promedio[$value['acta_id']] = $value['promedio_calificacion']; 
    }

    foreach ($arr_acta as $acta_id) {
        $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
        $consulta->bindParam(':acta_id', $acta_id, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $promedio_calificacion = $arr_promedio[$acta_id] ?? 0; 

            if ($resultado['modalidad'] == 'H') {
                $MHDisenio += $promedio_calificacion;
                $contH++;
            } else if ($resultado['modalidad'] == 'V') {
                $MVDisenio += $promedio_calificacion;
                $contV++;
            }
        }
    }

    $PHDisenio = number_format($contH > 0 ? $MHDisenio / $contH : 0, 1);
    $PVDisenio = number_format($contV > 0 ? $MVDisenio / $contV : 0, 1);
    // CONSULTA Oportunidad en la retroalimentación y respuesta
    $MHOporunidad = 0;
    $MVOporunidad  = 0;
    $contH = 0;
    $contV = 0;
    $consulta = $conn->prepare("WITH promedios AS (
    SELECT
        acta_id,
        (COALESCE(r2, 0) + COALESCE(r4, 0) + COALESCE(r9, 0)) * (100/30) AS calificacion
    FROM
        preguntav
    )
    SELECT
        acta_id,
        AVG(calificacion) AS promedio_oportunidad
    FROM
        promedios
    GROUP BY
    acta_id;");
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $arr_acta = [];
    $arr_promedio = [];

    foreach ($resultado as $value) {
        $arr_acta[] = $value['acta_id'];
        $arr_promedio[$value['acta_id']] = $value['promedio_oportunidad']; 
    }

    foreach ($arr_acta as $acta_id) {
        $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
        $consulta->bindParam(':acta_id', $acta_id, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $promedio_calificacion = $arr_promedio[$acta_id] ?? 0; 

            if ($resultado['modalidad'] == 'H') {
                $MHOporunidad += $promedio_calificacion;
                $contH++;
            } else if ($resultado['modalidad'] == 'V') {
                $MVOporunidad += $promedio_calificacion;
                $contV++;
            }
        }
    }

    $PHOportunidad = number_format($contH > 0 ? $MHOporunidad / $contH : 0, 1);
    $PVOportunidad = number_format($contV > 0 ? $MVOporunidad / $contV : 0, 1);
    // CONSULTAR Calidad de retroalimentación y respuesta
    $MHCalidad = 0;
    $MVCalidad  = 0;
    $contH = 0;
    $contV = 0;
    $consulta = $conn->prepare("WITH promedios AS (
    SELECT
        acta_id,
        (COALESCE(r3, 0) + COALESCE(r5, 0) + COALESCE(r6, 0)) * (100.0 / 30) AS suma_datos
    FROM
        preguntav
    )
    SELECT
        acta_id,
        AVG(suma_datos) AS promedio_calidad
    FROM
        promedios
    GROUP BY
    acta_id;");
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $arr_acta = [];
    $arr_promedio = [];

    foreach ($resultado as $value) {
        $arr_acta[] = $value['acta_id'];
        $arr_promedio[$value['acta_id']] = $value['promedio_calidad']; 
    }

    foreach ($arr_acta as $acta_id) {
        $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
        $consulta->bindParam(':acta_id', $acta_id, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $promedio_calificacion = $arr_promedio[$acta_id] ?? 0; 

            if ($resultado['modalidad'] == 'H') {
                $MHCalidad += $promedio_calificacion;
                $contH++;
            } else if ($resultado['modalidad'] == 'V') {
                $MVCalidad += $promedio_calificacion;
                $contV++;
            }
        }
    }

    $PHCalidad = number_format($contH > 0 ? $MHCalidad / $contH : 0, 1);
    $PVCalidad = number_format($contV > 0 ? $MVCalidad / $contV : 0, 1);
    // CONSULTAR Dominio y desempeño del Asesor en línea
    $MHDominio = 0;
    $MVDominio  = 0;
    $contH = 0;
    $contV = 0;
    $consulta = $conn->prepare("WITH promedios AS (
    SELECT
        acta_id,
        (COALESCE(r7, 0) + COALESCE(r8, 0) + COALESCE(r10, 0)) * (100.0 / 30) AS suma_datos
    FROM
        preguntav
    )
    SELECT
        acta_id,
        AVG(suma_datos) AS promedio_dominio
    FROM
        promedios
    GROUP BY
    acta_id;");
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $arr_acta = [];
    $arr_promedio = [];

    foreach ($resultado as $value) {
        $arr_acta[] = $value['acta_id'];
        $arr_promedio[$value['acta_id']] = $value['promedio_dominio']; 
    }

    foreach ($arr_acta as $acta_id) {
        $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
        $consulta->bindParam(':acta_id', $acta_id, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $promedio_calificacion = $arr_promedio[$acta_id] ?? 0; 

            if ($resultado['modalidad'] == 'H') {
                $MHDominio += $promedio_calificacion;
                $contH++;
            } else if ($resultado['modalidad'] == 'V') {
                $MVDominio += $promedio_calificacion;
                $contV++;
            }
        }
    }

    $PHDominio = number_format($contH > 0 ? $MHDominio / $contH : 0, 1);
    $PVDominio = number_format($contV > 0 ? $MVDominio / $contV : 0, 1);
    // CONSULTAR Diseño del curso en claridad de contenidos
    $MHDclaridad = 0;
    $MVDclaridad  = 0;
    $contH = 0;
    $contV = 0;
    $consulta = $conn->prepare("WITH promedios AS (
    SELECT
        acta_id,
        (COALESCE(r12, 0) + COALESCE(r18, 0) + COALESCE(r15, 0)) * (100.0 / 30) AS suma_datos
    FROM
        preguntav
    )
    SELECT
        acta_id,
        AVG(suma_datos) AS promedio_claridad
    FROM
        promedios
    GROUP BY
    acta_id;");
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $arr_acta = [];
    $arr_promedio = [];

    foreach ($resultado as $value) {
        $arr_acta[] = $value['acta_id'];
        $arr_promedio[$value['acta_id']] = $value['promedio_claridad']; 
    }

    foreach ($arr_acta as $acta_id) {
        $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
        $consulta->bindParam(':acta_id', $acta_id, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $promedio_calificacion = $arr_promedio[$acta_id] ?? 0; 

            if ($resultado['modalidad'] == 'H') {
                $MHDclaridad += $promedio_calificacion;
                $contH++;
            } else if ($resultado['modalidad'] == 'V') {
                $MVDclaridad += $promedio_calificacion;
                $contV++;
            }
        }
    }

    $PHDclaridad = number_format($contH > 0 ? $MHDclaridad / $contH : 0, 1);
    $PVDclaridad = number_format($contV > 0 ? $MVDclaridad / $contV : 0, 1);
    // CONSULTAR Diseño del curso en calidad de contenidos
    $MHDcalidad = 0;
    $MVDcalidad  = 0;
    $contH = 0;
    $contV = 0;
    $consulta = $conn->prepare("WITH promedios AS (
    SELECT
        acta_id,
        (COALESCE(r12, 0) * 10) AS suma_datos
    FROM
        preguntav
    )
    SELECT
        acta_id,
        AVG(suma_datos) AS promedio_claridad
    FROM
        promedios
    GROUP BY
    acta_id;");
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $arr_acta = [];
    $arr_promedio = [];

    foreach ($resultado as $value) {
        $arr_acta[] = $value['acta_id'];
        $arr_promedio[$value['acta_id']] = $value['promedio_claridad']; 
    }

    foreach ($arr_acta as $acta_id) {
        $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
        $consulta->bindParam(':acta_id', $acta_id, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $promedio_calificacion = $arr_promedio[$acta_id] ?? 0; 

            if ($resultado['modalidad'] == 'H') {
                $MHDcalidad += $promedio_calificacion;
                $contH++;
            } else if ($resultado['modalidad'] == 'V') {
                $MVDcalidad += $promedio_calificacion;
                $contV++;
            }
        }
    }

    $PHDcalidad = number_format($contH > 0 ? $MHDcalidad / $contH : 0, 1);
    $PVDcalidad = number_format($contV > 0 ? $MVDcalidad / $contV : 0, 1);
    // CONSULTAR Variedad de contenidos
    $MHDvariedad = 0;
    $MVDvariedad  = 0;
    $contH = 0;
    $contV = 0;
    $consulta = $conn->prepare("WITH promedios AS (
    SELECT
        acta_id,
        (COALESCE(r13, 0) + COALESCE(r17, 0)) * (100.0 / 20) AS suma_datos
    FROM
        preguntav
    )
    SELECT
        acta_id,
        AVG(suma_datos) AS promedio_claridad
    FROM
        promedios
    GROUP BY
    acta_id;");
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $arr_acta = [];
    $arr_promedio = [];

    foreach ($resultado as $value) {
        $arr_acta[] = $value['acta_id'];
        $arr_promedio[$value['acta_id']] = $value['promedio_claridad']; 
    }

    foreach ($arr_acta as $acta_id) {
        $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
        $consulta->bindParam(':acta_id', $acta_id, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $promedio_calificacion = $arr_promedio[$acta_id] ?? 0; 

            if ($resultado['modalidad'] == 'H') {
                $MHDvariedad += $promedio_calificacion;
                $contH++;
            } else if ($resultado['modalidad'] == 'V') {
                $MVDvariedad += $promedio_calificacion;
                $contV++;
            }
        }
    }

    $PHDvariedad = number_format($contH > 0 ? $MHDvariedad / $contH : 0, 1);
    $PVDvariedad = number_format($contV > 0 ? $MVDvariedad / $contV : 0, 1);
    // CONSULTAR Utilidad de las herramientas de la plataforma Moodle
    $MHDutilidad = 0;
    $MVDutilidad  = 0;
    $contH = 0;
    $contV = 0;
    $consulta = $conn->prepare("WITH promedios AS (
    SELECT
        acta_id,
        (COALESCE(r14, 0) * 10) AS suma_datos
    FROM
        preguntav
    )
    SELECT
        acta_id,
        AVG(suma_datos) AS promedio_utilidad
    FROM
        promedios
    GROUP BY
    acta_id;");
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $arr_acta = [];
    $arr_promedio = [];

    foreach ($resultado as $value) {
        $arr_acta[] = $value['acta_id'];
        $arr_promedio[$value['acta_id']] = $value['promedio_utilidad']; 
    }

    foreach ($arr_acta as $acta_id) {
        $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
        $consulta->bindParam(':acta_id', $acta_id, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $promedio_calificacion = $arr_promedio[$acta_id] ?? 0; 

            if ($resultado['modalidad'] == 'H') {
                $MHDutilidad += $promedio_calificacion;
                $contH++;
            } else if ($resultado['modalidad'] == 'V') {
                $MVDutilidad += $promedio_calificacion;
                $contV++;
            }
        }
    }

    $PHDutilidad = number_format($contH > 0 ? $MHDutilidad / $contH : 0, 1);
    $PVDutilidad = number_format($contV > 0 ? $MVDutilidad / $contV : 0, 1);
    // CONSULTAR AUTONOMIA
    $MHDautonomia = 0;
    $MVDautonomia = 0;
    $contH = 0;
    $contV = 0;
    $consulta = $conn->prepare("WITH promedios AS (
    SELECT
        acta_id,
        (COALESCE(r16, 0) + COALESCE(r20, 0)) * (100.0 / 20) AS suma_datos
    FROM
        preguntav
    )
    SELECT
        acta_id,
        AVG(suma_datos) AS promedio_autonomia
    FROM
        promedios
    GROUP BY
    acta_id;");
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $arr_acta = [];
    $arr_promedio = [];

    foreach ($resultado as $value) {
        $arr_acta[] = $value['acta_id'];
        $arr_promedio[$value['acta_id']] = $value['promedio_autonomia']; 
    }

    foreach ($arr_acta as $acta_id) {
        $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
        $consulta->bindParam(':acta_id', $acta_id, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $promedio_calificacion = $arr_promedio[$acta_id] ?? 0; 

            if ($resultado['modalidad'] == 'H') {
                $MHDautonomia += $promedio_calificacion;
                $contH++;
            } else if ($resultado['modalidad'] == 'V') {
                $MVDautonomia += $promedio_calificacion;
                $contV++;
            }
        }
    }

    $PHDautonomia = number_format($contH > 0 ? $MHDautonomia / $contH : 0, 1);
    $PVDautonomia = number_format($contV > 0 ? $MVDautonomia / $contV : 0, 1);
    // CONSULTAR Evaluacion de contenidos
    $MHDcontenidos = 0;
    $MVDcontenidos = 0;
    $contH = 0;
    $contV = 0;
    $consulta = $conn->prepare("WITH promedios AS (
    SELECT
        acta_id,
        (COALESCE(r14, 0) * 10) AS suma_datos
    FROM
        preguntav
    )
    SELECT
        acta_id,
        AVG(suma_datos) AS promedio_contenidos
    FROM
        promedios
    GROUP BY
    acta_id;");
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $arr_acta = [];
    $arr_promedio = [];

    foreach ($resultado as $value) {
        $arr_acta[] = $value['acta_id'];
        $arr_promedio[$value['acta_id']] = $value['promedio_contenidos']; 
    }

    foreach ($arr_acta as $acta_id) {
        $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
        $consulta->bindParam(':acta_id', $acta_id, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $promedio_calificacion = $arr_promedio[$acta_id] ?? 0; 

            if ($resultado['modalidad'] == 'H') {
                $MHDcontenidos += $promedio_calificacion;
                $contH++;
            } else if ($resultado['modalidad'] == 'V') {
                $MVDcontenidos += $promedio_calificacion;
                $contV++;
            }
        }
    }

    $PHDcontenidos = number_format($contH > 0 ? $MHDcontenidos / $contH : 0, 1);
    $PVDcontenidos = number_format($contV > 0 ? $MVDcontenidos / $contV : 0, 1);
    // CONSULTAR Disenio grafico del curso
    $MHDgrafico = 0;
    $MVDgrafico = 0;
    $contH = 0;
    $contV = 0;
    $consulta = $conn->prepare("WITH promedio21 AS (
    SELECT
        acta_id,
        (
            SELECT AVG(value::numeric)
            FROM unnest(string_to_array(r21, ',')) AS value
            WHERE value ~ '^\d+(\.\d+)?$'
        ) * 10 AS promedio_r21
    FROM
        preguntav
    )
    SELECT
        acta_id,
        AVG(promedio_r21) AS promedio_disenio
    FROM
        promedio21
    GROUP BY
    acta_id;");
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $arr_acta = [];
    $arr_promedio = [];

    foreach ($resultado as $value) {
        $arr_acta[] = $value['acta_id'];
        $arr_promedio[$value['acta_id']] = $value['promedio_disenio']; 
    }

    foreach ($arr_acta as $acta_id) {
        $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
        $consulta->bindParam(':acta_id', $acta_id, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $promedio_calificacion = $arr_promedio[$acta_id] ?? 0; 

            if ($resultado['modalidad'] == 'H') {
                $MHDgrafico += $promedio_calificacion;
                $contH++;
            } else if ($resultado['modalidad'] == 'V') {
                $MVDgrafico += $promedio_calificacion;
                $contV++;
            }
        }
    }

    $PHDgrafico = number_format($contH > 0 ? $MHDgrafico / $contH : 0, 1);
    $PVDgrafico = number_format($contV > 0 ? $MVDgrafico / $contV : 0, 1);
    // CONSULTAR Modalidades de escuela
    $query = "SELECT
    acta_id,
    unidad,
    carrera,
    materia,
    COUNT(DISTINCT numcontrol) AS total_alumnos,
    COUNT(DISTINCT grupo) AS total_grupos,
    COUNT(DISTINCT numcontrol) AS total_docentes
FROM
    virtuales
GROUP BY
    acta_id, unidad, carrera, materia;";
$stmt = $conn->prepare($query);
$stmt->execute();

// Obtener los resultados
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

$unidad_totales = [];
$acta_id = [];
$datosEsc = [];

// Procesar resultados
foreach ($resultados as $fila) {
    $acta_id[] = $fila['acta_id'];
    $acta = $fila['acta_id'];
    $unidad = abreviarPrimeraPalabra($fila['unidad']);
    $carrera = abreviarPrimeraPalabra($fila['carrera']);
    $materia = $fila['materia'];
    $total_alumnos = $fila['total_alumnos'];
    $total_grupos = $fila['total_grupos'];
    $total_docentes = $fila['total_docentes'];

    // Acumular el total de alumnos por unidad
    if (!isset($unidad_totales[$unidad])) {
        $unidad_totales[$unidad] = 0;
    }
    $unidad_totales[$unidad] += $total_alumnos;

    // Consulta adicional dentro del bucle
    $queryAsesor = "WITH asesor_en_linea AS (
        SELECT
            acta_id,
            (r7 + r8 + r10 + r2 + r4 + r9 + r3 + r5 + r6) AS calificacion
        FROM
            preguntav
    )
    SELECT
        acta_id,
        AVG(calificacion) AS promedio_calificacion
    FROM
        asesor_en_linea
    WHERE
        acta_id = :acta_id
    GROUP BY
        acta_id;";

    $stmtAsesor = $conn->prepare($queryAsesor); // Preparar la consulta
    $stmtAsesor->bindParam(':acta_id', $acta, PDO::PARAM_STR); // Enlazar el parámetro
    $stmtAsesor->execute(); // Ejecutar la consulta
    $resultadosAsesor = $stmtAsesor->fetchAll(PDO::FETCH_ASSOC); // Obtener los resultados

    // Asegurar que hay resultados antes de intentar acceder a ellos
    $promAsesor = isset($resultadosAsesor[0]['promedio_calificacion']) ? $resultadosAsesor[0]['promedio_calificacion'] : null;
    ////////
    $queryDisenio = "WITH calificaciones AS (
    SELECT
        acta_id,
        (
            SELECT AVG(value::numeric)
            FROM unnest(string_to_array(r21, ',')) AS value
            WHERE value ~ '^\d+(\.\d+)?$'
        ) AS promedio_r21,
        r12 + r18 + r15 + r13 + r17 + r16 + r20 + r14 AS suma_atributos_sin_promedio
    FROM
        preguntav
    ),
    calificaciones_con_promedio AS (
        SELECT
            acta_id,
            promedio_r21,
            suma_atributos_sin_promedio + promedio_r21 AS suma_atributos
        FROM
            calificaciones
    )
    SELECT
        acta_id,
        AVG(suma_atributos) AS promedio_calificacion
    FROM
        calificaciones_con_promedio
    where
        acta_id = :acta_id
    GROUP BY
        acta_id;";

    $stmtDisenio = $conn->prepare($queryDisenio); // Preparar la consulta
    $stmtDisenio->bindParam(':acta_id', $acta, PDO::PARAM_STR); // Enlazar el parámetro
    $stmtDisenio->execute(); // Ejecutar la consulta
    $resultadosDisenio = $stmtDisenio->fetchAll(PDO::FETCH_ASSOC); // Obtener los resultados

    // Asegurar que hay resultados antes de intentar acceder a ellos
    $promDisenio = isset($resultadosDisenio[0]['promedio_calificacion']) ? $resultadosDisenio[0]['promedio_calificacion'] : null;

    $promT = (($promAsesor + $promDisenio)>0)?(($promAsesor + $promDisenio) / 2):0;
    // Almacenar los datos en el array
    $datosEsc[] = [$unidad, $carrera, $materia, &$unidad_totales[$unidad], $total_grupos, $total_docentes, number_format($promAsesor, 1), number_format($promDisenio, 1), number_format($promT, 1)];
    }
    //
    $arrMH = [];
    $arrMV = [];
    $cont = 0;
    foreach ($acta_id as $acta_id) {
        $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
        $consulta->bindParam(':acta_id', $acta_id, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $datoArr = $datosEsc[$cont];
            if ($resultado['modalidad'] == 'H') {
                $arrMH[] = $datoArr;
            } else if ($resultado['modalidad'] == 'V') {
                $arrMV[] = $datoArr;
            }
        }
        $cont++;
    }
    //
} catch (PDOException $exp) {
    $tipoError = 'No se pudo conectar a la base de datos';
}

$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
//
$pdf->setFooterText('Reporte Institucional modalidad híbrida y/o virtual', ($periodo . ' ' . $anio));
// Agregar páginas con contenido diferente
$pdf->AddPage();
$pdf->Portada();

//$pdf->AddPage();
//$pdf->Indice();

$pdf->AddPage();
$pdf->Page1Content($MHU, $MVU, $MH, $MV, $MHG, $MVG, $MHA, $MVA, $MHE, $MVE, $MHInstr, $MVInstr, $PHAsesor, $PVAsesor, $PHDisenio, $PVDisenio);

$pdf->AddPage();
$pdf->Page2Content($MHE, $MVE, $MHInstr, $MVInstr, $PHOportunidad, $PVOportunidad, $PHCalidad, $PVCalidad, $PHDominio, $PVDominio, 
    $PHDclaridad, $PVDclaridad, $PHDcalidad, $PVDcalidad, $PHDvariedad, $PVDvariedad, $PHDutilidad, $PVDutilidad, $PHDautonomia, $PVDautonomia,
    $PHDcontenidos, $PVDcontenidos, $PHDgrafico, $PVDgrafico);

$pdf->AddPage();
$pdf->Page3Content($arrMH);

$pdf->AddPage();
$pdf->Page4Content($arrMV);

$pdf->AddPage();
$pdf->IndiceData($pdf->pageNumbers);

$pdf->Output();

?>
