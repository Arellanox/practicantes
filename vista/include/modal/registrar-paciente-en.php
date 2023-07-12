<div class="modal fade" id="ModalRegistrarPaciente" tabindex="-1" aria-labelledby="filtrador" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content">
            <div class="modal-header header-modal">
                <h5 class="modal-title">

                    New registration of personal information

                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center" id="detalle-registro">

                    Make sure all your information is correct.
                    <br>

                    Use your
                    <strong>

                        CURP

                    </strong>

                    to be able to generate your agenda.

                </p>
                <form class="row" id="formRegistrarPaciente">
                    <div class="col-12 col-lg-4">
                        <label for="nombre" class="form-label">

                            Names

                        </label>
                        <input type="text" name="nombre" value="" class="form-control input-form" required="" style="text-transform: uppercase;">
                    </div>
                    <div class="col-6 col-lg-4">
                        <label for="paterno" class="form-label">

                            Last name

                        </label>
                        <input type="text" name="paterno" value="" class="form-control input-form" style="text-transform: uppercase;">
                    </div>
                    <div class="col-6 col-lg-4">
                        <label for="materno" class="form-label">

                            Mother's last name

                        </label>
                        <input type="text" name="materno" value="" class="form-control input-form" style="text-transform: uppercase;">
                    </div>
                    <div class="col-6 col-lg-3">
                        <label for="nacimiento" class="form-label">

                            Birthdate

                        </label>
                        <input type="date" class="form-control input-form" name="nacimiento" placeholder="" required="" onchange="$(`input[class='form-control input-form edadPacienteRegistro']`).val(calcularEdad(this.value))">
                    </div>
                    <div class="col-6 col-lg-2">
                        <label for="edad" class="form-label">

                            Age

                        </label>
                        <div class="input-group">
                            <input type="number" class="form-control input-form edadPacienteRegistro" step="0.01" name="edad" placeholder="" min="0" max="150" required="">
                            <span class="input-span">

                                years

                            </span>
                        </div>
                    </div>
                    <div class="col-7 col-lg-4">
                        <label for="curp" class="form-label">

                            curp

                        </label>
                        <input type="text" class="form-control input-form" name="curp" placeholder="" required="" id="curp-registro-infor" style="text-transform: uppercase;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="checkCurpPasaporte">
                            <label class="form-check-label" for="checkCurpPasaporte">


                                I'm a foreigner


                            </label>
                        </div>
                        <!-- pattern="[A-Za-z]{4}[0-9]{6}[HMhm]{1}[A-Za-z]{5}[0-9]{2}" -->
                    </div>
                    <div class="col-5 col-lg-3">
                        <label for="celular" class="form-label">

                            Phone

                        </label>
                        <input type="number" class="form-control input-form" name="celular" placeholder="">
                        <!-- pattern="[0-9]{10}" -->
                    </div>

                    <div class="col-6 col-lg-4">
                        <label for="correo" class="form-label">

                            Email

                        </label>
                        <input type="email" class="form-control input-form" name="correo" placeholder="First Mail" required="" data-bs-toggle="tooltip" data-bs-placement="top" title="An email is required to send results">
                        <input type="email" class="form-control input-form" name="correo_2" placeholder="Second Mail" data-bs-toggle="tooltip" data-bs-placement="top" title="An email is required to send results">
                    </div>


                    <div class="col-6 col-lg-2">
                        <label for="postal" class="form-label">

                            Postal Code

                        </label>
                        <input type="number" class="form-control input-form" name="postal" placeholder="">
                        <!-- pattern="[0-9]{5}" -->
                    </div>
                    <div class="col-6 col-lg-3">
                        <label for="estado" class="form-label">

                            State

                        </label>
                        <input type="text" class="form-control input-form" name="estado" placeholder="" style="text-transform: uppercase;">
                    </div>
                    <div class="col-6 col-lg-3">
                        <label for="municipio" class="form-label">

                            Municipality

                        </label>
                        <input type="text" class="form-control input-form" name="municipio" placeholder="" style="text-transform: uppercase;">
                    </div>
                    <div class="col-6 col-lg-4">
                        <label for="colonia" class="form-label">

                            Colony

                        </label>
                        <input type="text" class="form-control input-form" name="colonia" placeholder="" style="text-transform: uppercase;">
                    </div>
                    <div class="col-6 col-lg-4">
                        <label for="exterior" class="form-label">

                            No. Outside

                        </label>
                        <div class="input-group">
                            <span class="input-span">

                                No.

                            </span>
                            <input type="text" class="form-control input-form" name="exterior" placeholder="" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="col-6 col-lg-4">
                        <label for="interior" class="form-label">

                            No.Inside

                        </label>
                        <div class="input-group">
                            <span class="input-span">

                                No.

                            </span>
                            <input type="text" class="form-control input-form" name="interior" placeholder="" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="calle" class="form-label">

                            Street

                        </label>
                        <input type="text" class="form-control input-form" name="calle" placeholder="" style="text-transform: uppercase;">
                    </div>

                    <div class="col-6 col-lg-3">
                        <label for="nacionalidad" class="form-label">

                            Nationality

                        </label>
                        <input type="text" class="form-control input-form" name="nacionalidad" placeholder="" style="text-transform: uppercase;">
                    </div>
                    <div class="col-6 col-lg-3">
                        <label for="pasaporte" class="form-label">

                            Passport

                        </label>
                        <input type="text" class="form-control input-form" name="pasaporte" placeholder="" id="pasaporte-registro" style="text-transform: uppercase;"> <!-- Requerido si no tiene curp -->
                    </div>
                    <div class="col-6 col-lg-3">
                        <label for="rfc" class="form-label">RFC</label>
                        <input type="text" class="form-control input-form" name="rfc" placeholder="" style="text-transform: uppercase;">
                    </div>
                    <!-- <div class="col-6 col-lg-3">
  <label for="vacuna" class="form-label">Vacuna</label>
  <select class="input-form" name="vacuna" id="vacuna">
      <option value="1" >Ninguno...</opcion>
      <option value="PFIZER">PFIZER</opcion>
      <option value="ASTRA ZENECA" >ASTRA ZENECA</opcion>
      <option value="SPUTNIK V" >SPUTNIK V</opcion>
      <option value="SINOVAC" >SINOVAC</opcion>
      <option value="CANSINO" >CANSINO</opcion>
      <option value="MODERNA" >MODERNA</opcion>
      <option value="COVAX" >COVAX</opcion>
      <option value="JOHNSON & JOHNSON" >JOHNSON & JOHNSON</opcion>
      <option value="SINOPHARM" >SINOPHARM</opcion>
      <option value="OTRA">OTRA (ESPECIFIQUE)</opcion>
  </select>
