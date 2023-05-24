<div class="col-12 loader" id="loader" style="">
  <div class="preloader" id="preloader"> </div>
</div>
<div class="row">
  <div class="col-3 col-lg-3" style="margin-right: -5px !important;">
    <div class="card mt-3 p-3" id="lista-pacientes">
      <h5>Lista de pacientes</h5>

      <!-- Control de turnos -->
      <div id="turnos_panel"></div>

      <div class="text-center mt-2">
        <div class="input-group flex-nowrap">
          <!-- <span class="input-group-text" id="addon-wrapping" data-bs-toggle="tooltip" data-bs-placement="left" title="Los iconos representan el estado del paciente a las areas">
                        <i class="bi bi-info-circle"></i>
                    </span> -->
          <input type="search" class="form-control input-color" aria-controls="TablaEstatusTurnos" style="display: unset !important; margin-left: 0px !important" name="inputBuscarTableListaNuevos" placeholder="Filtrar coincidencias" id="BuscarTablaListaMuestras" data-bs-toggle="tooltip" data-bs-placement="top" title="Filtra la lista por coincidencias">
          <span class="input-group-text" id="addon-wrapping" data-bs-toggle="tooltip" data-bs-placement="top" title="Los pacientes con muestras tomadas se visualizarán confirmados de color verde">
            <i class="bi bi-info-circle"></i>
          </span>

        </div>
      </div>


      <table class="table display responsive" id="TablaMuestras" style="width: 100%">
        <thead class="">
          <tr>
            <th scope="col d-flex justify-content-center" class="all">#</th>
            <th scope="col d-flex justify-content-center" class="all">Nombre</th>
            <th scope="col d-flex justify-content-center" class="min-tablet">Folio</th>
            <th scope="col d-flex justify-content-center" class="none">Compañia</th>
            <th scope="col d-flex justify-content-center" class="none">Edad</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
  <div class="col-3 col-lg-3 informacion-muestras" style="margin-right: -5px !important;display:none">
    <div class="card m-3" id="panel-informacion"> </div>
    <!-- <div class="card m-3 p-4">
      <h4>Estudios anteriores</h4>
      <div class="accordion" id="accordionResultadosAnteriores">
      </div>
    </div> -->
  </div>
  <div class="col-lg-6 informacion-muestras" style="margin-right: -5px !important;display:none">
    <div class="card mt-3 p-3">
      <div class="row">
        <div class="col-12 col-lg-7">
          <h4>Estudios y contenedores</h4>
          <p class="none-p">Lista de los estudios y contenedores del pacientes</p>
        </div>
        <div class="col-12 col-lg-5 d-flex justify-content-center align-items-center">
          <button type="submit" data-attribute="guardar" class="btn btn-hover" id="muestra-tomado" style="margin-bottom:4px">
            <i class="bi bi-droplet-fill"></i> Muestra tomada
          </button>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-12">
          <h5>Estudios:</h5>
          <ul class="list-group overflow-auto" id="lista-estudios-paciente" style="max-width: 100%; max-height: 70vh;margin-bottom:10px;">
            <!-- <li class="list-group-item">
              GRUPO DE EXAMEN - SERVICIO
              <br>
              <i class="bi bi-arrow-return-right"></i> MUESTRA - CONTENEDOR
            </li> -->
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="col-9 d-flex justify-content-center align-items-center" id='loaderDivmuestras' style="max-height: 75vh; display:none">
    <div class="preloader" id="loader-muestras"></div>
  </div>
</div>
<style media="screen">
  #TablaMuestras_filter {
    display: none
  }
</style>