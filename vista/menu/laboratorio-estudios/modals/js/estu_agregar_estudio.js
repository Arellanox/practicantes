


let rellenoGrupoSelect, rellenoMetodoSelect, rellenoEquipoSelect, rellenoMaquilaSelect, rellenoClasificacion, rellenoMedidas, rellenoSatFacturacion
const ModalRegistrarEstudio = document.getElementById("ModalRegistrarEstudio");
ModalRegistrarEstudio.addEventListener("show.bs.modal", (event) => {

  if (modalEdit) {
    $('#modal-title-estudios').html('Actualizar Información del estudio: ' + array_selected['DESCRIPCION'])
  } else {
    $('#modal-title-estudios').html('Agregar Nuevo Estudio');
  }


  setTimeout(() => {
    $('input[type=radio][name=local]').change(function () {
      if (this.value == '0') {
        $('#div-maquila').fadeIn()
        $('#maquila_agregar_estudio').prop('required', true)
      }
      else if (this.value == '1') {
        $('#div-maquila').fadeOut()
        $('#maquila_agregar_estudio').prop('required', false)
      }
    });
  }, 500);

})

// $(document).ready(function () {
//   $('#summernote-estudios').summernote({
//     toolbar: [
//       // ['style', ['style']],
//       ['font', ['bold', 'underline', 'clear']],
//       // ['color', ['color']],
//       ['para', ['ul', 'ol', 'paragraph']],
//       // ['table', ['table']],
//       // ['insert', ['link', 'picture', 'video']],
//       // ['view', ['fullscreen', 'codeview', 'help']]
//     ]
//   });
// });

$("#ModalRegistrarEstudio").on("hidden.bs.modal", function () {
  // put your default event here
  if (modalEdit) {
    // $('#formRegistrarEstudio').html(formEstudios);
    $('#div-select-grupo, #div-select-metodo, #div-select-contenedores, #div-select-equipo').html('')

    agregarContenedorMuestra('#div-select-contenedores', numberContenedor, 1);
    agregarHTMLSelectorInput('#div-select-grupo', 'Grupo', rellenoGrupoSelect)
    agregarHTMLSelector('#div-select-metodo', 'Método', rellenoMetodoSelect)
    agregarHTMLSelector('#div-select-equipo', 'Equipo', rellenoEquipoSelect)

    $('#maquila_agregar_estudio').html(rellenoMaquilaSelect)

    // $('input[name="muestra_valores"]').prop('checked', false);
    $('#input-dirigido-sexo-referencia option').removeClass('selected');
    $('#input-dirigido-sexo-servicio option').removeClass('selected');


    $('input[name="descripcion"]').val('');
    $('input[name="abreviatura"]').val('');
    $('input[name="muestra_valores"], input[name="grupos"]').prop('checked', false);

  }
});

