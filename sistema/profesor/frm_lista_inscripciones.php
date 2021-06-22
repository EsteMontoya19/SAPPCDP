<?php
    // Clases
    include('../clases/BD.php');
    include('../clases/Grupo.php');
    include('../clases/Sesion.php');
    include('../clases/PDF.php');

    // Inicializamos las variables requeridas
    //? Solo recibe el ID del grupo
    $idGrupo = $_POST['idGrupo'];
    $obj_Grupo = new Grupo();
    $arr_Inscritos = $obj_Grupo->buscarInscripcionesxGrupo($idGrupo);
    $curso = $obj_Grupo->buscarNombreCursoxGrupo($idGrupo);
    $obj_Sesion = new Sesion();
    $sesion = $obj_Sesion->numSesionesGrupo($idGrupo);
    $numSesiones = $sesion->numero;
    $arr_sesiones = $obj_Sesion->buscarFechaSesiones($idGrupo);

    //Se almacena el Titulo de la Lista
    $nombreCurso = 'ID del Grupo: '.$idGrupo.'   Nombre del Curso: '.$curso->curs_nombre.'    Núm. Sesiones: '.$numSesiones;

    //Titulo de la Pagina y metodos requeridos de la instancia PDF
    $pdf = new PDF(); 
    $pdf->AddPage('C', 'letter', 0); // Añade paginas Orientación: vertical 'P' u horizontal 'L', tamaño de papel (Legal, letter, etc), rotar pagina con SOLO multiplos de 90° positivos o negativos. Rota con todo y texto
    $pdf->AliasNbPages();
    $pdf->SetFont('Arial','B',14); //Tipo de letra, Estilo ('B', 'I', 'U' o '') y Tamaño en puntos defecto 12. Obligatorio al menos una vez antes de invocar por primera vez el metodo Cell
    $pdf->Cell(256,12,utf8_decode($nombreCurso),0,1,'C'); //ancho, alto, Texto, Borde 0 o 1 o 'L','R','B','T' o combinación, Salto de Linea (1 siguiente), alineación (L, R, C), color (TRUE o FALSE) función

    /*Creamos banderas 
        $numeroUno almacena el numero de ciclos que debe dar, si el número de sesiones es menor p igual a 10 será un unico ciclo.
        $numeroDos numero de sesiones que restan para el ultimo o unico ciclo de 1 a 10
        $numeroTres almacena el número 10, para indicar cuando un grupo tiene más de 10 sesiones
    */
    //Si el modulo(% residuo) difiere de 0
    if(fmod($numSesiones,10.0) != 0){
        $numeroUno = intdiv($numSesiones,10)+1;
        $numeroDos = $numSesiones-(($numeroUno-1)*10);
        if($numSesiones>10){
            $numeroTres=10;
        } 
    } else {
        $numeroUno = $numSesiones/10;
        $numeroTres = 10;
    }

    $pdf->SetFont('Arial','B',12);
    
    //Se inicializa el contador en 0. Servirá para indicar el lugar en el que se guardará una consulta
    $i=0; 
    //Se pasa el arreglo de la consulta sql a un arreglo númerico. Ya que el KEY númerico en este caso es más facil de consultar
    foreach ($arr_sesiones as $sesion) {
        $arr_fechas[$i] = $sesion['fecha'];
        $i++; 
    }

    //Se inicializa el contador en 0.
    $j=0; 
    /*  La función imprimirFecha, imprime el valor del $arreglo en el lugar $j
        $contador inicializa el contador del for
        $pdf es la instancia que estamos ocupando para imprimir el PDF
        Devuelve $j para conocer el lugar siguiente del arreglo por si existe un siguiente ciclo y continúe en ese lugar.*/
    function imprimirFecha($contador, $arreglo, $j, $pdf){
        for($i=$contador; $i>0; $i--){
            $pdf->Cell(13,5,$arreglo[$j],1,0,'L');
            $j++;
        }
        return $j;
    }
    /*  La función imprimirFecha, imprime celdas vacias
        $contador inicializa el contador del for
        $pdf es la instancia que estamos ocupando para imprimir el PDF */
    function imprimirColumnasFecha($contador, $pdf){
        for($i=$contador; $i>0; $i--){
            $pdf->Cell(13,5,'',1,0,'L');
        }
    }

    //Se inicializa el contador en 0.
    $h=0;
    // Recorre el número de ciclos necesarios
    for($i=$numeroUno; $i>0; $i--){

        // Se cambia el valor de la bandera de acuerdo al npumero de sesiones que requiere el ciclo
        if($i==1 AND $numSesiones>=10) {
            $numeroTres = $numeroDos;
        } elseif($i>1) {
            $numeroTres = 10;
        } elseif($i==1) {
            $numeroTres = $numeroDos;
        }

        // Se imprime el encabezado de la tabla
        $pdf->Cell(128,5,'Nombre Completo',1,0,'L');
        $h = imprimirFecha($numeroTres, $arr_fechas, $h, $pdf);

        $pdf->Ln(5);

        // Se imprime el cuerpo de la tabla
        foreach($arr_Inscritos as $inscrito){
            $nombreCompleto=$inscrito['pers_apellido_paterno'].' '.$inscrito['pers_apellido_materno'].' '.$inscrito['pers_nombre'];
            $pdf->Cell(128,5,$nombreCompleto,1,0,'L');
            imprimirColumnasFecha($numeroTres, $pdf);
            $pdf->Ln(5);
        }

        //Se añade una pagina. En el ultimo recorrido, se ignora.
        if($i!=1){
            $pdf->AddPage('C', 'letter', 0);
        }
    }

    $pdf->Ln(5);

    // Se almacena el nombre de descarga del pdf
    //TODO Verificar si este puede ser el nombre del pdf
    $nombre = str_replace(' ', '', $curso->curs_nombre);
    $nombreCursoPDF = $nombre.$curso->curs_nivel.$curso->curs_tipo;
    
    $pdf->Output('I', utf8_decode($nombreCursoPDF).'.pdf'); //Salida para imprimir, Destino ('I' navegador, 'D' descarga, 'F' descargar en fichero local, 'S' enviar el documento por una cadena de caracteres ), el siguiente parametro es el nombre, Con I y D si hay codificación del segundo parametro de ISO-8859 

?>