<?php
// Clases
include('../../clases/BD.php');
include('../../clases/Grupo.php');
include('../../clases/Profesor.php');
// Objetos
$obj_Grupo = new Grupo();
$obj_Profesor = new Profesor();
//Catálogos
$arr_GruposPrivados = $obj_Grupo->buscarGruposPrivados();
$arr_profesores = $obj_Profesor->buscarProfesoresActivos();
$arr_inscritos = $obj_Grupo->buscarCorreosDeParticipantes($_POST['grupo']);

//Variables
$instructorGrupo = $obj_Grupo->buscarDatosInstructorGrupo($_POST['grupo'])->pers_id_persona;

//POST
$grupo = $_POST['grupo'];
?>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-condensed table-hover" id="tabla_profesores" width="100%" cellspacing="0">
        <thead class="thead-dark"> 
            <tr>
            <th>ID</th>
            <th>Nombre(s)</th>
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>Nombramiento</th>
            <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($arr_profesores as $profesor) { ?>
                <?php if ($instructorGrupo != $profesor['pers_id_persona']) {
                    //? En el caso de que no haya nigun inscrito mandamos la bandera directa en 1 para que ya no haga nada
                    $bandera = 0;
                    if (empty($arr_inscritos) == false) {
                        //? Se hace un foreach con todos los inscritos para no mostrar en la tabla a ningun profesor que ya se encuentre inscrito
                        foreach ($arr_inscritos as $inscrito) {
                            if ($inscrito['pers_id_persona'] == $profesor['pers_id_persona']) {
                                $bandera = 1;
                            }
                        }
                    }
                    //? En caso de que si haya habido registros en el arreglo y no se haya encontrado el profesor en los inscritos, se muestra en la tabla
                    if ($bandera == 0) { ?>
                        <tr>
                            <td><?php echo $profesor['pers_id_persona']; ?></td>
                            <td><?php echo $profesor['pers_nombre']; ?></td>
                            <td><?php echo $profesor['pers_apellido_paterno']; ?></td>
                            <td><?php echo $profesor['pers_apellido_materno']; ?></td>
                            <td><?php echo $profesor['nomb_descripcion']; ?></td>

                            <td>
                            <button id="btn-inscribir-profesor" type="button" class="btn btn-descarga" 
                                onclick="inscribirProfesor(<?php echo $profesor['pers_id_persona']; ?>, <?php echo $grupo; ?>)">Inscribir Profesor</button>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </tbody>
        </table>
    </div>
</div>

<script src="../sistema/inscripciones/control_inscripciones.js"></script>