</div>
<div class="col-6 col-lg-3" >
  <label for="vacunaextra" class="form-label">Especifique otra vacuna</label>
  <input type="text" class="form-control input-form" placeholder="" style="text-transform:uppercase;" value="NA" name="vacunaExtra" id="vacunaExtra" onkeyup="javascript:this.value=this.value.toUpperCase();" readonly>
</div>
<div class="col-6 col-lg-3">
  <label for="dosis" class="form-label">Dosis</label>
  <select class="input-form" name="inputTipoPDF" id="inputDosis">
      <option value="1" >Ninguno...</opcion>
      <option value="1RA" >1RA DOSIS</opcion>
      <option value="2DA">2DA DOSIS</opcion>
      <option value="3RA" >3RA DOSIS</opcion>
      <option value="REFUERZO" >REFUERZO</opcion>
  </select>
</div> -->
                    <div class="col-12 col-lg-6" style="margin-top: 30px;margin-bottom: 15px;">
                        <div class="container">
                            <div class="row" style="zoom:110%;">
                                <div class="col-md-auto">
                                    <label for="">

                                        Gender:

                                    </label>
                                </div>
                                <div class="col">
                                    <input type="radio" id="mascuCues" name="genero" value="MASCULINO" required="">
                                    <label for="mascuCues">

                                        Male

                                    </label>
                                </div>
                                <div class="col">
                                    <input type="radio" id="FemeCues" name="genero" value="FEMENINO" required="">
                                    <label for="FemeCues">

                                        Female

                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-xxl-3 bd-callout bd-callout-warning" id="contenido-procedencia">

                    </div>
                </form>
                <p>

                    The personal data collected will be protected, incorporated and processed in the corresponding Personal Data System, in accordance with the provisions of the Federal Law on Transparency and Access to Public Government Information and other applicable provisions.

                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-pantone-7541" data-bs-dismiss="modal"><i class="bi bi-arrow-left-short"></i>

                    Cancel

                </button>
                <button type="submit" form="formRegistrarPaciente" class="btn btn-pantone-7408" id="btn-formregistrar-informacion">
                    <i class="bi bi-send-plus"></i>

                    to register


                </button>
            </div>
        </div>




    </div>
</div>