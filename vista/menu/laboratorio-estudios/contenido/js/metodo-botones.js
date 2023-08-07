$("#Buscarmetodo").click(function () {
  idMetodo = $('#select_metodos').val();
  text = $("#select_metodos option:selected").text();
  if (idMetodo != "") {
    TablaMetodos.$('tr.selected').removeClass('selected');
    document.getElementById("edit-metodo-descripcion").value = text;
    var tr = selectedTrTable(text, 1, 'TablaMetodos')
    array_metodo = TablaMetodos.row(tr).data();
    cambiarFormMetodo(1);
  } else {
    array_metodo = null;
    cambiarFormMetodo(0);
  }
})

$("#Limpiarmetodo").click(function () {
  TablaMetodos.$('tr.selected').removeClass('selected');
  array_metodo = null;
  cambiarFormMetodo(0)
})

$('#desactivar-metodo').click(function () {
  if (array_metodo != null) {
    Swal.fire({
      title: "¿Está seguro que desea desactivar este método?",
      text: "No podrán elegir este método",
      icon: 'warning',
      showCancelButton: true,
      cancelButtonColor: '#3085d6',
      confirmButtonColor: '#d33',
      confirmButtonText: 'Desactivar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          data: { id: array_metodo['ID_METODO'], api: 5 },
          url: "../../../api/laboratorio_metodos_api.php",
          type: "POST",
          success: function (data) {
            data = jQuery.parseJSON(data);
            if (mensajeAjax(data)) {
              Toast.fire({
                icon: 'success',
                title: '¡Usuario Eliminado!',
                timer: 2000
              });
              document.getElementById("formEditarmetodo").reset();
              TablaMetodos.ajax.reload();
              selectMetodo()
            }
          },
        });
      }
    })
  } else {
    alertSelectTable();
  }
})
