<?php
include('../clases/BD.php');
include('../clases/Grupo.php');

//* Objetos
$obj_Grupo = new Grupo();

if(isset($_POST['mensaje'])) {

    $destinatario = $_POST['destinatario'];
    $asunto = $_POST['asunto'];
    $mensaje = $_POST['mensaje'];
    $remitente = "capacitaciondistancia@fca.unam.mx";

    //? Se le quita el uno para eliminar el espacio
    $posicion = stripos($destinatario, "|") - 1;
    $idGrupo = substr($destinatario, 0, $posicion);

    $existe = $obj_Grupo->buscarGrupo($idGrupo);
    if(isset($existe)) {
        $arr_inscritos = $obj_Grupo->buscarCorreosDeParticipantes($idGrupo);
        foreach ($arr_inscritos as $iCont => $inscrito) {
            if(isset($inscrito['pers_correo'])) {
                //TODO: AQUI TENDRÍA QUE IR LA LINEA QUE SE ENCARGA DE MANDAR EL CORREO
                $mensajes = fopen("Correos enviados.txt" , "a");
                fwrite($mensajes, "Remitente: ".$remitente.PHP_EOL);
                fwrite($mensajes, "Para: ".$inscrito['pers_correo'].PHP_EOL);
                fwrite($mensajes, "Asunto: ".$asunto.PHP_EOL);
                fwrite($mensajes, "Mensaje: ".$mensaje.PHP_EOL);
                fwrite($mensajes, " ".PHP_EOL);
                fclose($mensajes);
                
                mail($inscrito['pers_correo'], $asunto, $mensaje, "From: ".$remitente . "\r\n" ."Reply-To: ".$remitente);
            }
        }
        exit("1");
    } else {
        exit("3");
    }
    exit("2");

} else if (isset($_POST['pista'])){
    
    $arr_pistas = $obj_Grupo->buscarGruposIndicio($_POST['pista']);
    $arr_autocompletado = array();


    if (!isset($arr_pistas)) {
        exit("2");
    } else {
        foreach ($arr_pistas as $iCont => $pista) {
            $arr_autocompletado[$iCont] = $pista['grup_id_grupo'] . ' | '. $pista['curs_nombre']. ' | '. $pista['curs_tipo']. ' | '. $pista['curs_nivel']. ' | '. $pista['grup_inicio_insc'];
        }
        exit(json_encode($arr_autocompletado));
    }
    exit("2");

}

function obtenerGrupo($destinatario) {
    

}






?>