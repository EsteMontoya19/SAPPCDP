<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="SICENAPYME">
  <meta name="author" content="">

  <!-- Título de la página -->
  <title>Inicio de sesión</title>

  <!-- Referencias -->

  <!-- Iconos -->
  <link href="recursos/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Icono de la pestaña -->
  <link rel="recursos/shortcut icon" href="recursos/favicon.ico" />

  <!-- Alertify -->
  <link rel="stylesheet" type="text/css" href="recursos/alertify/css/alertify.css">
  <link rel="stylesheet" type="text/css" href="recursos/alertify/css/alertify.rtl.css">
  <link rel="stylesheet" type="text/css" href="recursos/alertify/css/themes/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="recursos/alertify/css/themes/bootstrap.rtl.css">

  <!-- Bootstrap 4 -->
  <link href="recursos/css/bootstrap.css" rel="stylesheet" type="text/css">
  <link href="recursos/css/bootstrap.css.map" rel="stylesheet" type="text/css">
  <link href="recursos/css/sb-admin.css" rel="stylesheet" type="text/css">
  <link href="recursos/css/sicenapyme.css" rel="stylesheet" type="text/css">
  <link href="recursos/css/bootstrap-modificado.css" rel="stylesheet" type="text/css">

  <!-- JQuery -->
  <script src="recursos/js/jquery-3.4.1.js"></script>

  <!-- DropItemps -->
  <script src="recursos/js/bootstrap.bundle.js"></script>

  <!-- Alertify -->
  <script src="recursos/alertify/alertify.js"></script>

  <!-- Direcciones del sistema-->
  <script src="sistema/recursos/body.js"></script>
</head>

<?php
    //Clases
  include('clases/BD.php');
  include('clases/Grupo.php');
  
    //Objetos y Arreglos
  $obj_Grupo = new Grupo();
  $arr_grupos = $obj_Grupo ->buscarGruposProfesores();
?>


<body >
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
                    <th>Nivel</th>
                    <th>Objetivo</th>
                    <th>Modalidad</th>
                    <th>Lugares Disponibles</th>
                    <th>Último día de inscripciones*</th>
                    <th>Número de sesiones</th>
                    <th>Opciones</th>
                    <!--
                    <th>Tipo</th>
                    <th>Modalidad</th>
                    <th>Lugares Disp</th>
                    <th>Profesor</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Número de sesiones</th>
                    <th>Opciones</th>
                    -->
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
                  foreach ($arr_grupos as $grupo) {?>
                      <tr>
                        <td><?php echo $grupo['grup_id_grupo'];?></td>
                        <td><?php echo $grupo['curs_nombre'];?></td>
                        <!--
                        <td><?php /* echo $grupo['curs_tipo'];?></td>
                        <td><?php echo $grupo['grup_modalidad'];?></td>
                        <td><?php echo ($grupo['grup_cupo'] - $grupo['grup_num_inscritos']);?></td>
                        <td><?php echo $grupo['pers_nombre'];?> <?php echo $grupo['pers_apellido_paterno'];?> <?php echo $grupo['pers_apellido_materno'];?></td>
                        <td><?php echo $grupo['grup_inicio_insc'];?></td>
                        <td><?php echo $grupo['grup_fin_insc'];?></td>
                        <td><?php echo $grupo['curs_num_sesiones'];*/?></td>
                        -->
                        <td><?php echo $grupo['curs_nivel'];?></td>
                        <td><?php echo $grupo['curs_objetivos'];?></td>
                        <td><?php echo $grupo['grup_modalidad'];?></td>
                        <td><?php echo ($grupo['grup_cupo'] - $grupo['grup_num_inscritos']);?></td>
                        <td><?php echo $grupo['grup_fin_insc'];?></td>
                        <td><?php echo $grupo['curs_num_sesiones'];?></td>
                        <td>
                          <a href="index.php" type="button" class="btn btn-info btn-table" title="Detalles" style="margin-top: 5px;">
                            <i>¡Inscríbete!</i>
                          </a>
                        </td>
                      </tr>
                  <?php } } ?>
                  
                </tbody>
              </table>
              <?php
              //? Tenemos en el css un estilo para las leyendas importantes?
              ?>
              <p> <FONT color="#FD2424">*Los grupos se cierran cuando se alcanza el máximo de inscritos o despúes del último día de insripción.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="sistema/profesor/control_profesores.js"></script>
</body>

</html>