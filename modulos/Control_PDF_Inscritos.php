<?php
    // Clases
    include('../clases/BD.php');
    include('../clases/Grupo.php');
    include('../clases/Sesion.php');
    include('../clases/Moderador.php');
    include('../clases/Profesor.php');
    include('../clases/Plataforma.php');
    include('../clases/Busqueda.php');
    include('../clases/PDF_horizontal.php');
    include('../clases/Personal_Grupo.php');
    include('../clases/Asistencia.php');

    // Inicializamos las variables requeridas
    //? Solo recibe el ID del grupo
    $idGrupo = $_GET['idGrupo'];

    $obj_Grupo = new Grupo();
    $obj_Sesion = new Sesion();
    $obj_Moderador = new Moderador();
    $obj_Profesor = new Profesor();
    $obj_Plataforma = new Plataforma();
    $obj_Busqueda = new Busqueda();
    $obj_Personal = new Personal_Grupo();
    $obj_Asistencia = new Asistencia();

    /*
        Se obtienen los siguintes datos de cada inscrito:
            insc_id_inscripcion,
            pers_apellido_paterno, pers_apellido_materno, pers_nombre,
            pers_correo,
            insc_aprobado
    */
    $arr_Inscritos = $obj_Grupo->buscarInscripcionesxGrupo($idGrupo);
    /*
        Se obtienen los siguintes datos de cada sesión:
            día
            mes
    */
    $arr_sesiones = $obj_Sesion->buscarDiaMesSesiones($idGrupo);
    /*
        Se obtiene los siguientes datos de un grupo:
            curs_nombre, curs_nivel, esta_id_estado, curs_tipo,
            P.usua_id_usuario,
            plat_id_plataforma, salo_id_salon,
            M.moap_id_modalidad, moap_nombre,
            id_moderador
    */
    $curso = $obj_Grupo->buscarNombreCursoxGrupo($idGrupo);
    /*
        Se obtiene los siguientes datos de una sesion:
            numero
    */
    $sesion = $obj_Sesion->numSesionesGrupo($idGrupo);
    // Se asigna el dato numero a una variable
    $numSesiones = $sesion->numero;

    /*
        Se "arma" el texto del grupo:
            ID del grupo, Nombre del curso, Número de sesiones
    */
    $id_Grupo='ID del Grupo: '.$idGrupo;
    $nombreCurso = 'Nombre del Curso: '.$curso->curs_nombre;
    $sesiones = 'Núm. Sesiones: '.$numSesiones;
    /*
        Se obtienen los siguintes datos de un instructor o moderador:
            g.usua_id_usuario, u.pers_id_persona,
            pers_nombre, pers_apellido_paterno, pers_apellido_materno
    */
    $instructor = $obj_Personal->buscarPersonal($idGrupo, 2);
    $moderador = $obj_Personal->buscarPersonal($idGrupo, 3);
    /*
        Se "arma" el texto del grupo:
            instructor
    */
    $nombreInstructor='Instructor: '.$instructor->pers_nombre.' '.$instructor->pers_apellido_paterno.' '.$instructor->pers_apellido_materno;
    /*
        Se "arma" el texto del grupo si hay un moderador:
            instructor
    */
if (isset($moderador)) {
    $nombreModerador='Moderador: '.$moderador->pers_nombre.' '.$moderador->pers_apellido_paterno.' '.$moderador->pers_apellido_materno;
} else {
    $nombreModerador='Moderador: Sin moderador';
}
    /*
        Se obtienen los datos de la modalidad
            1. Edificio y Salon
            2. Plataforma
            3. Plataforma Externa
        Se "arma" el texto del grupo:
            Lugar
            nombre de la modalidad
    */
