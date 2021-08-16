<?php

class Constancias
{
    
    function agregarConstancia()
    {
      //Aquí iría una validación pero puede ser que ya se esté haciendo en otra parte
        $SQL_BUS_CONSTANCIA =
        " INSERT INTO Constancia (cons_estado) VALUES ('En trámite');
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_BUS_CONSTANCIA);
        $bd->cerrarBD();
        return $this->id_constancia = Constancias :: buscarUltimo(); //? Se regresa el valor de la constancia recién creada 
    }

    function cargarConstancia($constancia, $url)
    {   
        //? Se toma esta para evitar errores del servidor
        $Object = new DateTime();  
        $Object->setTimezone(new DateTimeZone('America/Mexico_City'));
        $hora = $Object->format("h:i:s");  

        $SQL_BUS_CONSTANCIA =
        "UPDATE Constancia
        SET cons_url = '$url', cons_estado = 'Disponible', cons_fecha = current_date, cons_hora = '$hora'
        WHERE cons_id_constancias = $constancia";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_BUS_CONSTANCIA);
        $bd->cerrarBD();
    }



    function buscarUltimo()
    {
        $bd = new BD();
        $SQL_BUS_CONSTANCIA = 
        "SELECT last_value FROM constancia_cons_id_constancias_seq; ";

        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_BUS_CONSTANCIA);
        
        $obj_Constancia_Seq = $transaccion_1->traerObjeto(0);
        $constancia_Seq = $obj_Constancia_Seq->last_value;
        $bd->cerrarBD();

        return $constancia_Seq;
    }

    //? Se utiliza para darle formato de dos digitos a las constancias que suben
    function renombrarConstancia($nombre, $direccion){      
        // Se obtiene el caracter que sería un numero si se siguira un patron de 2 numeros en la contancia
        $esNumero = substr($nombre, -6, 1);
        $finalCadena = substr($nombre, -5);

        
        // Verificamos si es un numero, si es así significa que es mayor a 9 y ya tiene dos digitos, entonces no se hace nada.
        if(!ctype_digit($esNumero)) {
            //Obtenemos la parte final de la cadena para no alterarla
            $nuevoNombre = str_replace($finalCadena, "0".$finalCadena, $nombre); 
    
            //Renombramos el archivo con el nuevo nombre
            rename($direccion.$nombre, $direccion.$nuevoNombre);
        }
    }

    public function consultarConstanciaInstructores($fechaInicio, $fechaFin)
    {
        $SQL_Ins_Horario =
        "SELECT DISTINCT U.usua_id_usuario,P.pers_id_persona, (P.pers_nombre ||' ' || P.pers_apellido_paterno || ' ' || P.pers_apellido_materno) as Nombre_instructor,
                        G.grup_id_grupo, C.curs_id_curso, C.curs_nombre, C.curs_tipo, C.curs_nivel, C.curs_num_sesiones
        FROM Grupo G, Personal_Grupo PG, Usuario U, Persona P, Curso C
        WHERE G.grup_id_grupo = PG.grup_id_grupo 
        AND U.usua_id_usuario = PG.usua_id_usuario
        AND P.pers_id_persona = U.pers_id_persona 
        AND G.curs_id_curso = C.curs_id_curso
        AND U.rol_id_rol = 2 
        AND G.grup_id_grupo IN(SELECT grup_id_grupo
                                FROM Sesion S
                                GROUP BY grup_id_grupo
                                HAVING MAX(sesi_fecha) BETWEEN '". $fechaInicio. "' and '". $fechaFin. "');
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Ins_Horario);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros(0));
    }

    public function consultarConstanciaModeradores($fechaInicio, $fechaFin)
    {
        $SQL_Ins_Horario =
        " SELECT DISTINCT U.usua_id_usuario,P.pers_id_persona, (P.pers_nombre ||' ' || P.pers_apellido_paterno || ' ' || P.pers_apellido_materno) as Nombre_instructor,
            G.grup_id_grupo, C.curs_id_curso, C.curs_nombre, C.curs_tipo, C.curs_nivel, C.curs_num_sesiones
            FROM Grupo G, Personal_Grupo PG, Usuario U, Persona P, Curso C
            WHERE G.grup_id_grupo = PG.grup_id_grupo and U.usua_id_usuario = PG.usua_id_usuario
            and P.pers_id_persona = U.pers_id_persona and G.curs_id_curso = C.curs_id_curso
            and U.rol_id_rol = 3 and G.grup_id_grupo IN(SELECT grup_id_grupo
                                                    FROM Sesion
                                                    WHERE sesi_fecha BETWEEN '". $fechaInicio. "' and '". $fechaFin. "'
                                                    GROUP BY 1)
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Ins_Horario);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros(0));
    }

    function actualizarEstadoConstanciaDescargada($id)
    {
        $SQL_Act_Est_Constancia = 
        "
        UPDATE Constancia
        SET cons_descargada = true
        WHERE cons_id_constancias = $id
        ";
        
        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Act_Est_Constancia);
        $bd->cerrarBD();
    }
}
