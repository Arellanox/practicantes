<?php
$menu = $_POST['menu'];
$tip = $_POST['tip'];
$appname = 'practicantes';
session_start();
?>
<?php
switch ($menu) {
  case 'Pre-registro': ?>
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
  <?php break;
  case 'Login': ?>
    <nav class="navbar border-3 border-bottom border-dark bg-navbar">
      <div class="container-fluid d-flex justify-content-center">
        <a href="#" class="navbar-brand" id="img"> <img src="https://bimo-lab.com/archivos/sistema/bimo_banner.png" id="logo_empresa_login" /> </a>
      </div>
    </nav>
  <?php break;
  case 'validador':
  case 'lista_servicios' ?>
  <nav class="navbar border-3 border-bottom border-dark bg-navbar">
    <div class="container-fluid d-flex justify-content-center">
      <a href="#" class="navbar-brand" id="img"> <img src="https://bimo-lab.com/archivos/sistema/bimo_banner.png" id="logo_empresa_login" /> </a>
    </div>
  </nav>
<?php break;
  case 'TURNERO': ?>
  <nav class="navbar border-dark bg-navbar">
    <div class="container-fluid d-flex justify-content-center divTurnoNav">
      <!-- Turnos- Areas -->
      <a href="#" class="navbar-brand" id="img"> <img src="https://bimo-lab.com/archivos/sistema/bimo_banner.png" id="logo_empresa_login" /> </a>
    </div>
  </nav>
  <?php break;

    // case 'procedencia': 
  ?>



<?php // break;

  default:
?>
  <nav class="navbar navbar-expand-lg border-3 border-bottom border-dark bg-navbar navbar-menu" id="navbar_principal">
    <div class="container-fluid">

      <?php
      if ($menu != 'procedencia') { ?>
        <a href="https://bimo-lab.com/index.php" class="navbar-brand">
          <img src="https://bimo-lab.com/archivos/sistema/bimo_banner.png" id="logo_empresa" />
          <?php
          if ($_SESSION['URLACTUAL'] == 'drjb.com.mx' && $menu != 'procedencia')
            echo "| Vista de Capacitación";
          ?>
        </a>
      <?php } else { ?>
        <img src="https://bimo-lab.com/archivos/sistema/bimo_banner.png" id="logo_empresa" width="" />
      <?php } ?>
      <?php

      // $fecha_actual = new DateTime(); // obtiene la fecha actual en formato 'año-mes-día'
      // $fecha_sumada = $fecha_actual->add(new DateInterval('P2D')); // suma 2 días a la fecha actual
      // $fecha_sumada_string = $fecha_actual->format('Y-m-d'); // convierte la fecha sumada en una cadena de texto en formato 'año-mes-día'

      // echo $fecha_sumada; // imprime la nueva fecha en formato 'año-mes-día'

      if (false && $menu != 'procedencia') :
      ?>

        <img src="https://bimo-lab.com/nuevo_checkup/1724986_dbc8d.gif" style="width: 90px; z-index: 99; position: absolute; left: 40px; top: 12px; transform: rotate(0.04turn);" />
        <div class="contenido-extra-cumple">
          <a href="#" class="btn-flotante-cumple" id="btn-flotante-cumple" data-bs-toggle="modal" data-bs-target="#modalCardCumpleaños" style="opacity: 0.02;">
            <!-- <i class="bi bi-question-diamond"></i> -->
            <img src="https://bimo-lab.com/nuevo_checkup/931950.png" alt="" id="paste-cumple" style="height: 300px;">
          </a>

          <div class="modal fade" id="modalCardCumpleaños" tabindex="-1" aria-labelledby="filtrador" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered ">
              <div class="modal-content">
                <!-- <div class="modal-header header-modal">
                  <h5 class="modal-title" id="filtrador"></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div> -->
                <div class="modal-body">
                  <div id="tsparticles"></div>
                  <div style="position: relative; width: 100%; height: 0; padding-top: 140.9524%;
  padding-bottom: 0; box-shadow: 0 2px 8px 0 rgba(63,69,81,0.16); margin-top: 1.6em; margin-bottom: 0.9em; overflow: hidden;
  border-radius: 8px; will-change: transform;">
                    <iframe loading="lazy" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; border: none; padding: 0;margin: 0;" src="https:&#x2F;&#x2F;www.canva.com&#x2F;design&#x2F;DAFhaaU2rcM&#x2F;watch?embed" allowfullscreen="allowfullscreen" allow="fullscreen">
                    </iframe>
                  </div>
                  <!-- <a href="https:&#x2F;&#x2F;www.canva.com&#x2F;design&#x2F;DAFhaaU2rcM&#x2F;watch?utm_content=DAFhaaU2rcM&amp;utm_campaign=designshare&amp;utm_medium=embeds&amp;utm_source=link" target="_blank" rel="noopener">Tarjeta vertical felicitación cumpleaños empleado empresa elegante dorado</a> de Bimo Talento Humano -->
                </div>
                <!-- <div class="modal-footer">
                  <button type="button" class="btn btn-cancelar" data-bs-dismiss="modal"> Cancelar</button>
                  <button type="submit" form="formNuevaBase" class="btn btn-confirmar" id="submit-registrarGrupo">
                    Crear
                  </button>
                </div> -->
              </div>
            </div>
          </div>
        </div>
        <style>
          #paste-cumple {
            transition: height 0.8s cubic-bezier(0.165, 0.84, 0.44, 1)
          }

          #btn-flotante-cumple {
            transition: opacity 1s cubic-bezier(0.165, 0.84, 0.44, 1);
          }

          video::-webkit-media-controls {
            display: none;
          }
        </style>
        <script>
          // autoHeightDiv('#container-card-cumple', 120)

          // Obtener la imagen por su ID
          const imagen = document.getElementById('paste-cumple');
          const contenedor = document.getElementById('btn-flotante-cumple')

          // Definir el tamaño final de la imagen
          const alturaFinal = 40;

          // Definir la opacidad inicial de la imagen
          const opacidadFinal = 1;

          // Calcular el tamaño y la opacidad de la imagen en cada paso de la transición
          const alturaActual = imagen.offsetHeight;
          const alturaPaso = (alturaActual - alturaFinal) / 50;
          const opacidadActual = parseFloat(getComputedStyle(contenedor).opacity);
          const opacidadPaso = (opacidadFinal - opacidadActual) / 50;


          // Función para reducir gradualmente el tamaño de la imagen
          function reducirImagen() {
            const altura = imagen.offsetHeight;
            const nuevaAltura = altura - alturaPaso * Math.pow((1 - altura / alturaFinal), 2.5);
            const opacidad = parseFloat(getComputedStyle(contenedor).opacity);
            const opacidadRestante = opacidadFinal - opacidad;
            const nuevaOpacidad = opacidad + opacidadRestante * 0.05;
            if (nuevaAltura > alturaFinal) {
              imagen.style.height = `${nuevaAltura}px`;
              contenedor.style.opacity = nuevaOpacidad;
            } else {
              imagen.style.height = `${alturaFinal}px`;
              contenedor.style.opacity = opacidadFinal;
              clearInterval(intervalo);
            }
          }

          // Llamar a la función de reducción de tamaño en intervalos regulares
          // setTimeout(() => {
          const intervalo = setInterval(reducirImagen, 10);
          // }, 500);




          $(document).ready(async function() {
            await loadFull(tsParticles);

            $("#tsparticles")
              .particles()
              .ajax("https://bimo-lab.com/nuevo_checkup/vista/menu/principal/particles.json", function(container) {
                // container is the particles container where you can play/pause or stop/start.
                // the container is already started, you don't need to start it manually.
              });
          });
        </script>
      <?php endif; ?>


      <button class="navbar-toggler" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop" style="color: white;border-color: #ffffff54;">
        <!-- onclick="openNav()" -->
        <i class="bi bi-list"></i>
      </button>
      <div id="navbarCollapse" class="collapse navbar-collapse">
        <ul class="nav navbar-nav" id="navbar-js">
          <?php
          if ($menu != 'procedencia') {
            include "navbar-menu/navlink-normales.php";
            include "areas-windows-float.php";
          }
          ?>

        </ul>
        <ul class="nav navbar-nav ms-auto">

          <!-- Botones alado de los usuarios -->
          <li class="nav-item dropstart d-flex justify-content-center align-items-center m">
            <?php
            if ($menu != 'procedencia') {
              include "btn-user/buttons.php";
            }
            ?>
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
                    <?php if ($menu != 'procedencia') { ?>
                      <div class="profile-description text-center">
                        <a href="<?php echo $_SESSION['newsletter']['button_usuario']['url'] ?>" target="_blank" class="a-hover"><i class="bi bi-newspaper"></i> <?php echo $_SESSION['newsletter']['button_usuario']['tittle_button'] ?></a>
                      </div>
                    <?php } ?>
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