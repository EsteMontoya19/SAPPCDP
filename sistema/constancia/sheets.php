<?php
    require_once "../../recursos/Excel/vendor/autoload.php";
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    // Variables
    $arr_participantes = [1,2,4,5];
    $FechaInicio = $_POST["GrupoInicioInscripcion"];
    $FechaFin = $_POST["GrupoFinInscripcion"];
    $rol = 0;

    // Definition: Este arreglo tiene los estilos que se le dan a cada celda para que permanezcan centrados
    $styleArray = [
        'font' => [
            'bold' => true,
        ],
        'alignment' => [
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ]
    ];

    // Section: Creación de la Spreadsheet.
    $documento = new Spreadsheet();
    $documento
        -> getProperties()
        -> setCreator('FCA UNAM');


    $documento->createSheet();

    $documento->setActiveSheetIndex(0);
    // Definition: Cambia el nombre de la hoja activa.
    $documento->getActiveSheet()->setTitle('Profesores');
    $documento->getActiveSheet()->setCellValue('A1', 'Instructores');
    $hojaProfesores = $documento -> setActiveSheetIndex(0);
    $hojaProfesores -> setCellValueByColumnAndRow(1, 1, "Nombre");
    $hojaProfesores -> setCellValueByColumnAndRow(2, 1, "Evento");
    $hojaProfesores -> setCellValueByColumnAndRow(3, 1, "Texto");
    $hojaProfesores -> setCellValueByColumnAndRow(4, 1, "Periodo");
    $hojaProfesores -> setCellValueByColumnAndRow(5, 1, "Fecha de firma");
    $hojaProfesores -> setCellValueByColumnAndRow(6, 1, "Duración");
    $hojaProfesores -> setCellValueByColumnAndRow(7, 1, "Horas Acreditadas");
    $hojaProfesores -> setCellValueByColumnAndRow(8, 1, "Firmante");
    $hojaProfesores -> setCellValueByColumnAndRow(9, 1, "Puesto");


    $documento->setActiveSheetIndex(1);
    // Definition: Cambia el nombre de la hoja activa.
    $documento->getActiveSheet()->setTitle('Monitores');
    $documento->getActiveSheet()->setCellValue('A1', 'Moderadores');
    $hojaMonitores = $documento -> setActiveSheetIndex(1);
    $hojaMonitores -> setCellValueByColumnAndRow(1, 1, "Nombre");
    $hojaMonitores -> setCellValueByColumnAndRow(2, 1, "Evento");
    $hojaMonitores -> setCellValueByColumnAndRow(3, 1, "Texto");
    $hojaMonitores -> setCellValueByColumnAndRow(4, 1, "Periodo");
    $hojaMonitores -> setCellValueByColumnAndRow(5, 1, "Fecha de firma");
    $hojaMonitores -> setCellValueByColumnAndRow(6, 1, "Duración");
    $hojaMonitores -> setCellValueByColumnAndRow(7, 1, "Horas Acreditadas");
    $hojaMonitores -> setCellValueByColumnAndRow(8, 1, "Firmante");
    $hojaMonitores -> setCellValueByColumnAndRow(9, 1, "Puesto");

    // Definition: esta línea sirve para dejar el cursor al inicio del primer nombre registrado.
    $documento->setActiveSheetIndex(0)->setSelectedCell('A2');


    ob_clean();
    $writer = new Xlsx($documento);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="Lista de Asistencia".xlsx');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;
