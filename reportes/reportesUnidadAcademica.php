<?php

require_once './../library/fpdf/fpdf.php';
include('./../php/conexion.php');

function obtenerParametroGET($nombre, $default = 'No definido') {
    return isset($_GET[$nombre]) ? htmlspecialchars($_GET[$nombre]) : $default;
}

function convertirTexto($texto) {
    $texto = mb_strtolower($texto, 'UTF-8');
    $texto = mb_convert_case($texto, MB_CASE_TITLE, 'UTF-8');
    return $texto;
}

function abreviarPrimeraPalabra($texto) {
    //$texto = mb_strtoupper($texto, 'UTF-8');
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

    function Portada($unidad){
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
        $this->Cell($xSeg, 10, utf8_decode('Reporte de Evaluación del Desempeño Docente'), 0, 0, 'R', true);
        $this->Ln();
        $this->SetFont('Arial', '', 14);
        $this->Cell($xIni, 10, utf8_decode(''), 0, 0, 'R');
        $this->Cell($xSeg, 10, utf8_decode($unidad), 0, 0, 'R', true);
        $this->Ln();
        $this->SetFillColor(235, 243, 246);
        $this->Cell($xIni, 10, utf8_decode(''), 0, 0, 'R');
        $this->SetTextColor(80, 80, 80);
        $this->Cell($xSeg, 10, utf8_decode('Asignaturas híbridas y/o virtuales'), 0, 0, 'R', true);
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
        $this->MultiCell(0, 10, utf8_decode('I. Resultado Institucional'), 0, 'L');
        
        //$this->Cell(0, 10, utf8_decode('Proximamente tablas'), 1, 1, 'C');
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

        $this->SetFont('Arial', '', 10);
        $ER = ($MHE + $MVE);
        $EP = ($MHE + $MVE);
        $ESP = $ER - $EP;
        $promIA = (($PHAsesor + $PVAsesor) > 0)?number_format(($PHAsesor + $PVAsesor) / 2, 1):0;
        $promID = (($PHDisenio + $PVDisenio) > 0)?number_format(($PHDisenio + $PVDisenio) / 2, 1):0;
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
        if ($promI != 0 && $promHib != 0 && $promVirt != 0){
            $this->SetTextColor(38, 71, 114);
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
            $this->SetXY($valX, $valY + 35);
            //**** */
            $this->SetTextColor(38, 71, 114);
            $this->SetFont('Arial', '', 10);
            $this->MultiCell(0, 10, utf8_decode('Gráfico 1. Resultado institucional y modalidad.'), 0, 'R');
        }
        $this->MultiCell(0, 6, utf8_decode('**El resultado institucional refiere al índice global de los resultados de evaluación docente de los programas educativos de las unidades académicas participantes por modalidad.'), 0, 'L');
        $this->MultiCell(0, 6, utf8_decode('*Total de asesores participantes son contabilizados como registros únicos.'), 0, 'L');
    }

    function Page2Content($unidadP, $PHAR, $PVAR, $MHG, $MVG, $EHU, $EVU,$PHPE, $PVPE){
        $this->pageNumbers[] = $this->PageNo();
        // Contenido de la página 3 (texto y operación)
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 10, utf8_decode('II.  Resultado de evaluación de ' . $unidadP . '. Niveles de participación y modalidad'), 0, 'L');
        //
        $separador = 10;
        $tamanioAltoColumna = 5;
        $subTitulos = [
            "\nUnidad académica / Modalidad",//1
            "Número de Asignaturas registradas",//2
            "Número de Asignaturas participantes",//3
            "\n\nNúmero de grupos",//4
            "\nRegistrados en sistema",//5
            "\nParticipantes en la evaluación *",//6
            "\nEvaluados por unidad académica",//7 
            "\nPromedio total de evaluación"//8
        ];
        $divisionTitulo = 277 / count($subTitulos);
        $medidas = [($divisionTitulo), ($divisionTitulo * 3), ($divisionTitulo * 2), $divisionTitulo, $divisionTitulo];
        //
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', 'B', 12);
        $this->AddTableHeaderMan2($medidas, ($tamanioAltoColumna + 2), ['', 'Asignaturas', 'Estudiantes', 'Asesores', ''], true, [218, 238, 243]);
        
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 10);
        $this->AddTableSubT2($tamanioAltoColumna, $subTitulos, true, [242, 242, 242]);
        $this->Ln($separador);
        //
        $tamanioAltoColumna = 8;
        $promIU = (($PHPE + $PVPE)>0)?number_format(($PHPE + $PVPE) / 2, 1):0;
        $ER = ($MHG + $MVG);
        $EP = ($EHU + $EVU);
        $unidadData = [
            $unidadP,//1
            ($PHAR + $PVAR),//2
            ($PHAR + $PVAR),//3
            ($MHG + $MVG),//4
            $ER,//5
            $EP,//6
            ($EHU + $EVU),//7 
            $promIU //8
        ];
        $this->AddTableBodyPage2C($tamanioAltoColumna, $unidadData, true, [218, 238, 243]);
        //$this->Ln($separador);
        $this->SetFont('Arial', '', 10);
        $unidadData = [
            "Modalidad híbrida",//1
            $PHAR,//2
            $PHAR,//3
            $MHG,//4
            $MHG,//5
            $EHU,//6
            $EHU,//7 
            $PHPE //8
        ];
        $this->AddTableBodyPage2C($tamanioAltoColumna, $unidadData, true, [218, 238, 243]);
        //$this->Ln($separador);

        $unidadData = [
            "Modalidad virtual",//1
            $PVAR,//2
            $PVAR,//3
            $MVG,//4
            $MVG,//5
            $EVU,//6
            $EVU,//7 
            $PVPE //8
        ];
        $this->AddTableBodyPage2C($tamanioAltoColumna, $unidadData, true, [218, 238, 243]);
        //$this->Ln($separador);
        //
        $this->SetTextColor(38, 71, 114);
        $this->Ln(5);
        //
        if($ER != 0 && $EP != 0){
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('Evaluacion a partir de la opinión de los estudiantes '. $unidadP), 1, 1, 'C');
        //
        $this->Ln(3);
        $valX = $this->GetX();
        $valY = $this->GetY();
        $ESP = $ER - $EP;
        $dataEstudiantes = array('Registrados en sistema' => $ER, 'Participantes' => $EP, 'Sin participación' => $ESP);
        $this->BarDiagram(200, 55, $dataEstudiantes, '%l : %v (%p)', array(79, 129, 189));
        $this->SetXY($valX, $valY + 50);
        //
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 10, utf8_decode('Gráfico 2. Opinión de estudiantes. '. $unidadP), 0, 'R');
        }
        $this->MultiCell(0, 10, utf8_decode('* Total de estudiantes participantes de los programas educativos de la Unidad Académica son contabilizados como registros únicos.'), 0, 'L');
    }

    function Page3Content($unidadP,$MHAPevaluados, $MVAPevaluados, $EHU, $EVU, $PHAsesorU, $PVAsesorU, $PHDisenioU, $PVDisenioU){
        $this->pageNumbers[] = $this->PageNo();
        //
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 10, utf8_decode('III.  Resultado de evaluación de ' . $unidadP . '. Dimensiones de evaluación y modalidad'), 0, 'L');
        //
        $separador = 10;
        $tamanioAltoColumna = 5;
        $subTitulos = [
            "\nTotal de asesores evaluados*",//1
            "Total de estudiantes participantes*",//2
            "\nPromedio total de evaluación",  //3
            "1) Funciones del asesor en línea",//4
            "\n2) Diseño y calidad del curso"//5
        ];
        $divisionTitulo = 277 / count($subTitulos);
        $medidas1 = [($divisionTitulo*3), ($divisionTitulo * 2)];
        $medidas2 = [($divisionTitulo*3), ($divisionTitulo * 2)];
        //
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', 'B', 12);
        $this->AddTableHeaderMan($medidas1, ($tamanioAltoColumna + 2), ['', 'Dimensiones de evaluación'], true, [218, 238, 243]);
        $this->AddTableHeaderMan3($medidas2, ($tamanioAltoColumna + 2), [$unidadP, 'Promedio total por dimensión'], true, [218, 238, 243]);
        
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 10);
        $this->AddTableSubT2($tamanioAltoColumna, $subTitulos, true, [242, 242, 242]);
        $this->Ln();

        $this->SetFont('Arial', '', 10);
        $promAsesor = (($PHAsesorU + $PVAsesorU)>0)?number_format(($PHAsesorU + $PVAsesorU) / 2, 1):0;
        $promDisenio = (($PHDisenioU + $PVDisenioU)>0)?number_format(($PHDisenioU + $PVDisenioU) / 2, 1):0;
        $promTUnidad = (($promAsesor + $promDisenio)>0)?number_format(($promAsesor + $promDisenio) / 2, 1):0;
        $unidadData = [
            ($MHAPevaluados + $MVAPevaluados),//1
            ($EHU + $EVU),//2
            $promTUnidad,  //3
            "",//4
            ""//5
        ];
        $this->AddTableBodyPage3C($tamanioAltoColumna, $unidadData, true, [255, 255, 255]);
        $tamanioAltoColumna = 5;
        $medidas3 = [($divisionTitulo*2), $divisionTitulo, $divisionTitulo, $divisionTitulo];
        $this->AddTableHeaderMan($medidas3, ($tamanioAltoColumna + 2), ['', 'Modalidad híbrida', $PHAsesorU, $PHDisenioU], true, [255, 255, 255]);
        $this->AddTableHeaderMan($medidas3, ($tamanioAltoColumna + 2), ['', 'Modalidad virtual', $PVAsesorU, $PVDisenioU], true, [255, 255, 255]);
        //
        $this->AddTableHeaderMan($medidas3, ($tamanioAltoColumna + 2), ['', 'Total', $promAsesor, $promDisenio], true, [255, 255, 255]);
        //
        $this->Ln(3);
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('Evaluacion a partir de la opinión de los estudiantes '. $unidadP), 1, 1, 'C');
        //
        //$this->Ln(2);
        if ($promAsesor != 0 && $promDisenio != 0){
        $valX = $this->GetX();
        $valY = $this->GetY();
        $dataEstudiantes = array('Funciones del asesor en línea' => $promAsesor, 'Diseño y calidad del curso' => $promDisenio);
        $this->BarDiagram(200, 55, $dataEstudiantes, '%l : %v (%p)', array(79, 129, 189));
        $this->SetXY($valX, $valY + 55);
        
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 10, utf8_decode('Gráfico 3. Dimensiones e evaluación. '. $unidadP), 0, 'R');
        }
        $this->MultiCell(0, 10, utf8_decode('* Total de docentes y estudiantes participantes de los programas educativos de la Unidad Académica son contabilizados como registros únicos'), 0, 'L');
    
    }

    function Page4Content($unidadP, $EHU, $EVU, $PHOportunidadU, $PVOportunidadU, $PHCalidadU, $PVCalidadU, $PHDominioU, $PVDominioU, $PHAsesorU, $PVAsesorU, $PHDisenioU, $PVDisenioU){
        $this->pageNumbers[] = $this->PageNo();
        //
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 10, utf8_decode('IV. Resultado de evaluación de ' . $unidadP . '. Modalidad, dimensiones de evaluación y desglose de dimensión'), 0, 'L');
        //
        $promAsesor = (($PHAsesorU + $PVAsesorU)>0)?number_format(($PHAsesorU + $PVAsesorU) / 2, 1):0;
        $promDisenio = (($PHDisenioU + $PVDisenioU)>0)?number_format(($PHDisenioU + $PVDisenioU) / 2, 1):0;
        $promTUnidad = (($promAsesor + $promDisenio)>0)?number_format(($promAsesor + $promDisenio) / 2, 1):0;
        //
        $separador = 10;
        $tamanioAltoColumna = 5;
        $subTitulos = [
            "\n$promTUnidad",//1
            "\nEstudiantes participantes*",//2
            "Oportunidad en la retroalimentación y respuesta",  //3
            "Calidad de retroalimentación y respuesta",//4
            "Dominio y desempeño del asesor en línea", //5
            "Promedio total de dimensión" //6
        ];
        $divisionTitulo = 277 / count($subTitulos);
        $medidas1 = [($divisionTitulo*6)];
        $medidas2 = [($divisionTitulo*1), ($divisionTitulo * 5)];
        //
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 12);
        $this->AddTableHeaderMan3($medidas1, ($tamanioAltoColumna + 2), ['Desglose Dimensiones de evaluación'], true, [191, 191, 191]);
        $this->AddTableHeaderMan3($medidas2, ($tamanioAltoColumna + 2), [$unidadP, 'Dimensión: Funciones del asesor en línea'], true, [218, 238, 243]);
        
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 10);
        $this->AddTableBodyT4($tamanioAltoColumna, $subTitulos, true, [255, 255, 255]);
        $this->Ln();
        $tamanioAltoColumna = 7;
        //
        $promH = number_format(($PHOportunidadU + $PHCalidadU + $PHDominioU) /3, 1);
        $unidadData = [
            "Modalidad híbrida",//1
            $EHU,//2
            $PHOportunidadU,  //3
            $PHCalidadU,//4
            $PHDominioU, //5
            $promH
        ];
        $this->AddTableBodyPage3C($tamanioAltoColumna, $unidadData, true, [255, 255, 255]);
        $promV = number_format(($PVOportunidadU + $PVCalidadU + $PVDominioU) /3, 1);
        $unidadData = [
            "Modalidad virtual",//1
            $EVU,//2
            $PVOportunidadU,  //3
            $PVCalidadU,//4
            $PVDominioU, //5
            $promV
        ];
        $this->AddTableBodyPage3C($tamanioAltoColumna, $unidadData, true, [255, 255, 255]);
        $this->SetFont('Arial', 'B', 10);
        $promO = (($PHOportunidadU + $PVOportunidadU)>0)?number_format(($PHOportunidadU + $PVOportunidadU) / 2, 1):0;
        $promC = (($PHCalidadU + $PVCalidadU)>0)?number_format(($PHCalidadU + $PVCalidadU) / 2, 1):0;
        $promD = (($PHDominioU + $PVDominioU)>0)?number_format(($PHDominioU + $PVDominioU) / 2, 1):0;
        $promTotal = (($promH + $promV)>0)?number_format(($promH + $promV) / 2, 1):0;
        $unidadData = [
            "Total",//1
            ($EHU + $EVU),//2
            $promO,  //3
            $promC,//4
            $promD, //5
            $promTotal 
        ];
        $this->AddTableBodyPage3C($tamanioAltoColumna, $unidadData, true, [255, 255, 255]);
        //
        $this->Ln(3);
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('Dimensiones de evaluación: '. $unidadP), 1, 1, 'C');
        //
        //$this->Ln(2);
        if ($promO != 0 && $promC != 0 && $promD != 0 && $promTotal != 0){
        $valX = $this->GetX();
        $valY = $this->GetY();
        $dataEstudiantes = array('Oportunidad...' => $promO, 'Calidad...' => $promC,  'Dominio y desempeño...' => $promD,  'Promedio total...' => $promTotal);
        $this->BarDiagram(200, 55, $dataEstudiantes, '%l : %v (%p)', array(79, 129, 189));
        $this->SetXY($valX, $valY + 55);
        //
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 10, utf8_decode('Gráfico 4. Desglose dimensiones de evaluación. '. $unidadP), 0, 'R');
        }
        $this->MultiCell(0, 10, utf8_decode('* Total de estudiantes participantes de los programas educativos de la Unidad Académica son contabilizados como registros únicos'), 0, 'L');
    }

    function Page5Content($unidadP, $EHU, $EVU, $PHAsesorU, $PVAsesorU, $PHDisenioU, $PVDisenioU, $PHCLaridadU, $PVCLaridadU, $PHDCalidadU, $PVDCalidadU, $PHDVariedadU, $PVDVariedadU, $PHDMoodleU, $PVDMoodleU, $PHDAutonomiaU, $PVDAutonomiaU, $PHDContenidoU, $PVDContenidoU, $PHDGraficoU, $PVDGraficoU){
        $this->pageNumbers[] = $this->PageNo();
        //
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 10, utf8_decode('V. Resultado de evaluación de ' . $unidadP . '. Modalidad, dimensiones de evaluación y desglose de dimensión'), 0, 'L');
        //
        $promAsesor = (($PHAsesorU + $PVAsesorU)>0)?number_format(($PHAsesorU + $PVAsesorU) / 2, 1):0;
        $promDisenio = (($PHDisenioU + $PVDisenioU)>0)?number_format(($PHDisenioU + $PVDisenioU) / 2, 1):0;
        $promTUnidad = (($promAsesor + $promDisenio)>0)?number_format(($promAsesor + $promDisenio) / 2, 1):0;
        //
        $separador = 10;
        $tamanioAltoColumna = 5;
        $subTitulos = [
            "\n$promTUnidad",//1
            "\nEstudiantes participantes*",//2
            "Diseño del curso en claridad de contenidos",  //3
            "Diseño del curso en calidad de contenidos",//4
            "Variedad de contenidos", //5
            "Utilidad de Moodle", //6
            "Autonomía", //7
            "Evaluación de contenidos", //8
            "Diseño gráfico del curso", //9
            "Promedio total de dimensión" //10
        ];
        $divisionTitulo = 277 / count($subTitulos);
        $medidas1 = [($divisionTitulo * 10)];
        $medidas2 = [($divisionTitulo * 1), ($divisionTitulo * 9)];
        //
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 10);
        $this->AddTableHeaderMan3($medidas1, ($tamanioAltoColumna + 2), ['Desglose Dimensiones de evaluación'], true, [191, 191, 191]);
        $this->AddTableHeaderMan3($medidas2, ($tamanioAltoColumna + 2), [$unidadP, 'Dimensión: Funciones del asesor en línea'], true, [218, 238, 243]);
        
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 10);
        $this->AddTableBodyT4($tamanioAltoColumna, $subTitulos, true, [255, 255, 255]);
        $this->Ln();
        $tamanioAltoColumna = 7;
        //
        $promH = number_format(($PHCLaridadU + $PHDCalidadU + $PHDVariedadU + $PHDMoodleU + $PHDAutonomiaU + $PHDContenidoU + $PHDGraficoU) /3, 1);
        $unidadData = [
            "Modalidad híbrida",//1
            $EHU,//2
            $PHCLaridadU,  //3
            $PHDCalidadU,//4
            $PHDVariedadU, //5
            $PHDMoodleU, //6
            $PHDAutonomiaU, //7
            $PHDContenidoU, //8
            $PHDGraficoU, //9
            $promH
        ];
        $this->AddTableBodyPage3C($tamanioAltoColumna, $unidadData, true, [255, 255, 255]);
        $promV = number_format(($PVCLaridadU + $PVDCalidadU + $PVDVariedadU + $PVDMoodleU + $PVDAutonomiaU + $PVDContenidoU + $PVDGraficoU) /3, 1);
        $unidadData = [
            "Modalidad virtual",//1
            $EVU,//2
            $PVCLaridadU,  //3
            $PVDCalidadU,//4
            $PVDVariedadU, //5
            $PVDMoodleU, //6
            $PVDAutonomiaU, //7
            $PVDContenidoU, //8
            $PVDGraficoU, //9
            $promV
        ];
        $this->AddTableBodyPage3C($tamanioAltoColumna, $unidadData, true, [255, 255, 255]);
        $this->SetFont('Arial', 'B', 10);
        $promCL = (($PHCLaridadU + $PHCLaridadU)>0)?number_format(($PHCLaridadU + $PHCLaridadU) / 2, 1):0;
        $promDC = (($PHDCalidadU + $PVDCalidadU)>0)?number_format(($PHDCalidadU + $PVDCalidadU) / 2, 1):0;
        $promDV = (($PHDVariedadU + $PVDVariedadU)>0)?number_format(($PHDVariedadU + $PVDVariedadU) / 2, 1):0;
        $promM = (($PHDMoodleU + $PVDMoodleU)>0)?number_format(($PHDMoodleU + $PVDMoodleU) / 2, 1):0;
        $promA = (($PHDAutonomiaU + $PVDAutonomiaU)>0)?number_format(($PHDAutonomiaU + $PVDAutonomiaU) / 2, 1):0;
        $promC = (($PHDContenidoU + $PVDContenidoU)>0)?number_format(($PHDContenidoU + $PVDContenidoU) / 2, 1):0;
        $promD = (($PHDGraficoU + $PVDGraficoU)>0)?number_format(($PHDGraficoU + $PVDGraficoU) / 2, 1):0;
        $promTotal = (($promCL + $promDC + $promDV + $promM + $promA + $promC + $promD )>0)?number_format(($promCL + $promDC + $promDV + $promM + $promA + $promC + $promD ) / 7, 1):0;
        $unidadData = [
            "Total",//1
            ($EHU + $EVU),//2
            $promCL,  //3
            $promDC,//4
            $promDV, //5
            $promM, //6
            $promA, //7
            $promC, //8
            $promD, //9
            $promTotal 
        ];
        $this->AddTableBodyPage3C($tamanioAltoColumna, $unidadData, true, [255, 255, 255]);
        //
        $this->Ln(3);
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('Dimensiones de evaluación: '. $unidadP), 1, 1, 'C');
        //
        //$this->Ln(2);
        if ($promCL != 0 && $promDC != 0 && $promDV != 0 && $promM != 0 && $promA != 0 && $promC != 0 && $promD != 0 && $promTotal != 0){
        $valX = $this->GetX();
        $valY = $this->GetY();
        $dataEstudiantes = array('Oportunidad...' => $promCL, 'Calidad...' => $promDC,  'Dominio y desempeño...' => $promDV, 'Herramienta Moodle' => $promM,
            'Autonomía' => $promA, 'Evaluación de contenidos' => $promC, 'Diseño gráfico...' => $promD, 'Promedio total...' => $promTotal);
        $this->BarDiagram(200, 55, $dataEstudiantes, '%l : %v (%p)', array(79, 129, 189));
        $this->SetXY($valX, $valY + 55);
        //
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 10, utf8_decode('Gráfico 5. Desglose dimensiones de evaluación. '. $unidadP), 0, 'R');
        $this->MultiCell(0, 10, utf8_decode('*Total de estudiantes participantes de los programas educativos de la Unidad Académica son contabilizados como registros únicos'), 0, 'L');
        }
    }

    function Page6Content($unidadP, $PHAsesor, $PVAsesor, $PHDisenio, $PVDisenio, $PHPE, $PVPE, $PHAsesorU, $PVAsesorU, $PHDisenioU, $PVDisenioU){
        $this->pageNumbers[] = $this->PageNo();
        //
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 10, utf8_decode('VI.- Resultado institucional por unidad académica y dimensiones de evaluación'), 0, 'L');
        //
        $promIA = (($PHAsesor + $PVAsesor)>0)?number_format(($PHAsesor + $PVAsesor) / 2, 1):0;
        $promID = (($PHDisenio + $PVDisenio)>0)?number_format(($PHDisenio + $PVDisenio) / 2, 1):0;
        $promI = (($promIA + $promID)>0)?number_format(($promIA + $promID) / 2, 1):0;

        $promIU = ($PHPE + $PVPE) / 2;

        $promAsesor = (($PHAsesorU + $PVAsesorU)>0)?number_format(($PHAsesorU + $PVAsesorU) / 2, 1):0;
        $promDisenio = (($PHDisenioU + $PVDisenioU)>0)?number_format(($PHDisenioU + $PVDisenioU) / 2, 1):0;
        //
        if ($promI != 0 && $promIU != 0 && $promAsesor != 0 && $promDisenio != 0){
        $valX = $this->GetX();
        $valY = $this->GetY();
        $dataEstudiantes = array('Resultado Institucional' => $promI, 'Resultado de '.$unidadP => $promIU,  'Asesor '.$unidadP => $promAsesor, 'Diseño '.$unidadP => $promDisenio);
        $this->BarDiagram(270, 80, $dataEstudiantes, '%l : %v (%p)', array(79, 129, 189));
        $this->SetXY($valX, $valY + 80);
        //
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 10, utf8_decode('Grafica 6. Resultado institucional por unidad académica y dimensiones de evaluación. '. $unidadP), 0, 'R');
        }
    }

    function Page7Content($unidadP){
        $this->pageNumbers[] = $this->PageNo();
        //
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 10, utf8_decode('VII.- Niveles de participación y resultado de evaluación por programa educativo y asignatura'), 0, 'L');
        //
        $separador = 10;
        $tamanioAltoColumna = 5;
        $subTitulos = [
            "\nPrograma/s educativo/s",//1
            "\n\nModalidad",//2
            "\nNombre de la asignatura",  //3
            "\n\nNúmero de grupos",//4
            "Estudiantes registrados en sistema", //5
            "\nEstudiantes participantes *", //6
            "\nAsesores evaluados", //7
            "\nPromedio total de dimensión" //9
        ];
        $divisionTitulo = 277 / count($subTitulos);
        $medidas1 = [($divisionTitulo * 8)];
        //
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 10);
        $this->AddTableHeaderMan3($medidas1, ($tamanioAltoColumna + 2), [$unidadP], true, [191, 191, 191]);
        $this->AddTableSubT2($tamanioAltoColumna, $subTitulos, true, [218, 238, 243]);
        $this->Ln();
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

    function AddTableHeaderMan($tam, $tamY, $titulosTablas, $useFillColor = true, $fillColor = [255, 255, 255]){
        if ($useFillColor) {
            $this->SetFillColor(...$fillColor);
        }
        
        foreach ($titulosTablas as $j => $titulo) {
            $this->Cell($tam[$j], $tamY, utf8_decode($titulo), ($j == 0)? false : true, 0, 'C', ($j == 0)? false : true);
        }
        $this->Ln();
    }

    function AddTableHeaderMan2($tam, $tamY, $titulosTablas, $useFillColor = true, $fillColor = [255, 255, 255]){
        if ($useFillColor) {
            $this->SetFillColor(...$fillColor);
        }
        
        foreach ($titulosTablas as $j => $titulo) {
            $this->Cell($tam[$j], $tamY, utf8_decode($titulo), ($j == 0 || $j == count($titulosTablas) - 1)? false : true, 0, 'C', ($j == 0 || $j == count($titulosTablas) - 1)? false : true);
        }
        $this->Ln();
    }

    function AddTableHeaderMan3($tam, $tamY, $titulosTablas, $useFillColor = true, $fillColor = [255, 255, 255]){
        if ($useFillColor) {
            $this->SetFillColor(...$fillColor);
        }
        
        foreach ($titulosTablas as $j => $titulo) {
            $this->Cell($tam[$j], $tamY, utf8_decode($titulo), true, 0, 'C', true);
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

    function AddTableSubT2($tamY, $titulosTablas, $useFillColor = true, $fillColor = [255, 255, 255]){
        if ($useFillColor) {
            $this->SetFillColor(...$fillColor);
        }
        $tamColumna = 277 / count($titulosTablas);
        foreach ($titulosTablas as $j => $titulo) {
            // Guardar la posición actual
            $x = $this->GetX();
            $y = $this->GetY();

            $this->MultiCell($tamColumna, $tamY, utf8_decode($titulo), true, 'C',true);

            $this->SetXY($x + $tamColumna, $y);
        }
        $this->Ln();
    }

    function AddTableBodyT4($tamY, $titulosTablas, $useFillColor = true, $fillColor = [255, 255, 255]){
        if ($useFillColor) {
            $this->SetFillColor(...$fillColor);
        }
        $tamColumna = 277 / count($titulosTablas);
        foreach ($titulosTablas as $j => $titulo) {

            $x = $this->GetX();
            $y = $this->GetY();

            if ($j != 0){
                $this->SetFillColor(242, 242, 242);
            }

            $this->MultiCell($tamColumna, $tamY, utf8_decode($titulo), true, 'C',true);

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

    function AddTableBodyPage2C($tamY, $titulosTablas, $useFillColor = true, $fillColor = [255, 255, 255]){
        if ($useFillColor) {
            $this->SetFillColor(...$fillColor);
        }
        $color = count($titulosTablas) -1;
        $tamColumna = 277 / count($titulosTablas);
        foreach ($titulosTablas as $j => $titulo) {

            $this->Cell($tamColumna, $tamY, utf8_decode($titulo), 1 , 0, 'C', ($j == 0)? true : false);
        }
        $this->Ln();
    }

    function AddTableBodyPage3C($tamY, $titulosTablas, $useFillColor = true, $fillColor = [255, 255, 255]){
        if ($useFillColor) {
            $this->SetFillColor(...$fillColor);
        }
        $color = count($titulosTablas) -1;
        $tamColumna = 277 / count($titulosTablas);
        foreach ($titulosTablas as $j => $titulo) {

            $this->Cell($tamColumna, $tamY, utf8_decode($titulo), 1 , 0, 'C', true);
        }
        $this->Ln();
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

    function IndiceData($pages, $unidadP){
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
        $this->AddIndice($anchoColumnas, ['I. Resultado Institucional'], $this->pageNumbers[0], true); 
        $this->AddIndice($anchoColumnas, ['II.  Resultado de evaluación de ' . $unidadP . '. Niveles de participación y modalidad'], $this->pageNumbers[1], true, [220, 228, 241]); 
        $this->AddIndice($anchoColumnas, ['III.  Resultado de evaluación de ' . $unidadP . '. Dimensiones de evaluación y modalidad'], $this->pageNumbers[2], true); 
        $this->AddIndice($anchoColumnas, ['IV. Resultado de evaluación de ' . $unidadP . '. Modalidad, dimensiones de evaluación y desglose de dimensión'. "\n\t" .'- Funciones del asesor en línea'], $this->pageNumbers[3], true, [220, 228, 241]);
        $this->AddIndice($anchoColumnas, ['V. Resultado de evaluación de ' . $unidadP . '. Modalidad, dimensiones de evaluación y desglose de dimensión'. "\n\t" .'- Diseño y calidad del curso'], $this->pageNumbers[4], true);
        $this->AddIndice($anchoColumnas, ['VI.- Resultado institucional por unidad académica y dimensiones de evaluación'], $this->pageNumbers[5], true, [220, 228, 241]);
        $this->AddIndice($anchoColumnas, ['VII.- Niveles de participación y resultado de evaluación por programa educativo y asignatura'], $this->pageNumbers[6], true);
        //
    }
}
// Obtener parámetros GET
$periodo = obtenerParametroGET('periodo', 'Sin definir "periodo"');
$anio = obtenerParametroGET('anio', 'Sin definir "anio"');
$unidad = obtenerParametroGET('unidad', 'Sin definir "unidad"');
//
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
    // CONSULTA ASIGNATURAS REGISTRADAS
    $MHAR = 0;
    $MVAR = 0;
    $consulta = $conn->prepare("SELECT acta_id, materia as asignatura FROM virtuales where unidad = :unidad;");
    $consulta->bindParam(':unidad', $unidad, PDO::PARAM_STR);
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $arr_acta = [];

    foreach ($resultado as $value) {
        $arr_acta[] = $value['acta_id'];
    }

    foreach ($arr_acta as $acta_id) {
        $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
        $consulta->bindParam(':acta_id', $acta_id, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $promedio_calificacion = $arr_promedio[$acta_id] ?? 0; 

            if ($resultado['modalidad'] == 'H') {
                $MHAR ++;
            } else if ($resultado['modalidad'] == 'V') {
                $MVAR ++;
            }
        }
    }
    // CONSULTA NUMERO DE GRUPOS
    $MHG = 0;
    $MVG = 0;
    $consulta = $conn->prepare("WITH ranked_units AS (
    SELECT
        acta_id,
        grupo,
        unidad,
        ROW_NUMBER() OVER (PARTITION BY matricula ORDER BY acta_id DESC) AS rn
    FROM
        virtuales
    )
    SELECT
        acta_id,
        grupo
    FROM
        ranked_units
    WHERE
        rn = 1 AND unidad = :unidad
    ORDER BY
        acta_id DESC;");
    $consulta->bindParam(':unidad', $unidad, PDO::PARAM_STR);
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $arr_acta = [];

    foreach ($resultado as $value) {
        $arr_acta[] = $value['acta_id'];
    }

    foreach ($arr_acta as $acta_id) {
        $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
        $consulta->bindParam(':acta_id', $acta_id, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $promedio_calificacion = $arr_promedio[$acta_id] ?? 0; 

            if ($resultado['modalidad'] == 'H') {
                $MHG ++;
            } else if ($resultado['modalidad'] == 'V') {
                $MVG ++;
            }
        }
    }
    // CONSULTAR ESTUDIANTES UNIDAD
    $EHU = 0;
    $EVU = 0;
    $consulta = $conn->prepare("WITH ranked_units AS (
    SELECT
        acta_id,
        matricula,
        unidad,
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
        rn = 1 and unidad = :unidad
    ORDER BY
        acta_id DESC;");
    $consulta->bindParam(':unidad', $unidad, PDO::PARAM_STR);
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
                $EHU++;
            } else if ($resultado['modalidad'] == 'V') {
                $EVU++;
            }
        }
    }
    // CONSULTA PROMEDIO EVALUACION
    $MHP = 0;
    $MVP = 0;
    $contH = 0;
    $contV = 0;
    $consulta = $conn->prepare("WITH calificaciones AS (
    SELECT
        acta_id,
        (r7 + r8 + r10 + r2 + r4 + r9 + r3 + r5 + r6) AS calificacion,
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
            calificacion,
            promedio_r21,
            suma_atributos_sin_promedio + promedio_r21 AS suma_atributos
        FROM
            calificaciones
    )
    SELECT
        acta_id,
        AVG(calificacion) AS promedio_calificacion_simple,
        AVG(suma_atributos) AS promedio_calificacion_total
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
        $arr_promedio[$value['acta_id']] = (($value['promedio_calificacion_simple'] + $value['promedio_calificacion_total']) / 2); 
    }

    foreach ($arr_acta as $acta_id) {
        $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
        $consulta->bindParam(':acta_id', $acta_id, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $promedio_calificacion = $arr_promedio[$acta_id] ?? 0; 

            if ($resultado['modalidad'] == 'H') {
                $MHP += $promedio_calificacion;
                $contH++;
            } else if ($resultado['modalidad'] == 'V') {
                $MVP += $promedio_calificacion;
                $contV++;
            }
        }
    }

    $PHPE = number_format($contH > 0 ? $MHAsesor / $contH : 0, 1);
    $PVPE = number_format($contV > 0 ? $MVAsesor / $contV : 0, 1);
    // CONSULTAR ASESORES EVALUADOS
    $MHAPevaluados = 0;
    $MVAPevaluados = 0;
    $consulta = $conn->prepare("WITH ranked_units AS (
    SELECT
        acta_id,
        numcontrol,
        unidad,
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
        rn = 1 and unidad = :unidad
    ORDER BY
        acta_id DESC;");
    $consulta->bindParam(':unidad', $unidad, PDO::PARAM_STR);
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
                $MHAPevaluados++;
            } else if ($resultado['modalidad'] == 'V') {
                $MVAPevaluados++;
            }
        }
    }
    // CONSULTAR PROMEDIO ASESOR EN LINEA UNIDAD
    $MHAsesorU = 0;
    $MVAsesorU = 0;
    $contH = 0;
    $contV = 0;

    $consulta = $conn->prepare("SELECT acta_id FROM virtuales WHERE unidad = :unidad;");
    $consulta->bindParam(':unidad', $unidad, PDO::PARAM_STR);
    $consulta->execute();
    $actasUnidad = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $arr_actaUnidad = array_column($actasUnidad, 'acta_id');
    $arr_promedio = [];

    foreach ($arr_actaUnidad as $acta_id) {
        $consulta = $conn->prepare("
            WITH calificaciones AS (
                SELECT
                    acta_id,
                    (r7 + r8 + r10 + r2 + r4 + r9 + r3 + r5 + r6) AS calificacion
                FROM
                    preguntav
                WHERE
                    acta_id = :acta_id
            )
            SELECT
                acta_id,
                AVG(calificacion) AS promedio_calificacion
            FROM
                calificaciones
            GROUP BY
                acta_id;
        ");
        $consulta->bindParam(':acta_id', $acta_id, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $arr_promedio[$acta_id] = $resultado['promedio_calificacion'];
        }
    }
    foreach ($arr_actaUnidad as $acta_id) {
        $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
        $consulta->bindParam(':acta_id', $acta_id, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $promedio_calificacion = $arr_promedio[$acta_id] ?? 0;

            if ($resultado['modalidad'] == 'H') {
                $MHAsesorU += $promedio_calificacion;
                $contH++;
            } elseif ($resultado['modalidad'] == 'V') {
                $MVAsesorU += $promedio_calificacion;
                $contV++;
            }
        }
    }
    $PHAsesorU = number_format($contH > 0 ? $MHAsesorU / $contH : 0, 1);
    $PVAsesorU = number_format($contV > 0 ? $MVAsesorU / $contV : 0, 1);
    // CONSULTAR PROMEDIO DISENIO Y CALIDAD UNIDAD
    $MHDisenioU = 0;
    $MVDisenioU = 0;
    $contH = 0;
    $contV = 0;

    $consulta = $conn->prepare("SELECT acta_id FROM virtuales WHERE unidad = :unidad;");
    $consulta->bindParam(':unidad', $unidad, PDO::PARAM_STR);
    $consulta->execute();

    $actasUnidad = $consulta->fetchAll(PDO::FETCH_ASSOC);
    $arr_actaUnidad = array_column($actasUnidad, 'acta_id');

    $arr_promedio = [];

    foreach ($arr_actaUnidad as $acta_id) {
        $consulta = $conn->prepare("
            WITH calificaciones AS (
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
                WHERE
                    acta_id = :acta_id
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
                acta_id;
        ");
        $consulta->bindParam(':acta_id', $acta_id, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $arr_promedio[$acta_id] = $resultado['promedio_calificacion'];
        }
    }

    foreach ($arr_actaUnidad as $acta_id) {
        $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
        $consulta->bindParam(':acta_id', $acta_id, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $promedio_calificacion = $arr_promedio[$acta_id] ?? 0;

            if ($resultado['modalidad'] == 'H') {
                $MHDisenioU += $promedio_calificacion;
                $contH++;
            } elseif ($resultado['modalidad'] == 'V') {
                $MVDisenioU += $promedio_calificacion;
                $contV++;
            }
        }
    }

    $PHDisenioU = number_format($contH > 0 ? $MHDisenioU / $contH : 0, 1);
    $PVDisenioU = number_format($contV > 0 ? $MVDisenioU / $contV : 0, 1);
    // CONSULTA ASESOR OPORTUNIDAD
    $MHOporunidad = 0;
    $MVOporunidad  = 0;
    $contH = 0;
    $contV = 0;

    $consulta = $conn->prepare("SELECT acta_id FROM virtuales WHERE unidad = :unidad;");
    $consulta->bindParam(':unidad', $unidad, PDO::PARAM_STR);
    $consulta->execute();
    $actasUnidad = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $arr_actaUnidad = array_column($actasUnidad, 'acta_id');
    $arr_promedio = [];

    foreach ($arr_actaUnidad as $acta_id) {
        $consulta = $conn->prepare("
            WITH calificaciones AS (
                SELECT
                    acta_id,
                    (r2 + r4 + r9) * (100/30) AS calificacion
                FROM
                    preguntav
                WHERE
                    acta_id = :acta_id
            )
            SELECT
                acta_id,
                AVG(calificacion) AS promedio_calificacion
            FROM
                calificaciones
            GROUP BY
                acta_id;
        ");
        $consulta->bindParam(':acta_id', $acta_id, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $arr_promedio[$acta_id] = $resultado['promedio_calificacion'];
        }
    }
    foreach ($arr_actaUnidad as $acta_id) {
        $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
        $consulta->bindParam(':acta_id', $acta_id, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $promedio_calificacion = $arr_promedio[$acta_id] ?? 0;

            if ($resultado['modalidad'] == 'H') {
                $MHOporunidad += $promedio_calificacion;
                $contH++;
            } elseif ($resultado['modalidad'] == 'V') {
                $MVOporunidad += $promedio_calificacion;
                $contV++;
            }
        }
    }
    $PHOportunidadU = number_format($contH > 0 ? $MHOporunidad / $contH : 0, 1);
    $PVOportunidadU = number_format($contV > 0 ? $MVOporunidad / $contV : 0, 1);
    // CONSULTAR ASESOR CALIDAD
    $MHCalidadU = 0;
    $MVCalidadU  = 0;
    $contH = 0;
    $contV = 0;

    $consulta = $conn->prepare("SELECT acta_id FROM virtuales WHERE unidad = :unidad;");
    $consulta->bindParam(':unidad', $unidad, PDO::PARAM_STR);
    $consulta->execute();
    $actasUnidad = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $arr_actaUnidad = array_column($actasUnidad, 'acta_id');
    $arr_promedio = [];

    foreach ($arr_actaUnidad as $acta_id) {
        $consulta = $conn->prepare("
            WITH calificaciones AS (
                SELECT
                    acta_id,
                    (r3 + r5 + r6) * (100/30) AS calificacion
                FROM
                    preguntav
                WHERE
                    acta_id = :acta_id
            )
            SELECT
                acta_id,
                AVG(calificacion) AS promedio_calificacion
            FROM
                calificaciones
            GROUP BY
                acta_id;
        ");
        $consulta->bindParam(':acta_id', $acta_id, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $arr_promedio[$acta_id] = $resultado['promedio_calificacion'];
        }
    }
    foreach ($arr_actaUnidad as $acta_id) {
        $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
        $consulta->bindParam(':acta_id', $acta_id, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $promedio_calificacion = $arr_promedio[$acta_id] ?? 0;

            if ($resultado['modalidad'] == 'H') {
                $MHCalidadU += $promedio_calificacion;
                $contH++;
            } elseif ($resultado['modalidad'] == 'V') {
                $MVCalidadU += $promedio_calificacion;
                $contV++;
            }
        }
    }
    $PHCalidadU = number_format($contH > 0 ? $MHCalidadU / $contH : 0, 1);
    $PVCalidadU = number_format($contV > 0 ? $MVCalidadU / $contV : 0, 1);
    // CONSULTAR ASESOR DOMINIO
    $MHDominioU = 0;
    $MVDominioU = 0;
    $contH = 0;
    $contV = 0;

    $consulta = $conn->prepare("SELECT acta_id FROM virtuales WHERE unidad = :unidad;");
    $consulta->bindParam(':unidad', $unidad, PDO::PARAM_STR);
    $consulta->execute();
    $actasUnidad = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $arr_actaUnidad = array_column($actasUnidad, 'acta_id');
    $arr_promedio = [];

    foreach ($arr_actaUnidad as $acta_id) {
        $consulta = $conn->prepare("
            WITH calificaciones AS (
                SELECT
                    acta_id,
                    (r7 + r8 + r10) * (100/30) AS calificacion
                FROM
                    preguntav
                WHERE
                    acta_id = :acta_id
            )
            SELECT
                acta_id,
                AVG(calificacion) AS promedio_calificacion
            FROM
                calificaciones
            GROUP BY
                acta_id;
        ");
        $consulta->bindParam(':acta_id', $acta_id, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $arr_promedio[$acta_id] = $resultado['promedio_calificacion'];
        }
    }
    foreach ($arr_actaUnidad as $acta_id) {
        $consulta = $conn->prepare("SELECT modalidad FROM virtuales_modalidad WHERE acta_id = :acta_id;");
        $consulta->bindParam(':acta_id', $acta_id, PDO::PARAM_STR);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $promedio_calificacion = $arr_promedio[$acta_id] ?? 0;

            if ($resultado['modalidad'] == 'H') {
                $MHDominioU += $promedio_calificacion;
                $contH++;
            } elseif ($resultado['modalidad'] == 'V') {
                $MVDominioU += $promedio_calificacion;
                $contV++;
            }
        }
    }
    $PHDominioU = number_format($contH > 0 ? $MHDominioU / $contH : 0, 1);
    $PVDominioU = number_format($contV > 0 ? $MVDominioU / $contV : 0, 1);
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

    $PHCLaridadU = number_format($contH > 0 ? $MHDclaridad / $contH : 0, 1);
    $PVCLaridadU = number_format($contV > 0 ? $MVDclaridad / $contV : 0, 1);
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

    $PHDCalidadU = number_format($contH > 0 ? $MHDcalidad / $contH : 0, 1);
    $PVDCalidadU = number_format($contV > 0 ? $MVDcalidad / $contV : 0, 1);
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

    $PHDVariedadU = number_format($contH > 0 ? $MHDvariedad / $contH : 0, 1);
    $PVDVariedadU = number_format($contV > 0 ? $MVDvariedad / $contV : 0, 1);
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

    $PHDMoodleU = number_format($contH > 0 ? $MHDutilidad / $contH : 0, 1);
    $PVDMoodleU = number_format($contV > 0 ? $MVDutilidad / $contV : 0, 1);
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

    $PHDAutonomiaU = number_format($contH > 0 ? $MHDautonomia / $contH : 0, 1);
    $PVDAutonomiaU = number_format($contV > 0 ? $MVDautonomia / $contV : 0, 1);
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

    $PHDContenidoU = number_format($contH > 0 ? $MHDcontenidos / $contH : 0, 1);
    $PVDContenidoU = number_format($contV > 0 ? $MVDcontenidos / $contV : 0, 1);
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

    $PHDGraficoU = number_format($contH > 0 ? $MHDgrafico / $contH : 0, 1);
    $PVDGraficoU = number_format($contV > 0 ? $MVDgrafico / $contV : 0, 1);
    // CONSULTA FINAL
    
} catch (PDOException $exp) {
    $tipoError = 'No se pudo conectar a la base de datos';
}

$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
//
$unidadP = convertirTexto($unidad);
$unidadF = abreviarPrimeraPalabra($unidadP);
$pdf->setFooterText('Reporte híbridas y/o virtuales. '. $unidadF, ($periodo . ' ' . $anio));

$pdf->AddPage();
$pdf->Portada($unidadP);

//$pdf->AddPage();
//$pdf->Indice();

$pdf->AddPage();
$pdf->Page1Content($MHU, $MVU, $MH, $MV, $MHG, $MVG, $MHA, $MVA, $MHE, $MVE, $MHInstr, $MVInstr, $PHAsesor, $PVAsesor, $PHDisenio, $PVDisenio);

$pdf->AddPage();
$pdf->Page2Content($unidadP, $MHAR, $MVAR, $MHG, $MVG, $EHU, $EVU, $PHPE, $PVPE);

$pdf->AddPage();
$pdf->Page3Content($unidadP, $MHAPevaluados, $MVAPevaluados, $EHU, $EVU, $PHAsesorU, $PVAsesorU, $PHDisenioU, $PVDisenioU);

$pdf->AddPage();
$pdf->Page4Content($unidadP, $EHU, $EVU, $PHOportunidadU, $PVOportunidadU, $PHCalidadU, $PVCalidadU, $PHDominioU, $PVDominioU, $PHAsesorU, $PVAsesorU, $PHDisenioU, $PVDisenioU);

$pdf->AddPage();
$pdf->Page5Content($unidadP, $EHU, $EVU, $PHAsesorU, $PVAsesorU, $PHDisenioU, $PVDisenioU, $PHCLaridadU, $PVCLaridadU, $PHDCalidadU, $PVDCalidadU, $PHDVariedadU, $PVDVariedadU, $PHDMoodleU, $PVDMoodleU, $PHDAutonomiaU, $PVDAutonomiaU, $PHDContenidoU, $PVDContenidoU, $PHDGraficoU, $PVDGraficoU);

$pdf->AddPage();
$pdf->Page6Content($unidadP, $PHAsesor, $PVAsesor, $PHDisenio, $PVDisenio, $PHPE, $PVPE, $PHAsesorU, $PVAsesorU, $PHDisenioU, $PVDisenioU);

$pdf->AddPage();
$pdf->Page7Content($unidadP);

$pdf->AddPage();
$pdf->IndiceData($pdf->pageNumbers, $unidadP);

$pdf->Output();

?>
