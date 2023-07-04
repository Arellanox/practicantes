<?php
include "../../../variables.php";
date_default_timezone_set('America/Mexico_City');
if ($menu != "PrincipalMenu") : ?>
  <li class="nav-item">
    <a href="<?php echo "$https$url/$appname/vista/menu/principal";
              /*echo $https . $url . '/' . /$appname . '/vista/menu/principal/';*/ ?>">
      <i class="bi bi-window"></i> Menú
    </a>
  </li>
<?php endif; ?>
<!-- <?php if ($menu == "Mesometria") : ?>
  <li class="nav-item">
    <a href="<?php echo "$https$url/$appname/vista/menu/consultorio/"; ?>">
      <i class="bi bi-clipboard"></i> Consultorio
    </a>
  </li>
<?php endif; ?> -->

<?php
if ($menu != 'Recepción' && $_SESSION['vista']['RECEPCIÓN'] == 1) : ?>
  <li class="nav-item">
    <a href="<?php echo "$https$url/$appname/vista/menu/recepcion/"; ?>">
      <i class="bi bi-people-fill"></i> Recepción
    </a>
  </li>
<?php endif; ?>


<?php if ($menu == "Recepción") : ?>
  <!-- <li class="nav-item">
    <a href="" data-bs-toggle="modal" data-bs-target="#ModalRegistrarPaciente">
      <i class="bi bi-person-plus"></i> Registrar
    </a>
  </li>
  <li class="nav-item">
    <a href="" data-bs-toggle="modal" data-bs-target="#ModalRegistrarPrueba">
      <i class="bi bi-person-lines-fill"></i> Agendar
    </a>
  </li>
  <li class="nav-item">
    <a href="" data-bs-toggle="modal" data-bs-target="#modalSolicitudIngresoParticulares">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-at" viewBox="0 0 16 16">
        <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2H2Zm3.708 6.208L1 11.105V5.383l4.708 2.825ZM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2-7-4.2Z" />
        <path d="M14.247 14.269c1.01 0 1.587-.857 1.587-2.025v-.21C15.834 10.43 14.64 9 12.52 9h-.035C10.42 9 9 10.36 9 12.432v.214C9 14.82 10.438 16 12.358 16h.044c.594 0 1.018-.074 1.237-.175v-.73c-.245.11-.673.18-1.18.18h-.044c-1.334 0-2.571-.788-2.571-2.655v-.157c0-1.657 1.058-2.724 2.64-2.724h.04c1.535 0 2.484 1.05 2.484 2.326v.118c0 .975-.324 1.39-.639 1.39-.232 0-.41-.148-.41-.42v-2.19h-.906v.569h-.03c-.084-.298-.368-.63-.954-.63-.778 0-1.259.555-1.259 1.4v.528c0 .892.49 1.434 1.26 1.434.471 0 .896-.227 1.014-.643h.043c.118.42.617.648 1.12.648Zm-2.453-1.588v-.227c0-.546.227-.791.573-.791.297 0 .572.192.572.708v.367c0 .573-.253.744-.564.744-.354 0-.581-.215-.581-.8Z" />
      </svg> Solicitud
    </a>
  </li> -->
  <li class="nav-item">
    <a href="#pendientes" type="button">
      <i class="bi bi-person-bounding-box"></i> Espera
    </a>
  </li>
  <li class="nav-item">
    <a href="#rechazados" type="button">
      <i class="bi bi-person-x-fill"></i> Rechazados
    </a>
  </li>
  <li class="nav-item">
    <a href="#ingresados" type="button">
      <i class="bi bi-person-badge-fill"></i> Aceptados
    </a>
  </li>

  <?php if ($_SESSION['perfil'] ==  1) : ?>
    <li class="nav-item">
      <a href="<?php echo "$https$url/$appname/vista/menu/pacientes-completos/"; ?>" type="button">
        <i class="bi bi-person-check"></i> Finalizados
      </a>
    </li>
  <?php endif; ?>


<?php endif; ?>

<?php if ($menu == "Usuarios" && $_SESSION['perfil'] == 1) : ?>
  <li class="nav-item">
    <div class="dropdown ">
      <a class="dropdown-toggle" id="dropadmin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-journals"></i> Catalogos
      </a>
      <ul class="dropdown-menu bg-navbar-drop drop-areas" aria-labelledby="dropadmin">
        <a class="dropdown-a align-items-center" type="button" data-bs-toggle="modal" data-bs-target="#modalRegistrarcargos">
          <i class="bi bi-person-badge"></i> Cargos
        </a>
        <a class="dropdown-a align-items-center" type="button" data-bs-toggle="modal" data-bs-target="#modalRegistrartitulos">
          <i class="bi bi-briefcase"></i> Titulos
        </a>
        <a class="dropdown-a align-items-center" type="button" data-bs-toggle="modal" data-bs-target="#modalRegistraruniversidades">
          <i class="bi bi-mortarboard"></i> Universidades
        </a>
        <a class="dropdown-a align-items-center" type="button" data-bs-toggle="modal" data-bs-target="#modalRegistrarespecialidades">
          <i class="bi bi-postcard"></i> Especialidades
        </a>
      </ul>
    </div>
  </li>
  <li class="nav-item">
    <a href="#Usuarios" class="">
      <i class="bi bi-person-lines-fill"></i> Usuarios
    </a>
  </li>
<?php endif; ?>