async function getValueEstudio(id) {
  return new Promise(function (resolve, reject) {
    $.ajax({
      type: 'POST',
      url: `${http}${servidor}/${appname}/api/laboratorio_servicios_api.php`,
      dataType: 'json',
      data: {
        api: 2, id_servicio: id
      },
      beforeSend: function () {
        modalEdit = false;
        $('#formRegistrarEstudio').html(formEstudios);
        $('#div-select-grupo, #div-select-metodo, #div-select-contenedores, #div-select-equipo').html('')
        recargarSelects();

        $('#registrar-clasificacion-estudio').html(rellenoClasificacion)
        $('#registrar-medidas-estudio').html(rellenoMedidas)
        $('#registrar-concepto-facturacion').html(rellenoSatFacturacion)
        $('#maquila_agregar_estudio').html(rellenoMaquilaSelect)

        // alertMensaje('info', 'Cargando información...', 'Espere un momento mientras se cargan los datos');
      },
      success: function (data) {
        if (mensajeAjax(data)) {
          // try {
          let row = data.response.data;

          $('#input-descripcion').val(ifnull(row.DESCRIPCION, ''));
          $('#input-abreviatura').val(ifnull(row.ABREVIATURA, ''));

          if (row.CLASIFICACION_ID) {
            $('#registrar-clasificacion-estudio').val(row.CLASIFICACION_ID).trigger('change');
          } else {
            $('#sin_clasificacion').prop('checked', true);
          }

          if (row.MEDIDA_ID) {
            $('#registrar-medidas-estudio').val(row.MEDIDA_ID).trigger('change');
          } else {
            $('#sin_medida').prop('checked', true);
          }

          $('#input-dias_entrega').val(ifnull(row.DIAS_DE_ENTREGA));

          if (row.CODIGO_SAT_ID) {
            $('#registrar-concepto-facturacion').val(row.CODIGO_SAT_ID).trigger('change');
          } else {
            $('#registrar-concepto-facturacion').val(32).trigger('change'); ///Codigo sat
          }

          $('#input-indicaciones').val(ifnull(row.INDICACIONES))

          $("#input-dirigido-sexo-servicio option").prop('selected', false)
          $("#input-dirigido-sexo-servicio option").filter(function () {
            //may want to use $.trim in here
            return $(this).text() == row.SEXO_SERVICIO;
          }).prop('selected', true);

          $(`input[name="local"][value="${row.LOCAL}"]`).prop('checked', true);
          if (row.LOCAL == '0') {
            $('#div-maquila').fadeIn()
            $('#maquila_agregar_estudio').val(row.MAQUILA_ID);
            $('#maquila_agregar_estudio').prop('required', true);

          } else {
            $('#div-maquila').fadeOut()
            $('#maquila_agregar_estudio').val(1);
            $('#maquila_agregar_estudio').prop('required', false);

          }


          let grupos = row.GRUPOS
          if (grupos) {
            grupos = grupos.GRUPO_ID
            for (const key in grupos) {
              setTimeout(() => {
                if (Object.hasOwnProperty.call(grupos, key)) {
                  const element = grupos[key];
                  if (element) {
                    console.log(element)
                    let nameInput = agregarHTMLSelectorInput('#div-select-grupo', 'Grupo', rellenoGrupoSelect, element['GRUPO'], element['ORDEN'])
                    $(`select[name="${nameInput}"`).val(element['GRUPO']).trigger('change')
                  }
                }
              }, 100);
            }
          }

          $(`input[type="radio"][name="grupos"][value="${row.ES_GRUPO}"]`).prop('checked', true)


          let metodo = row.METODO_ID;
          for (const key in metodo) {
            setTimeout(() => {
              if (Object.hasOwnProperty.call(metodo, key)) {
                const element = metodo[key];
                if (element) {
                  console.log(element)
                  let nameInput = agregarHTMLSelector('#div-select-metodo', 'Método', rellenoMetodoSelect)
                  $(`select[name="${nameInput}"]`).val(element).trigger('change');
                }
              }
            }, 100);
          }

          try {
            let contenedor = row.CONTENEDORES.CONTENEDOR_ID;
            for (const key in contenedor) {
              setTimeout(() => {
                if (Object.hasOwnProperty.call(contenedor, key)) {
                  const element = contenedor[key];
                  if (element) {
                    console.log(element)
                    let nameSelect = agregarContenedorMuestra('#div-select-contenedores', numberContenedor, 1);

                    $(`select[name="${nameSelect[0]}"]`).val(element.CONTENEDOR_ID)
                    $(`select[name="${nameSelect[1]}"]`).val(element.MUESTRA_ID)
                  }
                }
              }, 100);
            }
          } catch (error) {

          }



          let equipo = row.EQUIPO_ID
          for (const key in equipo) {
            setTimeout(() => {
              if (Object.hasOwnProperty.call(equipo, key)) {
                const element = equipo[key];
                if (element) {
                  let nameSelect = agregarHTMLSelector('#div-select-equipo', 'Equipo', rellenoEquipoSelect)
                  $(`select[name="${nameSelect}"]`).val(element).trigger('change');
                }
              }
            }, 100);
          }


          $(`input[name="muestra_valores"][value="${row.MUESTRA_VALORES_REFERENCIA}"]`).prop('checked', true);
          if (row.VALOR_MINIMO)
            $('#valor_minimo_referencia').val(ifnull(`${row.VALOR_MINIMO}`))
          if (row.VALOR_MAXIMO)
            $('#valor_maximo_referencia').val(ifnull(`${row.VALOR_MAXIMO}`))

          $("#input-dirigido-sexo-referencia option").prop('selected', false)
          $("#input-dirigido-sexo-referencia option").filter(function () {
            //may want to use $.trim in here
            return $(this).text() == row.SEXO_REFERENCIA;
          }).prop('selected', true);

          $('#input-edad-inicial-referencia').val(ifnull(row.EDAD_INICIAL));
          $('#input-edad-final-referencia').val(ifnull(row.EDAD_FINAL));



          // } catch (error) {
          //   alertMensaje('error', 'Oops.', 'Hubo un error en mostrar los valores del servicio', 'NO GUARDE NADA; REPORTA ESTE ERROR');

          // }







          modalEdit = id;
        }
      },
      complete: function () {
        alertToast('Datos recuperados', 'success')
        resolve(1);
      },
      error: function (jqXHR, exception, data) {
        modalEdit = false;
        alertErrorAJAX(jqXHR, exception, data)
      },
    })
  });

}


