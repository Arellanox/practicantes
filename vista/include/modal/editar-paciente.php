<div class="modal fade" id="ModalEditarPaciente" tabindex="-1" aria-labelledby="filtrador" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header header-modal">
        <h5 class="modal-title">Editar información del paciente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="text-center">Actualice la información requerida, no podrá regresar estos cambios</p>
        <form class="row" id="formEditarPaciente">
          <div class="col-12 col-lg-4">
            <label for="nombre" class="form-label">Nombres</label>
            <input type="text" name="nombre" value="" class="form-control input-form" required id="editar-nombre">
          </div>
          <div class="col-6 col-lg-4">
            <label for="paterno" class="form-label">Apellido paterno</label>
            <input type="text" name="paterno" value="" class="form-control input-form" id="editar-paterno">
          </div>
          <div class="col-6 col-lg-4">
            <label for="materno" class="form-label">Apellido materno</label>
            <input type="text" name="materno" value="" class="form-control input-form" id="editar-materno">
          </div>
          <div class="col-6 col-lg-3">
            <label for="nacimiento" class="form-label">Fecha de nacimiento</label>
            <input type="date" class="form-control input-form" name="nacimiento" placeholder="" required id="editar-nacimiento" onchange="$(`#editar-edad`).val(calcularEdad(this.value))">
          </div>
          <div class="col-6 col-lg-2">
            <label for="edad" class="form-label">Edad</label>
            <div class="input-group">
              <input type="number" class="form-control input-form" step="0.01" name="edad" placeholder="" min="0" max="150" required id="editar-edad">
              <span class="input-span">años</span>
            </div>
          </div>
          <div class="col-7 col-lg-4">
            <label for="curp" class="form-label">CURP</label>
            <input type="text" class="form-control input-form" name="curp" placeholder="" required id="editar-curp"> <!-- pattern="[A-Za-z]{4}[0-9]{6}[HMhm]{1}[A-Za-z]{5}[0-9]{2}" -->
          </div>
          <div class="col-5 col-lg-3">
            <label for="celular" class="form-label">Télefono</label>
            <input type="number" class="form-control input-form" name="celular" pattern="[0-9]{10}" placeholder="" id="editar-telefono">
          </div>
          <div class="col-6 col-lg-4">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" class="form-control input-form" name="correo" id="editar-correo" placeholder="Primer Correo">
            <input type="email" class="form-control input-form" name="correo_2" id="editar-correo_2" placeholder="Segundo Correo">
          </div>
          <div class="col-6 col-lg-2">
            <label for="postal" class="form-label">Código postal</label>
            <input type="number" class="form-control input-form" name="postal" id="editar-postal" pattern="[0-9]{5}" placeholder="" id="editar-posta">
          </div>
          <div class="col-6 col-lg-3">
            <label for="estado" class="form-label">Estado</label>
            <input type="text" class="form-control input-form" name="estado" placeholder="" id="editar-estado">
          </div>
          <div class="col-6 col-lg-3">
            <label for="municipio" class="form-label">Municipio</label>
            <input type="text" class="form-control input-form" name="municipio" placeholder="" id="editar-municipio">
          </div>
          <div class="col-6 col-lg-4">
            <label for="colonia" class="form-label">Colonia</label>
            <input type="text" class="form-control input-form" name="colonia" placeholder="" id="editar-colonia">
          </div>
          <div class="col-6 col-lg-4">
            <label for="exterior" class="form-label">No. Exterior</label>
            <div class="input-group">
              <span class="input-span">No.</span>
              <input type="text" class="form-control input-form" name="exterior" placeholder="" id="editar-exterior">
            </div>
          </div>
          <div class="col-6 col-lg-4">
            <label for="interior" class="form-label">No. Interior</label>
            <div class="input-group">
              <span class="input-span">No.</span>
              <input type="text" class="form-control input-form" name="interior" placeholder="" id="editar-interior">
            </div>
          </div>
          <div class="col-6">
            <label for="calle" class="form-label">Calle</label>
            <input type="text" class="form-control input-form" name="calle" placeholder="" id="editar-calle">
          </div>

          <div class="col-6 col-lg-3">
            <label for="nacionalidad" class="form-label">Nacionalidad</label>
            <input type="text" class="form-control input-form" name="nacionalidad" placeholder="" id="editar-nacionalidad">
          </div>
          <div class="col-6 col-lg-3">
            <label for="pasaporte" class="form-label">Pasaporte</label>
            <input type="text" class="form-control input-form" name="pasaporte" placeholder="" id="editar-pasaporte">
          </div>
          <div class="col-6 col-lg-3">
            <label for="rfc" class="form-label">RFC</label>
            <input type="text" class="form-control input-form" name="rfc" placeholder="" id="editar-rfc">
          </div>
          <!-- <div class="col-6 col-lg-3">
            <label for="vacuna" class="form-label">Vacuna</label>
            <select class="input-form form-select" name="vacuna" id="editar-vacuna">
              <option value="1">Ninguno...</opcion>
              <option value="PFIZER">PFIZER</opcion>
              <option value="ASTRA ZENECA">ASTRA ZENECA</opcion>
              <option value="SPUTNIK V">SPUTNIK V</opcion>
              <option value="SINOVAC">SINOVAC</opcion>
              <option value="CANSINO">CANSINO</opcion>
              <option value="MODERNA">MODERNA</opcion>
              <option value="COVAX">COVAX</opcion>
              <option value="JOHNSON & JOHNSON">JOHNSON & JOHNSON</opcion>
              <option value="SINOPHARM">SINOPHARM</opcion>
              <option value="OTRA">OTRA (ESPECIFIQUE)</opcion>
            </select>
          </div>
          <div class="col-6 col-lg-3" id="editar-extra">
            <label for="vacunaextra" class="form-label">Especifique otra vacuna</label>
            <input type="text" class="form-control input-form" name="vacunaExtra" id="editar-vacunaExtra" placeholder="" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" readonly>
          </div>


          <div class="col-6 col-lg-3">
            <label for="inputDosis" class="form-label">Dosis</label>
            <select class="input-form form-select" name="inputDosis" id="editar-inputDosis">
              <option value="1">Ninguno...</opcion>
              <option value="1RA">1RA DOSIS</opcion>
              <option value="2DA">2DA DOSIS</opcion>
              <option value="3RA">3RA DOSIS</opcion>
              <option value="REFUERZO">REFUERZO</opcion>
            </select>
          </div> -->

          <div class="col-12 col-lg-6" style="margin-top: 30px;margin-bottom: 15px;">
            <div class="container">
              <div class="row" style="zoom:110%;">
                <div class="col-md-auto">
                  <label for="">Genero: </label>
                </div>
                <div class="col">
                  <input type="radio" id="edit-mascuCues" name="genero" value="MASCULINO" required>
                  <label for="edit-mascuCues">Masculino</label>
                </div>
                <div class="col">
                  <input type="radio" id="edit-femenCues" name="genero" value="FEMENINO" required>
                  <label for="edit-emeCues">Femenino</label>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-cancelar" data-bs-dismiss="modal"><i class="bi bi-arrow-left-short"></i> Cancelar</button>
        <button type="submit" form="formEditarPaciente" class="btn btn-confirmar" id="btn-actualizar">
          <i class="bi bi-send-plus"></i> Actualizar
        </button>
      </div>
    </div>
  </div>
</div>