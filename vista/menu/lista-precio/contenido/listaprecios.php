<div class="row ">
  <div class="card col-4 p-4" style="margin-bottom:5px;">
    <div class="text-start row" id="text-start" style="margin-top:4px;zoom:95%;margin-bottom:5px;">
      <h4>Seleccione una area</h4>
      <p class="none-p">Tipo de lista a mostrar:</p>
      <div class="d-flex justify-content-center">
        <div class="col-auto m-1">
          <input type="radio" class="btn-check" name="selectTipLista" id="check-Costo" value="1" autocomplete="off" checked>
          <label class="btn btn-outline-primary" for="check-Costo"><i class="bi bi-list"></i> Costo</label>
        </div>
        <div class="col-auto m-1">
          <input type="radio" class="btn-check" name="selectTipLista" id="check-Precios" value="2" autocomplete="off">
          <label class="btn btn-outline-primary" for="check-Precios"><i class="bi bi-list"></i> Precios</label>
        </div>
        <div class="col-auto m-1">
          <input type="radio" class="btn-check" name="selectTipLista" id="check-paquetes" value="3" autocomplete="off">
          <label class="btn btn-outline-primary" for="check-paquetes"><i class="bi bi-list"></i> Paquetes</label>
        </div>
      </div>
      <div class="mt-3" id="divSeleccionCliente">
        <label for="inputBuscarTableListaNuevos">Seleccione un cliente:</label>
        <select name="metodo" id="seleccionar-cliente" required>
        </select>
      </div>
      <p class="none-p vista_estudios-precios">Seleccione area:</p>
      <style media="screen">
        .btn-outline-success {
          border-color: transparent;
        }

        .btn-outline-success:hover {
          opacity: 50%;
        }
      </style>


      <div class="col-auto m-1 vista_estudios-precios">
        <input type="radio" class="btn-check" name="selectChecko" id="check-img" value="11" autocomplete="off">
        <label class="btn btn-outline-success" for="check-img"><i class="bi bi-list"></i> Ultrasonido</label>
      </div>
      <div class="col-auto m-1 vista_estudios-precios">
        <input type="radio" class="btn-check" name="selectChecko" id="check-rx" value="8" autocomplete="off">
        <label class="btn btn-outline-success" for="check-rx"><i class="bi bi-list"></i> Rayos X</label>
      </div>
      <div class="col-auto m-1 vista_estudios-precios">
        <input type="radio" class="btn-check" name="selectChecko" id="check-lab" value="6" autocomplete="off">
        <label class="btn btn-outline-success" for="check-lab"><i class="bi bi-list"></i> Laboratorio</label>
      </div>
      <div class="col-auto m-1 vista_estudios-precios">
        <input type="radio" class="btn-check" name="selectChecko" id="check-otros" value="0" autocomplete="off">
        <label class="btn btn-outline-success" for="check-otros"><i class="bi bi-list"></i>Otros Servicios</label>
      </div>


      <!-- <div class="col-12 m-1" id="vista_paquetes-precios">
        <label for="inputBuscarTableListaNuevos">Seleccione un paquete:</label>
        <select name="metodo" id="seleccion-paquete" required>
        </select>
      </div> -->
    </div>
  </div>
  <div class="col-8 card">
    <div class="text-center" style="margin-top:4px;zoom:95%;margin-bottom:5px;">
      <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" id="btn-guardar-lista">
        <i class="bi bi-save"></i> Guardar
      </button>
      <button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" id="vistaPreviaExel" data-bs-toggle="modal" disabled data-bs-target="#vistaPreviaExelModal">
        <i class="bi bi-filetype-exe"></i> Excel (Vista previa)
      </button>
    </div>

    <div class="" style="margin-left: 30px; margin-right: 30px;">
      <table class="table table-hover display responsive " id="TablaListaPrecios" style="width: 100%">
        <thead style="width: 100%">
          <!-- <tr>
            <th scope="col d-flex justify-content-center" class="all">#</th>
            <th scope="col d-flex justify-content-center" class="all">Ab</th>
            <th scope="col d-flex justify-content-center" class="all">Nombre</th>
            <th scope="col d-flex justify-content-center" class="min-tablet">Costo</th>
            <th scope="col d-flex justify-content-center" class="min-tablet">Margen</th>
            <th scope="col d-flex justify-content-center" class="min-tablet">Total</th>
          </tr> -->
        </thead>
        <tbody id="contenido-lista-precios"> </tbody>
      </table>
      <!-- <div class="d-flex justify-content-center">
        <div class="preloader" id="loader-tabla-precios" style="display:none"></div>
      </div> -->
    </div>
  </div>
</div>