<?php
date_default_timezone_set('America/Mexico_City');
?>









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