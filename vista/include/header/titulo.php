<?php $menu = $_POST['menu'];
$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : 0 ?>
<div class="px-3 pt-2 border-bottom" id="Titulo-Contenido">
  <div class="container d-flex flex-wrap">
    <div class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto">
      <div class="row">
        <?php
        switch ($tipo) {
          case 'btn-regresar-vista':
            echo '<div class="col-auto d-flex justify-content-center align-items-center">
                    <a href="" id="btn-regresar-vista" onclick="event.preventDefault()"><i class="bi bi-chevron-bar-left"></i> Regresar</a>
                  </div>';
            break;
        }

        ?>

        <div class="col-auto d-flex justify-content-start">
          <h2 class="text-center"><?php echo $menu; ?></h2> <!-- Dinamico -->
        </div>

      </div>
    </div>
    <div class="col-12 col-lg-auto text-center" id="botones-menu-js">
      <?php include "botones.php" ?>
    </div>
  </div>
</div>