<?php

  include('../clases/BD.php');
  include('../clases/Grupo.php');
  include('../clases/Horario.php');
  include('../clases/Periodo.php');
  include('../clases/Ponente.php');

  $obj_Grupo = new Grupo();
  $obj_Horario = new Horario();
  $obj_Periodo = new Periodo();
  $obj_Ponente = new Ponente();


  if($_POST['dml'] == 'insert')
  {
    
    $modalidad = $_POST['GrupoModalidad'];
    $estatus_grupo = $_POST['GrupoEstatus'];
    $cupo = $_POST['GrupoCupo'];
    $evento = $_POST['GrupoCurso'];
    $evento_id = substr($evento, 2);
    $clave = 'Prueba';
    $tipo_evento = $evento[0];

    //echo 'evento id = ' . $evento_id;
    //echo ' | tipo_evento id = ' . $evento_id;

    if ($tipo_evento != '4') {

      //echo " | No es webinar";

      $profesor = $_POST['GrupoProfesores'];
      $periodo_ini1 = $_POST['GrupoInsInicio'];
      $periodo_fin1 = $_POST['GrupoInsFin'];
      $periodo_ini2 = $_POST['GrupoCurInicio'];
      $periodo_fin2 = $_POST['GrupoCurFin'];

      $obj_Grupo->agregarGrupo($estatus_grupo, $evento_id, $modalidad, $profesor, $clave, $cupo);
      $grupo = $obj_Grupo->id_grupo;

      $periodo_tipo = 1;
      $obj_Periodo->agregarPeriodo($grupo, $periodo_ini1, $periodo_fin1, $periodo_tipo);

      $periodo_tipo = 2;
      $obj_Periodo->agregarPeriodo($grupo, $periodo_ini2, $periodo_fin2, $periodo_tipo);

      $dia1 = $_POST['GrupoDia1'];
      $salon1 = $_POST['GrupoSalon1'];
      $hora_inicio1 = $_POST['GrupoHoraInicio1'];
      $hora_fin1 = $_POST['GrupoHoraFin1'];

      $dia2 = $_POST['GrupoDia2'];
      $salon2 = $_POST['GrupoSalon2'];
      $hora_inicio2 = $_POST['GrupoHoraInicio2'];
      $hora_fin2 = $_POST['GrupoHoraFin2'];

      $dia3 = $_POST['GrupoDia3'];
      $salon3 = $_POST['GrupoSalon3'];
      $hora_inicio3 = $_POST['GrupoHoraInicio3'];
      $hora_fin3 = $_POST['GrupoHoraFin3'];

      $dia4 = $_POST['GrupoDia4'];
      $salon4 = $_POST['GrupoSalon4'];
      $hora_inicio4 = $_POST['GrupoHoraInicio4'];
      $hora_fin4 = $_POST['GrupoHoraFin4'];

      $dia5 = $_POST['GrupoDia5'];
      $salon5 = $_POST['GrupoSalon5'];
      $hora_inicio5 = $_POST['GrupoHoraInicio5'];
      $hora_fin5 = $_POST['GrupoHoraFin5'];

      $dia6 = $_POST['GrupoDia6'];
      $salon6 = $_POST['GrupoSalon6'];
      $hora_inicio6 = $_POST['GrupoHoraInicio6'];
      $hora_fin6 = $_POST['GrupoHoraFin6'];

      if ($dia1 != 0)
      {
        $obj_Horario->agregarHorario($dia1, $salon1, $grupo, $hora_inicio1, $hora_fin1);
      }
      if ($dia2 != 0)
      {
        $obj_Horario->agregarHorario($dia2, $salon2, $grupo, $hora_inicio2, $hora_fin2);
      }
      if ($dia3 != 0)
      {
        $obj_Horario->agregarHorario($dia3, $salon3, $grupo, $hora_inicio3, $hora_fin3);
      }
      if ($dia4 != 0)
      {
        $obj_Horario->agregarHorario($dia4, $salon4, $grupo, $hora_inicio4, $hora_fin4);
      }
      if ($dia5 != 0)
      {
        $obj_Horario->agregarHorario($dia5, $salon5, $grupo, $hora_inicio5, $hora_fin5);
      }if ($dia6 != 0)
      {
        $obj_Horario->agregarHorario($dia6, $salon6, $grupo, $hora_inicio6, $hora_fin6);
      }
    } else {

      //echo " | Es webinar";

      $profesor = NULL;

      $obj_Grupo->agregarGrupoWebinar($estatus_grupo, $evento_id, $modalidad, $tipo_grupo, $clave, $cupo, $costo, $descuento);
      $grupo = $obj_Grupo->id_grupo;

      $periodo_ini1 = $_POST['GrupoInsInicioWeb'];
      $periodo_fin1 = $_POST['GrupoInsFinWeb'];

      $periodo_tipo = 1;
      $obj_Periodo->agregarPeriodo($grupo, $periodo_ini1, $periodo_fin1, $periodo_tipo);

      $periodo_ini2 = $_POST['GrupoCurInicioWeb'];
      $periodo_fin2 = NULL;

      $periodo_tipo = 2;
      $obj_Periodo->agregarPeriodoWeb($grupo, $periodo_ini2, $periodo_tipo);

      $dia1 = 1;
      $salon1 = $_POST['UDTGrupoSalonWeb'];
      $hora_inicio1 = $_POST['UDTGrupoHoraInicioWeb'];
      $hora_fin1 = $_POST['UDTGrupoHoraFinWeb'];

      $obj_Horario->agregarHorario($dia1, $salon1, $grupo, $hora_inicio1, $hora_fin1);

      $ponente1 = $_POST['PonenteNombre1'];
      $cargo1 = $_POST['PonenteCargo1'];
      $semblanza1 = $_POST['PonenteSemblanza1'];

      $obj_Ponente->agregarPonente($grupo, $ponente1, $cargo1, $semblanza1);

      $ponente2 = $_POST['PonenteNombre2'];
      $cargo2 = $_POST['PonenteCargo2'];
      $semblanza2 = $_POST['PonenteSemblanza2'];

      $ponente3 = $_POST['PonenteNombre3'];
      $cargo3 = $_POST['PonenteCargo3'];
      $semblanza3 = $_POST['PonenteSemblanza3'];

      if ($ponente2 != '')
      {
        $obj_Ponente->agregarPonente($grupo, $ponente2, $cargo2, $semblanza2);
      }
      if ($ponente3 != '')
      {
        $obj_Ponente->agregarPonente($grupo, $ponente3, $cargo3, $semblanza3);
      }
    }

    echo 1;
  }
  elseif($_POST['dml'] == 'update')
  {
    $grupo = $_POST['idGrupo'];
    $modalidad = $_POST['GrupoModalidad'];
    $estatus_grupo = $_POST['GrupoEstatus'];
    $cupo = $_POST['GrupoCupo'];
    $clave = 'Prueba';

    $evento = $_POST['id_evento'];
    $tipo_evento = $obj_Grupo->buscarTipoEvento($grupo);

    if ($tipo_evento->even_id_tiev != '4') {
      $profesor = $_POST['GrupoProfesores'];

      $obj_Grupo->actualizarGrupo($grupo, $estatus_grupo, $evento, $modalidad, $profesor, $clave, $cupo);

      $perido1 = $_POST['idPeriodo1'];
      $periodo_ini1 = $_POST['GrupoInsInicio'];
      $periodo_fin1 = $_POST['GrupoInsFin'];
      $obj_Periodo->actualizarPeriodo(95, $periodo_ini1, $periodo_fin1);


      $periodo2 = $_POST['idPeriodo2'];
      $periodo_ini2 = $_POST['GrupoCurInicio'];
      $periodo_fin2 = $_POST['GrupoCurFin'];
      $obj_Periodo->actualizarPeriodo(96, $periodo_ini2, $periodo_fin2);

      if(isset($_POST['idHorario1']))
      {
        $horario1 = $_POST['idHorario1'];
        $dia1 = $_POST['UDTGrupoDia1'];
        $salon1 = $_POST['UDTGrupoSalon1'];
        $hora_inicio1 = $_POST['UDTGrupoHoraInicio1'];
        $hora_fin1 = $_POST['UDTGrupoHoraFin1'];

        if ($dia1 != NULL)
        {
          $obj_Horario->actualizarHorario($horario1, $dia1, $salon1, $hora_inicio1, $hora_fin1);
        }
      }

      if(isset($_POST['idHorario2']))
      {
        $horario2 = $_POST['idHorario2'];
        $dia2 = $_POST['UDTGrupoDia2'];
        $salon2 = $_POST['UDTGrupoSalon2'];
        $hora_inicio2 = $_POST['UDTGrupoHoraInicio2'];
        $hora_fin2 = $_POST['UDTGrupoHoraFin2'];

        if ($dia1 != NULL)
        {
          $obj_Horario->actualizarHorario($horario2, $dia2, $salon2, $hora_inicio2, $hora_fin2);
        }
      }

      if(isset($_POST['idHorario3']))
      {
        $horario3 = $_POST['idHorario3'];
        $dia3 = $_POST['UDTGrupoDia3'];
        $salon3 = $_POST['UDTGrupoSalon3'];
        $hora_inicio3 = $_POST['UDTGrupoHoraInicio3'];
        $hora_fin3 = $_POST['UDTGrupoHoraFin3'];

        if ($dia1 != NULL)
        {
          $obj_Horario->actualizarHorario($horario3, $dia3, $salon3, $hora_inicio3, $hora_fin3);
        }
      }

      if(isset($_POST['idHorario4']))
      {
        $horario4 = $_POST['idHorario4'];
        $dia4 = $_POST['UDTGrupoDia4'];
        $salon4 = $_POST['UDTGrupoSalon4'];
        $hora_inicio4 = $_POST['UDTGrupoHoraInicio4'];
        $hora_fin4 = $_POST['UDTGrupoHoraFin4'];

        if ($dia1 != NULL)
        {
          $obj_Horario->actualizarHorario($horario4, $dia4, $salon4, $hora_inicio4, $hora_fin4);
        }
      }

      if(isset($_POST['idHorario5']))
      {
        $horario5 = $_POST['idHorario5'];
        $dia5 = $_POST['UDTGrupoDia5'];
        $salon5 = $_POST['UDTGrupoSalon5'];
        $hora_inicio5 = $_POST['UDTGrupoHoraInicio5'];
        $hora_fin5 = $_POST['UDTGrupoHoraFin5'];

        if ($dia1 != NULL)
        {
          $obj_Horario->actualizarHorario($horario5, $dia5, $salon5, $hora_inicio5, $hora_fin5);
        }
      }

      if(isset($_POST['idHorario6']))
      {
        $horario6 = $_POST['idHorario6'];
        $dia6 = $_POST['UDTGrupoDia6'];
        $salon6 = $_POST['UDTGrupoSalon6'];
        $hora_inicio6 = $_POST['UDTGrupoHoraInicio'];
        $hora_fin6 = $_POST['UDTGrupoHoraFin6'];

        if ($dia1 != NULL)
        {
          $obj_Horario->actualizarHorario($horario6, $dia6, $salon6, $hora_inicio6, $hora_fin6);
        }
      }

      if(isset($_POST['GrupoDia1']))
      {
        if($_POST['GrupoDia1'] != 0)
        {
          $NEWdia1 = $_POST['GrupoDia1'];
          $NEWsalon1 = $_POST['GrupoSalon1'];
          $NEWhora_inicio1 = $_POST['GrupoHoraInicio1'];
          $NEWhora_fin1 = $_POST['GrupoHoraFin1'];

          if ($NEWdia1 != NULL)
          {
            $obj_Horario->agregarHorario($NEWdia1, $NEWsalon1, $grupo, $NEWhora_inicio1, $NEWhora_fin1);
          }
        }
      }

      if(isset($_POST['GrupoDia2']))
      {
        if($_POST['GrupoDia2'] != 0)
        {
          $NEWdia2 = $_POST['GrupoDia2'];
          $NEWsalon2 = $_POST['GrupoSalon2'];
          $NEWhora_inicio2 = $_POST['GrupoHoraInicio2'];
          $NEWhora_fin2 = $_POST['GrupoHoraFin2'];

          if ($NEWdia2 != NULL)
          {
            $obj_Horario->agregarHorario($NEWdia2, $NEWsalon2, $grupo, $NEWhora_inicio2, $NEWhora_fin2);
          }
        } 
        
      }

      if(isset($_POST['GrupoDia3']))
      {
        if($_POST['GrupoDia3'] != 0)
        {
          $NEWdia3 = $_POST['GrupoDia3'];
          $NEWsalon3 = $_POST['GrupoSalon3'];
          $NEWhora_inicio3 = $_POST['GrupoHoraInicio3'];
          $NEWhora_fin3 = $_POST['GrupoHoraFin3'];

          if ($NEWdia3 != NULL)
          {
            $obj_Horario->agregarHorario($NEWdia3, $NEWsalon3, $grupo, $NEWhora_inicio3, $NEWhora_fin3);
          }
        }
        
      }

      if(isset($_POST['GrupoDia4']))
      {
        if($_POST['GrupoDia4'] != 0)
        {
          $NEWdia4 = $_POST['GrupoDia4'];
          $NEWsalon4 = $_POST['GrupoSalon4'];
          $NEWhora_inicio4 = $_POST['GrupoHoraInicio4'];
          $NEWhora_fin4 = $_POST['GrupoHoraFin4'];

          if ($NEWdia4 != NULL)
          {
            $obj_Horario->agregarHorario($NEWdia4, $NEWsalon4, $grupo, $NEWhora_inicio4, $NEWhora_fin4);
          }
        }
      }

      if(isset($_POST['GrupoDia5']))
      {
        if($_POST['GrupoDia5'] != 0)
        {
          $NEWdia5 = $_POST['GrupoDia5'];
          $NEWsalon5 = $_POST['GrupoSalon5'];
          $NEWhora_inicio5 = $_POST['GrupoHoraInicio5'];
          $NEWhora_fin5 = $_POST['GrupoHoraFin5'];

          if ($NEWdia5 != NULL)
          {
            $obj_Horario->agregarHorario($NEWdia5, $NEWsalon5, $grupo, $NEWhora_inicio5, $NEWhora_fin5);
          }
        }
      }

      if(isset($_POST['GrupoDia6']))
      {
        if($_POST['GrupoDia6'] != 0)
        {
          $NEWdia6 = $_POST['GrupoDia6'];
          $NEWsalon6 = $_POST['GrupoSalon6'];
          $NEWhora_inicio = $_POST['GrupoHoraInicio6'];
          $NEWhora_fin6 = $_POST['GrupoHoraFin6'];

          if ($NEWdia6 != NULL)
          {
            $obj_Horario->agregarHorario($NEWdia6, $NEWsalon6, $grupo, $NEWhora_inicio6, $NEWhora_fin6);
          }
        }
      }


      echo 1;
    } else {
      //echo " | Es webinar";

      $obj_Grupo->actualizarGrupoWeb($grupo, $estatus_grupo, $evento, $modalidad, $tipo_grupo, $clave, $cupo, $costo, $descuento);

      $perido1 = $_POST['idPeriodo1'];
      $periodo_ini1 = $_POST['GrupoInsInicio'];
      $periodo_fin1 = $_POST['GrupoInsFin'];
      $obj_Periodo->actualizarPeriodo($perido1, $periodo_ini1, $periodo_fin1);


      $periodo2 = $_POST['idPeriodo2'];
      $periodo_ini2 = $_POST['GrupoCurInicioWeb'];
      $obj_Periodo->actualizarPeriodoWeb($periodo2, $periodo_ini2);

      $horario = $_POST['ID_HorarioWeb'];
      $dia1 = 1;
      $salon1 = $_POST['UDTGrupoSalonWeb'];
      $hora_inicio1 = $_POST['UDTGrupoHoraInicioWeb'];
      $hora_fin1 = $_POST['UDTGrupoHoraFinWeb'];

      $obj_Horario->actualizarHorario($horario, $dia1, $salon1, $hora_inicio1, $hora_fin1);

      $id_ponente1 = $_POST['id_Ponente1'];
      $ponente1 = $_POST['PonenteNombreCRUD1'];
      $cargo1 = $_POST['PonenteCargoCRUD1'];
      $semblanza1 = $_POST['PonenteSemblanzaCRUD1'];

      $obj_Ponente->actualizarPonente($id_ponente1, $ponente1, $cargo1, $semblanza1);

      if (isset($_POST['id_Ponente2'])) {
        $id_ponente2 = $_POST['id_Ponente2'];
        $ponente2 = $_POST['PonenteNombreCRUD2'];
        $cargo2 = $_POST['PonenteCargoCRUD2'];
        $semblanza2 = $_POST['PonenteSemblanzaCRUD2'];

        $obj_Ponente->actualizarPonente($id_ponente2, $ponente2, $cargo2, $semblanza2);
      }

      if (isset($_POST['id_Ponente3'])) {
        $id_ponente3 = $_POST['id_Ponente3'];
        $ponente3 = $_POST['PonenteNombreCRUD3'];
        $cargo3 = $_POST['PonenteCargoCRUD3'];
        $semblanza3 = $_POST['PonenteSemblanzaCRUD3'];

        $obj_Ponente->actualizarPonente($id_ponente3, $ponente3, $cargo3, $semblanza3);
      }

      $n_ponente2 = $_POST['PonenteNombre2'];
      $n_cargo2 = $_POST['PonenteCargo2'];
      $n_semblanza2 = $_POST['PonenteSemblanza2'];

      $n_ponente3 = $_POST['PonenteNombre3'];
      $n_cargo3 = $_POST['PonenteCargo3'];
      $n_semblanza3 = $_POST['PonenteSemblanza3'];

      if ($n_ponente2 != '')
      {
        $obj_Ponente->agregarPonente($grupo, $n_ponente2, $n_cargo2, $n_semblanza2);
      }
      if ($n_ponente3 != '')
      {
        $obj_Ponente->agregarPonente($grupo, $n_ponente3, $n_cargo3, $n_semblanza3);
      }
      
      echo 1;
    }
  }
  elseif($_POST['dml'] == 'delete')
  {
    $grupo = $_POST['id'];
    $obj_Ponente->eliminarTodosPonentes($grupo);
    $obj_Horario->eliminarTodosHorario($grupo);
    $obj_Periodo->eliminarTodosPeriodos($grupo);
    $obj_Grupo->eliminarGrupo($grupo);

    echo 1;
  }
  elseif($_POST['dml'] == 'borrar')
  {
    $horario = $_POST['id'];

    $obj_Horario->eliminarHorario($horario);

    echo 1;
  }
  elseif($_POST['dml'] == 'eliminar_ponente')
  {
    $ponente = $_POST['id'];

    $obj_Ponente->eliminarPonente($ponente);

    echo 1;
  }
?>
