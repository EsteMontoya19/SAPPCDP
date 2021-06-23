<?php
    include('../clases/BD.php');
    include('../clases/Grupo.php');
    include('../clases/Sesion.php');

    $idGrupo = $_GET['idGrupo'];
    $obj_Grupo = new Grupo();
    $arr_Inscritos = $obj_Grupo->buscarInscripcionesxGrupo($idGrupo);
    $curso = $obj_Grupo->buscarNombreCursoxGrupo($idGrupo);
    $profesor = $obj_Grupo->buscarGrupo($idGrupo);
    $obj_Sesion = new Sesion();
    $sesion = $obj_Sesion->numSesionesGrupo($idGrupo);
    $numSesiones = $sesion->numero;
    $arr_sesiones = $obj_Sesion->buscarFechaSesiones($idGrupo);

    $file = fopen("Mensajes.txt", "a");
    fwrite($file, "Sesiones: ".$numSesiones.PHP_EOL);
    fwrite($file, "Datos del GET: ".$profesor);
    fclose($file);

    // ? Variables para permitir conseguir la coordenada X de una celda en número.
    $numero = $numSesiones + 4;
    $letra= chr($numero+64);
    

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
    $hoja -> setCellValueByColumnAndRow(1,1, "Relación de participantes");
    $hoja -> setCellValueByColumnAndRow(2,3, 'Curso: '.$curso->curs_nombre);
    $hoja -> setCellValueByColumnAndRow(2,4, "Instructor: ");
    $hoja -> setCellValueByColumnAndRow(2,5, "Moderador: ");
    $hoja -> setCellValueByColumnAndRow(2,6, "Fecha de la primera sesión: ");

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
    $hoja -> getStyle("A1:".$letra."1") -> applyFromArray($styleArray);
    $hoja -> getStyle("A8:".$letra."8") -> applyFromArray($styleArray);
    
    $hoja -> mergeCells("A7:E7");
    $hoja -> setCellValueByColumnAndRow(1,8, "#");
    $hoja -> setCellValueByColumnAndRow(2,8, "Profesor");
    $hoja -> setCellValueByColumnAndRow(3,8, "Correo");
    
    // TODO: Se tiene que obtener el length de las sesiones para saber el límite del for -> length + 4
    for ($i=4; $i <= $numSesiones + 3  ; $i++) {
        // !Ver si funciona
        $hoja -> setCellValueByColumnAndRow($i,8, "Asistencia");
    }
    // TODO: Se tiene que adaptar a for de arriba en caso de ser más de una sesión.
    $hoja -> setCellValueByColumnAndRow($numSesiones + 4, 8, "Constancia");

    //* Inicia la sección de datos.
    // TODO: Se tiene que adaptar al número de inscritos.
    for ($i=9; $i <= 12 ; $i++) {
        $hoja -> setCellValueByColumnAndRow(1,$i, $i-8);
        $hoja -> setCellValueByColumnAndRow(2,$i, "Fuentes Aguilar Karen");
        $hoja -> setCellValueByColumnAndRow(3,$i, "laKarenMaestra@gmail.com");
    }
    $documento->getActiveSheet()->freezePane('D9','D9');
    ob_clean();
    $writer = new Xlsx($documento);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="Lista de Asistencia"');
    $writer->save('php://output');
    exit;  
?>