<?php if ($menu == "Servicios") : ?>
  <?php if ($_SESSION['vista']['LABORATORIO'] == 1) : ?>
    <li class="nav-item">
      <a href="" data-bs-toggle="modal" data-bs-target="#modalRegistrarmetodos">
        <i class="bi bi-box"></i> Metodos
      </a>
    </li>
  <?php endif; ?>
  <?php if ($_SESSION['vista']['LABORATORIO'] == 1) : ?>
    <li class="nav-item">
      <a href="#Estudios">
        <i class="bi bi-box"></i> Estudios
      </a>
    </li>
  <?php endif; ?>
  <?php if ($_SESSION['vista']['LABORATORIO'] == 1) : ?>
    <li class="nav-item">
      <a href="#Grupos">
        <i class="bi bi-collection"></i> Grupos de examenes
      </a>
    </li>
  <?php endif; ?>
  <?php if ($_SESSION['vista']['SERVICIOS (EQUIPOS)'] == 1) : ?>
    <li class="nav-item">
      <a href="#Equipos">
        <i class="bi bi-thunderbolt"></i> Equipos
      </a>
    </li>
  <?php endif; ?>
<?php endif; ?>

<?php if ($menu == "ServiciosLab") : ?>
  <!-- <li class="nav-item">
    <a href="" onclick="history.go(-1)">
      <i class="bi bi-reply"></i> Regresar
    </a>
  </li> -->


  <li class="nav-item">
    <div class="dropdown ">
      <a class="dropdown-toggle" id="dropCatalogosLab" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-journals"></i> Catalogos
      </a>
      <ul class="dropdown-menu bg-navbar-drop drop-areas" aria-labelledby="dropCatalogosLab">
        <a class="dropdown-a align-items-center" type="button" data-bs-toggle="modal" data-bs-target="#modalRegistrarmetodos">
          <i class="bi bi-box"></i> Métodos
        </a>
        <a class="dropdown-a align-items-center" type="button" data-bs-toggle="modal" data-bs-target="#modalRegistrarmaquila">
          <i class="bi bi-box"></i> Laboratorio Maquila
        </a>
      </ul>
    </div>
  </li>

  <!-- <li class="nav-item">
    <a href="" data-bs-toggle="modal" data-bs-target="#modalRegistrarmetodos">
      <i class="bi bi-box"></i> Metodos
    </a>
  </li>

  <li class="nav-item">
    <a href="" data-bs-toggle="modal" data-bs-target="#modalRegistrarmaquila">
      <i class="bi bi-box"></i> Laboratorios Maquila
    </a>
  </li> -->

  <li class="nav-item">
    <a href="#EstudiosLab">
      <i class="bi bi-box"></i> Estudios
    </a>
  </li>

  <li class="nav-item">
    <a href="#GruposLab">
      <i class="bi bi-collection"></i> Grupos de examenes
    </a>
  </li>

<?php endif; ?>

<?php if ($menu == "Laboratorio") : #$menu == "AreaMaster" 
?>

  <li class="nav-item">
    <div class="dropdown ">
      <!-- <a class="dropdown-toggle" id="dropadmin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-clipboard-heart"></i> Estudios del area
      </a> -->
      <ul class="dropdown-menu bg-navbar-drop drop-areas" aria-labelledby="dropadmin">
        <a class="dropdown-a align-items-center" type="button" href="" onclick="cargarVistaServiciosPorArea('Estudios')">
          <i class="bi bi-dot"></i> Estudios
        </a>
        <a class="dropdown-a align-items-center" type="button" href="" onclick="cargarVistaServiciosPorArea('Grupos')">
          <i class="bi bi-dot"></i> Grupos
        </a>
      </ul>
    </div>
  </li>
<?php endif; ?>

<?php if ($menu == "ListaPrecios") : ?>
  <li class="nav-item">
    <a href="#LISTA_PRECIOS">
      <i class="bi bi-tags"></i> Precios Estudio
    </a>
  </li>
  <li class="nav-item">
    <a href="#PAQUETES_ESTUDIOS">
      <i class="bi bi-box-fill"></i> Paquetes
    </a>
  </li>
  <li class="nav-item">
    <a href="#COTIZACIONES_ESTUDIOS">
      <i class="bi bi-inbox"></i> Cotizaciones
    </a>
  </li>
<?php endif; ?>

<?php if ($menu == "Consultorio") : ?>
  <li class="nav-item">
    <a href="#" type="button" onclick="obtenerConsultorioMain()">
      <i class="bi bi-thunderbolt"></i> Menú Historia Clínica
    </a>
  </li>
  <!-- <li class="nav-item">
    <a href="#Perfil">
      <i class="bi bi-thunderbolt"></i> Perfil paciente
    </a>
  </li>
  <li class="nav-item">
    <a href="#Consultorio">
      <i class="bi bi-thunderbolt"></i> Consultorio
    </a>
  </li> -->
<?php endif; ?>

<?php if ($menu == 'Facturacion') : ?>
  <li class="nav-item">
    <a href="#Estados-Cuentas">
      <i class="bi bi-thunderbolt"></i> Estado de cuentas
    </a>
  </li>
  <li class="nav-item">
    <a href="#Cuentas-usuarios">
      <i class="bi bi-thunderbolt"></i> Cuentas de usuario
    </a>
  </li>
<?php endif; ?>





<!-- Menu nuevo de la ujat -->

<!-- <?php if ($menu == 'Ujat') : ?>
 
<?php endif; ?> -->


<li class="nav-item">
  <a href="<?php echo "$https$url/$appname/vista/menu/Ujat"; ?>">
    <i class=" bi bi-thunderbolt"></i> UJAT
  </a>
</li>


<!-- Aqui termine el menu nuevo de la ujat -->