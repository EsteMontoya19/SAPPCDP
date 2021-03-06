<!DOCTYPE html>
<html lang="es">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="Sistema de gestión de inscricpiones a grupos PPCDP" content="">
    <meta name="CIFCA" content="">

    <title>PPDCP</title>

    <!-- Referencias -->

    <!-- Iconos -->
    <link href="../recursos/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Icono de la pestaña -->
    <link rel="../recursos/shortcut icon" href="../recursos/favicon.ico"/>

    <!-- Alertify -->

    <link rel="stylesheet" type="text/css" href="../recursos/alertify/css/alertify.css">
    <link rel="stylesheet" type="text/css" href="../recursos/alertify/css/alertify.rtl.css">
      <link rel="stylesheet" type="text/css" href="../recursos/alertify/css/themes/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../recursos/alertify/css/themes/bootstrap.rtl.css">

    <!-- JQuery Ui (Auto completado) -->
    <link href="../recursos/css/jquery-ui.min.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap 4 -->
    <link href="../recursos/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../recursos/css/bootstrap.css.map" rel="stylesheet" type="text/css">
    <link href="../recursos/css/sb-admin.css" rel="stylesheet" type="text/css">
    <link href="../recursos/css/bootstrap-modificado.css" rel="stylesheet" type="text/css">

    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css">

  </head>

  <body id="page-top">

    <nav class="navbar navbar-expand-lg navbar-dark bg-blue">

      <a class="navbar-brand mr-1" id="btn_inicio" type="button"><h3 style="color:#fff;">PPDCP</h3></a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar Search -->
      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
          <ul class="navbar-nav ml-auto">
            
            <li id="btn_usuarios" class="nav-item">
                <a class="nav-link" href="#" style="color:#FFFFFF"><i class="fas fa-user-shield"></i>&nbsp; Usuarios</a>
            </li>

            <li id="btn_cursos" class="nav-item">
                <a class="nav-link" href="#" style="color:#FFFFFF"><i class="fas fa-book"></i>&nbsp; Cursos</a>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#FFFFFF">
                <i class="fas fa-users"><div style="width: 20px;"></div></i>Grupos
              </a>
              <div class="dropdown-menu dropdown-menu-down" aria-labelledby="navbarUser">
                <a class="dropdown-item" type="button"  id="btn_grupos">Listado grupos</a>
                <a class="dropdown-item" type="button"  id="btn_gruposPrivados">Inscripciones privados</a>
              </div>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#FFFFFF">
                <i class="fa fa-file-alt"><div style="width: 20px;"></div></i>Constancias
              </a>
              <div class="dropdown-menu dropdown-menu-down" aria-labelledby="navbarUser">
                <a class="dropdown-item" type="button"  id="btn_DescargarExcel">Descargar Excel</a>
                <a class="dropdown-item" type="button"  id="btn_SubirConstancias">Cargar Zip</a>
              </div>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#FFFFFF">
                <i class="fa fa-file-alt"><div style="width: 20px;"></div></i>Cuestionario
              </a>
              <div class="dropdown-menu dropdown-menu-down" aria-labelledby="navbarUser">
                <a class="dropdown-item" type="button"  id="btn_preguntas">Preguntas</a>
                <a class="dropdown-item" type="button"  id="btn_cuestionario">Cuestionario Actual</a>
              </div>
            </li>

            <li id="btn_reportes" class="nav-item">
                <a class="nav-link" href="#" style="color:#FFFFFF"><i class="fa fa-file-alt"></i>&nbsp; Reportes</a>
            </li>

            <li id="btn_correo" class="nav-item">
                <a class="nav-link" href="#" style="color:#FFFFFF"><i class="fas fa-envelope"></i></i>&nbsp; Correo</a>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#FFFFFF">
                <i class="fas fa-user-circle"><div style="width: 20px;"></div></i>Catálogos
              </a>
              <div class="dropdown-menu dropdown-menu-down" aria-labelledby="navbarUser">
                <a class="dropdown-item disabled" href="#"></a>
                <?php //! Se descontinuo preguntas de seguridad ?>
                <!--<a class="dropdown-item" type="button"  id="btn_preguntaseguridad">Preguntas de seguridad</a> -->
                <a class="dropdown-item" type="button"  id="btn_plataforma">Plataforma</a>
                <a class="dropdown-item" type="button"  id="btn_calendario">Calendario</a>
                <a class="dropdown-item" type="button"  id="btn_coordinacion">Coordinacion</a>
                <a class="dropdown-item" type="button"  id="btn_nombramiento">Nombramiento</a>
              </div>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#FFFFFF">
                <i class="fas fa-user-circle"></i>
                &nbsp; <?php echo isset($cuenta) ? $cuenta->pers_nombre : ""; ?> <?php echo isset($cuenta) ? $cuenta->pers_apellido_paterno : ""; ?> <?php echo isset($cuenta) ? $cuenta->pers_apellido_materno: ""; ?>
              </a>
              <div class="dropdown-menu dropdown-menu-down" aria-labelledby="navbarUser">
                <a class="dropdown-item disabled" href="*"><?php echo isset($cuenta) ? $cuenta->rol_nombre : ""; ?></a>
                <a id="btn_cuenta" class="dropdown-item" href="#" onclick="miCuenta(<?php echo isset($cuenta) ? $cuenta->usua_id_usuario : ""; ?>, <?php echo isset($cuenta) ? $cuenta->usua_id_persona : ""; ?>)" > Mi cuenta</a>
                <?php //? Cambiar contraseña, no visible ?>
                <!--
                <a class="dropdown-item" href="#" onclick="cambiarContrasena(<?php echo isset($cuenta) ? $cuenta->usua_id_usuario : ""; ?>, <?php echo isset($cuenta) ? $cuenta->usua_id_persona : ""; ?>)" >Cambiar contraseña</a>
                -->
                <a class="dropdown-item" href="../modulos/Cerrar_Sesion.php">Cerrar sesión</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>