if ($curso->moap_id_modalidad == 1) {
    $modalidad = $obj_Grupo->buscarDatosPresencial($idGrupo);
    $nombreLugar = 'Edificio: '.$modalidad->edif_nombre.'     Salon: '.$modalidad->salo_nombre;
    $modalidadNombre = 'Modalidad: Presencial';
} elseif ($curso->moap_id_modalidad == 2) {
    $modalidad = $obj_Grupo->buscarDatosEnLinea($idGrupo);
    $nombreLugar = 'Plataforma: '.$modalidad->plat_nombre;
    $modalidadNombre = 'Modalidad: En línea';
} elseif ($curso->moap_id_modalidad == 3) {
    $modalidad = $obj_Grupo->buscarDatosAutogestivo($idGrupo);
    $nombreLugar = 'Plataforma externa: '.$modalidad->grup_url;
    $modalidadNombre = 'Modalidad: Autogestivo';
}
    
    //Titulo de la Pagina y metodos requeridos de la instancia PDF
    $pdf = new PDF();
    $pdf->AddPage('C', 'letter', 0); // Añade paginas Orientación: vertical 'P' u horizontal 'L', tamaño de papel (Legal, letter, etc), rotar pagina con SOLO multiplos de 90° positivos o negativos. Rota con todo y texto
    $pdf->AliasNbPages();
    $pdf->SetFont('Arial', 'B', 12); //Tipo de letra, Estilo ('B', 'I', 'U' o '') y Tamaño en puntos defecto 12. Obligatorio al menos una vez antes de invocar por primera vez el metodo Cell
    //Datos del grupo
    /*
        Se imprimen los datos del grupo:
            ID del grupo, Nombre del curso, Número de sesiones
            Instructor, Moderador
            Modalidad y Lugar
    */
    $pdf->Cell(256, 6, utf8_decode($id_Grupo), 0, 1, 'L'); //ancho, alto, Texto, Borde 0 o 1 o 'L','R','B','T' o combinación, Salto de Linea (1 siguiente), alineación (L, R, C), color (TRUE o FALSE) función
    $pdf->Cell(256, 6, utf8_decode($nombreCurso), 0, 1, 'L');
    $pdf->Cell(256, 6, utf8_decode($sesiones), 0, 1, 'L');
    $pdf->Cell(256, 6, utf8_decode($nombreInstructor), 0, 1, 'L');
    $pdf->Cell(256, 6, utf8_decode($nombreModerador), 0, 1, 'L');
    $pdf->Cell(256, 6, utf8_decode($modalidadNombre), 0, 1, 'L');
    $pdf->Cell(256, 6, utf8_decode($nombreLugar), 0, 1, 'L');
    // Salto de Linea
    $pdf->Ln(10);

    /*Creamos banderas
        $numeroUno almacena el numero de ciclos que debe dar, si el número de sesiones es menor p igual a 10 será un unico ciclo.
        $numeroDos numero de sesiones que restan para el ultimo o unico ciclo de 1 a 10
        $numeroTres almacena el número 10, para indicar cuando un grupo tiene más de 10 sesiones
    */
    //Si el modulo(% residuo) difiere de 0
if (fmod($numSesiones, 3.0) != 0) {
    $numeroUno = ((int)($numSesiones / 3))+1;
    $numeroDos = $numSesiones-(($numeroUno-1)*3);
    if ($numSesiones>3) {
        $numeroTres=3;
    }
} else {
    $numeroUno = $numSesiones/3;
    $numeroDos = $numSesiones-(($numeroUno-1)*3);
    $numeroTres = 3;
}

    //Se inicializa el contador en 0. Servirá para indicar el lugar en el que se guardará una consulta
    $i=0;
    //Se pasa el arreglo de la consulta sql a un arreglo númerico. Ya que el KEY númerico en este caso es más facil de consultar
foreach ($arr_sesiones as $sesion) {
    $arr_fechas[$i] = $sesion['dia'].'-'.$sesion['mes'];
    $i++;
}
    /*  La función imprimirFecha, imprime el valor del $arreglo en el lugar $j
        $contador inicializa el contador del for
        $pdf es la instancia que estamos ocupando para imprimir el PDF
        Devuelve $j para conocer el lugar siguiente del arreglo por si existe un siguiente ciclo y continúe en ese lugar.
    */
function imprimirFecha($contador, $arreglo, $j, $pdf)
{
    for ($i=$contador; $i>0; $i--) {
        $pdf->Cell(15, 5, $arreglo[$j], 1, 0, 'L', 1);
        $j++;
    }
    return $j;
}
    /*
        La función imprimirFecha, imprime celdas vacias,
            coloreadas dependiendo el  valor de asistencia
                true = verde
                false = rojo
                null = amarillo
        $contador inicializa el contador del for
        $pdf es la instancia que estamos ocupando para imprimir el PDF
        Devuelve $j para conocer el lugar siguiente del arreglo por si existe un siguiente ciclo y continúe en ese lugar.
    */
    
function imprimirColumnasFecha($contador, $pdf, $arreglo, $j, $numSesiones)
{
    for ($i=$contador; $i>0; $i--) {
        //El arreglo tiene un valor y es menor al numero de sesiones
        if (isset($arreglo) && $j<$numSesiones) {
            if ($arreglo[$j] == 't') {
                $pdf->SetFillColor(201, 228, 197); //verde
                global $conAsistencias;
                $conAsistencias++;
            } elseif ($arreglo[$j] == 'f') {
                $pdf->SetFillColor(245, 71, 72); // Rojo
            }
        } else {
            $pdf->SetFillColor(238, 232, 170); // Amarillo
        }
        //Imprime la celda, el ultimo 1 indica utilizar SetFillColor
        $pdf->Cell(15, 5, '', 1, 0, 'L', 1);
            
        $j++;
    }
    return $j;
}


    //Se inicializa el contador en 0.
    $h=0;
    // Recorre el número de ciclos necesarios
