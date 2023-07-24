<?php
session_start();
date_default_timezone_set('America/Mexico_City');


$menu = $_POST['menu']; ?>


<?php if ($menu == "Menú principal") : ?>
  <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" data-bs-toggle="modal" data-bs-target="#modalFiltrarTabla">
    <i class="bi bi-archive"></i> Filtro
  </button>
<?php endif; ?>


<?php if ($menu == "Recepción | Espera" || $menu == "Recepción | Aceptados" || $menu == "Recepción | Rechazados") : ?>
  <!-- <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" id="btn-editar">
    <i class="bi bi-pencil-square"></i> Actualizar información del paciente
  </button> -->
  <!-- <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" id="btn-perfil" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualiza todos los pacientes del area">
    <i class="bi bi-image"></i> Subir imagen
  </button> -->

  <span data-bs-toggle="modal" data-bs-target="#ModalRegistrarPaciente" data-bs-dismiss="offcanvas">
    <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" data-bs-toggle="tooltip" data-bs-placement="top" title="Registra y agenda un paciente particular">
      <i class="bi bi-person-plus"></i> Registrar
    </button>
  </span>

  <span data-bs-toggle="modal" data-bs-target="#ModalRegistrarPrueba" data-bs-dismiss="offcanvas">
    <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" data-bs-toggle="tooltip" data-bs-placement="top" title="Agenda un paciente ya existente">
      <i class="bi bi-person-lines-fill"></i> Agendar
    </button>
  </span>


  <span data-bs-toggle="modal" data-bs-target="#modalSolicitudIngresoParticulares" data-bs-dismiss="offcanvas" id="solicitudIngresoParticulares">
    <button type="button" class="btn btn-hover me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Envia un correo con un token de registro para particulares">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-at" viewBox="0 0 16 16">
        <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2H2Zm3.708 6.208L1 11.105V5.383l4.708 2.825ZM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2-7-4.2Z" />
        <path d="M14.247 14.269c1.01 0 1.587-.857 1.587-2.025v-.21C15.834 10.43 14.64 9 12.52 9h-.035C10.42 9 9 10.36 9 12.432v.214C9 14.82 10.438 16 12.358 16h.044c.594 0 1.018-.074 1.237-.175v-.73c-.245.11-.673.18-1.18.18h-.044c-1.334 0-2.571-.788-2.571-2.655v-.157c0-1.657 1.058-2.724 2.64-2.724h.04c1.535 0 2.484 1.05 2.484 2.326v.118c0 .975-.324 1.39-.639 1.39-.232 0-.41-.148-.41-.42v-2.19h-.906v.569h-.03c-.084-.298-.368-.63-.954-.63-.778 0-1.259.555-1.259 1.4v.528c0 .892.49 1.434 1.26 1.434.471 0 .896-.227 1.014-.643h.043c.118.42.617.648 1.12.648Zm-2.453-1.588v-.227c0-.546.227-.791.573-.791.297 0 .572.192.572.708v.367c0 .573-.253.744-.564.744-.354 0-.581-.215-.581-.8Z" />
      </svg> Solicitud
    </button>
  </span>


  <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" onclick="pasarPaciente()" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Manda a un paciente a una area disponible">
    <i class="bi bi-arrow-repeat"></i> Optimizar Turnero
  </button>

  <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" id="get-modal-qr-clientes" data-bs-toggle="tooltip" data-bs-placement="bottom" title="QR de Clientes">
    <i class="bi bi-qr-code"></i> QR
  </button>


<?php endif; ?>



<?php if ($menu == "Usuarios") : ?>
  <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" data-bs-toggle="modal" data-bs-target="#ModalRegistrarUsuario">
    <i class="bi bi-person-plus-fill"></i> Agregar nuevo
  </button>
  <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" data-bs-toggle="modal" data-bs-target="#ModalFormUsuario" data-bs-whatever="new">
    <i class="bi bi-person-plus-fill"></i> Nuevo Usuario
  </button>
  <!-- <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" data-bs-toggle="modal" data-bs-target="#ModalMostrarPermisosCargos">
    <i class="bi bi-list-nested"></i> Permisos y Cargos
  </button> -->
<?php endif; ?>


<?php if ($menu == "Pre-registro") : ?>
  <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" data-bs-toggle="modal" data-bs-target="#ModalRegistrarPaciente">
    <i class="bi bi-person-plus-fill"></i> Registrar mi información
  </button>
