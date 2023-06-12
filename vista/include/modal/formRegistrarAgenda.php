<p class="text-center">Utilice su <strong>CURP</strong> para crear su registro de laboratorio</p>
<div class="row">
  <div class="col-12 col-lg-8" id="Label-BuscarPaciente">
    <label for="curp" class="form-label" id="label-identificacion">CURP</label>
    <input type="text" name="curp" value="" class="form-control input-form" id="curp-paciente" required>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="" id="checkCurpPasaporte-agenda">
      <label class="form-check-label" for="checkCurpPasaporte-agenda">
        Soy extranjero
      </label>
    </div>
  </div>
  <div class="col-12 col-lg-4" style="margin-bottom: 10px;">
    <label for="selectpaciente" class="form-label">Buscar paciente</label>
    <div class="row">
      <div class="col-auto">
        <button class="btn btn-sm btn-confirmar" type="button" id="actualizarForm"><i class="bi bi-binoculars"></i> Consultar</button>
      </div>
      <div class="col-auto">
        <button class="btn btn-sm btn-borrar" type="button" id="eliminarForm"><i class="bi bi-eraser"></i> Limpiar</button>
      </div>
    </div>
  </div>
</div>
<div id="formDIV">
  <p id="mensaje" class="text-center"></p>
  <div class="row">
    <div class="col-6">
      <p>Paciente:</p>
      <p id="paciente-registro"></p>
    </div>
    <div class="col-6">
      <p>CURP/Pasaporte:</p>
      <p id="curp-registro"></p>
    </div>
    <div class="col-6">
      <p>Sexo:</p>
      <p id="sexo-registro"></p>
    </div>
    <div class="col-6">
      <p>Procedencia</p>
      <div class="" id="procedencia-agenda">
        <p id="procedencia-registro"></p>
      </div>
    </div>
    <div class="col-6">
      <label for="segmento" class="form-label">Seleccionar segmento</label>
      <select class="form-control input-form" id="selectSegmentos">
      </select>
    </div>
    <div class="col-6">
      <label for="curp" class="form-label">Fecha de agenda</label>
      <input type="date" name="fechaAgenda" value="" class="form-control input-form" required id="fecha-agenda">
    </div>
  </div>
  <br>
  <div id="cuestionadioRegistro">
    <h3>Cuestionario</h3>
    <p class="none-p" style="margin-left: 10px" id="descripcion-antecedentes">
      Si es su primer registro, rellene cada campo del cuestionario. Si ha tenido un registro previo podrá visualizar su
      información y actualizarlos. <br>
      Haga click en cada categoria del cuestionario para desplegar los campos del mismo.
    </p>
    <div class="mt-3" id="antecedentes-registro">

    </div>
  </div>

  <!-- Cuestionario de espirometria -->
  <div class="mt-3" id="formulario-espiro">

  </div>

</div>