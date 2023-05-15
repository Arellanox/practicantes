<div class="modal fade" id="ModalRegistrarPrueba" tabindex="-1" aria-labelledby="filtrador" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header header-modal">
        <h5 class="modal-title">Agendar nuevo registro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formRegistrarAgenda">
          <?php include "formRegistrarAgenda.php"; ?>
        </form>
      </div>
      <div class="modal-footer ">
        <!-- d-flex justify-content-between  -->
        <!-- <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
          <label class="form-check-label" for="flexCheckChecked">
            Checked checkbox
          </label>
        </div> -->
        <button type="button" class="btn btn-cancelar" data-bs-dismiss="modal"><i class="bi bi-arrow-left-short"></i> Cancelar</button>
        <button type="submit" form="formRegistrarAgenda" class="btn btn-confirmar" id="btn-formregistrar-agenda">
          <i class="bi bi-send-plus"></i> Registrar
        </button>
      </div>
    </div>
  </div>
</div>