for ($i=$numeroUno; $i>0; $i--) {
    // Se cambia el valor de la bandera de acuerdo al numero de sesiones que requiere el ciclo
    if ($i==1 and $numSesiones>=3) {
        $numeroTres = $numeroDos;
    } elseif ($i>1) {
        $numeroTres = 3;
    } elseif ($i==1) {
        $numeroTres = $numeroDos;
    }

    // Se imprime el encabezado de la tabla
    //Color y fuente
    $pdf->SetFillColor(81, 196, 211);
    $pdf->SetFont('Arial', 'B', 12);
    //Encabezado: Numero de Lista, Profesor y Correo, Fechas y Constancia
    $pdf->Cell(8, 5, '#', 1, 0, 'C', 1);
    $pdf->Cell(94, 5, 'Profesor', 1, 0, 'L', 1);
    $pdf->Cell(94, 5, 'Correo', 1, 0, 'L', 1);
    $h = imprimirFecha($numeroTres, $arr_fechas, $h, $pdf);
    if ($i==1) {
        $pdf->Cell(25, 5, 'Constancia', 1, 0, 'L', 1);
    }
    //Salto de línea
    $pdf->Ln(5);
    //Fuente
    $pdf->SetFont('Arial', '', 12);
    //Se inicializa contador
    $k=1;
    //Se imprime el cuerpo de la tabla
    foreach ($arr_Inscritos as $inscrito) {
        //Datos del inscrito: Numero de Lista, Nombre y Correo
        $pdf->Cell(8, 5, $k, 1, 0, 'C');
        $nombreCompleto=$inscrito['pers_apellido_paterno'].' '.$inscrito['pers_apellido_materno'].' '.$inscrito['pers_nombre'];
        $pdf->Cell(94, 5, utf8_decode($nombreCompleto), 1, 0, 'L');
        $correo=$inscrito['pers_correo'];
        $pdf->Cell(94, 5, utf8_decode($correo), 1, 0, 'L');

        /*
                Se obtienen los siguientes datos de una inscripcion:
                    I.INSC_ID_INSCRIPCION, SESI_ID_SESION, ASIS_PRESENTE
        */
        $arr_asistencias = $obj_Asistencia->buscarAsistenciasInscripcion($idGrupo, $inscrito['insc_id_inscripcion']);
        //Se inicializa contador
        $n=0;
        //Se pasa el arreglo de la consulta sql a un arreglo númerico. Ya que el KEY númerico en este caso es más facil de consultar
        if (isset($arr_asistencias)) {
            foreach ($arr_asistencias as $asistencia) {
                $asistencias[$n] = $asistencia['asis_presente'];
                $n++;
            }
        } else {
            $asistencias = null;
        }

        //Se inicializa contador
        $m=0;
        //Se imprimen las columnas de asistencia de un inscrito
        if ($i>0) {
            $conAsistencias = 0;
            $m = imprimirColumnasFecha($numeroTres, $pdf, $asistencias, $m, $numSesiones);
        }
            
        /*
                Constancia
                    Imprime celdas vacias,
                    coloreadas dependiendo el  valor de aprobado
                        true = verde
                        false = rojo
                        null = amarillo
        */
            
        if ($i==1) {
            //Si el total de asietencia difiere de 0 o el estado es diferente de 4 (Finalizado)
            if ($conAsistencias != 0 || $curso->grup_id_estado == 4) {
                //El curso ya finalizó
                // Tuvo todas las asistencias
                if ($conAsistencias == $numSesiones) {
                    $pdf->SetFillColor(201, 228, 197); //Verde
                } else {
                    $pdf->SetFillColor(245, 71, 72); // Rojo
                }
            } else {
                //El curso no ha terminado
                $pdf->SetFillColor(238, 232, 170); // Amarillo
            }
            $pdf->Cell(25, 5, '', 1, 0, 'L', 1);
        }
        //Salto de línea
        $pdf->Ln(5);
        $k++;
    }

    //Se añade una pagina. En el ultimo recorrido, se ignora.
    if ($i!=1) {
        $pdf->AddPage('C', 'letter', 0);
    }
}

    $pdf->Ln(5);

    // Se almacena el nombre de descarga del pdf
    //TODO Verificar si este puede ser el nombre del pdf
    $nombre = str_replace(' ', '', $curso->curs_nombre);
    $nombreCursoPDF = $nombre.$curso->curs_nivel.$curso->curs_tipo;
    
    $pdf->Output('I', utf8_decode($nombreCursoPDF).'.pdf'); //Salida para imprimir, Destino ('I' navegador, 'D' descarga, 'F' descargar en fichero local, 'S' enviar el documento por una cadena de caracteres ), el siguiente parametro es el nombre, Con I y D si hay codificación del segundo parametro de ISO-8859
