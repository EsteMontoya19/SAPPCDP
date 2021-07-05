<?php
// Clases
include('../../clases/BD.php');
include('../../clases/Busqueda.php');

// Catálogos
$obj_Busqueda = new Busqueda();
$arr_coordinaciones = $obj_Busqueda->selectCoordinaciones();
$arr_niveles = $obj_Busqueda->selectNiveles();
$arr_modalidades = $obj_Busqueda->selectModalidades();
// TODO: Preguntar si esto es requerido.
// $arr_preguntas = $obj_Busqueda->selectPregunta();
?>


<form name="form_usuario" id="form_usuario" method="POST">
    <input type="hidden" name="dml" id="dml" value="insert">
    <input type="hidden" name="intUsuarioRol" id="intUsuarioRol" value="4">
    <input type="hidden" name="numCoordinaciones" id="numCoordinaciones" value=<?php echo(sizeof($arr_coordinaciones)); ?>>

    <div class="form-group row">
      <label for="rfc" class="col-sm-6 col-form-label">Nombre(s): *</label>
      <div class="col-sm-12">
        <input type="text" class="form-control" id="strUsuarioNombre" name = "strUsuarioNombre" placeholder = "Samuel Antonio">
      </div>
    </div>


    <div class="form-group row">
      <label for="rfc" class="col-sm-6 col-form-label">Apellido Paterno: *</label>
      <div class="col-sm-12">
        <input type="text" class="form-control" id="strUsuarioPrimerApe" name = "strUsuarioPrimerApe" placeholder = "Montoya">
      </div>
    </div>


    <div class="form-group row">
      <label for="rfc" class="col-sm-6 col-form-label">Apellido Materno: </label>
      <div class="col-sm-12">
        <input type="text" class="form-control" id="strUsuarioSegundoApe" name = "strUsuarioSegundoApe" placeholder = "Aguilar">
      </div>
    </div>


    <div class="form-group row">
      <label for="rfc" class="col-sm-6 col-form-label">Correo Electrónico: *</label>
      <div class="col-sm-12">
        <input type="email" class="form-control" id="strUsuarioCorreo" name = "strUsuarioCorreo" placeholder = "ejemplo@gmail.com">
      </div>
    </div>


    <div class="form-group row">
      <label for="rfc" class="col-sm-6 col-form-label">Número de Teléfono: *</label>
      <div class="col-sm-12">
        <input type="email" class="form-control" id="strUsuarioTelefono" name = "strUsuarioTelefono" placeholder = "1234567890">
      </div>
    </div>

    <h5 class="modal-title col-lg-12 negritas" id="exampleModalLabel"
      style="background: #5d2860;color: #fff;padding: 10px">Datos de profesor</h5>

    <div class="form-group row">
      <label for="numTrab" class="col-sm-6 col-form-label">Número trabajador: *</label>
      <div class="col-sm-12">
        <input type="text" class="form-control" name= "intNum_Trabajador" id="intNum_Trabajador" placeholder = "123456">
      </div>
    </div>
    <div class="form-group row">
      <label for="rfc" class="col-sm-6 col-form-label">RFC con Homoclave: *</label>
      <div class="col-sm-12">
        <input type="text" class="form-control" id="strRFC" name = "strRFC" placeholder = "NNNN000000XXX">
      </div>
    </div>

    <?php //!La semblanza ya no se llena aqui, hasta el apartado de Mi Cuenta ?>
    <!-- <div class="form-group row">
      <label for="rfc" class="col-sm-6 col-form-label">Semblanza: *</label>
      <div class="col-sm-12">
        <textarea type="text" class="form-control" id="strSemblanza" name="strSemblanza" placeholder = "Descripción del profesor"></textarea>
      </div>
    </div> -->


    <div class="form-group row">
      <label for="strNivel" class="col-sm-6 col-form-label">Niveles en que imparte clases *:</label>
      <div class="col-sm-12" style="padding-left: 40px">
        <?php foreach ($arr_niveles as $nivel) { ?>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="strNivel<?php echo ($nivel['nive_id_nivel']);?>" name="strNivel<?php echo ($nivel['nive_id_nivel']);?>"
                    value="<?php echo ($nivel['nive_id_nivel']);?>">
            <label class="form-check-label" for="inlineCheckbox1"><?php echo ($nivel['nive_nombre']);?></label>
          </div>
        <?php } ?>
      </div>
    </div>


    <div class="form-group row">
    <label for="modalidadImparticion" class="col-sm-6 col-form-label"><b>Modalidad en la que imparte clases : * </b></label>
      <div class="col-sm-12" style="padding-left: 40px">
        <?php foreach ($arr_modalidades as $modalidad) { ?>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="strModalidad<?php echo ($modalidad['moda_id_modalidad']);?>" name="strModalidad<?php echo ($modalidad['moda_id_modalidad']);?>"
                    value="<?php echo ($modalidad['moda_id_modalidad']);?>">
            <label class="form-check-label" for="inlineCheckbox1"><?php echo ($modalidad['moda_nombre']);?></label>
          </div>
        <?php } ?>
      </div>
    </div>

    <div class="form-group row">
      <label for="strCoordinacion" class="col-sm-6 col-form-label"><b>Coordinaciones a las que pertenece: *</b></label>
      <div class="col-sm-12">
        <table> <?php //*? Esto lo creo para hacer columnas con los checkbox?>
          <tr>
            <td>
              <?php foreach ($arr_coordinaciones as $coordinacion) { ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="strCoordinacion<?php echo ($coordinacion['coor_id_coordinacion']);?>" name="strCoordinacion<?php echo ($coordinacion['coor_id_coordinacion']);?>"
                              value="<?php echo ($coordinacion['coor_id_coordinacion']);?>">
                      <label class="form-check-label" for="inlineCheckbox1"><?php echo ($coordinacion['coor_nombre']);?></label> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                        <?php //*? Esto lo creo para hacer dos columnas con las coordinaciones si se borra solo aparecen en una fila
                          $tamano = sizeof($arr_coordinaciones);
                          static $mostradas = 0;
                          if ($mostradas == 12 ){
                            echo("</td><td>");
                            $mostradas = 0;
                          } else {
                            $mostradas++;
                          }
                        ?>
                    </div>
              <?php } ?>
            </td>
          </tr>
        </table>
      </div>
    </div>

    <?php //! Se elimino todo lo de datos de recuperación ?>
    <!-- <h5 class="modal-title negritas" id="exampleModalLabel" style="background: #5d2860;color: #fff;padding: 10px">
      Datos de Recuperación</h5>


    <div class="form-group row">
      <label for="strNombreUsuario" class="col-sm-6 col-form-label">Nombre de usuario *:</label>
      <div class="col-sm-12">
        <input type="text" class="form-control" id="strNombreUsuario" name="strNombreUsuario" placeholder = "Usuario">
      </div>
    </div>

    <div class="form-group row">
      <label for="strContrasenia01" class="col-sm-6 col-form-label">Contraseña</label>
      <div class="col-sm-12">
        <input type="password" class="form-control" id="strContrasenia01" name = "strContrasenia01">
      </div>
    </div>

    <div class="form-group row">
      <label for="rfc" class="col-sm-6 col-form-label">Confirmar contraseña</label>
      <div class="col-sm-12">
        <input type="password" class="form-control" id="strContrasenia02" name= "strContrasenia02">
      </div>
    </div>

    <div class="form-group row">
      <label for="rfc" class="col-sm-6 col-form-label">Pregunta secreta</label>
      <div class="col-sm-12">
        <select class="custom-select" id="UsuarioPregunta"name="UsuarioPregunta">
        <option value="0">Seleccione una pregunta</option>
        <?php foreach ($arr_preguntas as $pregunta) { if ($pregunta['prse_activo'] == 't') { ?>
          <option value="<?php echo $pregunta['prse_id_pregunta']; ?>">
            <?php echo $pregunta['prse_pregunta']; ?>
          </option>
        <?php } }?>
      </select>
      </div>
    </div>

    <div class="form-group row">
      <label for="rfc" class="col-sm-6 col-form-label">Respuesta</label>
      <div class="col-sm-12">
        <input type="text" class="form-control" id="UsuarioRespuesta" name = "UsuarioRespuesta">
      </div>
    </div> -->
  </form>

  <script src="sistema/usuarios/control_usuario.js"></script>