<?php
include('../../clases/BD.php');
include('../../clases/Curso.php');

$obj_curso = new Curso();
$arr_cursos = $obj_curso->buscarTodosCursos();

$x = 0;
?>



<script src="../sistema/cursos/control_cursos.js"></script>

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
                <div class="col-sm-2" aligne="center">
                    <a href="#">
                        <button id="btn-registro-curso" type="button" class="btn btn-success">
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
                    <table class="table table-condensed table-hover" id="tabla_cursos" width="100%" cellspacing="0">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre del curso</th>
                                <th>Tipo</th>
                                <th>Nivel</th>
                                <th>Número de sesiones</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($arr_cursos as $cursos) { ?>
                            <tr>
                                <?php $x++; ?>
                                <td><?php echo $cursos['curs_id_cursos']; ?></td>
                                <td><?php echo $cursos['curs_nombre']; ?></td>
                                <td><?php echo $cursos['curs_tipo']; ?></td>
                                <td><?php echo $cursos['curs_nivel']; ?></td>
                                <td><?php echo $cursos['curs_num_sesiones']; ?></td>
                                <td>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            id="estatusCurso<?php echo $x ?>"
                                            <?php if ($cursos['curs_activo'] == 't') { ?> checked <?php } ?>
                                            onclick="cambioEstatus(<?php echo $cursos['curs_id_cursos'] ?> , '<?php echo $cursos['curs_activo']; ?>', '<?php echo $cursos['curs_nombre']; ?>')">
                                        <label class="custom-control-label" for="estatusCurso<?php echo $x ?>"></label>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info btn-table" title="Detalles" onclick="consultarCursoDirecto(<?php echo $cursos['curs_id_cursos'] ?>)">
                                        <i class="fas fa-search-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-table" title="Editar" onclick="actualizarCursoDirecto(<?php echo $cursos['curs_id_cursos'] ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>