<?php
date_default_timezone_set('America/Mexico_City');
if ($_SESSION['vista']['CONSULTORIO'] == 1) : ?>
  <a class="dropdown-a align-items-center" type="button" href="<?php echo $https . $url . '/' . $appname . '/vista/menu/consultorio/'; ?>">
    <i class="bi bi-clipboard2-pulse"></i> Consultorio
  </a>
<?php endif; ?>
<?php if ($_SESSION['vista']['SOMATOMETRIA'] == 1) : ?>
  <a class="dropdown-a align-items-center" type="button" href="<?php echo $https . $url . '/' . $appname . '/vista/menu/somatometria/'; ?>">
    <i class="bi bi-heart-pulse"></i> Somatometría | Signos vitales
  </a>
<?php endif; ?>

<!-- IMAGENOLOGÍA -->
<?php if ($_SESSION['vista']['ULTRASONIDO'] == 1 || $_SESSION['vista']['ULTRASONIDOTOMA'] == 1) : ?>
  <a class="dropdown-a align-items-center collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#board-ultrasonido" aria-expanded="false">
    <i class="bi bi-person-video"></i> Ultrasonido
  </a>
  <div class="collapse" id="board-ultrasonido">
    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
      <?php if ($_SESSION['vista']['ULTRASONIDO'] == 1) : ?>
        <li>
          <a class="dropdown-a align-items-center" type="button" href="<?php echo $https . $url . '/' . $appname . '/vista/menu/area-master/#ULTRASONIDO'; ?>">
            <i class="bi bi-dot"></i> Interpretación
          </a>
        </li>
      <?php endif; ?>
      <?php if ($_SESSION['vista']['ULTRASONIDOTOMA'] == 1) : ?>
        <li>
          <a href="<?php echo $https . $url . '/' . $appname . '/vista/menu/area-master/#ULTRASONIDOTOMA'; ?>" class="dropdown-a align-items-center" type="button">
            <i class="bi bi-dot"></i> Captura
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
<?php endif; ?>

<?php if ($_SESSION['vista']['RX'] == 1 || $_SESSION['vista']['RXTOMA'] == 1) : ?>
  <a class="dropdown-a align-items-center collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#board-rayosX" aria-expanded="false">
    <i class="bi bi-universal-access"></i> Rayos X
  </a>
  <div class="collapse" id="board-rayosX">
    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
      <?php if ($_SESSION['vista']['RX'] == 1) : ?>
        <li>
          <a class="dropdown-a align-items-center" type="button" href="<?php echo $https . $url . '/' . $appname . '/vista/menu/area-master/#RX'; ?>">
            <i class="bi bi-dot"></i> Interpretación
          </a>
        </li>
      <?php endif; ?>
      <?php if ($_SESSION['vista']['RXTOMA'] == 1) : ?>
        <li>
          <a href="<?php echo $https . $url . '/' . $appname . '/vista/menu/area-master/#RXTOMA'; ?>" class="dropdown-a align-items-center" type="button">
            <i class="bi bi-dot"></i> Captura
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
<?php endif; ?>

<!-- Otras Areas -->
<?php if ($_SESSION['vista']['ELECTROCARDIOGRAMA'] == 1 || $_SESSION['vista']['ELECTROCARDIOGRAMA_CAPTURAS'] == 1) : ?>
  <a class="dropdown-a align-items-center collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#board-electro" aria-expanded="false">
    <i class="bi bi-activity"></i> Electrocardiograma
  </a>
  <div class="collapse" id="board-electro">
    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
      <?php if ($_SESSION['vista']['ELECTROCARDIOGRAMA'] == 1) : ?>
        <li>
          <a class="dropdown-a align-items-center" type="button" href="<?php echo $https . $url . '/' . $appname . '/vista/menu/area-master/#ELECTROCARDIOGRAMA'; ?>">
            <i class="bi bi-dot"></i> Interpretación
          </a>
        </li>
      <?php endif; ?>
      <?php if ($_SESSION['vista']['ELECTROCARDIOGRAMA_CAPTURAS'] == 1) : ?>
        <li>
          <a href="<?php echo $https . $url . '/' . $appname . '/vista/menu/area-master/#ELECTROCARDIOGRAMA_CAPTURAS'; ?>" class="dropdown-a align-items-center" type="button">
            <i class="bi bi-dot"></i> Captura
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
<?php endif; ?>
<?php if ($_SESSION['vista']['ESPIROMETRIA'] == 1) : ?>
  <a class="dropdown-a align-items-center" type="button" href="<?php echo $https . $url . '/' . $appname . '/vista/menu/area-master/#ESPIROMETRIA'; ?>">
    <i class="bi bi-lungs"></i> Espirometría
  </a>
<?php endif; ?>
<?php if ($_SESSION['vista']['AUDIOMETRIA'] == 1) : ?>
  <a class="dropdown-a align-items-center" type="button" href="<?php echo $https . $url . '/' . $appname . '/vista/menu/area-master/#AUDIOMETRIA'; ?>">
    <i class="bi bi-ear"></i> Audiometría
  </a>
