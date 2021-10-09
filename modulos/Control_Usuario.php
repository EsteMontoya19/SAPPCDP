<?php

  include('../clases/BD.php');
  include('../clases/Usuario.php');
  include('../clases/Persona.php');
  include('../clases/Profesor.php');
  include('../clases/Busqueda.php');
  include('../clases/Moderador.php');
  include('../clases/Administrador.php');

  $obj_Persona = new Persona();
  $obj_Usuario = new Usuario();
  $obj_Moderador = new Moderador();
  $obj_Profesor = new Profesor();
  $obj_Busqueda = new Busqueda();
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

      //? Se verifica que no tenga una cuenta en ese rol
      $profesor_existente = $obj_Profesor->buscarNumTrabajador($_POST['intNum_Trabajador'], $rol);
      if(isset($profesor_existente->prof_num_trabajador)) {
        exit("3");
      }

      //? Este switch vrifica cuentas existentes y asigna usuarios y contraseñas, asi como numero de cuentas de existir
      switch($rol) {
        //? Para los demas usuarios su nombre de usuario y contraseña son los que ellos decidan
        case ADMINISTRADOR:
        case INSTRUCTOR:
          $nombreUsuario = $_POST['strNombreUsuario'];
          $contrasenia = $_POST['strContrasenia01'];      
        break;

        case MODERADOR:

        //? Se verifica si se registrara un Servidor Social o un Profesor Moderador
        //? Si mide 6 es un Profesor el que se esta registrando
        if(strlen($_POST['intNum_Trabajador']) == 6) {
          $num_cuenta = null;
          //? Si mide 9 es un Servidor Social el que se esta registrando
        } elseif (strlen($_POST['intNum_Trabajador']) == 9) {
          //?Si es un Servidor Social se verifica que no haya uno con el numero de cuenta ingresado
          if (isset($obj_Moderador->buscarServidorSocialNumCuenta($_POST['intNum_Trabajador'])->seso_id_servidor)) {
            exit("4");
          } 
          $num_cuenta = $_POST['intNum_Trabajador'];
        } else {
          exit("5");
        }
          $nombreUsuario = $_POST['strNombreUsuario'];
          $contrasenia = $_POST['strContrasenia01'];
        break;
          
        case PROFESOR:
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
      
      //? Se verifica que no se tenga un usuario con ese numero de usuario
      $usuario_existente = $obj_Usuario->buscarNombreUsuario($_POST['strNombreUsuario']);
      if(!isset($usuario_existente->usua_num_usuario)) {
        
        //?Datos de persona
        $rfc = $_POST['strRFC'];
        $sexo = $_POST['strSexo'];
        $nombre = $_POST['strUsuarioNombre'];
        $apellidoPaterno = $_POST['strUsuarioPrimerApe'];
        $apellidoMaterno = $_POST['strUsuarioSegundoApe'];
        $correo = $_POST['strUsuarioCorreo'];
        $telefono = $_POST['strUsuarioTelefono'];
        //? El admin los crea en activo, debo poner en profesor el estado como false
        $estado = isset($_POST['bEstado']) ? $_POST['bEstado'] : "TRUE"; 
        

        //? Datos de usuario
          //? Por solictud de usuario se quita pregunta de seguridad
        $pregunta = null;
        $recuperacion = null;
        // $pregunta = (integer) $_POST['UsuarioPregunta'];
        // $recuperacion = $_POST['UsuarioRespuesta'];
        
        //? Este switch asigna los datos según cada uno de los roles
        switch($rol){
          case ADMINISTRADOR:
            $num_trabajador = $_POST['intNum_Trabajador'];
          break;  

          
          case INSTRUCTOR:
            $num_trabajador = $_POST['intNum_Trabajador'];
            $semblanza = $_POST['strSemblanza'];

          break; 

          
          case MODERADOR: 
            //? Si no hay nada en numero de cuenta es que en la validación de la linea 50 si obtuvimos un Profesor
            if(!isset($num_cuenta)) {
              $num_trabajador = $_POST['intNum_Trabajador'];
            }
            $fechaInicio = $_POST['strFechaInicio'];
            $fechaFin = $_POST['strFechaFin']; 
            $horaInicio = $_POST['strHoraInicio']; 
            $horaFin = $_POST['strHoraFin'];

            //*? Creado para guardar los inputs. Solo guarda los que tienen algo
            $diasModerador=array();
            foreach($arr_dias as $dia){
              static $bandera =  1; 
              
              if(isset($_POST['strDiaServicio'.$bandera]) && $_POST['strDiaServicio'.$bandera] != "" ) {
                $diasModerador[$bandera] = $_POST['strDiaServicio'.$bandera];
              } 
              $bandera++;
            }

          break; 

          case PROFESOR:
            $semblanza = null;
            $num_trabajador = $_POST['intNum_Trabajador'];
            $nombramiento = $_POST['nombramiento'];
            
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

        //? Se buscan datos pre-existentes de profesor y persona (Se hace con Profesor por el autollenado)
        $profesor_existente = $obj_Profesor->buscarNumTrabajador($_POST['intNum_Trabajador'], null);
        
        if (isset($profesor_existente)) {
          $persona = $profesor_existente->prof_id_persona;
        } else {
          $obj_Persona->agregarPersona($nombre, $apellidoPaterno, $apellidoMaterno, $correo, $telefono, $rfc, $sexo);
          $persona = $obj_Persona->buscarUltimo();
        }
        
        $obj_Usuario->agregarUsuario($persona, $rol, $pregunta, $nombreUsuario, $contrasenia, $estado);

        //? Crear el Profesor
        switch($rol){
          case ADMINISTRADOR: //Administrador
            //? Si ya hay un profesor existente, ya no se registra nada
            if(!isset($profesor_existente)) {
              $obj_Profesor->agregarProfesor($persona, $num_trabajador, null, null);
            } 
          break;

          case MODERADOR: //Moderador
            //? Se debe de registrar un Servidor social
            if(isset($num_cuenta)) {
              $obj_Moderador->agregarServidor($persona, $num_cuenta);
            //? Se debde registrar un Profesor
            } else {
              //? Si ya hay un profesor existente, ya no se registra nada
              if(!isset($profesor_existente)) {
                $obj_Profesor->agregarProfesor($persona, $num_trabajador, null, null);
              }
            }

            $obj_Moderador->agregarModerador($obj_Usuario->buscarUsuarioPersona($persona, $rol)->usua_id_usuario, $fechaInicio, $fechaFin, $horaInicio, $horaFin );
            foreach($diasModerador as $id){
              $obj_Moderador->agregarDiasModerador($persona, $id);
            }
          break;

          case INSTRUCTOR: 
            //? Si ya hay un profesor existente, ya no se registra nada
            if(!isset($profesor_existente)) {
              $obj_Profesor->agregarProfesor($persona, $num_trabajador, $semblanza, null);
            } else {
              //? Si ya existe un profesor existente se actualiza sus datos por si no tiene semblanza
              $obj_Profesor->actualizarProfesor($persona, $num_trabajador, $semblanza, null);
            }
          break;

          case PROFESOR: 
            if(!isset($profesor_existente)) {
              $obj_Profesor->agregarProfesor($persona, $num_trabajador, null, $nombramiento);
            } 
            
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
        

        exit("1");
      } else {
        exit("2");
      }
        
    }
    elseif($_POST['dml'] == 'update')
    {
      $nombreUsu = $_POST['strNombreUsuario'];
      $usuario_existente = $obj_Usuario->buscarNombreUsuario($nombreUsu);
      $idPersona = $_POST['idPersona'];
      $idUsuario = $_POST['idUsuario'];

      $esElMismo = 0;
      if(isset($usuario_existente->usua_num_usuario) && ($nombreUsu == $usuario_existente->usua_num_usuario && $idUsuario == $usuario_existente->usua_id_usuario)){
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
        $sexo = $_POST['strSexo'];
        
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
          $nombramiento = $_POST['nombramiento'];

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
          $fechaInicio = $_POST['strFechaInicio'];
          $fechaFin = $_POST['strFechaFin']; 
          $horaInicio = $_POST['strHoraInicio']; 
          $horaFin = $_POST['strHoraFin'];

          $diasModerador=array();
          foreach($arr_dias as $dia){
            static $bandera =  1; 
            if(isset($_POST['strDiaServicio'.$bandera]) && $_POST['strDiaServicio'.$bandera] != "" ) {
              $diasModerador[$bandera] = $_POST['strDiaServicio'.$bandera];
            } 
            $bandera++;
          }
          //? Si existe un registro como Servidor Social, llamo al id para usar el isset
          if (isset($obj_Moderador->buscarServidorSocial($_POST['idPersona'])->seso_id_servidor)) {
            $num_cuenta = $_POST['intNumCuenta'];
          } else {
            $num_trabajador = $_POST['intNum_Trabajador'];
            $rfc = $_POST['strRFC'];
          }
        }
        
        $obj_Persona->actualizarPersona($idPersona, $nombre, $apellidoPaterno, $apellidoMaterno, $correo, $telefono, $rfc, $sexo);
        
        $obj_Usuario->actualizarUsuario($idPersona, $rol, $pregunta, $nombreUsuario, $contrasenia);

        switch($rol){
          case ADMINISTRADOR:
            $obj_Profesor->actualizarProfesor($idPersona, $num_trabajador, null, null);
          break;

          case MODERADOR:
            //? Primero debemos de saber si es un moderador Profesor o Servidor Social
            if(isset($num_trabajador)) {
              //? Si el número de trabajador es diferente a 6 es un error por que no se puede haber registrado
              //? a un profesor y despues cambiarlo a serviddr social
              if (strlen($num_trabajador) < 6 || strlen($num_trabajador) > 6) {
                exit("3");
              }
              $obj_Profesor->actualizarProfesor($idPersona, $num_trabajador, null, null);

              //? Si tiene número de cuenta es un servidor social
            } elseif (isset($num_cuenta)) {
              //? Si el número de cuenta es diferente a 9 es un error por que no se puede haber registrado
              //? a un Servidor Social  y despues cambiarlo a Profesora
              if (strlen($num_cuenta) < 9 || strlen($num_cuenta) > 9) {
                exit("4");
              }
              $obj_Moderador->actualizarServidor($idPersona , $num_cuenta);
            }

            $obj_Moderador->actualizarModerador($idPersona, $fechaInicio, $fechaFin, $horaInicio, $horaFin);
            $obj_Moderador->eliminarDiasModerador($idPersona);

            foreach($diasModerador as $id){
              $obj_Moderador->agregarDiasModerador($idPersona, $id);
            } 
          break; 

          case PROFESOR:
            $obj_Profesor->actualizarProfesor($idPersona, $num_trabajador, null, $nombramiento);
            
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

          case INSTRUCTOR:
            $obj_Profesor->actualizarProfesor($idPersona, $num_trabajador, $semblanza, $nombramiento);
          break;
        }
        exit("1");
      } else {
        exit("2");
      }
    }
    elseif($_POST['dml'] == 'deleteDeprecated')
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
    elseif($_POST['dml'] == 'llenadoPersona')
    {
      $resultado = array();
      $persona = $obj_Persona->buscarPersonaRFC($_POST['rfc']);
      
      
      if (isset($persona->pers_id_persona)) {
        $resultado ['estado'] = "Encontrado";
        $resultado ['nombre'] = $persona->pers_nombre;
        $resultado ['apellidoPaterno'] = $persona->pers_apellido_paterno;
        $resultado ['apellidoMaterno'] = $persona->pers_apellido_materno;
        $resultado ['correo'] = $persona->pers_correo;
        $resultado ['telefono'] = $persona->pers_telefono;
        $resultado ['sexo'] = $persona->pers_sexo;
        
      } else {
        $resultado ['estado'] = "Nulo";
      }
      echo json_encode($resultado);
      
    }
    elseif($_POST['dml'] == 'llenadoProfesor')
    {
      
      $resultado = array();
      $profesor = $obj_Profesor->buscarNumTrabajador($_POST['numTrabajador'], null);
      
      if (isset($profesor->prof_id_profesor)) {
        
        //? Asignamos al arreglo Json los datos del profesor
        $resultado ['estado'] = "Encontrado";
        $resultado ['idProfesor'] = $profesor->prof_id_profesor;
        $resultado ['idPersona'] = $profesor->prof_id_persona;
        $resultado ['numTrabajador'] = $profesor->prof_num_trabajador;
        $resultado ['semblanza'] = $profesor->prof_semblanza;
        $resultado ['rfc'] = $profesor->pers_rfc;
        $resultado ['sexo'] = $profesor->pers_sexo;
        
        $resultado ['nombre'] = $profesor->pers_nombre;
        $resultado ['apellidoPaterno'] = $profesor->pers_apellido_paterno;
        $resultado ['apellidoMaterno'] = $profesor->pers_apellido_materno;
        $resultado ['correo'] = $profesor->pers_correo;
        $resultado ['telefono'] = $profesor->pers_telefono;
           
        } else {
          $resultado ['estado'] = "Nulo";
        } 
        echo json_encode($resultado);
        
    }else if($_POST['dml'] == 'updateCuenta'){
      $obj_Persona->actualizarPersonaCuenta($_POST['idPersona'], $_POST['strUsuarioCorreo'], $_POST['strUsuarioTelefono']);

      exit("1");
    } else {
      exit("3");
    }
  }
?>