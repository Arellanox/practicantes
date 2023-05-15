<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasWithBackdrop" aria-labelledby="offcanvasWithBackdropLabel">
  <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-navbar" style="width: 100%;height:100%">
    <div class="offcanvas-header">
      <div class="d-flex align-items-center mb-md-0 me-md-auto text-white text-decoration-none">
        <img src="https://www.bimo-lab.com/archivos/sistema/LogoConFondoAppAndroid.png" style="height: 36px;margin-right: 20px;" />
        <span class="fs-4">Bimo-lab</span>
      </div>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <hr>
    <span class="fs-4 text-center" id="bienvenida-user">Bienvenido | <?php echo $_SESSION['nombre'] ?></span>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto dropdown-lu">
      <?php // navlink-normales
      include "navbar-menu/navlink-normales.php"; ?>
      <hr><?php
          // navlink-list
          #include "navbar-menu/navlink-droplist-areas.php";
          include "areas-windows-float.php";
          ?>



    </ul>
    <hr>
    <div class="dropdown">
      <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 2px">

        <div class="container-avatar" style="zoom: 130%">
          <img src="<?php echo $_SESSION['AVATAR']; ?>" alt="Avatar" class="image-avatar">
        </div>
        <p class="none-p text-white" style="margin-left: 10px"></p><?php echo $_SESSION['user'] ?></p>

      </a>
      <ul class="dropdown-menu text-small shadow bg-navbar-drop" aria-labelledby="dropdownUser1">
        <?php include "navbar-menu/navlink-dropuser.php"; ?>
      </ul>
    </div>
  </div>
</div>