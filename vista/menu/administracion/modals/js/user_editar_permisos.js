const modalEditarPermisosUsuario = document.getElementById('modalEditarPermisosUsuario')
modalEditarPermisosUsuario.addEventListener('show.bs.modal', event => {
  document.getElementById("checkboxPermisos").innerHTML = ''
  $.ajax({
    url: "../../../api/permisos_api.php",
    type: "POST",
    data: { api: 2 },
    success: function (data) {
      data = jQuery.parseJSON(data);
      if (mensajeAjax(data)) {
        var checkboxPermisos = "";
        for (var i = 0; i < data['response']['data'].length; i++) {
          // alert();
          checkboxPermisos += '<div class="col-auto"> <div class="input-group mb-3"> <div class="input-group-text">' +
            '<input class="form-check-input mt-0 permisosUsuario" value="' + data['response']['data'][i]['ID_PERMISO'] + '" type="checkbox" aria-label="Checkbox for following text input" id="checkPermisoUsuario' + data['response']['data'][i]['ID_PERMISO'] + '">' +
            '<label class="d-flex justify-content-center" for="checkPermisoUsuario' + data['response']['data'][i]['ID_PERMISO'] + '">' + data['response']['data'][i]['DESCRIPCION'] + '</label>' +
            '</div></div></div>';
        }
        // // console.log(checkboxPermisos);
        document.getElementById("checkboxPermisos").innerHTML = checkboxPermisos;
        $('.permisosUsuario').prop('checked', false);
        $.ajax({
          url: "../../../api/usuarios_permisos_api.php",
          type: "POST",
          data: { id: array_selected['ID_USUARIO'], api: 6 },
          success: function (data) {
            data = jQuery.parseJSON(data);
            if (mensajeAjax(data)) {
              for (var i = 0; i < data['response']['data'].length; i++) {
                $('#checkPermisoUsuario' + data['response']['data'][i]['PERMISO_ID']).prop('checked', true);
                // document.getElementById("checkPermisoUsuario"").checked = true;
              }
            }
          }
        })
      }
    }
  })


})


$(document).on('click', '.permisosUsuario', function () {
  let val = $(this).val();
  //Revisa en que status está el checkbox y controlalo según lo //desees
  if ($(this).is(':checked')) {
    $.ajax({
      url: "../../../api/usuarios_permisos_api.php",
      type: "POST",
      data: { id: array_selected['ID_USUARIO'], val: val, api: 1 },
      success: function (data) {
        data = jQuery.parseJSON(data);
        if (mensajeAjax(data)) {

        }
      }
    })
  } else {
    $.ajax({
      url: "../../../api/usuarios_permisos_api.php",
      type: "POST",
      data: { id: array_selected['ID_USUARIO'], val: val, a: 0, api: 5 },
      success: function (data) {
        data = jQuery.parseJSON(data);
        if (mensajeAjax(data)) {

        }
      }
    })
  }
});
