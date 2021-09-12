<?php
    require_once "../../recursos/Excel/vendor/autoload.php";
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use clases\Reporte;

    include('../../clases/BD.php');
    include('../../clases/Reporte.php');

    // Variables
    $objReporte = new Reporte();
    $fechaInicio= $_GET ['fechaDeInicio'];
    $fechaFin= $_GET ['fechaDeFin'];
    $arr_Profesores = $objReporte ->buscarCursosTomados($fechaInicio, $fechaFin);
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

    // Definition: Este arreglo tiene los estilos que se le dan a cada registro para darles formato
        $styleData = [
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ]
        ];

    // Section: Creación de la Spreadsheet.
        $documento = new Spreadsheet();
        $documento
        -> getProperties()
        -> setCreator('FCA UNAM');

    // Definition: Cambia el nombre de la hoja activa.
        $documento->getActiveSheet()->setTitle('Indicadores');
    // Section: Establecer los estilos de la hoja.
        $numeroDeRegistros = count($arr_Profesores)+1;
        $hojaIndicadores = $documento -> getActiveSheet();
        $hojaIndicadores ->getStyle('A1:F1')->applyFromArray($styleArray);
        $hojaIndicadores ->getStyle('A2:F'.$numeroDeRegistros)->applyFromArray($styleData);
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

    // Section: Agregar los datos.
        $k=0;
        foreach ($arr_Profesores as $registro) {
            // Variables
            $idGrupo = $registro['grup_id_grupo'];
            $idProfesor = $registro['prof_id_profesor'];
            $arr_Fechas_Periodos = $objReporte -> buscarFechaDeCursos($idGrupo);
            $arr_Modalidades_Profesor = $objReporte -> buscarModalidadesImpartidasPorProfesor($idProfesor);

            // Section: Datos de registro.
            $hojaIndicadores -> setCellValueByColumnAndRow(1, $k+2, $registro['nombre']);
            $hojaIndicadores -> setCellValueByColumnAndRow(2, $k+2, $registro['nomb_descripcion']);
            $hojaIndicadores -> setCellValueByColumnAndRow(4, $k+2, $registro['pers_sexo']);
            $hojaIndicadores -> setCellValueByColumnAndRow(5, $k+2, $registro['curs_nombre']);

            // Section: Datos de registro de la modalidad
            if (count($arr_Modalidades_Profesor)== 1) {
                $hojaIndicadores -> setCellValueByColumnAndRow(3, $k+2, $arr_Modalidades_Profesor[0]['moda_nombre']);
            } elseif (count($arr_Modalidades_Profesor) == 2) {
                // Variables
                $modalidad1= $arr_Modalidades_Profesor[0]['moda_nombre'];
                $modalidad2= $arr_Modalidades_Profesor[1]['moda_nombre'];
                $hojaIndicadores -> setCellValueByColumnAndRow(3, $k+2, $modalidad1.', '.$modalidad2);
            } elseif (count($arr_Modalidades_Profesor) == 2) {
                $modalidad1= $arr_Modalidades_Profesor[0]['moda_nombre'];
                $modalidad2= $arr_Modalidades_Profesor[1]['moda_nombre'];
                $modalidad3= $arr_Modalidades_Profesor[3]['moda_nombre'];
                $hojaIndicadores -> setCellValueByColumnAndRow(3, $k+2, $modalidad1.', '.$modalidad2.', '.$modalidad3);
            }

            // Section: Datos de registro del periodo
            // Definition: aquí comprobaremos cuatro puntos clave.
            //* Sólo tiene una sesión.
            if (sizeof($arr_Fechas_Periodos)==1) {
                // Variables
                $dia= $arr_Fechas_Periodos[0]['dia'];
                $mesNum = (integer) $arr_Fechas_Periodos[0]['mes'];
                $mes= $arr_meses[$mesNum-1];
                $anio= $arr_Fechas_Periodos[0]['anio'];

                $hojaIndicadores -> setCellValueByColumnAndRow(6, $k+2, $dia." de ".$mes.' del '.$anio);
            } elseif (sizeof($arr_Fechas_Periodos) > 1) {
                //* Tiene más de una sesión.
                // Variables
                $diaInicio= $arr_Fechas_Periodos[0]['dia'];
                $mesNumInicio = (integer) $arr_Fechas_Periodos[0]['mes'];
                $mesInicio= $arr_meses[$mesNum-1];
                $anioInicio= $arr_Fechas_Periodos[0]['anio'];

                $diaFin= $arr_Fechas_Periodos[1]['dia'];
                $mesNumFin = (integer) $arr_Fechas_Periodos[1]['mes'];
                $mesFin= $arr_meses[$mesNum-1];
                $anioFin= $arr_Fechas_Periodos[1]['anio'];

                if ($mesInicio == $mesFin) {
                    //* Ambas son el mismo mes
                    if ($diaFin == $diaInicio) {
                        $hojaIndicadores -> setCellValueByColumnAndRow(4, $k+2, $diaInicio." de ".$mesFin);
                    } else {
                        $hojaIndicadores ->
                        setCellValueByColumnAndRow(6, $k+2, "Del ".$diaInicio." al ".$diaFin." de ".$mesFin);
                    }
                } elseif ($mesInicio != $mesFin && $anioInicio == $anioFin) {
                    //* No son el mismo mes, pero si el mismo año
                    $hojaIndicadores ->
                    setCellValueByColumnAndRow(
                        6,
                        $k+2,
                        "Del ".$diaInicio." de ".$mesInicio." al ".$diaFin." de ".$mesFin
                    );
                } elseif ($anioInicio != $anioFin) {
                    //* No son del mismo mes y tampoco del mismo año.
                    $hojaIndicadores ->
                    setCellValueByColumnAndRow(
                        4,
                        $k+2,
                        "Del ".$diaInicio." de ".$mesInicio." del ".$anioInicio
                        ." al ".$diaFin." de ".$mesFin." del ".$anioFin
                    );
                }
            }
            $k++;
        }


    // Definition: esta línea sirve para dejar el cursor al inicio del primer nombre registrado.
        $documento->getActiveSheet()->setSelectedCell('A2');


        ob_clean();
        $writer = new Xlsx($documento);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Lista reconocimientos Moderadores e Instructores -12.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
