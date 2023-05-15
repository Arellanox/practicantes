<div class="col-12 col-lg-4">
  <label for="nombre" class="form-label">Nombre(s)</label>
  <input type="text" name="nombre" value="" class="form-control input-form" required>
</div>
<div class="col-6 col-lg-4">
  <label for="paterno" class="form-label">Apellido paterno</label>
  <input type="text" name="paterno" value="" class="form-control input-form">
</div>
<div class="col-6 col-lg-4">
  <label for="materno" class="form-label">Apellido materno</label>
  <input type="text" name="materno" value="" class="form-control input-form">
</div>
<div class="col-6 col-lg-3">
  <label for="nacimiento" class="form-label">Fecha de nacimiento</label>
  <input type="date" class="form-control input-form" name="nacimiento" placeholder="" required onchange="$(`input[class='form-control input-form edadPacienteRegistro']`).val(calcularEdad(this.value))">
</div>
<div class="col-6 col-lg-2">
  <label for="edad" class="form-label">Edad</label>
  <div class="input-group">
    <input type="number" class="form-control input-form edadPacienteRegistro" step="0.01" name="edad" placeholder="" min="0" max="150" required>
    <span class="input-span">años</span>
  </div>
</div>
<div class="col-7 col-lg-4">
  <label for="curp" class="form-label">CURP</label>
  <input type="text" class="form-control input-form" name="curp" placeholder="" required id="curp-registro-infor">
  <div class="form-check">
    <input class="form-check-input" type="checkbox" value="" id="checkCurpPasaporte">
    <label class="form-check-label" for="checkCurpPasaporte">
      Soy extranjero
    </label>
  </div>
  <!-- pattern="[A-Za-z]{4}[0-9]{6}[HMhm]{1}[A-Za-z]{5}[0-9]{2}" -->
</div>
<div class="col-5 col-lg-3">
  <label for="celular" class="form-label">Teléfono</label>
  <input type="number" class="form-control input-form" name="celular" placeholder="">
  <!-- pattern="[0-9]{10}" -->
</div>

<div class="col-6 col-lg-4">
  <label for="correo" class="form-label">Correo electronico</label>
  <input type="email" class="form-control input-form" name="correo" placeholder="Primer Correo" required data-bs-toggle="tooltip" data-bs-placement="top" title="Se requiere un correo para envio de resultados">
  <input type="email" class="form-control input-form" name="correo_2" placeholder="Segundo Correo" data-bs-toggle="tooltip" data-bs-placement="top" title="Se requiere un correo para envio de resultados">
</div>


<div class="col-6 col-lg-2">
  <label for="postal" class="form-label">Código postal</label>
  <input type="number" class="form-control input-form" name="postal" placeholder="">
  <!-- pattern="[0-9]{5}" -->
</div>
<div class="col-6 col-lg-3">
  <label for="estado" class="form-label">Estado</label>
  <input type="text" class="form-control input-form" name="estado" placeholder="">
</div>
<div class="col-6 col-lg-3">
  <label for="municipio" class="form-label">Municipio</label>
  <input type="text" class="form-control input-form" name="municipio" placeholder="">
</div>
<div class="col-6 col-lg-4">
  <label for="colonia" class="form-label">Colonia</label>
  <input type="text" class="form-control input-form" name="colonia" placeholder="">
</div>
<div class="col-6 col-lg-4">
  <label for="exterior" class="form-label">No. Exterior</label>
  <div class="input-group">
    <span class="input-span">No.</span>
    <input type="text" class="form-control input-form" name="exterior" placeholder="">
  </div>
</div>
<div class="col-6 col-lg-4">
  <label for="interior" class="form-label">No. Interior</label>
  <div class="input-group">
    <span class="input-span">No.</span>
    <input type="text" class="form-control input-form" name="interior" placeholder="">
  </div>
</div>
<div class="col-6">
  <label for="calle" class="form-label">Calle</label>
  <input type="text" class="form-control input-form" name="calle" placeholder="">
</div>

<div class="col-6 col-lg-3">
  <label for="nacionalidad" class="form-label">Nacionalidad</label>
  <input type="text" class="form-control input-form" name="nacionalidad" placeholder="">
</div>
<div class="col-6 col-lg-3">
  <label for="pasaporte" class="form-label">Pasaporte</label>
  <input type="text" class="form-control input-form" name="pasaporte" placeholder="" id="pasaporte-registro"> <!-- Requerido si no tiene curp -->
</div>
<div class="col-6 col-lg-3">
  <label for="rfc" class="form-label">RFC</label>
  <input type="text" class="form-control input-form" name="rfc" placeholder="">
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
        <label for="">Género: </label>
      </div>
      <div class="col">
        <input type="radio" id="mascuCues" name="genero" value="MASCULINO" required>
        <label for="mascuCues">Masculino</label>
      </div>
      <div class="col">
        <input type="radio" id="FemeCues" name="genero" value="FEMENINO" required>
        <label for="FemeCues">Femenino</label>
      </div>
    </div>
  </div>
</div>
<div class="col-12 col-lg-6 col-xxl-3 bd-callout bd-callout-warning" id="contenido-procedencia">

</div>