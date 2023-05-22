 <?php if ($_SESSION['vista']['AGENDA_PACIENTES'] == 1) : ?>
     <li class="nav-item Recepción">
         <div class="dropdown ">
             <a class="dropdown-toggle" id="dropCheckups" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                 <i class="bi bi-calendar2-event"></i> Agenda Checkups
             </a>
             <!-- Estos botones se cargan en el servidor desde el archivo del include -->
             <ul class="dropdown-menu bg-navbar-drop drop-areas" aria-labelledby="dropCheckups">
                 <a class="dropdown-a align-items-center" type="button" href="<?php echo $https . $url . '/' . $appname . '/vista/menu/agenda-estudios/#AGENDA_PACIENTES'; ?>">
                     <i class="bi bi-dot"></i> Ultrasonido
                 </a>
             </ul>
         </div>
     </li>
 <?php endif; ?>

 <!-- Laboratorio -->
 <?php if (
        $_SESSION['vista']['LABORATORIO'] == 1 ||
        $_SESSION['vista']['LABORATORIO_MUESTRA_1'] == 1 ||
        $_SESSION['vista']['CORREOSLAB'] == 1 ||
        $_SESSION['vista']['LABORATORIO_ESTUDIOS'] == 1
    ) : ?>
     <li class="nav-item Recepción">
         <div class="dropdown ">
             <a class="dropdown-toggle" id="dropLaboratorio" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                 <i class="bi bi-heart-pulse"></i> Laboratorio
             </a>
             <!-- Estos botones se cargan en el servidor desde el archivo del include -->
             <ul class="dropdown-menu bg-navbar-drop drop-areas" aria-labelledby="dropLaboratorio">
                 <?php include "navbar-menu/navlink-droplist-laboratorio.php";
                    ?>
             </ul>
         </div>
     </li>
 <?php endif; ?>

 <!-- Imagenologia -->
 <?php ?>
 <!-- <li class="nav-item Recepción">
         <div class="dropdown ">
             <a class="dropdown-toggle" id="dropImagenologia" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                 <i class="bi bi-person-bounding-box"></i> Imagenología
             </a>
             <ul class="dropdown-menu bg-navbar-drop drop-areas" aria-labelledby="dropImagenologia">

             </ul>
         </div>
     </li> -->
 <?php  ?>

 <?php if (
        $_SESSION['vista']['ELECTROCARDIOGRAMA'] == 1 || $_SESSION['vista']['ELECTROCARDIOGRAMA_CAPTURAS'] == 1 ||
        $_SESSION['vista']['ESPIROMETRIA'] == 1 ||
        $_SESSION['vista']['AUDIOMETRIA'] == 1 ||
        $_SESSION['vista']['OFTALMOLOGIA'] == 1 ||
        $_SESSION['vista']['SOMATOMETRIA'] == 1 ||
        $_SESSION['vista']['CONSULTORIO'] == 1 ||
        $_SESSION['vista']['ULTRASONIDO'] == 1 || $_SESSION['vista']['ULTRASONIDOTOMA'] == 1 ||
        $_SESSION['vista']['RX'] == 1 || $_SESSION['vista']['RXTOMA'] == 1 ||
        $_SESSION['vista']['NUTRICION'] == 1 || $_SESSION['vista']['NUTRICION_CAPTURAS'] == 1 ||
        $_SESSION['vista']['ESTUDIOS_ULTRASONIDO'] == 1 || $_SESSION['vista']['ESTUDIOS_RAYOSX'] == 1 || $_SESSION['vista']['ESTUDIOS_AREAS'] == 1 ||
        $_SESSION['vista']['CONTROL_TURNOS_PANTALLA'] == 1 || $_SESSION['vista']['CONTROL_TURNOS'] == 1
    ) : ?>
     <li class="nav-item Recepción">
         <div class="dropdown ">
             <a class="dropdown-toggle" id="dropCheckups" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                 <i class="bi bi-window-stack"></i> Checkups
             </a>
             <!-- Estos botones se cargan en el servidor desde el archivo del include -->
             <ul class="dropdown-menu bg-navbar-drop drop-areas" aria-labelledby="dropCheckups">
                 <?php include "navbar-menu/navlink-droplist-areas.php"; ?>
             </ul>
         </div>
     </li>
 <?php endif; ?>


 <?php if (
        $_SESSION['vista']['CLIENTES'] == 1 ||
        $_SESSION['vista']['SERVICIOS (EQUIPOS)'] == 1 ||
        $_SESSION['vista']['FACTURACIÓN'] == 1 ||
        $_SESSION['vista']['LISTA_PRECIOS'] == 1 || $_SESSION['vista']['PAQUETES_ESTUDIOS'] == 1 || $_SESSION['vista']['COTIZACIONES_ESTUDIOS'] == 1 ||
        $_SESSION['vista']['CURSOS BIMO'] == 1
    ) : ?>
     <li class="nav-item Recepción">
         <div class="dropdown ">
             <a class="dropdown-toggle" id="dropadmin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                 <i class="bi bi-briefcase"></i> Administración
             </a>
             <!-- Estos botones se cargan en el servidor desde el archivo del include -->
             <ul class="dropdown-menu bg-navbar-drop drop-areas" aria-labelledby="dropadmin">
                 <?php include "navbar-menu/navlink-droplist-admin.php"; ?>
             </ul>
         </div>
     </li>
 <?php endif; ?>

 <?php if ($_SESSION['perfil'] == 1) : ?>

     <li class="nav-item Recepción">
         <div class="dropdown ">
             <a class="dropdown-toggle" id="dropTI" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                 <i class="bi bi-motherboard"></i> TI
             </a>
             <!-- Estos botones se cargan en el servidor desde el archivo del include -->
             <ul class="dropdown-menu bg-navbar-drop drop-areas" aria-labelledby="dropTI">
                 <a class="dropdown-a align-items-center" type="button" href="<?php echo $https . $url . '/' . $appname . '/vista/menu/administracion/#USUARIOS'; ?>">
                     <i class="bi bi-person-fill-gear"></i> Usuarios
                 </a>
             </ul>
         </div>
     </li>
 <?php endif; ?>