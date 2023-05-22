<?php if (true) : ?>
  <!-- Administrativos -->
  <!-- <a class="dropdown-a align-items-center rounded collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#board-laboratorio-servicios" aria-expanded="false">
    <i class="bi bi-clipboard-heart"></i> Estudios laboratorio
  </a>
  <div class="collapse" id="board-laboratorio-servicios">
    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
        <li><a class="dropdown-a" type="button" class="btn btn-primary" href="<?php echo $https . $url . '/' . $appname . '/vista/menu/laboratorio-servicios/#Estudios'; ?>"><i class="bi bi-dot"></i> Estudios</a></li>
        <li><a class="dropdown-a" type="button" class="btn btn-primary" href="<?php echo $https . $url . '/' . $appname . '/vista/menu/laboratorio-servicios/#Grupos'; ?>"><i class="bi bi-dot"></i> Grupos de examenes</a></li>
    </ul>
  </div>
  <li><hr class="dropdown-divider"></li> -->
<?php endif; ?>




<!-- <?php if ($_SESSION['vista']['ADMINISTRACIÓN'] == 1 || $_SESSION['vista']['CLIENTES'] == 1) : ?>
  <a class="dropdown-a align-items-center rounded collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#board-admin" aria-expanded="false">
    <i class="bi bi-person-check"></i> Administración
  </a>
  <div class="collapse" id="board-admin">
    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
      <?php if ($_SESSION['vista']['CLIENTES'] == 1) : ?>
        <li>
          <a class="dropdown-a align-items-center" type="button" href="<?php echo $https . $url . '/' . $appname . '/vista/menu/clientes/'; ?>">
            <i class="bi bi-dot"></i> Clientes
          </a>
        </li>
      <?php endif; ?>
      <?php if ($_SESSION['vista']['CURSOS BIMO'] == 1) : ?>
        <li>
          <a href="<?php echo $https . $url . '/' . $appname . '/vista/menu/cursos-bimo/'; ?>" class="dropdown-a" type="button">
            <i class="bi bi-dot"></i> Cursos
          </a>
        </li>
      <?php endif; ?>
      <?php if ($_SESSION['perfil'] == 1) : ?>
        <li>
          <a href="<?php echo $https . $url . '/' . $appname . '/vista/menu/administracion/#USUARIOS'; ?>" class="dropdown-a" type="button">
            <i class="bi bi-dot"></i> Usuarios
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
  <li>
    <hr class="dropdown-divider">
  </li>
<?php endif; ?> -->

<?php if ($_SESSION['permisos']['ExcelInfoBeneUjat'] == 1) : ?>
  <a class="dropdown-a align-items-center rounded collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#board-Excel" aria-expanded="false">
    <i class="bi bi-file-earmark-spreadsheet"></i> Documentación Excel
  </a>
  <div class="collapse" id="board-Excel">
    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
      <?php if ($_SESSION['permisos']['ExcelInfoBeneUjat'] == 1) : ?>
        <li>
          <a class="dropdown-a align-items-center" type="button" href="#" onclick="return false" id="btn-beneficiarios-ujat">
            <i class="bi bi-dot"></i> Beneficiados UJAT
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
  <li>
    <hr class="dropdown-divider">
  </li>
<?php endif; ?>

<a href="#LogOut" class="dropdown-a"><i class="bi bi-box-arrow-up"></i> Cerrar Sesión</a>