<?php endif; ?>

<?php if ($menu == "Pre-registration") : ?>
  <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" data-bs-toggle="modal" data-bs-target="#ModalRegistrarPaciente">
    <i class="bi bi-person-plus-fill"></i> Register my information
  </button>

  <!-- Menú desplegable de cambio de idioma -->
  <div class="language-dropdown">
    <select onchange="changeLanguage(this.value)">
      <option value="es">Español</option>
      <option value="en">English</option>
    </select>
  </div>

<?php endif; ?>


<?php if (
  $menu == "Estudios - Laboratorio" ||
  $menu == "Estudios" ||
  $menu == "Grupos de estudios - Laboratorio" ||
  $menu == "Grupos de estudios" ||
  $menu == "Estudios de Rayos X" ||
  $menu == 'Estudios de Ultrasonido' ||
  $menu == "Estudios Checkup"
) : ?>
  <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" id="btn-agregar-estudio">
    <i class="bi bi-plus-square"></i> Agregar
  </button>
<?php endif; ?>

<?php if ($menu == "Equipos") : ?>
  <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" data-bs-toggle="modal" data-bs-target="#ModalRegistrarEquipo">
    <i class="bi bi-plus-square"></i> Agregar equipo
  </button>
<?php endif; ?>


<?php if ($menu == "Segmentos") : ?>
  <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" data-bs-toggle="modal" data-bs-target="#ModalRegistrarSegmentos">
    <i class="bi bi-plus-square"></i> Agregar nuevo segmento
  </button>
<?php endif; ?>


<?php if ($menu == "Somatometría") : ?>
  <button type="submit" class="btn btn-hover me-2" form="form-resultados-somatometria" style="margin-bottom:4px">
    <i class="bi bi-save"></i> Guardar resultados
  </button>
  <button type="submit" data-attribute="confirmar" class="btn btn-hover" id="omitir-paciente" style="margin-bottom:4px">
    <i class="bi bi-clipboard-x"></i> Saltar paciente
  </button>
<?php endif; ?>


<?php if ($menu == "Perfil del paciente") : ?>
  <!-- <button type="button" class="btn btn-pantone-7408 me-2" style="margin-bottom:4px" id="entrarConsultaMedica">
    <i class="bi bi-box-arrow-in-right"></i> Consulta Médica
  </button> -->
<?php endif; ?>


<?php if ($menu == "Paquetes de clientes") : ?>
  <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" data-bs-toggle="modal" data-bs-target="#ModalRegistrarPaquete">
    <i class="bi bi-save"></i> Crear Nuevo Paquete
  </button>
<?php endif; ?>

<?php if ($menu == 'Estado actual del paciente') : ?>
  <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" id="recargarTabla">
    <i class="bi bi-arrow-clockwise"></i> Re-cargar tabla
  </button>
<?php endif; ?>




<?php if ($menu == "Clientes") : ?>
  <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" data-bs-toggle="modal" data-bs-target="#ModalRegistrarCliente">
    <i class="bi bi-people"></i> Agregar Nuevo Cliente
  </button>
  <!-- <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" id="generar-codigoqr">
    <i class="bi bi-qr-code"></i> Generar QR Prerregistro
  </button> -->
<?php endif; ?>

<?php if (
  $menu == 'Reportes de Laboratorio Clínico' ||
  $menu == 'Validación y envío de resultados de laboratorio' ||
  $menu == 'Laboratorio Clínico' ||
  $menu == 'Resultados de Laboratorio Clinico' ||
  $menu == 'Resultados de Laboratorio Biomolecular' ||
  $menu == 'Laboratorio Biomolecular'
) : ?>
  <div class="row">
    <!-- <div class="col-auto">
      <div class="form-floating">
        <input type="date" class="form-control input-form" placeholder="fecha" id="fechaListadoLaboratorio" value="<?php echo date('Y-m-d') ?>">
        <label for="fechaListadoLaboratorio">Día de análisis</label>
      </div>
    </div> -->
    <div class="col-auto d-flex align-items-center">
      <label for="fechaListadoLaboratorio" class="form-label">Día de análisis</label>
    </div>
    <div class="col-auto d-flex align-items-center">
      <input type="date" class="form-control input-form" name="fechaListadoLaboratorio" value="<?php echo date('Y-m-d') ?>" required id="fechaListadoLaboratorio">
    </div>
    <div class="col-auto d-flex align-items-center" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualiza todos los pacientes del area">
      <input class="form-check-input" type="checkbox" value="" id="checkDiaAnalisis" style="margin: 5px">
      <label class="form-check-label" for="checkDiaAnalisis">
        Todos
      </label>
    </div>
  </div>
