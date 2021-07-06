<?php

  include('../clases/BD.php');
  include('../clases/Usuario.php');
  include('../clases/Persona.php');
  include('../clases/Profesor.php');
  include('../clases/Busqueda.php');
  include('../clases/ServidorSocial.php');
  include('../clases/Moderador.php');
  include('../clases/Administrador.php');

  $obj_Persona = new Persona();
  $obj_Usuario = new Usuario();
  $obj_Moderador = new Moderador();
  $obj_Profesor = new Profesor();
  $obj_Busqueda = new Busqueda();
  $obj_ServidorSocial = new ServidorSocial();
  $obj_Administrador = new Administrador();

  //Arreglos necesarios
  $arr_dias = $obj_Busqueda->selectDias();  
  $arr_niveles = $obj_Busqueda->selectNiveles();   
  $arr_modalidades = $obj_Busqueda->selectModalidades();
  $arr_coordinaciones = $obj_Busqueda->selectCoordinaciones();

    // Constantes de roles
    define ("ADMINISTRADOR" , 1);
    define ("INSTRUCTOR" , 2);
    define ("MODERADOR" , 3);
    define ("PROFESOR" , 4);
  
  if (isset($_POST['dml'])) {

    if($_POST['dml'] == 'insert')
    {
      $rol = (integer) $_POST['intUsuarioRol'];
      
      switch($rol) {
        //? Para los demas usuarios su nombre de usuario y contraseña son los que ellos decidan
        case ADMINISTRADOR:
        case INSTRUCTOR:
        case MODERADOR:
          $nombreUsuario = $_POST['strNombreUsuario'];
          $contrasenia = $_POST['strContrasenia01'];
          break;
          
        case PROFESOR:
          $profesor_existente = $obj_Profesor->buscarNumTrabajador($_POST['intNum_Trabajador']);
          if(isset($profesor_existente->prof_num_trabajador)) {
          exit("3");
          }

          //? Si existe algo en contraseña y en usuaruio significa que no venimos de mi cuenta
          if (isset($_POST['strContrasenia01']) && isset($_POST['strNombreUsuario']) ) {
            //? Se hace para respetar el cambio de usuario y contra si se hace desde usuario y no del Autoregistro
            if ($_POST['intNum_Trabajador'] != $_POST['strNombreUsuario'] ||  $_POST['strRFC'] != $_POST['strContrasenia01']) {
              $nombreUsuario = $_POST['strNombreUsuario'];
              $contrasenia = $_POST['strContrasenia01'];
            } else {
              //? Para los Profesores 
              $nombreUsuario = $_POST['intNum_Trabajador'];
              $contrasenia = $_POST['strRFC'];
            }
          } else {
            //?Significa que viene del Auto-Registro
            $nombreUsuario = $_POST['intNum_Trabajador'];
            $contrasenia = $_POST['strRFC'];
          }
        break;
      }
      
      $usuario_existente = $obj_Usuario->buscarNombreUsuario($nombreUsu);
      if(!isset($usuario_existente->usua_num_usuario)) {
        
        //?Datos de persona
        $nombre = $_POST['strUsuarioNombre'];
        $apellidoPaterno = $_POST['strUsuarioPrimerApe'];
        $apellidoMaterno = $_POST['strUsuarioSegundoApe'];
        $correo = $_POST['strUsuarioCorreo'];
        $telefono = $_POST['strUsuarioTelefono'];
        
        //? Datos de usuario
        //TODO: Preguntar por solictud de usuario se quita pregunta de seguridad
        $pregunta = null;
        $recuperacion = null;
        // $pregunta = (integer) $_POST['UsuarioPregunta'];
        // $recuperacion = $_POST['UsuarioRespuesta'];

        $estado = isset($_POST['bEstado']) ? $_POST['bEstado'] : "TRUE"; //? El admin los crea en activo, debo poner en profesor el estado como false
        
        //?Datos según rol
        switch($rol){
          case ADMINISTRADOR:
            $num_trabajador = $_POST['intNum_Trabajador'];
            $rfc = $_POST['strRFC'];
          break;  

          //TODO: Hcer validaciones para Instructor
          
          case MODERADOR: 
            //*? Creado para guardar los inputs. Solo guarda los que tienen algo
            $diasModerador=array();
            foreach($arr_dias as $dia){
              static $bandera =  1; 
              
              if(isset($_POST['strDiaServicio'.$bandera]) && $_POST['strDiaServicio'.$bandera] != "" ) {
                $diasModerador[$bandera] = $_POST['strDiaServicio'.$bandera];
              } 
              $bandera++;
            }

            $num_cuenta = $_POST['lbNumCuenta'];
            $fechaInicio = $_POST['strFechaInicio'];
            $fechaFin = $_POST['strFechaFin']; 
            $horaInicio = $_POST['strHoraInicio']; 
            $horaFin = $_POST['strHoraFin'];
          break; 

          case PROFESOR:
            $num_trabajador = $_POST['intNum_Trabajador'];
            $rfc = $_POST['strRFC'];
            $semblanza = isset($_POST['strSemblanza']) ? $_POST['strSemblanza'] : null;
            
            //*? Creado para guardar los inputs. Solo guarda los que tienen algo
            $nivelesProfesor=array();
            $bandera =  1; 
            foreach($arr_niveles as $nivel){
              if(isset($_POST['strNivel'.$bandera]) && $_POST['strNivel'.$bandera] != "" ) {
                $nivelesProfesor[$bandera] = $_POST['strNivel'.$bandera];
              } 
              $bandera++;
            }

            $modalidadesProfesor=array();
            $bandera =  1; 
            foreach($arr_modalidades as $modalidad){
              if(isset($_POST['strModalidad'.$bandera]) && $_POST['strModalidad'.$bandera] != "" ) {
                $modalidadesProfesor[$bandera] = $_POST['strModalidad'.$bandera];
              } 
              $bandera++;
            }

            $coordinacionesProfesor=array();
            $bandera =  1; 
            foreach($arr_coordinaciones as $coordinacion){
              if(isset($_POST['strCoordinacion'.$bandera]) && $_POST['strCoordinacion'.$bandera] != "" ) {
                $coordinacionesProfesor[$bandera] = $_POST['strCoordinacion'.$bandera];
              } 
              $bandera++;
            }
          break; 
        }

        
        $obj_Persona->agregarPersona($nombre, $apellidoPaterno, $apellidoMaterno, $correo, $telefono, $rfc);
        $persona = $obj_Persona->buscarUltimo();
        $obj_Usuario->agregarUsuario($persona, $rol, $pregunta, $nombreUsuario, $contrasenia, $estado);
        switch($rol){
          case ADMINISTRADOR: //Administrador
            $obj_Profesor->agregarProfesor($persona, $num_trabajador, null);
          break;

          case MODERADOR: //Moderador
            $obj_Moderador->agregarModerador($persona, $num_cuenta, $fechaInicio, $fechaFin, $horaInicio, $horaFin );
            foreach($diasModerador as $id){
              $obj_Moderador->agregarDiasModerador($persona, $id);
            }
          break;

          case 4: //Profesor
            $obj_Profesor->agregarProfesor($persona, $num_trabajador, $semblanza);
            
            foreach($nivelesProfesor as $id){
              $obj_Profesor->agregarNivelesProfesor($persona, $id);
            }
            foreach($modalidadesProfesor as $id){
              $obj_Profesor->agregarModalidadesProfesor($persona, $id);
            }
            foreach($coordinacionesProfesor as $id){
              $obj_Profesor->agregarCoordinacionesProfesor($persona, $id);
            }
          break;
        }
        

        echo 1;
      } else {
        echo 2;
      }
        
    }
    elseif($_POST['dml'] == 'update')
    {
      $nombreUsu = $_POST['strNombreUsuario'];
      $usuario_existente = $obj_Usuario->buscarNombreUsuario($nombreUsu);
      $idPersona = $_POST['idPersona'];
      $idUsuario = $_POST['idUsuario'];

      $esElMismo = 0;
      if($nombreUsu == $usuario_existente->usua_num_usuario && $idUsuario == $usuario_existente->usua_id_usuario){
        $esElMismo = 1;
      }

      if(!isset($usuario_existente->usua_num_usuario) || $esElMismo == 1) {
      //?Datos de persona
      $nombre = $_POST['strUsuarioNombre'];
      $apellidoPaterno = $_POST['strUsuarioPrimerApe'];
      $apellidoMaterno = $_POST['strUsuarioSegundoApe'];
      $correo = $_POST['strUsuarioCorreo'];
      $telefono = $_POST['strUsuarioTelefono'];
      $rfc = $_POST['strRFC'];
      
      //? Datos de usuario
      $nombreUsuario = $_POST['strNombreUsuario'];
      $rol = (integer) $_POST['hideRol'];
      //? Por petición del usuario se eliminaron las preguntas de seguridad 
      $pregunta = null;
      $recuperacion = null;
      $contrasenia = $_POST['strContrasenia01'];
      $estado = isset($_POST['bEstado']) ? $_POST['bEstado'] : "TRUE"; //? El admin los crea en activo, debo poner en profesor el estado como false
      
      //?Datos según rol
      if($rol == ADMINISTRADOR || $rol == INSTRUCTOR || $rol == PROFESOR) {
        $num_trabajador = $_POST['intNum_Trabajador'];

        if($rol == INSTRUCTOR) {
          $semblanza = $_POST['strSemblanza'];
        }
        //*? Creado para guardar los inputs. Solo guarda los que tienen algo
        $nivelesProfesor=array();
        $bandera =  1; 
        foreach($arr_niveles as $nivel){
          if(isset($_POST['strNivel'.$bandera]) && $_POST['strNivel'.$bandera] != "" ) {
            $nivelesProfesor[$bandera] = $_POST['strNivel'.$bandera];
          } 
          $bandera++;
        }
        $modalidadesProfesor=array();
        $bandera =  1; 
        foreach($arr_modalidades as $modalidad){
          if(isset($_POST['strModalidad'.$bandera]) && $_POST['strModalidad'.$bandera] != "" ) {
            $modalidadesProfesor[$bandera] = $_POST['strModalidad'.$bandera];
          } 
          $bandera++;
        }

        $coordinacionesProfesor=array();
        $bandera =  1; 
        foreach($arr_coordinaciones as $coordinacion){
          if(isset($_POST['strCoordinacion'.$bandera]) && $_POST['strCoordinacion'.$bandera] != "" ) {
            $coordinacionesProfesor[$bandera] = $_POST['strCoordinacion'.$bandera];
          } 
          $bandera++;
        } 
      }

      if($rol == MODERADOR) {
        //*? Creado para guardar los inputs. Solo guarda los que tienen algo
        $diasModerador=array();
        foreach($arr_dias as $dia){
          static $bandera =  1; 
          if(isset($_POST['strDiaServicio'.$bandera]) && $_POST['strDiaServicio'.$bandera] != "" ) {
            $diasModerador[$bandera] = $_POST['strDiaServicio'.$bandera];
          } 
          $bandera++;
        }
        $fechaInicio = $_POST['strFechaInicio'];
        $fechaFin = $_POST['strFechaFin']; 
        $horaInicio = $_POST['strHoraInicio']; 
        $horaFin = $_POST['strHoraFin'];
        //? Si tienen más de un rol no tienen datos de Servidor_Social, sino de profesor
        //? Este If valida eso y asigna las variables correspondientes
        if ($obj_Persona->rolesPersona($_POST['idPersona'])->roles_persona == 1) {
          $num_cuenta = $_POST['lbNumCuenta'];
        } else {
          $num_trabajador = $_POST['intNum_Trabajador'];
          $rfc = $_POST['strRFC'];
        }
      }
      
      $obj_Persona->actualizarPersona($idPersona, $nombre, $apellidoPaterno, $apellidoMaterno, $correo, $telefono, $rfc);
      
      $obj_Usuario->actualizarUsuario($idPersona, $rol, $pregunta, $nombreUsuario, $contrasenia);

      switch($rol){
        case ADMINISTRADOR:
          $obj_Profesor->actualizarProfesor($idPersona, $num_trabajador, null);
        break;

        case MODERADOR:
          //? Primero debemos de saber si es un moderador Profesor o Servidor Social
          if(isset($num_trabajador)) {
            //? Si el número de trabajador es diferente a 6 es un error por que no se puede haber registrado
            //? a un profesor y despues cambiarlo a serviddr social
            if (strlen($num_trabajador) < 6 || strlen($num_trabajador) > 6) {
              exit("3");
            }
            $obj_Profesor->actualizarProfesor($idPersona, $num_trabajador, null);

            //? Si tiene número de cuenta es un servidor social
          } elseif (isset($num_cuenta)) {
            //? Si el número de cuenta es diferente a 9 es un error por que no se puede haber registrado
            //? a un Servidor Social  y despues cambiarlo a Profesora
            if (strlen($num_trabajador) < 6 || strlen($num_trabajador) > 6) {
              exit("4");
            }
            $obj_ServidorSocial->actualizarServidor($idPersona , $num_cuenta);
          }

          $obj_Moderador->actualizarModerador($idPersona, $fechaInicio, $fechaFin, $horaInicio, $horaFin);
          $obj_Moderador->eliminarDiasModerador($idPersona);
          foreach($diasModerador as $id){
            $obj_Moderador->agregarDiasModerador($idPersona, $id);
          } 
          exit("1");
        break; 

        case PROFESOR:
        case INSTRUCTOR:
          $obj_Profesor->actualizarProfesor($idPersona, $num_trabajador, $semblanza);
          
          $obj_Profesor->eliminarNivelesProfesor($idPersona);
          foreach($nivelesProfesor as $id){
            $obj_Profesor->agregarNivelesProfesor($idPersona, $id);
          }
          $obj_Profesor->eliminarModalidadesProfesor($idPersona);
          foreach($modalidadesProfesor as $id){
            $obj_Profesor->agregarModalidadesProfesor($idPersona, $id);
          }
          $obj_Profesor->eliminarCoordinacionesProfesor($idPersona);
          foreach($coordinacionesProfesor as $id){
            $obj_Profesor->agregarCoordinacionesProfesor($idPersona, $id);
          }
        break;
      }

        if (isset($_POST['procedencia']) && $_POST['procedencia'] = "mi_cuenta") {
          exit ("10");
        } else {
          exit ("1");
        }
      } else {
        exit("2");
      }
    }
    elseif($_POST['dml'] == 'delete')
    {
      $usuario = $_POST['id'];
      $persona = $_POST['persona'];
      
      $obj_Usuario->eliminarUsuario($usuario); 
      $obj_Moderador->eliminarModerador($persona);
      $obj_Persona->eliminarPersona($persona);

      echo 1;
    }
    elseif($_POST['dml'] == 'cambio')
    {
      $usuario = $_POST['id'];
      $estatus = $_POST['estatus'];
      $rol = $_POST['rol'];

      if ($estatus == 't')
      {
        $estatus = 'FALSE';
        
        if($rol == 1) {
          $administradoresActivos = $obj_Administrador->administradoresActivos();
          if(isset($administradoresActivos) && $administradoresActivos <= 1 && !empty($administradoresActivos)) {
            exit("2");
          }
        }
        
        $obj_Usuario->modificarEstatus($usuario,$estatus);
      }
      elseif($estatus == 'f')
      {
        
        $estatus = 'TRUE';
        $obj_Usuario->modificarEstatus($usuario, $estatus);
      }

      exit("1");
    }
  } else {
    exit("3");
  }
?>