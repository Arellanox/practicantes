<div class="modal fade" id="ModalRegistrarPaciente" tabindex="-1" aria-labelledby="filtrador" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header header-modal">
        <h5 class="modal-title">Nuevo registro de información personal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="text-center" id="detalle-registro">Asegúrese que toda su información esté correcta. <br /> Utilice su <strong>CURP</strong> para poder generar su agenda.</p>
        <form class="row" id="formRegistrarPaciente">
          <?php include "formRegistroPaciente.php"; ?>
        </form>
        <p>Los datos personales recabados serán protegidos, incorporados y tratados en el Sistema de Datos Personales correspondiente, de conformidad con lo dispuesto por la Ley Federal de Transparencia y Acceso a la Información Pública Gubernamental y demás disposiciones aplicables.</p>
      </div> 
      <div class="modal-footer">
        <button type="button" class="btn btn-pantone-7541" data-bs-dismiss="modal"><i class="bi bi-arrow-left-short"></i> Cancelar</button>
        <button type="submit" form="formRegistrarPaciente" class="btn btn-pantone-7408" id="btn-formregistrar-informacion">
          <i class="bi bi-send-plus"></i> Registrar
        </button>
      </div>
    </div>
  </div>
</div>