<?php
  include('../clases/Cuenta.php');

  $obj_Cuenta = new Cuenta();
  $cuenta = $obj_Cuenta->buscarUsuarioSistema($_strUsuario, $_strContrasena);
?>
<input id = "idPersona" type="hidden" name="dml" value='<?php echo($cuenta->pers_id_persona);?>'>
<input id = "idRol" type="hidden" name="dml" value='<?php echo($cuenta->rol_id_rol);?>'>

<!-- Archivo para cargar el header y referencias -->
<?php 
if ($cuenta->rol_id_rol==1) {
	include_once '../sistema/recursos/header.php';
}elseif($cuenta->rol_id_rol==2){
  include_once '../sistema/recursos/header-instructor.php';
}elseif($cuenta->rol_id_rol==3){
	include_once '../sistema/recursos/header-monitor.php';
}else{
	include_once '../sistema/recursos/header-profesor.php';
}
  ?>
  <section id="container">
    
  </section>
<?php

?>
<!-- Sección inicial-->



<!-- Archivo para cargar el footer y los scripts -->

<?php include_once '../sistema/recursos/footer.php';?>