<?php endif; ?>
<?php if ($_SESSION['vista']['OFTALMOLOGIA'] == 1) : ?>
  <a class="dropdown-a align-items-center" type="button" href="<?php echo $https . $url . '/' . $appname . '/vista/menu/area-master/#OFTALMOLOGIA'; ?>">
    <i class="bi bi-eye"></i> Oftalmología
  </a>
<?php endif; ?>
<!-- Otras Areas -->
<?php if ($_SESSION['vista']['NUTRICION'] == 1 || $_SESSION['vista']['NUTRICION_CAPTURAS'] == 1) : ?>
  <a class="dropdown-a align-items-center collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#board-nutricion" aria-expanded="false">
    <img src="../../../archivos/sistema/nutrientes.svg" alt="" style="margin-top: -4px;    width: 17px;"> Nutrición
  </a>
  <div class="collapse" id="board-nutricion">
    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
      <?php if ($_SESSION['vista']['NUTRICION'] == 2) : ?>
        <li>
          <a class="dropdown-a align-items-center" type="button" href="<?php echo $https . $url . '/' . $appname . '/vista/menu/area-master/#NUTRICION'; ?>">
            <i class="bi bi-dot"></i> Interpretación
          </a>
        </li>
      <?php endif; ?>
      <?php if ($_SESSION['vista']['NUTRICION_CAPTURAS'] == 1) : ?>
        <li>
          <a href="<?php echo $https . $url . '/' . $appname . '/vista/menu/area-master/#NUTRICION_CAPTURAS'; ?>" class="dropdown-a align-items-center" type="button">
            <i class="bi bi-dot"></i> Estudio (InBody)
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </div>

  <!-- <a class="dropdown-a align-items-center" type="button" href="<?php echo $https . $url . '/' . $appname . '/vista/menu/area-master/#NUTRICION'; ?>">
    <i class="bi bi-activity"></i> NUTRICIÓN
  </a> -->
<?php endif; ?>




<?php if (
  $_SESSION['vista']['CONTROL_TURNOS_PANTALLA'] == 1 ||
  $_SESSION['vista']['CONTROL_TURNOS'] == 1
) : ?>
  <a class="dropdown-a align-items-center collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#board-turnos" aria-expanded="false">
    <i class="bi bi-back"></i> Control de Turnos
  </a>
  <div class="collapse" id="board-turnos">
    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
      <?php if ($_SESSION['vista']['CONTROL_TURNOS'] == 1) : ?>
        <li>
          <a class="dropdown-a align-items-center" type="button" href="<?php echo $https . $url . '/' . $appname . '/vista/menu/control-turnos/'; ?>">
            <i class="bi bi-dot"></i> Menú
          </a>
        </li>
      <?php endif; ?>
      <?php if ($_SESSION['vista']['CONTROL_TURNOS_PANTALLA'] == 1) : ?>
        <li>
          <a href="<?php echo $https . $url . '/' . $appname . '/vista/pantalla/control-turnos/'; ?>" class="dropdown-a align-items-center" type="button">
            <i class="bi bi-dot"></i> Pantalla
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
<?php endif; ?>



<?php if ($_SESSION['vista']['ESTUDIOS_ULTRASONIDO'] == 1 || $_SESSION['vista']['ESTUDIOS_RAYOSX'] == 1) : ?>
  <a class="dropdown-a align-items-center collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#board-validacionCorreoLab" aria-expanded="false">
    <i class="bi bi-box2-heart"></i> Estudios
  </a>
  <div class="collapse" id="board-validacionCorreoLab">
    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small shadow">
      <?php if ($_SESSION['vista']['ESTUDIOS_ULTRASONIDO'] == 1) : ?>
        <li>
          <a class="dropdown-a" type="button" class="btn btn-primary" href="<?php echo $https . $url . '/' . $appname . '/vista/menu/area-servicios/#ESTUDIOS_ULTRASONIDO'; ?>">
            <i class="bi bi-dot"></i> Ultrasonido
          </a>
        </li>

      <?php endif; ?>
      <?php if ($_SESSION['vista']['ESTUDIOS_RAYOSX'] == 1) : ?>
        <li>
          <a class="dropdown-a" type="button" class="btn btn-primary" href="<?php echo $https . $url . '/' . $appname . '/vista/menu/area-servicios/#ESTUDIOS_RAYOSX'; ?>">
            <i class="bi bi-dot"></i> Rayos X
          </a>
        </li>
      <?php endif; ?>
      <?php if ($_SESSION['vista']['ESTUDIOS_AREAS'] == 1) : ?>
        <li>
          <a class="dropdown-a" type="button" class="btn btn-primary" href="<?php echo $https . $url . '/' . $appname . '/vista/menu/area-servicios/#ESTUDIOS_AREAS'; ?>">
            <i class="bi bi-dot"></i> Checkups
          </a>
        </li>
      <?php endif; ?>

    </ul>
  </div>
<?php endif; ?>