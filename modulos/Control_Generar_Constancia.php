<?php
    require_once "../recursos/Excel/vendor/autoload.php";
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    include('../clases/BD.php');
    include('../clases/Grupo.php');
    include('../clases/Sesion.php');

    // Variables
    $arr_meses= array(
        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo',
        'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre',
        'Noviembre', 'Diciembre');
    $idGrupo = $_GET['idGrupo'];
    $obj_Grupo = new Grupo();
    $obj_Sesion = new Sesion();

    // Objetos
    $curso = $obj_Grupo->buscarNombreCursoxGrupo($idGrupo);
    $arr_inscritos = $obj_Grupo->buscarAcreedorConstancia($idGrupo);
    $arr_periodo_del_curso= $obj_Sesion -> buscarMinAndMaxSesion($idGrupo);
    $horasTotalesString = $obj_Sesion -> horasTotales($idGrupo);

    // Definition: Este arreglo tiene los estilos que se le dan a cada celda para que permanezcan centrados
    $styleArray = [
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

    // Section: Personalización del archivo
    $hoja = $documento -> getActiveSheet();
    $hoja ->getStyle('A1:I100')->applyFromArray($styleArray);
    $hoja -> getDefaultColumnDimension()->setWidth(30, 'cm');
    $hoja -> getColumnDimension('C')->setWidth(60, 'cm');
    $hoja -> getColumnDimension('H')->setWidth(60, 'cm');
    $hoja -> setTitle("Constancias ".$curso->curs_tipo.' '.$idGrupo);


    //? Esta parte escribe dentro de cada celda, con las cordenadas [A: Columna ,1: Fila]
    // Section: Títulos de la hoja.
    $hoja -> setCellValueByColumnAndRow(1, 1, "Nombre completo");
    $hoja -> setCellValueByColumnAndRow(2, 1, "Evento");
    $hoja -> setCellValueByColumnAndRow(3, 1, "Texto");
    $hoja -> setCellValueByColumnAndRow(4, 1, "Periodo");
    $hoja -> setCellValueByColumnAndRow(5, 1, "Fecha de firma");
    $hoja -> setCellValueByColumnAndRow(6, 1, "Duración");
    $hoja -> setCellValueByColumnAndRow(7, 1, "Horas acreeditadas");
    $hoja -> setCellValueByColumnAndRow(8, 1, "Firmante");
    $hoja -> setCellValueByColumnAndRow(9, 1, "Puesto");

    // Definition: Convertimos las horas de un tipo String a un Int.
    //! Esta es una solución en fase de prueba.
    $horasTotales = substr($horasTotalesString->horas, 0, 2);
    $horasTotales = (int) $horasTotales;

    $k=0;
    foreach ($arr_inscritos as $inscrito) {
        // Variables
        $nombrePersona=$inscrito['nombre'];

        $diaInicio = $arr_periodo_del_curso[0]['dia'];
        $mesInicioString = $arr_periodo_del_curso[0]['mes'];
        $mesInicioNum= (integer) $mesInicioString;
        $mesInicio= $arr_meses[$mesInicioNum-1];
        $anioInicio= $arr_periodo_del_curso[0]['anio'];

        $diaFin =$arr_periodo_del_curso[sizeof($arr_periodo_del_curso)-1]['dia'];
        $mesFinNum = (integer) $arr_periodo_del_curso[0]['mes']-1;
        $mesFin = $arr_meses[$mesFinNum];
        $anioFin= $arr_periodo_del_curso[sizeof($arr_periodo_del_curso)-1]['anio'];


        // Section: Datos de la hoja.
        $hoja -> setCellValueByColumnAndRow(1, $k+2, $nombrePersona);
        $hoja -> setCellValueByColumnAndRow(2, $k+2, $curso->curs_tipo." "."\"".$curso->curs_nombre."\"");


        // Definition aquí comprobaremos cuatro puntos clave.
        if (sizeof($arr_periodo_del_curso)==1) {
            //* Sólo tiene una sesión.
            if ($horasTotales > 1) {
                $hoja -> setCellValueByColumnAndRow(3, $k+2, "Por su participación en el ".$curso->curs_tipo." en línea "."\"".$curso->curs_nombre."\""." en el marco del Programa Permanente de Capacitación a Distancia para Profesores de la FCA, impartido el ".$diaInicio." de ".$mesFin." con una duración de ".$horasTotales.' '."horas.");
            } else {
                $hoja -> setCellValueByColumnAndRow(3, $k+2, "Por su participación en el ".$curso->curs_tipo." en línea "."\"".$curso->curs_nombre."\""." en el marco del Programa Permanente de Capacitación a Distancia para Profesores de la FCA, impartido el ".$diaInicio." de ".$mesFin." con una duración de ".$horasTotales.' '."hora.");
            }
            $hoja -> setCellValueByColumnAndRow(4, $k+2, $diaInicio." de ".$mesFin);
        } elseif (sizeof($arr_periodo_del_curso) > 1 && $mesInicio==$mesFin) {
            //* Tiene más de una sesión y ambas son el mismo mes.
            $hoja -> setCellValueByColumnAndRow(3, $k+2, "Por su participación en el ".$curso->curs_tipo." en línea "."\"".$curso->curs_nombre."\""." en el marco del Programa Permanente de Capacitación a Distancia para Profesores de la FCA, impartido del ".$diaInicio." al ".$diaFin." de ".$mesFin." con una duración de ".$horasTotales.' '."horas.");
            $hoja -> setCellValueByColumnAndRow(4, $k+2, "Del ".$diaInicio." al ".$diaFin." de ".$mesFin);
        } elseif (sizeof($arr_periodo_del_curso) >1 && $mesInicio != $mesFin && $anioInicio == $anioFin) {
            //* Tiene más de una sesión y no son el mismo mes.
            $hoja -> setCellValueByColumnAndRow(3, $k+2, "Por su participación en el ".$curso->curs_tipo." en línea "."\"".$curso->curs_nombre."\""." en el marco del Programa Permanente de Capacitación a Distancia para Profesores de la FCA, impartido del ".$diaInicio." de ".$mesInicio." al ".$diaFin." de ".$mesFin." con una duración de ".$horasTotales.' '."horas.");
            $hoja -> setCellValueByColumnAndRow(4, $k+2, "Del ".$diaInicio." de ".$mesInicio." al ".$diaFin." de ".$mesFin);
        } elseif (sizeof($arr_periodo_del_curso) >1 && $anioInicio != $anioFin) {
            //* No es el mismo año.
            $hoja -> setCellValueByColumnAndRow(3, $k+2, "Por su participación en el ".$curso->curs_tipo." en línea "."\"".$curso->curs_nombre."\""." en el marco del Programa Permanente de Capacitación a Distancia para Profesores de la FCA, impartido del ".$diaInicio." de ".$mesInicio." del ".$anioInicio." al ".$diaFin." de ".$mesFin." del ".$anioFin." con una duración de ".$horasTotales.' '."horas.");
            $hoja -> setCellValueByColumnAndRow(4, $k+2, "Del ".$diaInicio." de ".$mesInicio." del ".$anioInicio." al ".$diaFin." de ".$mesFin."del".$anioFin);
        }

        $hoja -> setCellValueByColumnAndRow(5, $k+2, $mesFin." del ".$anioFin);
        $hoja -> setCellValueByColumnAndRow(6, $k+2, $horasTotales.' horas');
        $hoja -> setCellValueByColumnAndRow(7, $k+2, "");
        $hoja -> setCellValueByColumnAndRow(8, $k+2, "Mtro. Tomás Humberto Rubio Pérez");
        $hoja -> setCellValueByColumnAndRow(9, $k+2, "Director");
        $k++;
    }

    // Definition: esta línea sirve para dejar el cursor al inicio del primer nombre registrado.
    $documento->getActiveSheet()->setSelectedCell('A2');

    // Section: Configuración para poder crear el Excel a un documento .xlsx como tal
    ob_clean();
    $writer = new Xlsx($documento);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename=Constancias_'.$curso->curs_tipo.'_'.$idGrupo.'.xlsx');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;
