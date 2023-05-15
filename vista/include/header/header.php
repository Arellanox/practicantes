<?php
$menu = $_POST['menu'];
$tip = $_POST['tip'];
$appname = 'nuevo_checkup';
session_start();
?>
<?php
switch ($menu) {
  case 'Prerregistro':
?>
    <nav class="navbar border-3 border-bottom border-dark bg-navbar">
      <div class="container-fluid d-flex justify-content-center">
        <a href="#" class="navbar-brand" id="img"> <img src="https://bimo-lab.com/archivos/sistema/bimo_banner.png" id="logo_empresa_login" /> </a>
      </div>
    </nav>
    <div class="px-3 py-2 border-bottom mb-3">
      <div class="container d-flex flex-wrap">
        <div class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto">
          <h2 class="text-center"><?php echo $menu; ?></h2> <!-- Dinamico -->
        </div>
        <div class="text-center" id="botones-menu-js">
          <?php
          if ($tip != 'pie') {
            include "botones.php";
          }
          ?>
        </div>
      </div>
    </div>
  <?php
    break;
  case 'Login'
  ?>
  <nav class="navbar border-3 border-bottom border-dark bg-navbar">
    <div class="container-fluid d-flex justify-content-center">
      <a href="#" class="navbar-brand" id="img"> <img src="https://bimo-lab.com/archivos/sistema/bimo_banner.png" id="logo_empresa_login" /> </a>
    </div>
  </nav>
<?php
    break;
  case 'validador':
?>
  <nav class="navbar border-3 border-bottom border-dark bg-navbar">
    <div class="container-fluid d-flex justify-content-center">
      <a href="#" class="navbar-brand" id="img"> <img src="https://bimo-lab.com/archivos/sistema/bimo_banner.png" id="logo_empresa_login" /> </a>
    </div>
  </nav>
<?php
    break;
  case 'TURNERO':
?>
  <nav class="navbar border-dark bg-navbar">
    <div class="container-fluid d-flex justify-content-center divTurnoNav">
      <!-- Turnos- Areas -->
      <a href="#" class="navbar-brand" id="img"> <img src="https://bimo-lab.com/archivos/sistema/bimo_banner.png" id="logo_empresa_login" /> </a>
    </div>
  </nav>
<?php
    break;
  default:
?>
  <nav class="navbar navbar-expand-lg border-3 border-bottom border-dark bg-navbar" style="padding-top: 5px; padding-bottom: 5px;" id="navbar_principal">
    <div class="container-fluid">
      <a href="#" class="navbar-brand"> <img src="https://bimo-lab.com/archivos/sistema/bimo_banner.png" id="logo_empresa" />
      </a>

      <button class="navbar-toggler" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop" style="color: white;border-color: #ffffff54;">
        <!-- onclick="openNav()" -->
        <i class="bi bi-list"></i>
      </button>
      <div id="navbarCollapse" class="collapse navbar-collapse">
        <ul class="nav navbar-nav" id="navbar-js">
          <?php
          include "navbar-menu/navlink-normales.php";
          include "areas-windows-float.php";
          ?>

        </ul>
        <ul class="nav navbar-nav ms-auto">

          <!-- Botones alado de los usuarios -->
          <li class="nav-item dropstart d-flex justify-content-center align-items-center m">
            <?php include "btn-user/buttons.php"; ?>
          </li>


          <li class="nav-item dropstart flex-grow-1">
            <!-- <a data-bs-toggle="dropdown" type="button" class="dropdown-toggle"><i class="bi bi-person-circle" style="zoom:190%"></i></a> -->
            <a data-bs-toggle="dropdown" type="button" class="">
              <div class=" container-avatar">
                <img src="<?php echo $_SESSION['AVATAR']; ?>" alt="Avatar" class="image-avatar">
                <div class="overlay-avatar">
                  <div class="text-avatar"><?php echo strtok($_SESSION['nombre'], " "); ?></div>
                </div>
              </div>
            </a>

            <ul class="dropdown-menu dropdown-menu-lg-end bg-navbar-drop" style="background-color: #ffffff00; padding:0px">
              <div class="" style="width: 100%">
                <div class="profile-card-4"><img src="<?php echo $_SESSION['AVATAR']; ?>" class="img img-responsive">
                  <div class="profile-content">
                    <div class="profile-name text-center"> <?php echo "$_SESSION[nombre] $_SESSION[apellidos]"; ?>
                      <p><?php echo "$_SESSION[cargo_descripcion]"; ?></p>
                    </div>
                    <div class="profile-description text-center">Hola, ¡buen día! :)</div>
                    <div class="profile-description text-center">
                      <a href="<?php echo $_SESSION['newsletter']['button_usuario']['url'] ?>" target="_blank" class="a-hover"><i class="bi bi-newspaper"></i> <?php echo $_SESSION['newsletter']['button_usuario']['tittle_button'] ?></a>
                    </div>

                    <div class="row" style="padding-right: 5%; padding-left: 5%;">
                      <?php include "navbar-menu/navlink-dropuser.php"; ?>
                    </div>
                  </div>
                </div>
              </div>
            </ul>
          </li>
        </ul>

      </div>
    </div>
  </nav>

<?php
    include "offcanvas.php";
    break;
}
?>

<script type="text/javascript">
  $('.dropdown-menu').on('click', function(e) {
    e.stopPropagation();
  });
</script>



<style>
  .card-container {
    padding: 100px 0px;
    -webkit-perspective: 1000;
    perspective: 1000;
  }

  .profile-card-4 {
    /* max-width: 300px; */
    background-color: #FFF;
    border-radius: 5px;
    box-shadow: 0px 0px 25px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    position: relative;
    /* margin: 10px auto; */
    /* cursor: pointer; */
  }

  .profile-card-4 img {
    transition: all 0.25s linear;
    width: 325px;
  }

  .profile-card-4 .profile-content {
    position: relative;
    padding: 15px;
    background-color: #FFF;
  }

  .profile-card-4 .profile-name {
    font-weight: bold;
    position: absolute;
    left: 0px;
    right: 0px;
    top: -70px;
    color: #FFF;
    font-size: 17px;
  }

  .profile-card-4 .profile-name p {
    font-weight: 600;
    font-size: 13px;
    letter-spacing: 1.5px;
  }

  .profile-card-4 .profile-description {
    color: #777;
    font-size: 12px;
    padding: 10px;
  }

  .profile-card-4 .profile-overview {
    padding: 15px 0px;
  }

  .profile-card-4 .profile-overview p {
    font-size: 10px;
    font-weight: 600;
    color: #777;
  }

  .profile-card-4 .profile-overview h4 {
    color: #273751;
    font-weight: bold;
  }

  .profile-card-4 .profile-content::before {
    content: "";
    position: absolute;
    height: 25px;
    top: -10px;
    left: 0px;
    right: 0px;
    background-color: #FFF;
    z-index: 0;
    transform: skewY(3deg);
  }

  .profile-card-4:hover img {
    transform: rotate(2deg) scale(1.04, 1.04);
    filter: brightness(60%);
  }
</style>