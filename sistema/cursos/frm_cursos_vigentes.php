<?php
include('../../clases/BD.php');
include('../../clases/Curso.php');

$obj_curso = new Curso();
$arr_cursos = $obj_curso->buscarTodosCursos();

$x = 0;
?>

<script>
    $(document).ready(function () {
        $('#btn_registro_curso').click(function () {
            $('#container').load('../sistema/cursos/frm_cursos');
        });
    });
</script>

<script src="../cursos/control_cursos.js"></script>

<div id="wrapper">
    <div id="content-wrapper">
        <div class="container-fluid">

            <!-- Indicador -->
            <div class="form-inline">
                <div class="col-sm-10" style="padding:0px">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">
                            <i class="fas fa-user-shield"></i>&nbsp; Cursos vigentes
                        </li>
                    </ol>
                </div>
                <div class="col-sm-2" align="center">
                    <a href="#">
                        <button id="btn_registro_curso" type="button" class="btn btn-success">
                            <i class="fas fa-plus-circle"></i>&nbsp;&nbsp; Agregar Curso
                        </button>
                    </a>
                </div>
            </div>

            <p>
                <hr>
            </p>

            <!-- Tabla -->
            <div class="card mb-3">
                <div class="table-responsive">
                    <table class="table table-condensed table-hover" id="tabla_usuarios" width="100%" cellspacing="0">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nombre del curso</th>
                                <th>Tipo</th>
                                <th>Nivel</th>
                                <th>Número de sesiones</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- <?php foreach ($arr_usuarios as $usuario) { ?>
                            <tr>
                                <?php $x++; ?>
                                <td><?php echo $usuario['usua_id_usuario']; ?></td>
                                <td><?php echo $usuario['pers_nombre']; ?></td>
                                <td><?php echo $usuario['pers_apellido_paterno']; ?></td>
                                <td><?php echo $usuario['pers_apellido_materno']; ?></td>
                                <td><?php echo $usuario['rol_nombre']; ?></td>

                                <td>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="estatusUsuario<?php echo $x ?>"
                                            <?php if ($usuario['usua_activo'] == 't') { ?> checked <?php } ?>
                                            onclick="cambioEstatus(<?php echo $usuario['usua_id_usuario'] ?> , '<?php echo $usuario['usua_activo']; ?>', '<?php echo $usuario['pers_nombre']; ?>', '<?php echo $usuario['pers_apellido_paterno']; ?>')">
                                        <label class="custom-control-label"
                                            for="estatusUsuario<?php echo $x ?>"></label>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-table" title="Actualizar"
                                        onclick="actualizarUsuario(<?php echo $usuario['rol_id_rol'] ?>, <?php echo $usuario['usua_id_usuario'] ?>, <?php echo $usuario['usua_num_usuario'] ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-info btn-table" title="Detalles"
                                        onclick="consultarUsuarioDirecto(<?php echo $usuario['usua_id_usuario'] ?>, <?php echo $usuario['pers_id_persona'] ?> , <?php echo $usuario['rol_id_rol'] ?>)">
                                        <i class="fas fa-search-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-table" title="Eliminar"
                                        onclick="eliminarUsuario(<?php echo $usuario['usua_id_usuario'] ?>,  <?php echo $usuario['pers_id_persona'] ?>, '<?php echo $usuario['pers_nombre']; ?>', '<?php echo $usuario['pers_apellido_paterno']; ?>')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php } ?> -->

                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="estatusUsuario1"
                                            checked="" onclick="cambioEstatus(2 , 't', 'Luis Eduardo', 'Magos')">
                                        <label class="custom-control-label" for="estatusUsuario1"></label>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info btn-table" title="Detalles">
                                        <i class="fas fa-search-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-table" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>