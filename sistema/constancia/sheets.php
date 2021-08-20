<?php
    include('../../clases/BD.php');
    include('../../clases/Grupo.php');
    include('../../clases/Asistencia.php');
    include('../../clases/Sesion.php');
    include('../../clases/Constancias.php');

    // Objetos
    $obj_Grupo = new Grupo();
    $obj_Sesion = new Sesion();
    $obj_Asistencia = new Asistencia();
    $obj_Constancia = new Constancias();
    
    // Inputs
    $fechaInicio =  $_POST["mesConstancia"];

    //? Se le da el formato a la fecha para restringir los periodos a un mes
    $fechaFin = substr($fechaInicio,-2);

    if($fechaFin == 12) {
        $fechaFin = substr($fechaInicio, 0, 4);
        $fechaFin += 1;
        $fechaFin = $fechaFin . "-01-01";
    } else {
        $fechaFin += 1;
        if ($fechaFin < 10) {
            $fechaFin = "0" . $fechaFin;
        }
        $fechaFin = substr($fechaInicio, 0 , 4) . "-" . $fechaFin;
        $fechaFin = $fechaFin . "-01";
    }
    $fechaInicio = $fechaInicio . "-01";

    
    $mensajes = fopen("Mensajes.txt" , "a");
    fwrite($mensajes, $fechaInicio.PHP_EOL);
    fwrite($mensajes, $fechaFin.PHP_EOL);
    fclose($mensajes);


    $instructores = $obj_Constancia->consultarConstanciaInstructores($fechaInicio, $fechaFin);
    $moderadores = $obj_Constancia->consultarConstanciaModeradores($fechaInicio, $fechaFin);

    require_once "../../recursos/Excel/vendor/autoload.php";
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    // Variables
    $arr_meses= array(
    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo',
    'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre',
    'Noviembre', 'Diciembre');


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
        $hojaProfesores ->getStyle('A1:I100')->applyFromArray($styleArray);
        $hojaProfesores -> getDefaultColumnDimension()->setWidth(30, 'cm');
        $hojaProfesores -> getColumnDimension('C')->setWidth(60, 'cm');
        $hojaProfesores -> getColumnDimension('H')->setWidth(60, 'cm');
        $hojaProfesores -> setTitle("Profesores");
    // Section: Agregar títulos de las columnas de Instructores.
        $hojaProfesores -> setCellValueByColumnAndRow(1, 1, "Nombre");
        $hojaProfesores -> setCellValueByColumnAndRow(2, 1, "Evento");
        $hojaProfesores -> setCellValueByColumnAndRow(3, 1, "Texto");
        $hojaProfesores -> setCellValueByColumnAndRow(4, 1, "Periodo");
        $hojaProfesores -> setCellValueByColumnAndRow(5, 1, "Fecha de firma");
        $hojaProfesores -> setCellValueByColumnAndRow(6, 1, "Duración");
        $hojaProfesores -> setCellValueByColumnAndRow(7, 1, "Horas Acreditadas");
        $hojaProfesores -> setCellValueByColumnAndRow(8, 1, "Firmante");
        $hojaProfesores -> setCellValueByColumnAndRow(9, 1, "Puesto");

    // Section: Agregar los datos.
        $k=0;
        foreach ($instructores as $instructor) {
            // Variables
            $arr_periodo_del_curso= $obj_Sesion -> buscarMinAndMaxSesion($instructor['grup_id_grupo']);
            $horasTotalesString = $obj_Sesion -> horasTotales($instructor['grup_id_grupo']);
            $horasTotales = substr($horasTotalesString->horas, 0, 2);
            $horasTotales = (int) $horasTotales;

            $diaInicio = $arr_periodo_del_curso[0]['dia'];
            $mesInicioString = $arr_periodo_del_curso[0]['mes'];
            $mesInicioNum= (integer) $mesInicioString;
            $mesInicio= $arr_meses[$mesInicioNum-1];
            $anioInicio= $arr_periodo_del_curso[0]['anio'];

            $diaFin =$arr_periodo_del_curso[sizeof($arr_periodo_del_curso)-1]['dia'];
            $mesFinNum = (integer) $arr_periodo_del_curso[0]['mes']-1;
            $mesFin = $arr_meses[$mesFinNum];
            $anioFin= $arr_periodo_del_curso[sizeof($arr_periodo_del_curso)-1]['anio'];
            $nombrePersona = $instructor['nombre_instructor'];


            // Section: Datos
            $hojaProfesores -> setCellValueByColumnAndRow(1, $k+2, $nombrePersona);
            $hojaProfesores -> setCellValueByColumnAndRow(2, $k+2, $instructor['curs_tipo'].' '.'"'.$instructor['curs_nombre'].'"');

            // Definition aquí comprobaremos cuatro puntos clave.
            if (sizeof($arr_periodo_del_curso)==1) {
                //* Sólo tiene una sesión.
                if ($horasTotales > 1) {
                    $hojaProfesores -> setCellValueByColumnAndRow(3, $k+2, "Por haber impartido el ".$instructor['curs_tipo']." de ".$instructor['curs_nombre']." en el marco del Programa Permanente de Capacitación a Distancia para Profesores de la FCA, impartido el ".$diaInicio." de ".$mesFin." con una duración de ".$horasTotales.' '."horas.");
                } else {
                    $hojaProfesores -> setCellValueByColumnAndRow(3, $k+2, "Por haber impartido el ".$instructor['curs_tipo']." de ".$instructor['curs_nombre']." en el marco del Programa Permanente de Capacitación a Distancia para Profesores de la FCA, impartido el ".$diaInicio." de ".$mesFin." con una duración de ".$horasTotales.' '."hora.");
                }
                $hojaProfesores -> setCellValueByColumnAndRow(4, $k+2, $diaInicio." de ".$mesFin);
            } elseif (sizeof($arr_periodo_del_curso) > 1 && $mesInicio==$mesFin) {
                //* Tiene más de una sesión y ambas son el mismo mes.
                $hojaProfesores -> setCellValueByColumnAndRow(3, $k+2, "Por haber impartido el ".$instructor['curs_tipo']." de ".$instructor['curs_nombre']." en el marco del Programa Permanente de Capacitación a Distancia para Profesores de la FCA, impartido del ".$diaInicio." al ".$diaFin." de ".$mesFin." con una duración de ".$horasTotales.' '."horas.");
                if ($diaFin == $diaInicio) {
                    $hojaProfesores -> setCellValueByColumnAndRow(4, $k+2, $diaInicio." de ".$mesFin);
                } else {
                    $hojaProfesores -> setCellValueByColumnAndRow(4, $k+2, "Del ".$diaInicio." al ".$diaFin." de ".$mesFin);
                }
            } elseif (sizeof($arr_periodo_del_curso) >1 && $mesInicio != $mesFin && $anioInicio == $anioFin) {
                //* Tiene más de una sesión y no son el mismo mes.
                $hojaProfesores -> setCellValueByColumnAndRow(3, $k+2, "Por haber impartido el ".$instructor['curs_tipo']." de ".$instructor['curs_nombre']." en el marco del Programa Permanente de Capacitación a Distancia para Profesores de la FCA, impartido del ".$diaInicio." de ".$mesInicio." al ".$diaFin." de ".$mesFin." con una duración de ".$horasTotales.' '."horas.");
                $hojaProfesores -> setCellValueByColumnAndRow(4, $k+2, "Del ".$diaInicio." de ".$mesInicio." al ".$diaFin." de ".$mesFin);
            } elseif (sizeof($arr_periodo_del_curso) >1 && $anioInicio != $anioFin) {
                //* No es el mismo año.
                $hojaProfesores -> setCellValueByColumnAndRow(3, $k+2, "Por haber impartido el ".$instructor['curs_tipo']." de ".$instructor['curs_nombre']." en el marco del Programa Permanente de Capacitación a Distancia para Profesores de la FCA, impartido del ".$diaInicio." de ".$mesInicio." del ".$anioInicio." al ".$diaFin." de ".$mesFin." del ".$anioFin." con una duración de ".$horasTotales.' '."horas.");
                $hojaProfesores -> setCellValueByColumnAndRow(4, $k+2, "Del ".$diaInicio." de ".$mesInicio." del ".$anioInicio." al ".$diaFin." de ".$mesFin."del".$anioFin);
            }

            $hojaProfesores -> setCellValueByColumnAndRow(5, $k+2, $mesFin." del ".$anioFin);
            if ($horasTotales > 1) {
                $hojaProfesores -> setCellValueByColumnAndRow(6, $k+2, $horasTotales.' horas');
            } else {
                $hojaProfesores -> setCellValueByColumnAndRow(6, $k+2, $horasTotales.' hora');
            }
            $hojaProfesores -> setCellValueByColumnAndRow(7, $k+2, "");
            $hojaProfesores -> setCellValueByColumnAndRow(8, $k+2, "Mtro. Tomás Humberto Rubio Pérez");
            $hojaProfesores -> setCellValueByColumnAndRow(9, $k+2, "Director");
            $k++;
        }




        $documento->setActiveSheetIndex(1);
        // Definition: Cambia el nombre de la hoja activa.
        $documento->getActiveSheet()->setTitle('Monitores');
        $documento->getActiveSheet()->setCellValue('A1', 'Moderadores');
        $hojaMonitores = $documento -> setActiveSheetIndex(1);
        $hojaMonitores ->getStyle('A1:I100')->applyFromArray($styleArray);
        $hojaMonitores -> getDefaultColumnDimension()->setWidth(30, 'cm');
        $hojaMonitores -> getColumnDimension('C')->setWidth(60, 'cm');
        $hojaMonitores -> getColumnDimension('H')->setWidth(60, 'cm');

        // Section: Agregar títulos de las columnas de Moderadores.
        $hojaMonitores -> setCellValueByColumnAndRow(1, 1, "Nombre");
        $hojaMonitores -> setCellValueByColumnAndRow(2, 1, "Evento");
        $hojaMonitores -> setCellValueByColumnAndRow(3, 1, "Texto");
        $hojaMonitores -> setCellValueByColumnAndRow(4, 1, "Periodo");
        $hojaMonitores -> setCellValueByColumnAndRow(5, 1, "Fecha de firma");
        $hojaMonitores -> setCellValueByColumnAndRow(6, 1, "Duración");
        $hojaMonitores -> setCellValueByColumnAndRow(7, 1, "Horas Acreditadas");
        $hojaMonitores -> setCellValueByColumnAndRow(8, 1, "Firmante");
        $hojaMonitores -> setCellValueByColumnAndRow(9, 1, "Puesto");

        // Section: Agregar los datos.
        $k=0;
        foreach ($moderadores as $instructor) {
            // Variables
            $arr_periodo_del_curso= $obj_Sesion -> buscarMinAndMaxSesion($instructor['grup_id_grupo']);
            $horasTotalesString = $obj_Sesion -> horasTotales($instructor['grup_id_grupo']);
            $horasTotales = substr($horasTotalesString->horas, 0, 2);
            $horasTotales = (int) $horasTotales;

            $diaInicio = $arr_periodo_del_curso[0]['dia'];
            $mesInicioString = $arr_periodo_del_curso[0]['mes'];
            $mesInicioNum= (integer) $mesInicioString;
            $mesInicio= $arr_meses[$mesInicioNum-1];
            $anioInicio= $arr_periodo_del_curso[0]['anio'];

            $diaFin =$arr_periodo_del_curso[sizeof($arr_periodo_del_curso)-1]['dia'];
            $mesFinNum = (integer) $arr_periodo_del_curso[0]['mes']-1;
            $mesFin = $arr_meses[$mesFinNum];
            $anioFin= $arr_periodo_del_curso[sizeof($arr_periodo_del_curso)-1]['anio'];
            $nombrePersona = $instructor['nombre_instructor'];


            // Section: Datos
            $hojaMonitores -> setCellValueByColumnAndRow(1, $k+2, $nombrePersona);
            $hojaMonitores -> setCellValueByColumnAndRow(2, $k+2, $instructor['curs_tipo'].' '.'"'.$instructor['curs_nombre'].'"');

            // Definition aquí comprobaremos cuatro puntos clave.
            if (sizeof($arr_periodo_del_curso)==1) {
                //* Sólo tiene una sesión.
                if ($horasTotales > 1) {
                    $hojaMonitores -> setCellValueByColumnAndRow(3, $k+2, "Por haber impartido el ".$instructor['curs_tipo']." de ".$instructor['curs_nombre']." en el marco del Programa Permanente de Capacitación a Distancia para Profesores de la FCA, impartido el ".$diaInicio." de ".$mesFin." con una duración de ".$horasTotales.' '."horas.");
                } else {
                    $hojaMonitores -> setCellValueByColumnAndRow(3, $k+2, "Por haber impartido el ".$instructor['curs_tipo']." de ".$instructor['curs_nombre']." en el marco del Programa Permanente de Capacitación a Distancia para Profesores de la FCA, impartido el ".$diaInicio." de ".$mesFin." con una duración de ".$horasTotales.' '."hora.");
                }
                $hojaMonitores -> setCellValueByColumnAndRow(4, $k+2, $diaInicio." de ".$mesFin);
            } elseif (sizeof($arr_periodo_del_curso) > 1 && $mesInicio==$mesFin) {
                //* Tiene más de una sesión y ambas son el mismo mes.
                $hojaMonitores -> setCellValueByColumnAndRow(3, $k+2, "Por haber impartido el ".$instructor['curs_tipo']." de ".$instructor['curs_nombre']." en el marco del Programa Permanente de Capacitación a Distancia para Profesores de la FCA, impartido del ".$diaInicio." al ".$diaFin." de ".$mesFin." con una duración de ".$horasTotales.' '."horas.");
                if ($diaFin == $diaInicio) {
                    $hojaMonitores -> setCellValueByColumnAndRow(4, $k+2, $diaInicio." de ".$mesFin);
                } else {
                    $hojaMonitores -> setCellValueByColumnAndRow(4, $k+2, "Del ".$diaInicio." al ".$diaFin." de ".$mesFin);
                }
            } elseif (sizeof($arr_periodo_del_curso) >1 && $mesInicio != $mesFin && $anioInicio == $anioFin) {
                //* Tiene más de una sesión y no son el mismo mes.
                $hojaMonitores -> setCellValueByColumnAndRow(3, $k+2, "Por haber impartido el ".$instructor['curs_tipo']." de ".$instructor['curs_nombre']." en el marco del Programa Permanente de Capacitación a Distancia para Profesores de la FCA, impartido del ".$diaInicio." de ".$mesInicio." al ".$diaFin." de ".$mesFin." con una duración de ".$horasTotales.' '."horas.");
                $hojaMonitores -> setCellValueByColumnAndRow(4, $k+2, "Del ".$diaInicio." de ".$mesInicio." al ".$diaFin." de ".$mesFin);
            } elseif (sizeof($arr_periodo_del_curso) >1 && $anioInicio != $anioFin) {
                //* No es el mismo año.
                $hojaMonitores -> setCellValueByColumnAndRow(3, $k+2, "Por haber impartido el ".$instructor['curs_tipo']." de ".$instructor['curs_nombre']." en el marco del Programa Permanente de Capacitación a Distancia para Profesores de la FCA, impartido del ".$diaInicio." de ".$mesInicio." del ".$anioInicio." al ".$diaFin." de ".$mesFin." del ".$anioFin." con una duración de ".$horasTotales.' '."horas.");
                $hojaMonitores -> setCellValueByColumnAndRow(4, $k+2, "Del ".$diaInicio." de ".$mesInicio." del ".$anioInicio." al ".$diaFin." de ".$mesFin."del".$anioFin);
            }

            $hojaMonitores -> setCellValueByColumnAndRow(5, $k+2, $mesFin." del ".$anioFin);
            if ($horasTotales > 1) {
                $hojaMonitores -> setCellValueByColumnAndRow(6, $k+2, $horasTotales.' horas');
            } else {
                $hojaMonitores -> setCellValueByColumnAndRow(6, $k+2, $horasTotales.' hora');
            }
            $hojaMonitores -> setCellValueByColumnAndRow(7, $k+2, "");
            $hojaMonitores -> setCellValueByColumnAndRow(8, $k+2, "Mtro. Tomás Humberto Rubio Pérez");
            $hojaMonitores -> setCellValueByColumnAndRow(9, $k+2, "Director");
            $k++;
        }

    // Definition: esta línea sirve para dejar el cursor al inicio del primer nombre registrado.
        $documento->setActiveSheetIndex(0)->setSelectedCell('A2');
        $hojaMonitores->setSelectedCell('A2');


        ob_clean();
        $writer = new Xlsx($documento);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Lista reconocimientos Moderadores e Insctructores".xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