async function getDataFirst(edit = false, id = false) {
  alertMsj({
    title: 'Obteniendo datos reales...',
    text: 'Espera un momento mientras recuperamos y visualizamos todo correctamente.',
    footer: 'Es probable que tarde : )',
    showCancelButton: false,
    showConfirmButton: false,
    allowOutsideClick: false,
  })
  await rellenarSelect("#registrar-clasificacion-estudio", "laboratorio_clasificacion_api", 2, 0, 1, {}, function (data, o) {
    rellenoClasificacion = o
  });
  // await rellenarSelect("#registrar-metodos-estudio", "laboratorio_metodos_api", 2, 0, 1);
  await rellenarSelect("#registrar-medidas-estudio", "laboratorio_medidas_api", 2, 0, 1, {}, function (data, o) {
    rellenoMedidas = o
  });
  // await rellenarSelect("#registrar-grupo-estudio", "servicios_api", 7, 0, 'DESCRIPCION');
  // await rellenarSelect("#registrar-area-estudio", "areas_api", 2, 0, 2);
  await rellenarSelect('#registrar-concepto-facturacion', 'sat_catalogo_api', 2, 0, 'COMPLETO', {}, function (data, o) {
    $('#registrar-concepto-facturacion').val(32).trigger('change');
    rellenoSatFacturacion = o
  });

  await rellenarSelect('.select-contenedor-Método', 'laboratorio_metodos_api', 2, 'ID_METODO', 'DESCRIPCION', {}, function (data, o) {
    rellenoMetodoSelect = o
  })

  await rellenarSelect('.select-contenedor-Grupo', 'servicios_api', 7, 0, 'DESCRIPCION', { id_area: 6 }, function (data, o) {
    rellenoGrupoSelect = o
  })

  await rellenarSelect('.select-contenedor-equipo', 'laboratorio_equipos_api', 2, 'ID_EQUIPO', 'DESCRIPCION.MODELO.MARCA', {}, function (data, o) {
    rellenoEquipoSelect = o
  })

  await rellenarSelect('#maquila_agregar_estudio', 'laboratorio_maquila_api', 2, 'ID_LABORATORIO', 'DESCRIPCION', {}, function (data, o) {
    rellenoMaquilaSelect = o;
  })

  if (edit)
    await getValueEstudio(id)



  if (!edit) {
    if (modalEdit) {
      $('input[name="descripcion"]').val('');
      $('input[name="abreviatura"]').val('');
      $('input[name="muestra_valores"], input[name="grupos"]').prop('checked', false);
    }
    swal.close(); //Cerrar la ventana de espera
  }
  $("#ModalRegistrarEstudio").modal('show');
}

function setValueSelect() {

}

