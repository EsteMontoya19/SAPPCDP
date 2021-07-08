<?php

// Clases
    include('../clases/BD.php');
    include('../clases/Sesion.php');
    include('../clases/PDF.php');
    include('../clases/Profesor.php');
    include('../clases/Grupo.php');
    include('../clases/Plataforma.php');
     
    if ($_GET['tipo'] == "comprobante") {
    
    //? ID's recibidos por get
    $idPersona = $_GET["idP"];
    $idGrupo = $_GET["idG"];
    
    //? Objetos necesarios para los resultados del comprobante de inscripción
    //Objetos
    $obj_Profesor = new Profesor ();
    $obj_Grupo = new Grupo ();
    $obj_Plataforma = new Plataforma ();
    $obj_Sesion = new Sesion();

    //? Variables con los datos de la consulta
    $profesor = $obj_Profesor->buscarProfesor($idPersona);
    $grupo = $obj_Grupo->buscarGrupo($idGrupo);
    if(isset($grupo->plat_id_plataforma) || $grupo->plat_id_plataforma != "") {
        $plataforma = $obj_Plataforma->buscarPlataforma($grupo->plat_id_plataforma);
    } else {
        $plataforma = null;
    }
    
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
    $pdf->SetFont("Arial","", 12);
    $pdf->Cell(0,10,utf8_decode("Fecha de impresión: ".date('d-m-Y')),0,1, "C", false);
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
    $pdf->Cell(28,5,utf8_decode("Profesor: "),1,0, "L", false);
    $pdf->SetFont("Times","", 12);
    $pdf->Cell(0,5,utf8_decode($grupo->pers_apellido_materno." ".$grupo->pers_apellido_paterno." ".$grupo->pers_nombre),1,1, "L", false);

    $pdf->SetFont("Times","B", 12);
    $pdf->Cell(28,5,utf8_decode("Moderador: "),1,0, "L", false);
    $pdf->SetFont("Times","", 12);
    if(isset($grupo->moderador)) {
        $pdf->Cell(0,5,utf8_decode( $grupo->moderador),1,1, "L", false);
    } else {
        $pdf->Cell(0,5,utf8_decode("Sin moderador"),1,1, "L", false);
    }


    
    
    if($grupo->moap_id_modalidad == 1) {
        //TODO: Falta asignarles variables
        $pdf->SetFont("Times","B", 12);
        $pdf->Cell(28,5,utf8_decode("Edificio: "),1,0, "L", false);
        $pdf->SetFont("Times","", 12);
        $pdf->Cell(0,5,utf8_decode("Por el momento no hay cursos preseciales"),1,1, "L", false);

        $pdf->SetFont("Times","B", 12);
        $pdf->Cell(28,5,utf8_decode("Salón: "),1,0, "L", false);
        $pdf->SetFont("Times","", 12);
        $pdf->Cell(0,5,utf8_decode("Por el momento no hay cursos preseciales"),1,1, "L", false);

    } elseif ($grupo->moap_id_modalidad == 2) {
        $pdf->SetFont("Times","B", 12);
        $pdf->Cell(28,5,utf8_decode("Plataforma: "),1,0, "L", false);
        $pdf->SetFont("Times","", 12);
        $pdf->Cell(0,5,utf8_decode(" ".$plataforma->plat_nombre),1,1, "L", false);

        $pdf->SetFont("Times","B", 12);
        $pdf->Cell(28,5,utf8_decode("Link acceso: "),1,0, "L", false);
        $pdf->SetFont("Times","", 12);
        $pdf->Cell(0,5,utf8_decode(" ".$grupo->grup_url),1,1, "L", false);
        
        $pdf->SetFont("Times","B", 12);
        $pdf->Cell(28,5,utf8_decode("ID Acceso: "),1,0, "L", false);
        $pdf->SetFont("Times","", 12);
        $pdf->Cell(0,5,utf8_decode(" ".$grupo->grup_id_acceso),1,1, "L", false);

        $pdf->SetFont("Times","B", 12);
        $pdf->Cell(28,5,utf8_decode("Clave acceso: "),1,0, "L", false);
        $pdf->SetFont("Times","", 12);
        $pdf->Cell(0,5,utf8_decode(" ".$grupo->grup_clave_acceso),1,1, "L", false);
        
    } elseif ($grupo->moap_id_modalidad == 3) {
        $pdf->SetFont("Times","B", 12);
        $pdf->Cell(28,5,utf8_decode("Plataforma: "),1,0, "L", false);
        $pdf->SetFont("Times","", 12);
        $pdf->Cell(0,5,utf8_decode(" ".$grupo->grup_url),1,1, "L", false);
    }


        $sesionesGrupo = $obj_Sesion->buscarFechaSesiones($idGrupo);
        
        $iCont = 1;
        foreach($sesionesGrupo as $sesion) {

            $pdf->SetFont("Times","B", 12);
            $pdf->Cell(28,5,utf8_decode("Sesión ".$iCont.": "),1,0, "L", false);
            $pdf->SetFont("Times","", 12);
            $pdf->Cell(0,5,utf8_decode($obj_Sesion->obtenerFechaEnLetra($sesion['fecha']). " de  ".$sesion['sesi_hora_inicio']." a ".$sesion['sesi_hora_fin']),1,1, "L", false);
            $iCont++;
        }
    }
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

    

?>