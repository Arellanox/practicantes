const modalEditarVistaUsuario = document.getElementById('modalEditarVistaUsuario')
modalEditarVistaUsuario.addEventListener('show.bs.modal', event => {
  obtenerPermisos('modulos_api', {api:2}, function (dataAjax){
    let data = jQuery.parseJSON(dataAjax);
    rellenarPermisosHTML(data, function (){
      obtenerPermisos('modulos_api', {usuario_id: array_selected['ID_USUARIO'],api:7}, function (data){
        $('.permisosUsuario').prop('checked', false);
        let dataAjax = jQuery.parseJSON(data);
          if (mensajeAjax(dataAjax)) {
            for (var i = 0; i < data['response']['data'].length; i++) {
              // console.log("WI")
              $('#CheckAreaUsuarios'+data['response']['data'][i]['MODULO_ID']).prop('checked', true);
              // document.getElementById("CheckAreaUsuarios"").checked = true;
            }
          }
      })
    })
  })
})


function obtenerPermisos(api, data, callback) {
  $.ajax({
    url: "../../../api/"+api+".php",
    type: "POST",
    data:data,
    success: function(data) {
      callback(data)
    }
  })
}

function rellenarPermisosHTML(data, callback){
    console.log(data);
    if (mensajeAjax(data)) {
      var checkboxarea = "";
      for (var i = 0; i < data['response']['data'].length; i++) {
        // alert();
        checkboxarea += '<div class="col-auto"> <div class="input-group mb-3"> <div class="input-group-text">'+
                                    '<input class="form-check-input mt-0 areasUsuarios" value="'+data['response']['data'][i]['ID_MODULO']+'" type="checkbox" aria-label="Checkbox for following text input" id="CheckAreaUsuarios'+data['response']['data'][i]['ID_MODULO']+'">'+
                                    '<label class="d-flex justify-content-center" for="CheckAreaUsuarios'+data['response']['data'][i]['ID_MODULO']+'">'+data['response']['data'][i]['DESCRIPCION']+'</label>'+
                            '</div></div></div>';
      }
      // // console.log(checkboxarea);
      document.getElementById("checkboxarea").innerHTML = checkboxarea;
      setTimeout(() => {
        callback()
      }, 100);
    }
}


$( document ).on( 'click', '.areasUsuarios', function(){
let val = $(this).val();
  //Revisa en que status está el checkbox y controlalo según lo //desees
  if( $( this ).is( ':checked' ) ){
    $.ajax({
      url: "../../../api/modulos_api.php",
      type: "POST",
      data:{usuario_id: array_selected['ID_USUARIO'],id_modulo: val, api:5},
      success: function(data) {
        data = jQuery.parseJSON(data);
        if (mensajeAjax(data)) {

        }
      }
    })
  }else{
    $.ajax({
      url: "../../../api/modulos_api.php",
      type: "POST",
      data:{usuario_id: array_selected['ID_USUARIO'], id_modulo: val, a: 0, api:6},
      success: function(data) {
        data = jQuery.parseJSON(data);
        if (mensajeAjax(data)) {

        }
      }
    })
  }
});