<?php endif; ?>

<?php if (
  $menu == 'Resultados de Ultrasonido'
  || $menu == 'Carga de imagenes de Ultrasonido'
  || $menu == 'Resultados de Rayos X'
  || $menu == 'Carga de placas de Rayos X'
  || $menu == 'Resultados de Espirometría'
  || $menu == 'Resultados de Audiometría'
  || $menu == 'Resultados de Oftalmología'
  || $menu == 'Resultados de Electrocardiograma'
  || $menu == 'Carga de Electrocardiograma'
  || $menu == 'Toma de muestras'
  || $menu == 'Somatometría | Signos Vitales'
  || $menu == 'Consultorio'
  || $menu == 'Estudio de Composición Corporal (InBody)'
) : ?>
  <div class="row">
    <div class="col-auto d-flex align-items-center">
      <label for="fechaListadoAreaMaster" class="form-label">Día de análisis</label>
    </div>
    <div class="col-auto d-flex align-items-center">
      <input type="date" class="form-control input-form" name="fechaListadoAreaMaster" value="<?php echo date('Y-m-d') ?>" required id="fechaListadoAreaMaster">
    </div>
    <div class="col-auto d-flex align-items-center" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualiza todos los pacientes del area">
      <input class="form-check-input" type="checkbox" value="" id="checkDiaAnalisis" style="margin: 5px">
      <label class="form-check-label" for="checkDiaAnalisis">
        Todos
      </label>
    </div>
  </div>
<?php endif; ?>

<?php if ($menu == 'Agenda de pacientes | Ultrasonido') : ?>
  <div class="row">
    <div class="col-auto d-flex align-items-center">
      <label for="fechaSelected" class="form-label">Día</label>
    </div>
    <div class="col-auto d-flex align-items-center">
      <input type="date" class="form-control input-form" name="fechaSelected" value="<?php echo date('Y-m-d') ?>" required id="fechaSelected">
    </div>
    <div class="col-auto d-flex align-items-center" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Visualiza todos los pacientes del area">
      <input class="form-check-input" type="checkbox" value="" id="checkDiaFechaSelected" style="margin: 5px">
      <label class="form-check-label" for="checkDiaFechaSelected">
        Todos
      </label>
    </div>
  </div>
<?php endif; ?>

<?php if ($menu == "Registros de Temperatura") : ?>
  <!-- <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" id="capturarTemperatura">
    <i class="bi bi-plus-circle-fill"></i> Capturar
  </button> -->

  <?php if (TRUE) : ?>
    <div class="d-flex">
      <button type="button" data-bs-toggle='tooltip' data-bs-placement='top' title="Liberar un rango de días  para la captura de temperaturas de los equipos" class="btn btn-hover me-2" style="margin-bottom:4px; display:none" id="LibererDiaTemperatura">
        <i class="bi bi-arrow-down-circle-fill"></i> Liberar Dia
      </button>

      <div class="dropdown">
        <button class="btn btn-hover me-2 dropdown-toggle" type="button" style="margin-bottom:4px;" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-gear-fill"></i> Configuración
        </button>
        <ul class="dropdown-menu">
          <li>
            <button class="btn dropdown-item" id="TermometrosbtnTemperaturas" data-bs-toggle='tooltip' data-bs-placement='top' title="Configuración de los termómetros asignados a los equipos">Termómetros</button>
          </li>
          <li>
            <button class="btn dropdown-item" id="ConfiguracionTemperaturasbtn" data-bs-toggle='tooltip' data-bs-placement='top' title="Configuración de los turnos y activar los días domingos">Más Configuración</button>
          </li>
        </ul>
      </div>

    </div>

  <?php endif; ?>


<?php endif; ?>


<?php if ($menu == 'Pacientes (Crédito)') : ?>
  <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" data-bs-toggle="modal" data-bs-target="#modalFiltroPacientesFacturacion">
    <i class="bi bi-archive"></i> Generar Grupo
  </button>
<?php endif; ?>