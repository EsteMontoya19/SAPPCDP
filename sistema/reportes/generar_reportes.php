<?php
    require_once "../../recursos/Excel/vendor/autoload.php";
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

    // Definition: Cambia el nombre de la hoja activa.
        $documento->getActiveSheet()->setTitle('Indicadores');
        $hojaIndicadores = $documento -> getActiveSheet();
        $hojaIndicadores ->getStyle('A1:I100')->applyFromArray($styleArray);
        $hojaIndicadores -> getDefaultColumnDimension()->setWidth(30, 'cm');
        $hojaIndicadores -> getColumnDimension('A')->setWidth(60, 'cm');
        $hojaIndicadores -> getColumnDimension('E')->setWidth(60, 'cm');
        $hojaIndicadores -> getColumnDimension('F')->setWidth(40, 'cm');
    // Section: Agregar títulos de las columnas de Instructores.
        $hojaIndicadores -> setCellValueByColumnAndRow(1, 1, "Nombre Completo");
        $hojaIndicadores -> setCellValueByColumnAndRow(2, 1, "División");
        $hojaIndicadores -> setCellValueByColumnAndRow(3, 1, "Modalidad");
        $hojaIndicadores -> setCellValueByColumnAndRow(4, 1, "Sexo");
        $hojaIndicadores -> setCellValueByColumnAndRow(5, 1, "Evento");
        $hojaIndicadores -> setCellValueByColumnAndRow(6, 1, "Periodo");


    // Definition: esta línea sirve para dejar el cursor al inicio del primer nombre registrado.
        $documento->getActiveSheet()->freezePane('A2', 'A2');


        ob_clean();
        $writer = new Xlsx($documento);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Lista reconocimientos Moderadores e Instructores -12.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
