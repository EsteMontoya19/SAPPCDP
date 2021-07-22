<?php
  include('../../clases/BD.php');
  include('../../clases/Grupo.php');
  include('../../clases/Profesor.php');
  include('../../clases/Sesion.php');

  $obj_Grupo = new Grupo();
  $arr_grupos = $obj_Grupo ->buscarGruposProfesores();
  $obj_Sesion = new Sesion();
  
if (isset($_POST['persona'])) {
    $idPersona = $_POST['persona'];
    $obj_profesor = new Profesor();
    $profesor = $obj_profesor->buscarInstructorxPersona($idPersona);
    if (isset($profesor)) {
        $id_profesor=$profesor->usua_id_usuario;
    } else {
        $id_profesor=0;
    }
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
              <i class="fas fa-home"></i>&nbsp; Inicio
            </li>
            </ol>
          </div>
        </div>


        <h1 style="font-size: 2rem; color:#212529; margin:1% 0 2% 1%; text-align:left">Bienvenido al Sistema de Apoyo al Programa Permanente de Capacitación a Distancia de Profesores de la FCA.</h1>
        <p>
          <hr>
        </p>

        <h2 style="font-size: 1.5rem; color:#126e82; margin:1% 0 2% 1%">Cursos disponibles</h2>
        <div class="card mb-3">
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
                    if (isset($arr_grupos)) {
                      foreach ($arr_grupos as $grupo) {
 
                        if ($grupo['usua_id_usuario'] != $id_profesor) {
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

                            <button type="button" class="btn btn-info btn-table" title="Detalles" style="margin-top: 5px;" onclick="consultarGrupo(<?php echo $grupo['grup_id_grupo']?>, <?php echo $idPersona?>, <?php echo $grupo['moap_id_modalidad']?>)">
                              <i class="fas fa-search-plus"></i>
                            </button>
                          </td>
                        </tr>
                      <?php } 
                      }
                    } ?>
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="../sistema/profesor/control_profesores.js"></script>
