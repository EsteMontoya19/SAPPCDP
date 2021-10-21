<?php
    include('../clases/BD.php');
    include('../clases/Grupo.php');
    include('../clases/Sesion.php');
    include('../clases/Asistencia.php');

    $idGrupo = $_GET['idGrupo'];
    $obj_Grupo = new Grupo();
    $obj_Sesion = new Sesion();
    $obj_Asistencia = new Asistencia();
    $arr_Inscritos = $obj_Grupo->buscarCorreosDeParticipantes($idGrupo);
    $curso = $obj_Grupo->buscarNombreCursoxGrupo($idGrupo);
    $grupo = $obj_Grupo->buscarGrupo($idGrupo);
    $sesion = $obj_Sesion->numSesionesGrupo($idGrupo);
    $arr_sesiones = $obj_Sesion->buscarFechaSesiones($idGrupo);
    $numSesiones = $sesion->numero;
    $arr_fechas = [];
    $sesiones = $obj_Sesion->buscarSesionesIDGrupo($idGrupo);
    $constancia = $obj_Asistencia->buscarAcreedorConstancia($idGrupo);

    //Se inicializa el contador en 0. Servirá para indicar el lugar en el que se guardará una consulta
    $i=0;

    //Se pasa el arreglo de la consulta sql a un arreglo numérico
    // ya que el KEY numérico en este caso es más fácil de consultar
