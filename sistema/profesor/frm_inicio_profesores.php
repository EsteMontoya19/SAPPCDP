<?php
  include('../../clases/BD.php');
  include('../../clases/Grupo.php');
  include('../../clases/Profesor.php');
  include('../../clases/Sesion.php');

  $obj_Grupo = new Grupo();
  $arr_grupos = $obj_Grupo ->buscarGruposProfesores();
  $obj_Sesion = new Sesion();
  
  if (isset($_POST['persona'])){
    $idPersona = $_POST['persona'];
    $obj_profesor = new Profesor();
    $id_profesor = $obj_profesor->buscarProfesorxPersona($idPersona);
  } else {
    $idPersona = 0;
  }

?>

  <div id="wrapper">
    <div id="content-wrapper">
      <div class="container-fluid">

        <!-- Indicador -->
        <div class="form-inline">
          <div class="col-sm-12">
            <ol class="breadcrumb">
            <li class="breadcrumb-item active">
              <i class="fas fa-users"></i>&nbsp; Grupos publicados
            </li>
            </ol>
          </div>
        </div>

        <p>
          <hr>
        </p>

        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-folder"></i> Resultados
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-condensed table-hover" id="tabla_grupos" width="100%" cellspacing="0">
                <thead class="thead-dark">
                  <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Modalidad</th>
                    <th>Lugares Disp</th>
                    <th>Profesor</th>
                    <th>Periodo de Inscripciones</th>
                    <th>Número de sesiones</th>
                    <th>Primera Sesión</th>
                    <th>Opciones</th>
                  </tr>
                </thead>
                <tbody>
                  
                                                          <!--
                                                            Se usa para validar que el id del profesor que esta consultando los grupos
                                                            no sea el mismo que el del grupo publicado, así directamente si es el mismo
                                                            quiere decir que el imparte el grupo, por lo que no hay motivo para que le 
                                                            permita inscribirse o verlo como posibilidad de grupo a inscribirse.
                                                          -->
                  <?php
                  if(isset($arr_grupos)){ 
                  foreach ($arr_grupos as $grupo) { 
                    if($grupo['usua_id_usuario'] != $id_profesor->usua_id_usuario) {
                      $sesion = $obj_Sesion->numSesionesGrupo($grupo['grup_id_grupo']);
                      $sesionUno = $obj_Sesion->buscarMinSesionDM($grupo['grup_id_grupo']);?>
                      <tr>
                        <td><?php echo $grupo['grup_id_grupo'];?></td>
                        <td><?php echo $grupo['curs_nombre'];?></td>
                        <td><?php echo $grupo['curs_tipo'];?></td>
                        <td><?php echo $grupo['moap_nombre'];?></td>
                        <td><?php echo ($grupo['grup_cupo'] - $grupo['grup_num_inscritos']);?></td>
                        <td><?php echo $grupo['pers_nombre'];?> <?php echo $grupo['pers_apellido_paterno'];?> <?php echo $grupo['pers_apellido_materno'];?></td>
                        <td><?php echo $grupo['diaini'].'-'.$grupo['mesini'].' al '.$grupo['diafin'].'-'.$grupo['mesfin'];?></td>
                        <td><?php echo $sesion->numero;?></td>
                        <td><?php echo $sesionUno->dia.'-'.$sesionUno->mes;?></td>
                        <td>

                          <button type="button" class="btn btn-info btn-table" title="Detalles" style="margin-top: 5px;" onclick="consultarGrupo(<?php echo $grupo['grup_id_grupo']?>,'<?php echo $idPersona?>')">
                            <i class="fas fa-search-plus"></i>
                          </button>
                        </td>
                      </tr>
                  <?php } } } ?>
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="../sistema/profesor/control_profesores.js"></script>

