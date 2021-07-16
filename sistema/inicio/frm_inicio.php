
  <div id="wrapper">
    <div id="content-wrapper">
      <div class="container-fluid">

        <!-- Breadcrumbs-->

        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">
              <i id="btn_inicio" class="fas fa-home"></i>&nbsp; Inicio
            </a>
          </li>
         
        </ol>
        <br>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align:center">
          
        <div id="comunicados" class="carousel slide" data-ride="carousel">
          
          <ol class="carousel-indicators">
            <li data-target="#comunicados" data-slide-to="0" class="active"></li>
            
            <?php 
            $comunicados = scandir("../../recursos/imagenes/Carrusel/" , 1);
            for ($iCont = 1 ; $iCont < count($comunicados) - 2; $iCont ++) { ?> 
              <li data-target= '#comunicados' data-slide-to= '<?php echo($iCont) ?>'></li> <?php
            } 
            ?>
          </ol>
          <div class="carousel-inner">
          <div class="carousel-item active">
                <img class="d-block img-fluid w-100"  src="../recursos/imagenes/Carrusel/AAInicial.jpg" alt="imagen0">
          </div>

          <?php 
            for ($iCont = 1 ; $iCont < count($comunicados) - 2; $iCont ++) { ?>
              <div class="carousel-item">
                <img class="d-block img-fluid w-100"  src="../recursos/imagenes/Carrusel/<?php 
                    echo ($comunicados[$iCont]) ?>" alt='<?php echo("imagen".$iCont) ?>'>
              </div> <?php
            } 
          ?>

          <a class="carousel-control-prev" href="#comunicados" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#comunicados" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
          
          
        </div>
      </div>
    </div>
  </div>
