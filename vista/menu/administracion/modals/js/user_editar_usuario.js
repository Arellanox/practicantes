const modalEditarRegistroUsuario = document.getElementById('ModalEditarRegistroUsuario')
modalEditarRegistroUsuario.addEventListener('show.bs.modal', event => {
  document.getElementById("formEditarUsuario").reset();
  $("#Input-Constraseña-Edit").hide();
  $("#edit-usuario-contraseña").removeAttr("name");
  rellenarSelect('#usuario-cargos-edit', 'tipos_usuarios_api', 2, 0, 1);
  rellenarSelect('#usuario-tipo-edit', 'tipos_usuarios_api', 2, 0, 1);
  // Colocar ajax
  $.ajax({
    url: "../../../api/usuarios_api.php",
    type: "POST",
    data: { id: array_selected['ID_USUARIO'], api: 3 },
    success: function (data) {
      data = jQuery.parseJSON(data);
      if (mensajeAjax(data)) {
        $('#usuario-cargos-edit').val(data['response']['data'][0]['CARGO_ID'])
        $('#usuario-tipo-edit').val(data['response']['data'][0]['TIPO_ID'])
        $('#edit-usuario-nombre').val(data['response']['data'][0]['NOMBRE'])
        $('#edit-usuario-paterno').val(data['response']['data'][0]['PATERNO'])
        $('#edit-usuario-materno').val(data['response']['data'][0]['MATERNO'])
        $('#edit-usuario-usuario').val(data['response']['data'][0]['USUARIO'])
        // $('#edit-usuario-contraseña').val("data")
        $('#edit-usuario-Profesión').val(data['response']['data'][0]['PROFESION'])
        $('#edit-usuario-cedula').val(data['response']['data'][0]['CEDULA'])
        $('#edit-usuario-telefono').val(data['response']['data'][0]['TELEFONO'])
        $('#edit-usuario-correo').val(data['response']['data'][0]['CORREO'])
      }
    }
  })
})
//Formulario de Preregistro
$("#formEditarUsuario").submit(function (event) {
  event.preventDefault();
  /*DATOS Y VALIDACION DEL REGISTRO*/
  var form = document.getElementById("formEditarUsuario");
  var formData = new FormData(form);
  formData.set('id', array_selected['ID_USUARIO']);
  formData.set('api', 4);

  $.ajax({
    data: formData,
    url: "../../../api/usuarios_api.php",
    type: "POST",
    processData: false,
    contentType: false,
    success: function (data) {
      data = jQuery.parseJSON(data);
      // console.log(data);
      if (mensajeAjax(data)) {
        Toast.fire({
          icon: 'success',
          title: '¡Usuario actualizado!',
          timer: 2000
        });
        document.getElementById("formEditarUsuario").reset();
        $("#ModalEditarRegistroUsuario").modal('hide');
        tablaUsuarios.ajax.reload()
      }
    },
  });
  event.preventDefault();
});


$("#btn-eliminar-usuario").click(function () {
  if (array_selected != null) {
    Swal.fire({
      title: "¿Está seguro que desea eliminar este usuario?",
      text: "¡Este usuario no podrá recuperarse!",
      icon: 'warning',
      showCancelButton: true,
      cancelButtonColor: '#3085d6',
      confirmButtonColor: '#d33',
      confirmButtonText: 'ELIMINAR',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          data: { id: array_selected['ID_USUARIO'], api: 5 },
          url: "../../../api/usuarios_api.php",
          type: "POST",
          success: function (data) {
            data = jQuery.parseJSON(data);
            if (mensajeAjax(data)) {
              Toast.fire({
                icon: 'success',
                title: '¡Usuario Eliminado!',
                timer: 2000
              });
              $("#ModalEditarRegistroUsuario").modal('hide');
              tablaUsuarios.ajax.reload()
            }
          },
        });
      }
    })
  } else {
    alertSelectTable();
  }
})