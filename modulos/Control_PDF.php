<?php

// Clases
    include('../clases/BD.php');
    include('../clases/Sesion.php');
    include('../clases/PDF.php');
    include('../clases/Profesor.php');
    include('../clases/Grupo.php');
    include('../clases/Plataforma.php');
    
    if ($_GET['tipo'] == "listaPDF") {
        // Inicializamos las variables requeridas
        //? Solo recibe el ID del grupo
        $idGrupo = $_POST['idGrupo'];
        $obj_Grupo = new Grupo();
        $arr_Inscritos = $obj_Grupo->buscarInscripcionesxGrupo($idGrupo);
        $curso = $obj_Grupo->buscarNombreCursoxGrupo($idGrupo);
        $obj_Sesion = new Sesion();
        $sesion = $obj_Sesion->numSesionesGrupo($idGrupo);
        $numSesiones = $sesion->count;
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
            if($i==1 && $numSesiones>=10) {
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
            
            $pdf->Output('D', utf8_decode($nombreCursoPDF).'.pdf'); //Salida para imprimir, Destino ('I' navegador, 'D' descarga, 'F' descargar en fichero local, 'S' enviar el documento por una cadena de caracteres ), el siguiente parametro es el nombre, Con I y D si hay codificación del segundo parametro de ISO-8859 
            
    }   
    
    if ($_GET['tipo'] == "comprobante") {
    
    //? ID's recibidos por get
    $idPersona = $_GET["idP"];
    $idGrupo = $_GET["idG"];
    
    //? Objetos necesarios para los resultados del comprobante de inscripción
    //Objetos
    $obj_Profesor = new Profesor ();
    $obj_Grupo = new Grupo ();
    $obj_Plataforma = new Plataforma ();

    //? Variables con los datos de la consulta
    $profesor = $obj_Profesor->buscarProfesor($idPersona);
    $grupo = $obj_Grupo->buscarGrupo($idGrupo);
    $plataforma = $obj_Plataforma->buscarPlataforma($grupo->plat_id_plataforma);
    
    //? Constructor
    $pdf = new PDF("P", "mm", "Letter"); //! Las medidas afectan lo expresado en otras funciones como Cell
    $pdf->AddPage("P", "Letter", 0);
    $pdf->AliasNbPages();

    //? Cell
    /*
    Funciones: Imprime una celda
    Parametros: Obligatorios y Opcionales (*)
    Descripción: 
    -------------------------------------------------------------
    w: Ancho de la celda (Poner 0 hacer que abarque todo el ancho)
    h: Alto de la celda (Hoja carta 240)
    texto: Texto a mostrar
    borde: 0 (sin borde) | 1 (con borde) || L(izquierda) && T(superiro) && R(derecha) && B(inferior)
    *posicion: 0(derecha) | 1(al comienzo de la linea) | 2(debajo)
    *alineación: L | C | R
    *fondo: true | false 
    *link: Se utiliza AddLink para posicionarse en un lugar especifico
    ---------------------------------------------------------------*/
    $pdf->Ln(10);
    $pdf->SetFont("Arial","B", 18);
    $pdf->Cell(0,10,utf8_decode("Comprobante de inscripción"),0,1, "C", false);
    $pdf->Ln(12);

    //? Datos del inscrito
    $pdf->SetFont("Times","B", 13);
    $pdf->Cell(0,5,utf8_decode("Datos del inscrito"),1,2, "C", false);
    
    $pdf->SetFont("Times","B", 12);
    $pdf->Cell(45,5,utf8_decode("Nombre: "),1,0, "L", false);
    $pdf->SetFont("Times","", 12);
    $pdf->Cell(0,5,utf8_decode(" ".$profesor->pers_nombre),1,1, "L", false);
    
    $pdf->SetFont("Times","B", 12);
    $pdf->Cell(45,5,utf8_decode("Apellido Paterno: "),1,0, "L", false);
    $pdf->SetFont("Times","", 12);
    $pdf->Cell(0,5,utf8_decode(" ".$profesor->pers_apellido_paterno),1,1, "L", false);
    
    $pdf->SetFont("Times","B", 12);
    $pdf->Cell(45,5,utf8_decode("Apellido Materno: "),1,0, "L", false);
    $pdf->SetFont("Times","", 12);
    $pdf->Cell(0,5,utf8_decode(" ".$profesor->pers_apellido_materno),1,1, "L", false);
    
    $pdf->SetFont("Times","B", 12);
    $pdf->Cell(45,5,utf8_decode("Número de trabajador: "),1,0, "L", false);
    $pdf->SetFont("Times","", 12);
    $pdf->Cell(0,5,utf8_decode(" ".$profesor->prof_num_trabajador),1,1, "L", false);
    
    $pdf->Ln(10);
    
    //? Datos del curso
    $pdf->SetFont("Times","B", 13);
    $pdf->Cell(0,5,utf8_decode("Datos del curso"),1,2, "C", false);
    $pdf->SetFont("Times","B", 12);
    $pdf->Cell(20,5,utf8_decode("Curso: "),1,0, "L", false);
    $pdf->SetFont("Times","", 12);
    $pdf->Cell(0,5,utf8_decode(" ".$grupo->curs_nombre),1,1, "L", false);

    $pdf->SetFont("Times","B", 12);
    $pdf->Cell(20,5,utf8_decode("Tipo: "),1,0, "L", false);
    $pdf->SetFont("Times","", 12);
    $pdf->Cell(0,5,utf8_decode(" ".$grupo->curs_tipo),1,1, "L", false);

    $pdf->SetFont("Times","B", 12);
    $pdf->Cell(20,5,utf8_decode("Nivel: "),1,0, "L", false);
    $pdf->SetFont("Times","", 12);
    $pdf->Cell(0,5,utf8_decode(" ".$grupo->curs_nivel),1,1, "L", false);

    $pdf->SetFont("Times","B", 12);
    $pdf->Cell(20,5,utf8_decode("Sesiones: "),1,0, "L", false);
    $pdf->SetFont("Times","", 12);
    $pdf->Cell(0,5,utf8_decode(" ".$grupo->curs_num_sesiones),1,1, "L", false);
    $pdf->Ln(10);



    //? Datos del grupo
    $pdf->SetFont("Times","B", 13);
    $pdf->Cell(0,5,utf8_decode("Datos del grupo"),1,2, "C", false);

    $pdf->SetFont("Times","B", 12);
    $pdf->Cell(25,5,utf8_decode("Profesor: "),1,0, "L", false);
    $pdf->SetFont("Times","", 12);
    $pdf->Cell(0,5,utf8_decode(" ".$grupo->pers_nombre),1,1, "L", false);

    $pdf->SetFont("Times","B", 12);
    $pdf->Cell(25,5,utf8_decode("Moderador: "),1,0, "L", false);
    $pdf->SetFont("Times","", 12);
    $pdf->Cell(0,5,utf8_decode(" ".$grupo->pers_apellido_paterno),1,1, "L", false);

    $pdf->SetFont("Times","B", 12);
    $pdf->Cell(25,5,utf8_decode("Modalidad: "),1,0, "L", false);
    $pdf->SetFont("Times","", 12);
    $pdf->Cell(0,5,utf8_decode(" ".$grupo->pers_apellido_materno),1,1, "L", false);
    
    
    if(!isset($grupo->plat_id_plataforma)) {
        //TODO: Falta asignarles variables
        $pdf->SetFont("Times","B", 12);
        $pdf->Cell(20,5,utf8_decode("Edificio: "),1,0, "L", false);
        $pdf->SetFont("Times","", 12);
        $pdf->Cell(0,5,utf8_decode("Por el momento no hay cursos preseciales"),1,1, "L", false);

        $pdf->SetFont("Times","B", 12);
        $pdf->Cell(20,5,utf8_decode("Salón: "),1,0, "L", false);
        $pdf->SetFont("Times","", 12);
        $pdf->Cell(0,5,utf8_decode("or el momento no hay cursos preseciales"),1,1, "L", false);

    } else {
        $pdf->SetFont("Times","B", 12);
        $pdf->Cell(25,5,utf8_decode("Plataforma: "),1,0, "L", false);
        $pdf->SetFont("Times","", 12);
        $pdf->Cell(0,5,utf8_decode(" ".$plataforma->plat_nombre),1,1, "L", false);
    }

    $pdf->SetFont("Times","B", 12);
    $pdf->Cell(25,5,utf8_decode("Sesiones: "),1,0, "L", false);
    $pdf->SetFont("Times","", 12);
    $pdf->Cell(0,5,utf8_decode(" ".$grupo->curs_num_sesiones),1,1, "L", false);
    $pdf->Ln(10);

    

    //? Output
    /*
    Funciones: Guarda o envía el documento
    Parametros: Obligatorios y Opcionales (*)
    Descripción: 
    -------------------------------------------------------------
    destino: I(envía docuemtno al navegador) | D(Fuerza la descarga y envía la navegador) 
        | F(Guarda en un fichero local) | S(Devuelve el doc como cadena)
    nombre: (Nombre con el cual se almacenará el documento)
    codificación: true(UTF-8) | false(ISO-8859-1)
    ---------------------------------------------------------------*/
    $pdf->Output("I", "Comprobante inscripción.pdf", true);
    }

?>