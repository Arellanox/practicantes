<div class="col-12 loader" id="loader">
  <div class="preloader" id="preloader"> </div>
</div>

<!-- tabs para movil -->
<div id="tab-button"></div>

<div class="row">
  <div class="col-12 col-xl-4 tab-first" id="tab-paciente" style="margin-right: -5px !important;">
    <div class="card mt-3 p-3" id="lista-pacientes">
      <h4>Lista de pacientes</h4>

      <table class="table display responsive" id="TablaLaboratorio" style="width: 100%; zoom: 90%">
        <thead class="">
          <tr>
            <th scope="col d-flex justify-content-center" class="all">#</th>
            <th scope="col d-flex justify-content-center" class="all">Nombre</th>
            <th scope="col d-flex justify-content-center" class="min-tablet">Prefolio</th>
            <th scope="col d-flex justify-content-center" class="tablet">Cliente</th>
            <th scope="col d-flex justify-content-center" class="none">Segmento</th>
            <th scope="col d-flex justify-content-center" class="none">Turno</th>
            <th scope="col d-flex justify-content-center" class="tablet">Sexo</th>
            <th scope="col d-flex justify-content-center" class="none">Expendiente</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>

  <div class="col-12 col-xl-3 tab-second" id="tab-informacion" style="margin-right: -5px !important;display:none !important">
    <div class="card mt-3" id="panel-informacion"> </div>
    <div class="card mt-3 p-4">
      <h4>Estudios anteriores</h4>
      <div class="accordion" id="accordionResultadosAnteriores">
      </div>
    </div>
  </div>
  <div class="col-12 col-xl-5 tab-second" id="tab-reporte" style="margin-right: -5px !important;display:none !important">
    <div class="card mt-3 p-3">
      <div class="row">
        <div class="col-12 col-lg-6">
          <h4>Formulario de resultados</h4>
          <p class="none-p">Estudios cargados del paciente </p>
        </div>
        <div class="col-12 col-lg-6 d-flex justify-content-end align-items-start">
          <button type="button" data-attribute="guardar" class="btn btn-hover subir-resultado-lab" style="margin-bottom:4px" data-bs-toggle="tooltip" data-bs-placement="top" title="Guarde su progreso">
            <i class="bi bi-clipboard2-pulse"></i> Guardar
          </button>
          <button type="button" data-attribute="confirmar" class="btn btn-confirmar subir-resultado-lab" style="margin-bottom:4px" data-bs-toggle="tooltip" data-bs-placement="top" title="Reporte como N/A para ocultar el reporte : )">
            <i class="bi bi-clipboard2-pulse"></i> Confirmar
          </button>
          <button type="submit" form="formAnalisisLaboratorio" data-attribute="confirmar" id="btnConfirmarResultados" class="btn btn-hover" style="margin-bottom:4px; display: none;" disabled="">
            <i class="bi bi-clipboard2-pulse"></i> submit
          </button>
        </div>
      </div>
      <form class="" id="formAnalisisLaboratorio">

        <div id="formulario-estudios" class="overflow-auto" style="max-width: 100%; margin-bottom:10px;height: 70vh;">
          <!-- <p class="mt-3">BIOMETRIA HEMATICA</p> -->
        </div>
      </form>
    </div>
  </div>

  <style media="screen">
    li:first-child {
      border-top-left-radius: 10px !important;
      border-top-right-radius: 10px !important;
    }

    li:last-child {
      border-bottom-left-radius: 10px !important;
      border-bottom-right-radius: 10px !important;
    }
  </style>


  <!-- Tercera Columna visual -->
  <div id="reload-selectable"> </div>
</div>