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
        $promIA = number_format(($PHAsesor + $PVAsesor) / 2, 1);
        $promID = number_format(($PHDisenio + $PVDisenio) / 2, 1);
        $promI = number_format(($promIA + $promID) / 2, 1);
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
        $promHib = number_format(($PHAsesor + $PHDisenio) / 2, 1);
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
        $promVirt = number_format(($PVAsesor + $PVDisenio) / 2, 1);
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
        $promIU = ($PHPE + $PVPE) / 2;
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
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('Evaluacion a partir de la opinión de los estudiantes '. $unidadP), 1, 1, 'C');
        //
        $this->Ln(3);
        $valX = $this->GetX();
        $valY = $this->GetY();
        $ESP = $ER - $EP;
        $dataEstudiantes = array('Registrados en sistema' => $ER, 'Participantes' => $EP, 'Sin participación' => $ESP);
        $this->BarDiagram(200, 55, $dataEstudiantes, '%l : %v (%p)', array(79, 129, 189));
        $this->SetXY($valX, $valY + 60);
        //
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 10, utf8_decode('Gráfico 4. Resultado Institucional, Modalidad, dimensiones de evaluación y desglose de dimensión: Funciones del asesor en línea.'), 0, 'R');
    }

    function Page3Content($unidadP,$MHAPevaluados, $MVAPevaluados, $EHU, $EVU){
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
        $tamanioAltoColumna = 8;
        $unidadData = [
            ($MHAPevaluados + $MVAPevaluados),//1
            ($EHU + $EVU),//2
            "\nPromedio total de evaluación",  //3
            "1) Funciones del asesor en línea",//4
            "\n2) Diseño y calidad del curso"//5
        ];
        
        $this->AddTableBodyPage3C($tamanioAltoColumna, $unidadData, true, [255, 255, 255]);
    }

    function Page4Content($unidadP){
        $this->pageNumbers[] = $this->PageNo();
        //
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 10, utf8_decode('IV. Resultado de evaluación de ' . $unidadP . '. Modalidad, dimensiones de evaluación y desglose de dimensión'), 0, 'L');
        //
    }

    function Page5Content($unidadP){
        $this->pageNumbers[] = $this->PageNo();
        //
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 10, utf8_decode('V. Resultado de evaluación de ' . $unidadP . '. Modalidad, dimensiones de evaluación y desglose de dimensión'), 0, 'L');
        //
    }

    function Page6Content(){
        $this->pageNumbers[] = $this->PageNo();
        //
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 10, utf8_decode('VI.- Resultado institucional por unidad académica y dimensiones de evaluación'), 0, 'L');
        //
    }

    function Page7Content(){
        $this->pageNumbers[] = $this->PageNo();
        //
        $this->SetTextColor(38, 71, 114);
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 10, utf8_decode('VII.- Niveles de participación y resultado de evaluación por programa educativo y asignatura'), 0, 'L');
        //
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
    //
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
$pdf->Page3Content($unidadP, $MHAPevaluados, $MVAPevaluados, $EHU, $EVU);

$pdf->AddPage();
$pdf->Page4Content($unidadP);

$pdf->AddPage();
$pdf->Page5Content($unidadP);

$pdf->AddPage();
$pdf->Page6Content();

$pdf->AddPage();
$pdf->Page7Content();

$pdf->AddPage();
$pdf->IndiceData($pdf->pageNumbers, $unidadP);

$pdf->Output();

?>
