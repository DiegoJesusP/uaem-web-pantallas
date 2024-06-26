<?php
require('./../fpdf/fpdf.php');
include('./../php/conexion.php');

// Clase PDF
class PDF extends FPDF
{
    // Cabecera del pdf
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
        $this->SetFont('Arial', 'B', 12);
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
    function Footer(){
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . ' / {nb}', 0, 0, 'C');
    }
    
    function TablaInicio($dataI){
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
        $this->Cell(70, 6, utf8_decode('Unidad académica:'), 'LR', 0, 'L', true);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(119, 6, utf8_decode($dataI['unidad']), 'LR', 0, 'C', true);
        $this->Ln();

        $this->SetFont('Arial', '', 10);
        $this->Cell(70, 6, utf8_decode('Modalidad:'), 'LR', 0, 'L', false);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(119, 6, utf8_decode('modalidad que se obtiene de la base de datos'), 'LR', 0, 'C', false);
        $this->Ln();
        
        $this->SetFont('Arial', '', 10);
        $this->Cell(70, 6, utf8_decode('Datos Generales:'), 'LR', 0, 'L', true);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(119, 6, utf8_decode('Índice (Global)'), 'LR', 0, 'C', true);
        $this->Ln();
        
        $this->SetFont('Arial', '', 10);
        $this->Cell(70, 6, utf8_decode('Promedio:'), 'LR', 0, 'L', false);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(119, 6, utf8_decode('Valor estático con variable'), 'LR', 0, 'C', false);
        $this->Ln();
        
        $this->SetFont('Arial', '', 10);
        $this->Cell(70, 6, utf8_decode('Asesor(a):'), 'LR', 0, 'L', true);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(119, 6, utf8_decode($dataI['nombre_docente']. " " . $dataI['ap_paterno_docente'] . " " . $dataI['ap_materno_docente']), 'LR', 0, 'C', true);
        $this->Ln();
        
        
        
        // Si $dataI['materia'] es un arreglo
        $aux = 0;
        foreach ($dataI['materia'] as $materia) {
            $this->SetFont('Arial', '', 10);
            if ($aux != 0){
                $this->Cell(70, 6, '', 'LR', 0, 'L', false);
            }else {
                $this->Cell(70, 6, utf8_decode('Curso(s):'), 'LR', 0, 'L', false);
            }
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(119, 6, utf8_decode($materia), 'LR', 0, 'C', false);
            $this->Ln(); // Salto de línea después de cada materia
            $aux ++;
        }

        // Línea de cierre
        $this->Cell(189, 0, '', 'T');
        $this->Ln(2);
    }

    //Crear la tabla de datos principal y las tablas adicionales
    function FancyTable($header, $data, $anchoColumnas, $numGrupos) {
        // Colores, ancho de Linea y fuente en negrita
        $this->SetFillColor(255, 255, 255); // Blanco
        $this->SetTextColor(0, 0, 0); // Negro
        $this->SetDrawColor(48, 83, 149); // Azul
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
        
        // Cabecera dinamica
        foreach ($header as $i => $title) {
            $this->Cell($anchoColumnas[$i], 7, $title, 1, 0, 'L', true);
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
        ];
        
        $this->SetFont('Arial', 'B', 10);
        foreach ($titulosTablas as $j => $titulo) {
            $this->Cell($anchoColumnas[0], 6, utf8_decode($titulo), 'LR', 0, 'L', $j % 2 == 0);
            for ($k = 1; $k <= $numGrupos; $k++) {
                $this->Cell($anchoColumnas[$k], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celdas vacías grupos
            }
            $this->Cell($anchoColumnas[$numGrupos + 1], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celda vacía total
            $this->Ln();
        }
        $this->Cell(189, 0, '', 'T');
        $this->Ln();
        //
        $this->SetFillColor(225, 238, 218); // Verde
        $titulosTablas = [
            'Asesor en Línea (índice Global):'
        ];
        
        $this->SetFont('Arial', 'B', 10);
        foreach ($titulosTablas as $j => $titulo) {
            $this->Cell($anchoColumnas[0], 6, utf8_decode($titulo), 'LR', 0, 'L', $j % 2 == 0);
            for ($k = 1; $k <= $numGrupos; $k++) {
                $this->Cell($anchoColumnas[$k], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celdas vacías grupos
            }
            $this->Cell($anchoColumnas[$numGrupos + 1], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celda vacía total
            $this->Ln();
        }
        $this->Cell(189, 0, '', 'T');
        $this->Ln();
        //
        $this->SetFillColor(255, 241, 204); // amarillo
        $titulosTablas = [
            'Diseño del Curso (índice Global):'
        ];
        
        $this->SetFont('Arial', 'B', 10);
        foreach ($titulosTablas as $j => $titulo) {
            $this->Cell($anchoColumnas[0], 6, utf8_decode($titulo), 'LR', 0, 'L', $j % 2 == 0);
            for ($k = 1; $k <= $numGrupos; $k++) {
                $this->Cell($anchoColumnas[$k], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celdas vacías grupos
            }
            $this->Cell($anchoColumnas[$numGrupos + 1], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celda vacía total
            $this->Ln();
        }
        $this->Cell(189, 0, '', 'T');
        $this->Ln(2);

    }

    function TablaRespuestas($anchoColumnas, $numGrupos){
        $this->SetFillColor(225, 238, 218); // Verde
        $this->SetTextColor(0, 0, 0); // Negro
        $this->SetDrawColor(0); // 
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
        
        // Selección de datos
        // Select * from preguntav where acta_id = :acta_id and id_grupo = :id_grupo;
        
        // Configuración de fuente
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(189, 6, utf8_decode('Asesor en Línea'), 'LR', 0, 'C', true);
        $this->Ln();
        //
        $this->SetFillColor(217, 217, 217); // gris
        $this->SetTextColor(0, 0, 0); // Negro
        $this->SetDrawColor(0); // negro
        //
        $titulosTablas = [
            'Funciones del Asesor en Línea:'
        ];

        $this->SetFont('Arial', 'B', 10);
        foreach ($titulosTablas as $j => $titulo) {
            $this->MultiCell($anchoColumnas[0], 6, utf8_decode($titulo), 'LR', 'L', $j % 2 == 0);
            $this->SetXY($this->GetX() + $anchoColumnas[0], $this->GetY() - 6); // Ajusta la posición después de MultiCell

            for ($k = 1; $k <= $numGrupos; $k++) {
                $this->Cell($anchoColumnas[$k], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celdas vacías grupos
            }
            $this->Cell($anchoColumnas[$numGrupos + 1], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celda vacía total
            $this->Ln();
        }

        $this->Cell(189, 0, '', 'T');
        $this->Ln();
        //
        $this->SetFillColor(255); // blanco
        $this->SetTextColor(0, 0, 0); // Negro
        $this->SetDrawColor(0); // negro
        
        $titulosTablas = [
            '-Dominio y Desempeño del Asesor:'
        ];

        $this->SetFont('Arial', 'B', 10);
        foreach ($titulosTablas as $j => $titulo) {
            $this->MultiCell($anchoColumnas[0], 6, utf8_decode($titulo), 'LR', 'L', $j % 2 == 0);
            $this->SetXY($this->GetX() + $anchoColumnas[0], $this->GetY() - 6); // Ajusta la posición después de MultiCell

            for ($k = 1; $k <= $numGrupos; $k++) {
                $this->Cell($anchoColumnas[$k], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celdas vacías grupos
            }
            $this->Cell($anchoColumnas[$numGrupos + 1], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celda vacía total
            $this->Ln();
        }

        $this->Cell(189, 0, '', 'T');
        $this->Ln();
        
        $this->SetFillColor(224, 235, 255); // azul
        $this->SetTextColor(0, 0, 0); // Negro
        $this->SetDrawColor(48, 83, 149); // azul
        $titulosTablas = [
            'Dominio en el manejo de las aplicaciones y herramientas de la plataforma Moodle:',
            'Dominio disciplinar por parte del profesor en la asignatura:',
            'Desempeño del asesor(a) como facilitador del aprendizaje a lo largo del curso:'
        ];

        $this->SetFont('Arial', '', 10);
        foreach ($titulosTablas as $j => $titulo) {
            $this->MultiCell($anchoColumnas[0], 6, utf8_decode($titulo), 'LR', 'L', $j % 2 == 0);
            $this->SetXY($this->GetX() + $anchoColumnas[0], $this->GetY() - 6); // Ajusta la posición después de MultiCell

            for ($k = 1; $k <= $numGrupos; $k++) {
                $this->Cell($anchoColumnas[$k], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celdas vacías grupos
            }
            $this->Cell($anchoColumnas[$numGrupos + 1], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celda vacía total
            $this->Ln();
        }

        $this->Cell(189, 0, '', 'T');
        $this->Ln();
        //
        $this->SetFillColor(255); // blanco
        $this->SetTextColor(0, 0, 0); // Negro
        $this->SetDrawColor(0); // negro
        
        $titulosTablas = [
            '-Oportunidad en la retroalimentación y respuestas:'
        ];

        $this->SetFont('Arial', 'B', 10);
        foreach ($titulosTablas as $j => $titulo) {
            $this->MultiCell($anchoColumnas[0], 6, utf8_decode($titulo), 'LR', 'L', $j % 2 == 0);
            $this->SetXY($this->GetX() + $anchoColumnas[0], $this->GetY() - 6); // Ajusta la posición después de MultiCell

            for ($k = 1; $k <= $numGrupos; $k++) {
                $this->Cell($anchoColumnas[$k], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celdas vacías grupos
            }
            $this->Cell($anchoColumnas[$numGrupos + 1], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celda vacía total
            $this->Ln();
        }

        $this->Cell(189, 0, '', 'T');
        $this->Ln();
        
        $this->SetFillColor(224, 235, 255); // azul
        $this->SetTextColor(0, 0, 0); // Negro
        $this->SetDrawColor(48, 83, 149); // azul
        $titulosTablas = [
            'Prontitud con que tu asesor respondió a tus dudas, preguntas o comentarios:',
            'Prontitud de tu asesor en respuesta o aportación en los foros:',
            'Prontitud de tu asesor para registrar tus calificaciónes en la plataforma:'
        ];

        $this->SetFont('Arial', '', 10);
        foreach ($titulosTablas as $j => $titulo) {
            $this->MultiCell($anchoColumnas[0], 6, utf8_decode($titulo), 'LR', 'L', $j % 2 == 0);
            $this->SetXY($this->GetX() + $anchoColumnas[0], $this->GetY() - 6); // Ajusta la posición después de MultiCell

            for ($k = 1; $k <= $numGrupos; $k++) {
                $this->Cell($anchoColumnas[$k], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celdas vacías grupos
            }
            $this->Cell($anchoColumnas[$numGrupos + 1], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celda vacía total
            $this->Ln();
        }

        $this->Cell(189, 0, '', 'T');
        $this->Ln();
        //
        $this->SetFillColor(255); // blanco
        $this->SetTextColor(0, 0, 0); // Negro
        $this->SetDrawColor(0); // negro
        
        $titulosTablas = [
            '-Calidad de retroalimentación y respuesta:'
        ];

        $this->SetFont('Arial', 'B', 10);
        foreach ($titulosTablas as $j => $titulo) {
            $this->MultiCell($anchoColumnas[0], 6, utf8_decode($titulo), 'LR', 'L', $j % 2 == 0);
            $this->SetXY($this->GetX() + $anchoColumnas[0], $this->GetY() - 6); // Ajusta la posición después de MultiCell

            for ($k = 1; $k <= $numGrupos; $k++) {
                $this->Cell($anchoColumnas[$k], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celdas vacías grupos
            }
            $this->Cell($anchoColumnas[$numGrupos + 1], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celda vacía total
            $this->Ln();
        }

        $this->Cell(189, 0, '', 'T');
        $this->Ln();
        
        $this->SetFillColor(224, 235, 255); // azul
        $this->SetTextColor(0, 0, 0); // Negro
        $this->SetDrawColor(48, 83, 149); // azul
        $titulosTablas = [
            'Calidad de las respuestas de tu asesor(a) a tus dudas, preguntas o comentarios:',
            'Comentarios o argumentos emitidos por tu asesor(a) para justificar las calificaciones que obtuviste:',
            'Promoción por parte del asesor en argumentar las patticipaciones en base a los comentario:'
        ];

        $this->SetFont('Arial', '', 10);
        foreach ($titulosTablas as $j => $titulo) {
            $this->MultiCell($anchoColumnas[0], 6, utf8_decode($titulo), 'LR', 'L', $j % 2 == 0);
            $this->SetXY($this->GetX() + $anchoColumnas[0], $this->GetY() - 6); // Ajusta la posición después de MultiCell

            for ($k = 1; $k <= $numGrupos; $k++) {
                $this->Cell($anchoColumnas[$k], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celdas vacías grupos
            }
            $this->Cell($anchoColumnas[$numGrupos + 1], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celda vacía total
            $this->Ln();
        }

        $this->Cell(189, 0, '', 'T');
        $this->Ln(2);
        //
        //Aqui empieza la segunda parte la de color amarillo
        //
        $this->SetFillColor(255, 241, 204); //amarillo
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(189, 6, utf8_decode('Diseño del curso'), 'LR', 0, 'C', true);
        $this->Ln();
        //
        $this->SetFillColor(217, 217, 217); // gris
        $this->SetTextColor(0, 0, 0); // Negro
        $this->SetDrawColor(0); // negro
        //
        $titulosTablas = [
            'Diseño Calidad del Curso:'
        ];

        $this->SetFont('Arial', 'B', 10);
        foreach ($titulosTablas as $j => $titulo) {
            $this->MultiCell($anchoColumnas[0], 6, utf8_decode($titulo), 'LR', 'L', $j % 2 == 0);
            $this->SetXY($this->GetX() + $anchoColumnas[0], $this->GetY() - 6); // Ajusta la posición después de MultiCell

            for ($k = 1; $k <= $numGrupos; $k++) {
                $this->Cell($anchoColumnas[$k], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celdas vacías grupos
            }
            $this->Cell($anchoColumnas[$numGrupos + 1], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celda vacía total
            $this->Ln();
        }

        $this->Cell(189, 0, '', 'T');
        $this->Ln();
        //
        $this->SetFillColor(255); // blanco
        $this->SetTextColor(0, 0, 0); // Negro
        $this->SetDrawColor(0); // negro
        
        $titulosTablas = [
            '-Diseño del Curso en claridad de contenidos:'
        ];

        $this->SetFont('Arial', 'B', 10);
        foreach ($titulosTablas as $j => $titulo) {
            $this->MultiCell($anchoColumnas[0], 6, utf8_decode($titulo), 'LR', 'L', $j % 2 == 0);
            $this->SetXY($this->GetX() + $anchoColumnas[0], $this->GetY() - 6); // Ajusta la posición después de MultiCell

            for ($k = 1; $k <= $numGrupos; $k++) {
                $this->Cell($anchoColumnas[$k], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celdas vacías grupos
            }
            $this->Cell($anchoColumnas[$numGrupos + 1], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celda vacía total
            $this->Ln();
        }

        $this->Cell(189, 0, '', 'T');
        $this->Ln();
        
        $this->SetFillColor(224, 235, 255); // azul
        $this->SetTextColor(0, 0, 0); // Negro
        $this->SetDrawColor(48, 83, 149); // azul
        $titulosTablas = [
            'Calidad de contenidos temáticos incluidos en el curso:',
            'Carga horaria declarada para este curso:',
            'Pertinencia en el diseño delas actividades de aprendizaje en el curso:'
        ];

        $this->SetFont('Arial', '', 10);
        foreach ($titulosTablas as $j => $titulo) {
            $this->MultiCell($anchoColumnas[0], 6, utf8_decode($titulo), 'LR', 'L', $j % 2 == 0);
            $this->SetXY($this->GetX() + $anchoColumnas[0], $this->GetY() - 6); // Ajusta la posición después de MultiCell

            for ($k = 1; $k <= $numGrupos; $k++) {
                $this->Cell($anchoColumnas[$k], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celdas vacías grupos
            }
            $this->Cell($anchoColumnas[$numGrupos + 1], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celda vacía total
            $this->Ln();
        }

        $this->Cell(189, 0, '', 'T');
        $this->Ln();
        //
        $this->SetFillColor(255); // blanco
        $this->SetTextColor(0, 0, 0); // Negro
        $this->SetDrawColor(0); // negro
        
        $titulosTablas = [
            '-Variedad de contenidos:'
        ];

        $this->SetFont('Arial', 'B', 10);
        foreach ($titulosTablas as $j => $titulo) {
            $this->MultiCell($anchoColumnas[0], 6, utf8_decode($titulo), 'LR', 'L', $j % 2 == 0);
            $this->SetXY($this->GetX() + $anchoColumnas[0], $this->GetY() - 6); // Ajusta la posición después de MultiCell

            for ($k = 1; $k <= $numGrupos; $k++) {
                $this->Cell($anchoColumnas[$k], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celdas vacías grupos
            }
            $this->Cell($anchoColumnas[$numGrupos + 1], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celda vacía total
            $this->Ln();
        }

        $this->Cell(189, 0, '', 'T');
        $this->Ln();
        
        $this->SetFillColor(224, 235, 255); // azul
        $this->SetTextColor(0, 0, 0); // Negro
        $this->SetDrawColor(48, 83, 149); // azul
        $titulosTablas = [
            'Variedad de contenidos temáticos incluidos en el curso:',
            'Variedad en el diseño de las actividades de aprendizaje incluidas en el curso:'
        ];

        $this->SetFont('Arial', '', 10);
        foreach ($titulosTablas as $j => $titulo) {
            $this->MultiCell($anchoColumnas[0], 6, utf8_decode($titulo), 'LR', 'L', $j % 2 == 0);
            $this->SetXY($this->GetX() + $anchoColumnas[0], $this->GetY() - 6); // Ajusta la posición después de MultiCell

            for ($k = 1; $k <= $numGrupos; $k++) {
                $this->Cell($anchoColumnas[$k], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celdas vacías grupos
            }
            $this->Cell($anchoColumnas[$numGrupos + 1], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celda vacía total
            $this->Ln();
        }

        $this->Cell(189, 0, '', 'T');
        $this->Ln();
        //
        $this->SetFillColor(255); // blanco
        $this->SetTextColor(0, 0, 0); // Negro
        $this->SetDrawColor(0); // negro
        
        $titulosTablas = [
            '-Nivel de autonomía:'
        ];

        $this->SetFont('Arial', 'B', 10);
        foreach ($titulosTablas as $j => $titulo) {
            $this->MultiCell($anchoColumnas[0], 6, utf8_decode($titulo), 'LR', 'L', $j % 2 == 0);
            $this->SetXY($this->GetX() + $anchoColumnas[0], $this->GetY() - 6); // Ajusta la posición después de MultiCell

            for ($k = 1; $k <= $numGrupos; $k++) {
                $this->Cell($anchoColumnas[$k], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celdas vacías grupos
            }
            $this->Cell($anchoColumnas[$numGrupos + 1], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celda vacía total
            $this->Ln();
        }

        $this->Cell(189, 0, '', 'T');
        $this->Ln();
        
        $this->SetFillColor(224, 235, 255); // azul
        $this->SetTextColor(0, 0, 0); // Negro
        $this->SetDrawColor(48, 83, 149); // azul

        $titulosTablas = [
            'Los materiales incluidos en el curso te permitieron aprender por si mismo(a) estimulando el interés por investigar y profundizar en conocimientos nuevos:',
            'Comprensión integral de los contenidos curriculares de la materia:'
        ];

        $this->SetFont('Arial', '', 10);
        foreach ($titulosTablas as $j => $titulo) {
            $this->MultiCell($anchoColumnas[0], 6, utf8_decode($titulo), 'LR', 'L', $j % 2 == 0);
            $this->SetXY($this->GetX() + $anchoColumnas[0], $this->GetY() - 6); // Ajusta la posición después de MultiCell

            for ($k = 1; $k <= $numGrupos; $k++) {
                $this->Cell($anchoColumnas[$k], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celdas vacías grupos
            }
            $this->Cell($anchoColumnas[$numGrupos + 1], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celda vacía total
            $this->Ln();
        }

        $this->Cell(189, 0, '', 'T');
        $this->Ln();

        
        $this->SetFillColor(255); // blanco
        $this->SetTextColor(0, 0, 0); // Negro
        $this->SetDrawColor(0, 0, 0); // azul
        
        $titulosTablas = [
            '-Evaluacion de contenidos:'
        ];

        $this->SetFont('Arial', 'B', 10);
        foreach ($titulosTablas as $j => $titulo) {
            $this->MultiCell($anchoColumnas[0], 6, utf8_decode($titulo), 'LR', 'L', $j % 2 == 0);
            $this->SetXY($this->GetX() + $anchoColumnas[0], $this->GetY() - 6); // Ajusta la posición después de MultiCell

            for ($k = 1; $k <= $numGrupos; $k++) {
                $this->Cell($anchoColumnas[$k], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celdas vacías grupos
            }
            $this->Cell($anchoColumnas[$numGrupos + 1], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celda vacía total
            $this->Ln();
        }

        $this->Cell(189, 0, '', 'T');
        $this->Ln();

        $titulosTablas = [
            '-Utilidad Moodle:'
        ];

        $this->SetFont('Arial', 'B', 10);
        foreach ($titulosTablas as $j => $titulo) {
            $this->MultiCell($anchoColumnas[0], 6, utf8_decode($titulo), 'LR', 'L', $j % 2 == 0);
            $this->SetXY($this->GetX() + $anchoColumnas[0], $this->GetY() - 6); // Ajusta la posición después de MultiCell

            for ($k = 1; $k <= $numGrupos; $k++) {
                $this->Cell($anchoColumnas[$k], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celdas vacías grupos
            }
            $this->Cell($anchoColumnas[$numGrupos + 1], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celda vacía total
            $this->Ln();
        }

        $this->Cell(189, 0, '', 'T');
        $this->Ln();

        $titulosTablas = [
            '-Diseño gráfico del curso:'
        ];

        $this->SetFont('Arial', 'B', 10);
        foreach ($titulosTablas as $j => $titulo) {
            $this->MultiCell($anchoColumnas[0], 6, utf8_decode($titulo), 'LR', 'L', $j % 2 == 0);
            $this->SetXY($this->GetX() + $anchoColumnas[0], $this->GetY() - 6); // Ajusta la posición después de MultiCell

            for ($k = 1; $k <= $numGrupos; $k++) {
                $this->Cell($anchoColumnas[$k], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celdas vacías grupos
            }
            $this->Cell($anchoColumnas[$numGrupos + 1], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celda vacía total
            $this->Ln();
        }

        $this->Cell(189, 0, '', 'T');
        $this->Ln();

        $this->SetFillColor(224, 235, 255); // azul
        $this->SetTextColor(0, 0, 0); // Negro
        $this->SetDrawColor(48, 83, 149); // azul
        $titulosTablas = [
            'Colores:',
            'Ilustraciones (Imágenes, logotipos):',
            'Navegabilidad:',
            'Tamaño y tipo de letra:'
        ];

        $this->SetFont('Arial', '', 10);
        foreach ($titulosTablas as $j => $titulo) {
            $this->MultiCell($anchoColumnas[0], 6, utf8_decode($titulo), 'LR', 'L', $j % 2 == 0);
            $this->SetXY($this->GetX() + $anchoColumnas[0], $this->GetY() - 6); // Ajusta la posición después de MultiCell

            for ($k = 1; $k <= $numGrupos; $k++) {
                $this->Cell($anchoColumnas[$k], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celdas vacías grupos
            }
            $this->Cell($anchoColumnas[$numGrupos + 1], 6, '', 'LR', 0, 'L', $j % 2 == 0); // Celda vacía total
            $this->Ln();
        }

        $this->Cell(189, 0, '', 'T');
        $this->Ln();

    }
    // 
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
$anchoFijo = 70; // Ancho fijo para la primera columna (Grupos)
$anchoVariable = 189 - $anchoFijo; // Ancho total disponible menos el ancho de la columna fija
$anchoGrupos = $anchoVariable / ($numGrupos + 1); // Distribuir el ancho entre las columnas de grupos y la columna Total
$anchoColumnas[] = $anchoFijo;
for ($i = 0; $i < $numGrupos; $i++) {
    $anchoColumnas[] = $anchoGrupos;
}
$anchoColumnas[] = $anchoGrupos; // Ancho para la columna Total
//
//


// Crear el PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

$pdf->TablaInicio($dataFromDb);
$pdf->FancyTable($header, $dataS, $anchoColumnas, $numGrupos);
$pdf->TablaRespuestas($anchoColumnas, $numGrupos);

//$nombreArchivo = 'reporte_' . $numcontrol . '.pdf';
//$nombreArchivo, "D"
$pdf->Output();

?>

