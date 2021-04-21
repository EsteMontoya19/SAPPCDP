<?php
  include('../clases/Cuenta.php');

  $obj_Cuenta = new Cuenta();
  $cuenta = $obj_Cuenta->buscarUsuarioSistema($_strUsuario, $_strContrasena);
?>

<!-- Archivo para cargar el header y referencias -->
<?php 
if ($cuenta->rol_id_rol==1) {
	include_once '../sistema/recursos/header.php';
}elseif($cuenta->rol_id_rol==2){
	include_once '../sistema/recursos/header-monitor.php';
}else{
	include_once '../sistema/recursos/header-profesor.php';
}

?>
<!-- Sección inicial-->

<section id="container">

  <?php include_once '../sistema/inicio/frm_inicio.php';?>

</section>

<!-- Archivo para cargar el footer y los scripts -->

<?php include_once '../sistema/recursos/footer.php';?>
