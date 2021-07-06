<?php
class ServidorSocial
{
    //? Actualiza los datos del servidor social
    function actualizarServidor ($persona , $numCuenta){
        $SQL_SERVIDOR = 
        " UPDATE Servidor_Social
          SET seso_num_cuenta = '$numCuenta'
          WHERE pers_id_persona = '$persona';
        ";
    }


}

?>