foreach ($arr_sesiones as $sesion) {
    $arr_fechas[$i] = $sesion['fecha'];
    $i++;
}



    // ? Variables para permitir conseguir la coordenada X de una celda en número.
    $numero = $numSesiones + 4;
    $letra= chr($numero+65);


    require_once "../recursos/Excel/vendor/autoload.php";
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    $styleArray = [
        'font' => [
            'bold' => true,
        ],
        'alignment' => [
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
    ];


    $documento = new Spreadsheet();

    $documento
        -> getProperties()
        -> setCreator('FCA UNAM');

    $hoja = $documento -> getActiveSheet();
    $hoja -> getDefaultColumnDimension()->setWidth(30, 'cm');
    $hoja -> getColumnDimension('A')->setWidth(5);
    $hoja -> setTitle("Asistencia del grupo");


    // Definition: Esta parte escribe dentro de cada celda, con las cordenadas [A: Columna ,1: Fila]
    $hoja -> setCellValueByColumnAndRow(1, 1, "Relación de participantes");
    $hoja -> setCellValueByColumnAndRow(2, 3, $curso->curs_tipo.': '.$curso->curs_nombre);
    $hoja ->setCellValueByColumnAndRow(2, 4, "Instructor: ".$grupo->pers_apellido_paterno." ".$grupo->pers_apellido_materno." ".$grupo->pers_nombre);
    if ($grupo->moderador== '') {
        $hoja -> setCellValueByColumnAndRow(2, 5, "Moderador: Sin moderador");
    } else {
        $hoja -> setCellValueByColumnAndRow(2, 5, "Moderador: ".$grupo->moderador);
    }
    $hoja -> setCellValueByColumnAndRow(2, 6, "Fecha de la primera sesión: ".$arr_fechas[0]);

    // Definition: Le da estilo al titulo principal.
    $hoja -> getStyle('A1') -> applyFromArray($styleArray);

    // Definition: Aquí combinamos las celdas para que se vea más presentable.
    $hoja -> mergeCells("A1:".$letra."1");
    $hoja -> mergeCells("A2:".$letra."2");

    //? For: Combina las celdas del primer apartado, donde se muestra la info del grupo.
    for ($i=1; $i <= 6; $i++) {
        $hoja -> mergeCells("B$i:E$i");
    }

    // Definition: Esto da el color Azul al titulo principal.
    $documento
    ->getActiveSheet()
    ->getStyle('A1')
    ->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()
    ->setARGB('77ACF1');

    // Definition: For -> Le da color a todos los encabezados de la lista de asistencia.
    $documento
    ->getActiveSheet()
    ->getStyle("A8:".$letra."8")
    ->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()
    ->setARGB('77ACF1');


    $hoja -> mergeCells("A7:E7");
    $hoja -> setCellValueByColumnAndRow(1, 8, "#");
    $hoja -> setCellValueByColumnAndRow(2, 8, "Profesor");
    $hoja -> setCellValueByColumnAndRow(3, 8, "Correo");
    // Definition: Se adaptan las columnas de Asistencia en caso de ser más de una sesión.
    for ($i=4; $i <= $numSesiones + 3; $i++) {
        $hoja -> setCellValueByColumnAndRow($i, 8, "Asistencia  ".$arr_fechas[$i-4]);
    }
    // Definition: Se coloca el apartado de constancia.
    $hoja -> setCellValueByColumnAndRow($numSesiones + 4, 8, "Constancia");
    $hoja -> setCellValueByColumnAndRow($numSesiones + 5, 8, "Observaciones");

    //* Inicia la sección de datos.
    // Definition: El ciclo for se adapta al número de inscritos
    $k=9;
    $columnaObservaciones;
    foreach ($arr_Inscritos as $inscrito) {
        // Section: Columna de ID -> Nombre -> Correo
        $nombrePersona=$inscrito['nombre'];
        $correoPersona=$inscrito['pers_correo'];
        $hoja -> setCellValueByColumnAndRow(1, $k, $k-8);
        $hoja -> setCellValueByColumnAndRow(2, $k, $nombrePersona);
        $hoja -> setCellValueByColumnAndRow(3, $k, $correoPersona);


        // Section: Columna de asistencias
        foreach ($sesiones as $iCont => $sesion) {
            $countSesiones;
            $asistencia = $obj_Asistencia->buscarAsistenciaSesion($sesion['sesi_id_sesion'], $inscrito['insc_id_inscripcion']);
            if (isset($asistencia)) {
                if ($asistencia->asis_presente =='t') {
                    //? Si estuvo presente marcamos la casilla sino, se queda despintada
                    $documento->getActiveSheet()->getStyleByColumnAndRow($iCont+4, $k)->getFill()->setFillType(
                        \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
                    )->getStartColor()->setARGB('C9E4C5');
                    $countSesiones++;
                    // $documento->getActiveSheet()->getStyleByColumnAndRow($iCont+4, $k)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
                } else {
                    $documento->getActiveSheet()->getStyleByColumnAndRow($iCont+4, $k)->getFill()->setFillType(
                        \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
                    )->getStartColor()->setARGB('F54748');
                    // $documento->getActiveSheet()->getStyleByColumnAndRow($iCont+4, $k)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
                }
            }
        }

        // Section: Columna de constancias
        if ($countSesiones == $numSesiones) {
            $documento->getActiveSheet()->getStyleByColumnAndRow($iCont+5, $k)->getFill()->setFillType(
                \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
            )->getStartColor()->setARGB('C9E4C5');
                    // $documento->getActiveSheet()->getStyleByColumnAndRow($sesion['sesi_id_sesion']+5, $k)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        } else {
            $documento->getActiveSheet()->getStyleByColumnAndRow($iCont+5, $k)->getFill()->setFillType(
                \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
            )->getStartColor()->setARGB('F54748');
                    // $documento->getActiveSheet()->getStyleByColumnAndRow($sesion['sesi_id_sesion']+5, $k)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        }

        // Section: Columna de observaciones.
        $hoja -> setCellValueByColumnAndRow($iCont+6, $k, $inscrito['insc_observacion']);

        $k++;
        $countSesiones = 0;
    }


    $documento->getActiveSheet()->freezePane('D9', 'D9');
    ob_clean();
    $writer = new Xlsx($documento);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename=Lista_Asistencia_'.$curso->curs_tipo.'_'.$idGrupo.'.xlsx');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;
