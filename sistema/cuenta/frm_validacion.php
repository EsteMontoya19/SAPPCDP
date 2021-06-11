<div id="wrapper">
    <div id="content-wrapper">
        <div class="container-fluid">
            <ol class="breadcrumb">
                <li id="btn-validacion-contrasena" class="breadcrumb-item">
                    <a href="#"><i class="fas fa-user-shield"></i>&nbsp;Validación usuario</a>
                </li>
            </ol>
            <p>
                <hr>
            </p>

            <!-- Formulario -->
            <form name="validacion_acceso" id="validacion_acceso" method='POST'>
                <!-- Datos generales -->
                <div class="form-group">
                    <div class="card lg-12">
                        <div class="card-header">
                            <i class="fas fa-id-card fa-lg"></i>
                            <b>&nbsp;&nbsp;Datos generales</b>
                        </div>

                        <div class="form-group">
                            <label><b>Para poder actualizar los datos de usuario debe confrmar
                                    su usuario y contraseña</b></label>
                        </div>

                        <div class="col-lg-12 form-row" style="margin-top: 15px;">
                            <div class="col-lg-6 form-group">
                                <div class="form-label-group">
                                    <input type="text" name="strUsuario" id="strUsuario" class="form-control"
                                        placeholder="Usuario" required="required" autofocus="autofocus">
                                    <label for="strUsuario"><i class="fas fa-user" style="color: orange"></i>&nbsp;
                                        Usuario</label>
                                </div>
                            </div>
                            <div class="col-lg-6 form-group">
                                <div class="form-label-group">
                                    <input type="password" name="strContrasena" id="strContrasena" class="form-control"
                                        placeholder="Contraseña" required="required">
                                    <label for="strContrasena"><i class="fas fa-key" style="color: orange"></i>&nbsp;
                                        Contraseña</label>
                                </div>
                            </div>
                            <div class="centrado">
                                <input type="checkbox" id="ver1" class="ver" onChange="hideOrShowPassword()" />
                                <label class="text" style="color:#0C4590">&nbsp;Mostrar contraseña</label>
                            </div>
                            <div class = "derecho">
                                <button type="button" class="btn btn-sy01 btn-block btn-comprobar-usuario btn-aceptar" id="btn-comprobar-usuario">Comprobar</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo $_POST['id']; ?>">
                    <input type="hidden" id="idPersona" name="idPersona" value="<?php echo $_POST['persona']; ?>">
                    <input type="hidden" id="dml" name="dml" value="contrasena">
            </form>
        </div>
    </div>
</div>
</div>

<script src="../sistema/cuenta/control_cuenta.js"></script>