//Formulario de Preregistro
$("#formRegistrarEstudio").submit(function (event) {
  event.preventDefault();
  /*DATOS Y VALIDACION DEL REGISTRO*/
  var form = document.getElementById("formRegistrarEstudio");
  var formData = new FormData(form);

  if ($('#sin_clasificacion').is(":checked"))
    formData.delete('clasificacion_id')

  if ($('#sin_medida').is(":checked"))
    formData.delete('medida_id')


  if ($('input[type=radio][name=local]').value == 0) {
    formData.delete('maquila_lab_id')
  }

  var textSummer = $('#summernote-estudios').summernote('code');
  console.log(textSummer);

  // var padre = formData.get("grupo");
  // formData.delete("grupo");
  // formData.set("padre", padre);
  // formData.set("grupos", 0);

  if (modalEdit)
    formData.set("id_servicio", array_selected['ID_SERVICIO']);


  formData.set("producto", 1);
  formData.set("area", 6);


  formData.set("seleccionable", 1);
  formData.set("para", 3);
  formData.set("costos", 1);
  // formData.set("utilidad", null);
  // formData.set("venta", null);
  formData.set("api", 1);

  Swal.fire({
    title: "¿Está seguro que todos los datos del estudio están correctos?",
    text: "Verifique la Informacion antes de Continuar!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Aceptar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      // $('#submit-registrarEstudio').prop('disabled', true);
      // Esto va dentro del AJAX
      $.ajax({
        data: formData,
        url: `${http}${servidor}/${appname}/api/laboratorio_servicios_api.php`,
        type: "POST",
        processData: false,
        contentType: false,
        cache: false,
        success: function (data) {
          data = jQuery.parseJSON(data);
          if (mensajeAjax(data)) {
            Toast.fire({
              icon: "success",
              title: "¡Estudio registrado!",
              timer: 2000,
            });

            recargarSelects(formData.get("grupo"));

            try { tablaServicio.ajax.reload(); } catch (error) { }
            try { tablaGrupos.ajax.reload(); } catch (error) { }

            if (modalEdit)
              $('#ModalRegistrarEstudio').close();

            $('input[name="descripcion"]').val('');
            $('input[name="abreviatura"]').val('');
            $('input[name="muestra_valores"], input[name="grupos"]').prop('checked', false);


          }
        },
        error: function (jqXHR, exception, data) {
          alertErrorAJAX(jqXHR, exception, data)
        },
      });
    }
  });
  event.preventDefault();
});






// Nuevo contenedores
$(document).on('click', '#nuevo-contenedor-muestra', function (event) {
  numberContenedor += 1;
  agregarContenedorMuestra('#div-select-contenedores', numberContenedor, 1);
})

// Nuevo grupo
$(document).on('click', '#nuevo-select-grupo', function (event) {
  event.preventDefault();
  agregarHTMLSelectorInput('#div-select-grupo', 'Grupo', rellenoGrupoSelect)
})

// Nuevo metodo
$(document).on('click', '#nuevo-select-metodo', function (event) {
  event.preventDefault();
  agregarHTMLSelector('#div-select-metodo', 'Método', rellenoMetodoSelect)
})

// Nuevo equipo
$(document).on('click', '#nuevo-select-equipo', function (event) {
  event.preventDefault();
  agregarHTMLSelector('#div-select-equipo', 'Equipo', rellenoEquipoSelect)
})

$(document).on('click', '.eliminarContenerMuestra1', function () {
  var parent_element = $(this).closest("div[class='row']");
  // console.log(parent_element)
  // numberContenedor -= 1;
  parent_element.remove();
});



// $('.eliminarContenerMuestra').on('click', function(event){
//   event.stopPropagation();
//   event.stopImmediatePropagation();
//   var parent_element = $(this).closest("div[class='row']");
//   console.log(parent_element)
//   parent_element.remove();
// })







select2("#registrar-clasificacion-estudio", "ModalRegistrarEstudio");

select2("#registrar-medidas-estudio", "ModalRegistrarEstudio");
select2("#registrar-concepto-facturacion", "ModalRegistrarEstudio");

select2("#registrar-contenedor1-estudio", "ModalRegistrarEstudio");
select2("#registrar-muestraCont1-estudio", "ModalRegistrarEstudio");

select2('.select-contenedor-equipo', 'ModalRegistrarEstudio');
select2('.select-contenedor-Método', 'ModalRegistrarEstudio');
select2('.select-contenedor-Grupo', 'ModalRegistrarEstudio');
