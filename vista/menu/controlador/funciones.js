//Formatear Fecha de sql
function formatoFecha(texto) {
  if (texto)
    return texto.replace(/^(\d{4})-(\d{2})-(\d{2})$/g, '$3/$2/$1');

  return '';
}

jQuery.fn.exists = function () { return this.length > 0; }

function formatoFechaSQL(fecha, formato) {
  const map = {
    dd: fecha.getDate(),
    mm: fecha.getMonth() + 1,
    // yy: fecha.getFullYear().toString().slice(-2),
    yy: fecha.getFullYear()
  }

  return formato.replace(/dd|mm|yy|yyy/gi, matched => map[matched]);
}

function formatoFecha2(fecha, optionsDate = [3, 1, 2, 2, 1, 1, 1], formatMat = 'best fit') {
  if (fecha == null)
    return '';
  // let options = {
  //   hourCycle: 'h12', //<-- Formato de 12 horas
  //   timeZone: 'America/Mexico_City'
  // } // p.m. - a.m.

  const options = {
    timeZone: 'America/Mexico_City',
    hourCycle: 'h12',
    weekday: ['narrow', 'short', 'long'][optionsDate[0] - 1],
    year: ['numeric', '2-digit'][optionsDate[1] - 1],
    month: ['narrow', 'short', 'long', 'numeric', '2-digit'][optionsDate[2] - 1],
    day: ['numeric', '2-digit'][optionsDate[3] - 1],
    hour: ['numeric', '2-digit'][optionsDate[4] - 1],
    minute: ['numeric', '2-digit'][optionsDate[5] - 1],
    seconds: ['numeric', '2-digit'][optionsDate[6] - 1]
  };

  let date;
  if (fecha.length == 10) {
    date = new Date(fecha + 'T00:00:00')
  } else {
    date = new Date(fecha)
  }

  // //console.log(date)
  return date.toLocaleDateString('es-MX', options)
}



function calcularEdad(fecha) {
  var hoy = new Date(), cumpleanos = new Date(fecha);
  var edad = hoy.getFullYear() - cumpleanos.getFullYear();
  var m = hoy.getMonth() - cumpleanos.getMonth();

  if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate()))
    edad--;
  return edad;
}

// Revisar sesión
function validarVista(area, reload = true) {
  if (!area.length)
    return si(reload)

  try {
    if (session['vista'][area] == 1) {
      validar = true
      return 1
    } else {
      return si(reload)
    }
  } catch (error) {
    return si(reload)
  }

  function si(reload) {
    if (reload) {
      validar = false
      alertMensajeConfirm({
        title: "¡No tiene permitido estar aqui!",
        text: "No tiene permiso para usar esta area",
        icon: "info",
        confirmButtonColor: "#d33",
        confirmButtonText: "Aceptar",
        allowOutsideClick: false
      }, function () {
        destroySession();
        window.location.replace(http + servidor + "/" + appname + "/vista/login/");
      })
      return false;
    } else {
      return false;
    }
  }
}

//Revisar permisos
function validarPermiso(permiso, reload = false) {
  try {
    if (session['permisos'][permiso] == 1 || session['permisos'][permiso] == '1') {
      //console.log(true)
      return true
    } else {
      //console.log(session['permisos'])
      //console.log(false)
      if (reload)
        window.location.reload()
      return false;
    }
  } catch (error) {
    //console.log(error)
    if (reload)
      window.location.reload()
    return false;
  }
}

//Mensaje para area 
function avisoArea(tip = 0) {
  if (tip == 0) {
    alertMensajeConfirm({
      title: 'Area no disponible',
      message: 'Probablemente no ha seleccionado un area correcta',
      icon: 'info'
    })
  }
}

//Ajax Async (NO FORM DATA SUPPORT)
async function ajaxAwait(dataJson, apiURL,
  config = {
    alertBefore: false
  },
  //Callback
  callbackBefore = function (data) {
    alertMsj({
      title: 'Espera un momento...',
      text: 'Estamos cargando tu solicitud, esto puede demorar un rato',
      icon: 'info',
      showCancelButton: false
    })
  },
  //Callback, antes de devolver la data
  callbackSuccess = function (data) {
    console.log('callback ajaxAwait por defecto')
  }
) {
  return new Promise(function (resolve, reject) {
    //Configura la funcion misma
    config = configAjaxAwait(config)


    $.ajax({
      url: `${http}${servidor}/${appname}/api/${apiURL}.php`,
      data: dataJson,
      dataType: 'json',
      type: 'POST',
      beforeSend: function () {
        config.callbackBefore ? callbackBefore() : 1;
      },
      success: function (data) {
        let row = data;
        try {
          if (config.response) {
            if (mensajeAjax(row)) {
              config.callbackAfter ? callbackSuccess(config.WithoutResponseData ? row.response.data : row) : 1;
              config.returnData ? resolve(config.WithoutResponseData ? row.response.data : row) : resolve(1)
            }
          } else {
            config.callbackAfter ? callbackSuccess(config.WithoutResponseData ? row.response.data : row) : 1;
            config.returnData ? resolve(config.WithoutResponseData ? row.response.data : row) : resolve(1)
          }
        } catch (error) {
          alertMensaje('error', 'Error', 'Datos/Configuración erronea', error);
        }

      },
      error: function (jqXHR, exception, data) {
        alertErrorAJAX(jqXHR, exception, data)
      },
    })
  });
}

//
function configAjaxAwait(config) {
  //valores por defecto de la funcion ajaxAwait y ajaxAwaitFormData
  const defaults = {
    alertBefore: false, //Alerta por defecto, "Estamos cargando la solucitud" <- Solo si la api consume tiempo
    response: true, //Si la api tiene la estructura correcta (response.code)
    callbackBefore: false, //Activa la function antes de enviar datos, before
    callbackAfter: false, //Activa una funcion para tratar datos enviados desde ajax, osea success
    returnData: true, // regresa los datos o confirmado (1)
    WithoutResponseData: false, //Manda los datos directos
    resetForm: false, //Reinicia el formulario en ajaxAwaitFormData
  }

  Object.entries(defaults).forEach(([key, value]) => {
    config[key] = config[key] ?? value;
  });
  return config;
}


//Ajax Async FormData
async function ajaxAwaitFormData(dataJson = { api: 0, }, apiURL, form = 'OnlyForm'  /* <-- Formulario sin # */,
  config = {
    alertBefore: false
  },
  //Callback antes de enviar datos
  callbackBefore = () => {
    alertMsj({
      title: 'Espera un momento...',
      text: 'Estamos cargando tu solicitud, esto puede demorar un rato',
      icon: 'info',
      showCancelButton: false
    })
  },
  //Callback, antes de devolver la data
  callbackSuccess = () => {
    console.log('callback ajaxAwait por defecto')
  }
) {
  // formData.set('api', 10);
  return new Promise(function (resolve, reject) {
    //Configura la funcion misma
    config = configAjaxAwait(config)

    let formID = document.getElementById(form);
    let formData = new FormData(formID);

    for (const key in dataJson) {
      if (Object.hasOwnProperty.call(dataJson, key)) {
        const element = dataJson[key];
        formData.set(`${key}`, element);
      }
    }

    $.ajax({
      url: `${http}${servidor}/${appname}/api/${apiURL}.php`,
      data: formData,
      processData: false,
      contentType: false,
      dataType: 'json',
      type: 'POST',
      beforeSend: function () {
        config.callbackBefore ? callbackBefore() : 1;
      },
      success: function (data) {
        config.resetForm ? formID.reset() : false;
        if (config.response) {
          if (mensajeAjax(data)) {
            config.callbackAfter ? callbackSuccess(config.WithoutResponseData ? data.response.data : data) : 1;
            config.returnData ? resolve(config.WithoutResponseData ? data.response.data : data) : resolve(1)
          }
        } else {
          config.callbackAfter ? callbackSuccess(config.WithoutResponseData ? data.response.data : data) : 1;
          config.returnData ? resolve(config.WithoutResponseData ? data.response.data : data) : resolve(1)
        }

      },
      error: function (jqXHR, exception, data) {
        alertErrorAJAX(jqXHR, exception, data)
      },
    })
  });
}




// Verificar si tiene una sesión activa
function loggin(callback, tipoUrl = 1) {
  if (tipoUrl != 3) {
    $.ajax({
      url: http + servidor + "/" + appname + "/api/usuarios_api.php",
      type: "POST",
      data: {
        api: 8
      },
      dataType: 'json',
      success: function (data) {
        if (mensajeAjax(data)) {
          // //console.log(data);
          if (data['response']['code'] == 1) {
            validar = true
            callback(1)
          } else {
            // alert(tipoUrl);
            switch (tipoUrl) {
              case 1:
                destroySession();
                window.location.replace = http + servidor + '/' + appname + '/vista/login/?page=' + window.location;
                break;
              case 2:
                destroySession();
                window.location.replace = http + servidor + '/' + appname + '/vista/login/';
                break;
              default:
                destroySession();
                window.location.replace = 'https://www.google.com/';
                break;
            }
          }
        }
      },
      error: function (jqXHR, exception, data) {
        alertErrorAJAX(jqXHR, exception, data)
      },
    });
  } else {
    validar = true
    callback(1);
  }
}

function destroySession() {
  $.ajax({
    url: http + servidor + "/" + appname + "/api/login_api.php",
    type: "POST",
    data: {
      api: 2
    }
  });
}


//Obtener numero rando
function getRandomInt(max) {
  return Math.floor(Math.random() * max);
}

function getRandomString() {
  var n = Math.floor(Math.random() * 11);
  var k = Math.floor(Math.random() * 1000000);
  var m = String.fromCharCode(n) + k;
  return m;
}

// Checa si es un numero
function checkNumber(x, transform = 0) {
  // check if the passed value is a number
  if (typeof x == 'number' && !isNaN(x)) {
    // check if it is integer
    if (Number.isInteger(x)) {
      return 1
    } else {
      return 1
    }
  } else {
    if (transform)
      return parseInt(x); //Entero
    return 0
  }
}


function ifnull(data, siNull = '') {
  if (typeof data === 'undefined') return siNull;
  if (data) {
    data = `${data}`.replace(/["]+/g, '&quot');
    data = `${data}`.replace(/["]+/g, '&#44;');


    return data;
  }
  return siNull;
}

function htmlCaracter(data) {

  st = document.getElementById('ent').value;
  st = st.replace(/&/g, "&amp;amp;");
  st = st.replace(/</g, "&amp;lt;");
  st = st.replace(/>/g, "&amp;gt;");
  st = st.replace(/"/g, "&amp;quot;");
  document.getElementById('result').innerHTML = '' + st;
}

function firstMayus(str) {
  str = str.charAt(0).toUpperCase() + str.slice(1);
  return str;
}

function truncate(str, maxlength) {
  return (str.length > maxlength) ?
    str.slice(0, maxlength - 1) + '…' : str;
}

//Especifico para areas dinamicas de un valor
function deletePositionString(str, position) {
  str = str.slice(0, position);
  return str;
}

function deleteSpace(str) {
  return str.replace(/ /g, "");
}


$(window).resize(function () {
  //aqui el codigo que se ejecutara cuando se redimencione la ventana
  // var alto=$(window).height();
  // var ancho=$(window).width();
  // alert("alto: "+alto+" ancho:"+ancho);

  $.fn.dataTable
    .tables({
      visible: true,
      api: true
    })
    .columns.adjust();
})

$(document).on('change click', 'input[type="file"]', function () {
  // //console.log($(this)[0])
  if ($(this)[0].files.length > 1) {
    var filename = `${$(this)[0].files.length} Archivos...`;
  } else {
    var filename = $(this).val().split('\\').pop();
    var extension = $(this).val().split('.').pop();

    var filename = filename.replace(`.${extension}`, '')

  }


  // //console.log(filename);
  var label = $(this).parent('div').find('label[class="input-file-label"]')
  if ($(this).val() == '') {
    label.html(`<i class="bi bi-box-arrow-up"></i> Seleccione un archivo`)
  } else {
    label.html(`File: ${truncate(filename, 15)} | ${extension}`)
  }
})

function resetInputFile() {
  $('input[name="file"]').each(function () {
    $(this).val('')
    var label = $(this).parent('div').find('label[class="input-file-label"]')
    label.html(`<i class="bi bi-box-arrow-up"></i> Seleccione un archivo`)
  });
}

//Devuelve la area
function getAreaActiva() {
  hash = window.location.hash.substring(1);
  switch (hash) {
    case "ULTRASONIDO": return 11;
    case "RX": return 8;
    case "ESPIROMETRIA": return 5;
    case "ELECTROCARDIOGRAMA": return 10;
    case "AUDIOMETRIA": return 4;
    case "OFTALMOLOGIA": return 3;
  }
}

// Omitir paciente actual
function pasarPacienteTurno(id_turno, id_area, liberar = 0, callback) {
  switch (liberar) {
    case 1:
      options = {
        title: "¿Desea liberar el turno?",
        text: "Se le otorgará otro paciente de la lista.",
        icon: "info",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, liberar",
        cancelButtonText: "Cancelar",
        allowOutsideClick: false
      }
      break;
    case 0:
      options = {
        title: "¿Está seguro omitir este paciente?",
        text: "¡Este paciente se mandará al final de la lista!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sí, omitir",
        cancelButtonText: "Cancelar",
        allowOutsideClick: false
      }
      break;
    default:
      break;
  }

  Swal.fire(options).then((result) => {
    if (result.isConfirmed) {
      // $('#submit-registrarEstudio').prop('disabled', true);
      // Esto va dentro del AJAX
      $.ajax({
        data: {
          api: 3,
          id_area: id_area,
          liberar: liberar
        },
        url: "../../../api/turnos_api.php",
        type: "POST",
        success: function (data) {
          data = jQuery.parseJSON(data);
          if (mensajeAjax(data)) {
            Toast.fire({
              icon: "success",
              title: "¡Paciente omitido!",
              timer: 2000,
            });
            callback(data)
          }
        },
        error: function (jqXHR, exception, data) {
          alertErrorAJAX(jqXHR, exception, data)
        },
      });
    }
  });
}

//Obtener paciente actual
function buscarPaciente(id_area, callback = function (data) { }) {
  alertMensajeConfirm({
    title: '¿Desea llamar al siguiente paciente?',
    text: "",
    icon: "info",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
  }, $.ajax({
    data: {
      api: 2,
      id_area: id_area
    },
    url: http + servidor + "/" + appname + "/api/turnero_api.php",
    // url: "../../../api/turneador_api.php",
    type: "POST",
    success: function (data) {
      data = jQuery.parseJSON(data);
      callback(data);
    },
    error: function (jqXHR, exception, data) {
      alertErrorAJAX(jqXHR, exception, data)
    },
  }), 1)
}


//Control de turnos 
function omitirPaciente(areaFisica) {
  alertMensajeConfirm({
    title: '¿Deseas omitir tu paciente actual?',
    text: "El paciente actual volverá a la lista de espera.",
    icon: "info",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
  }, function () {
    $.ajax({
      url: `${http}${servidor}/${appname}/api/turnero_api.php`,
      type: 'POST',
      dataType: 'json',
      data: { api: 3, area_fisica_id: areaFisica },
      success: function (data) {
        if (mensajeAjax(data)) {
          let row = data.response.data;
          // miStorage.setItem('paciente_actual_turno', row['NEXT']['turno_id'])
          // miStorage.setItem('paciente_actual_nombre', row['NEXT']['paciente'])
          pacienteTurnoActivo.selectID = row['NEXT']['ID_TURNO'];
          pacienteTurnoActivo.setguardado(row['NEXT']['PACIENTE']);
          $('#paciente_turno').html(row['NEXT']['paciente'])
          alertMsj({
            title: row['NEXT']['paciente'],
            text: `Es su siguiente paciente, acabas de omitir al paciente ${row['OMITTED']['paciente']}`,
            footer: 'Los pacientes omitidos serán saltados al final de la fila',
            icon: 'success',
            timer: 5000,
            showCancelButton: false,
            timerProgressBar: true,
          })

        }
      },
      error: function (jqXHR, exception, data) {
        alertErrorAJAX(jqXHR, exception, data)
      },
    })
  }, 1)
}

function llamarPaciente(areaFisica) {
  //console.log(areaFisica)
  alertMensajeConfirm({
    title: '¿Deseas liberar el área y llamar a un paciente?',
    text: "Un paciente llamado se mostrará en pantalla",
    icon: "info",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
  }, function () {
    $.ajax({
      url: http + servidor + "/" + appname + "/api/turnero_api.php",
      type: 'POST',
      dataType: 'json',
      data: { api: 2, area_fisica_id: areaFisica },
      success: function (data) {
        if (mensajeAjax(data)) {
          let row = data.response.data[0];
          // miStorage.setItem('paciente_actual_turno', row['ID_TURNO'])
          // miStorage.setItem('paciente_actual_nombre', row['PACIENTE'])
          pacienteTurnoActivo.selectID = row['ID_TURNO'];
          pacienteTurnoActivo.setguardado(row['PACIENTE']);
          $('#paciente_turno').html(row['PACIENTE'])
          alertMsj({
            title: row['PACIENTE'],
            text: 'Es su siguiente paciente',
            icon: 'success',
            timer: 5000,
            showCancelButton: false,
            timerProgressBar: true,
          })
        }
      },
      error: function (jqXHR, exception, data) {
        alertErrorAJAX(jqXHR, exception, data)
      },
    })
  }, 1)
}

function liberarPaciente(areaFisica, turno) {
  alertMensajeConfirm({
    title: '¿Deseas liberar el turno de este paciente?',
    text: "El paciente volverá a la lista de espera.",
    icon: "info",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
  }, function () {
    $.ajax({
      url: http + servidor + "/" + appname + "/api/turnero_api.php",
      type: 'POST',
      dataType: 'json',
      data: { api: 1, area_fisica_id: areaFisica, turno_id: turno },
      success: function (data) {
        if (mensajeAjax(data)) {
          if (data.response.data == 1) {
            // miStorage.removeItem('paciente_actual_turno')
            // miStorage.removeItem('paciente_actual_nombre')
            pacienteTurnoActivo.selectID = null;
            pacienteTurnoActivo.setguardado(null);
            $('#paciente_turno').html('Liberado')
            alertMsj({
              title: "¡Paciente liberado!",
              text: "Ya puedes llamar a un nuevo paciente al área : )",
              icon: "success",
              showCancelButton: false,
              timer: 8000,
              timerProgressBar: true,
            })
          }
        }
      },
      error: function (jqXHR, exception, data) {
        alertErrorAJAX(jqXHR, exception, data)
      },
    })
  }, 1)
}

function pasarPaciente() {
  alertMensajeConfirm({
    title: '¿Deseas enviar un paciente a otra área disponible?',
    text: "No podrás revertir esta acción.",
    icon: "info",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
  }, function () {
    $.ajax({
      url: `${http}${servidor}/${appname}/api/turnero_api.php`,
      type: 'POST',
      dataType: 'json',
      data: { api: 7 },
      success: function (data) {
        if (mensajeAjax(data)) {
          let row = data.response.data;
          // miStorage.setItem('paciente_actual_turno', row['ID_TURNO'])
          // miStorage.setItem('paciente_actual_nombre', row['PACIENTE'])
          pacienteTurnoActivo.selectID = row['ID_TURNO'];
          pacienteTurnoActivo.setguardado(row['PACIENTE']);
          // $('#paciente_turno').html(row['PACIENTE'])
          alertMsj({
            text: `Es el siguiente paciente en el área de ${row['AREA_FISICA']}.`,
            title: row['PACIENTE'],
            icon: 'success',
            timer: 5000,
            showCancelButton: false,
            timerProgressBar: true,
          })
        }
      },
      error: function (jqXHR, exception, data) {
        alertErrorAJAX(jqXHR, exception, data)
      },
    })
  }, 1)
}




// Validar la vista (OBSOLETOXD)
function redireccionarVista(vista, callback) {
  if (session.vista[vista] == 1 ? true : false) {
    callback();
  } else {
    window.location.href = http + servidor + '/' + appname + '/vista/login/';
  }
}



function DownloadFromUrl(fileURL, fileName) {
  var link = document.createElement('a');
  link.href = fileURL;
  link.download = fileName;
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}

//Para el campo de preregistro
function deshabilitarVacunaExtra(vacuna, div) {
  if (vacuna != "OTRA") {
    $("#" + div).fadeOut(400);
  } else {
    $("#" + div).fadeIn(400);
  }
}

function desactivarCampo(div, fade) {
  if (fade == 1) {
    $(div).fadeIn(400);
  } else {
    $(div + ": input").val("");
    $(div).fadeOut(400);
  }
}

// Notifiación  movil
if (window.innerWidth <= 768) {
  position = 'top';
} else {
  position = 'top';
  // position = 'top-start';
}

const Toast = Swal.mixin({
  toast: true,
  position: position,
  showConfirmButton: false,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
});

function isJson(str) {

  // //console.log(typeof str)

  if (typeof str === 'object') {
    return true;
  } else {
    return false;
  }
  // return false;
  // try {
  //   JSON.parse(str);
  // } catch (e) {
  //   return false;
  // }
  // return true;
}


// Obtener segmentos por procedencia en select
function getSegmentoByProcedencia(id, select) {
  return new Promise(resolve => {
    $('#' + select).find('option').remove().end()
    $.ajax({
      url: http + servidor + "/" + appname + "/api/segmentos_api.php",
      type: "POST",
      data: {
        id: id,
        api: 6
      },
      success: function (data) {
        var data = jQuery.parseJSON(data);
        if (mensajeAjax(data)) {
          if (data['response']['data'].length > 0) {
            for (var i = 0; i < data['response']['data'].length; i++) {
              var o = new Option("option text", data['response']['data'][i]['id']);
              $(o).html(data['response']['data'][i]['segmento']);
              $('#' + select).append(o);
            }
          } else {
            var o = new Option("option text", null);
            $(o).html('No contiene segmentos');
            $('#' + select).append(o);
          }
        }
      },
      complete: function () {
        resolve(1);
      },
      error: function (jqXHR, exception, data) {
        alertErrorAJAX(jqXHR, exception, data)
      },
    });
  });
}

function setSegmentoOption(select, idProcedencia, idSegmento) {
  var select = document.getElementById(select),
    length = select.options.length;
  while (length--) {
    select.remove(length);
  }
  $.ajax({
    url: http + servidor + "/" + appname + "/api/segmentos_api.php",
    type: "POST",
    data: {
      id: idProcedencia,
      api: 6
    },
    success: function (data) {
      var data = jQuery.parseJSON(data);
      if (mensajeAjax(data)) {
        if (data['response']['data'].length > 0) {
          for (var i = 0; i < data['response']['data'].length; i++) {
            var content = data['response']['data'][i]['segmento'];
            var value = data['response']['data'][i]['id'];
            var el = document.createElement("option");
            el.textContent = content;
            el.value = value;
            if (value == idSegmento) {
              el.selected = true;
            }
            select.appendChild(el);
          }
        } else {
          var content = "No contiene segmentos";
          var value = "";
          var el = document.createElement("option");
          el.textContent = content;
          el.value = value;

          select.appendChild(el);
        }
      }
    },
    error: function (jqXHR, exception, data) {
      alertErrorAJAX(jqXHR, exception, data)
    },
  });

  return true;
}


// Obtener procedencias en select
function getProcedencias(select) {
  return new Promise(resolve => {
    $('#' + select).find('option').remove().end()
    $.ajax({
      url: http + servidor + "/" + appname + "/api/clientes_api.php",
      type: "POST",
      data: {
        api: 2
      },
      dataType: "json",
      success: function (data) {
        if (mensajeAjax(data)) {
          for (var i = 0; i < data['response']['data'].length; i++) {
            var o = new Option("option text", data['response']['data'][i]['ID_CLIENTE']);
            $(o).html(data['response']['data'][i]['NOMBRE_COMERCIAL']);
            $('#' + select).append(o);
          }
        }
      },
      complete: function () {
        resolve(1);
      },
      error: function (jqXHR, exception, data) {
        alertErrorAJAX(jqXHR, exception, data)
      },
    })
  });
}


function setProcedenciaOption(select, idProcedencia) {
  var select = document.getElementById(select),
    length = select.options.length;
  while (length--) {
    select.remove(length);
  }
  $.ajax({
    url: http + servidor + "/" + appname + "/api/clientes_api.php",
    type: "POST",
    data: {
      api: 2
    },
    dataType: "json",
    success: function (data) {
      if (mensajeAjax(data)) {
        for (var i = 0; i < data['response']['data'].length; i++) {
          var content = data['response']['data'][i]['NOMBRE_COMERCIAL'];
          var value = data['response']['data'][i]['ID_CLIENTE'];
          var el = document.createElement("option");
          el.textContent = content;
          el.value = value;
          if (value == idProcedencia) {
            el.selected = true;
          }
          select.appendChild(el);

        }
      }
    },
    error: function (jqXHR, exception, data) {
      alertErrorAJAX(jqXHR, exception, data)
    },
  });
  return true;
}

// Obtener cargo y tipos de usuarios
function rellenarSelect(select = false, api, apinum, v, c, values = {}, callback = function (array) { }) {
  return new Promise(resolve => {
    values.api = apinum;

    let htmlContent;
    // Crear arreglo de contenido
    if (!Number.isInteger(c)) {
      htmlContent = c.split('.');
    }

    $(select).find('option').remove().end()
    $.ajax({
      url: http + servidor + "/" + appname + "/api/" + api + ".php",
      data: values,
      type: "POST",
      // dataType: "json",
      success: function (data) {

        if (typeof data == "string" && data.indexOf('response') > -1) {
          data = JSON.parse(data);
          // if (!mensajeAjax(data))
          //   return false;
          data = data['response']['data'];
          // data = data['data'];
        } else {
          data = JSON.parse(data);
        }

        let selectHTML = '';
        for (const key in data) {
          if (Object.hasOwnProperty.call(data, key)) {
            const element = data[key];
            // Crear el contenido del select por numero o arreglo
            if (Array.isArray(htmlContent)) {
              datao = "";
              for (var a = 0; a < htmlContent.length; a++) {
                if (element[htmlContent[a]] != null) {
                  if (datao == '') {

                    datao += element[htmlContent[a]];
                  } else {
                    datao += " - " + element[htmlContent[a]];
                  }
                }
                // //console.log(datao)

              }
            } else {
              datao = element[c];
            }
            // Rellenar select con Jquery
            var o = new Option("option text", element[v]);
            $(o).html(datao);
            selectHTML += $(o)[0].outerHTML
            if (select) {
              $(select).append(o);
            }
          }
        }

        // //console.log(data);
        callback(data, selectHTML);

      },
      complete: function (data) {
        resolve(1);
      },
      error: function (jqXHR, exception, data) {
        alertErrorAJAX(jqXHR, exception, data)
      },
    })
  });
}

function setSelectContent(array, select, v, c, reset = 1, selected) {
  //console.log(array);
  if (reset) $(select).find('option').remove().end()
  for (const key in array) {
    if (Object.hasOwnProperty.call(array, key)) {
      const element = array[key];
      //console.log(element)
      var o = new Option("option text", element[v]);
      $(o).html(element[c]);
      $(select).append(o);
    }
  }
}


function optionElement(select, value, content) {
  var o = new Option("option text", value);
  $(o).html(content);
  $(select).append(o);
  el.setAttribute('selected', 'selected');
}


$(window).on('hashchange', function (e) {
  var hash = window.location.hash.substring(1);
  switch (hash) {
    case 'LogOut':
      // window.location.hash = '';
      window.location.href = http + servidor + '/' + appname + '/vista/login/';
      break;
    default:
      break;
  }
});

function getParameterByName(name) {
  name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
  var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
  return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}


function loader(fade, scroll = null) {
  if (fade == 'Out') {
    $("#loader").fadeOut(100);
    $('body').removeClass('overflow-hidden');
    // let alturanav = $('nav [class="navbar navbar-expand-lg border-3 border-bottom border-dark bg-navbar"]').height()
    // //console.log(alturanav)
    // $("html, body").animate({ scrollTop: alturanav + "px" });
    // alert("salir");
  } else if (fade == 'In') {
    $("html, body").animate({ scrollTop: "0px" });
    $("#loader").fadeIn(100);
    $('body').addClass('overflow-hidden')
    // alert("entrar");
  }
  if (scroll == 'bottom') {
    let altura = $(document).height();
    $("html, body").animate({ scrollTop: altura + "px" });
  }

}

function loaderDiv(fade, div = null, loader, loaderDiv1 = null, seconds = 50, scroll = 0) {
  switch (fade) {
    case "Out":
      if (div != null) {
        $(div).fadeIn(seconds);
      }

      if (loaderDiv1 != null) {
        $(loaderDiv1).fadeOut(seconds);
      }
      $(loader).fadeOut(seconds);
      // alert("salir");
      break;

    case "In":
      if (div != null) {
        $(div).fadeOut(seconds);
      }
      if (loaderDiv1 != null) {
        $(loaderDiv1).fadeIn(seconds);
      }
      $(loader).fadeIn(seconds);
      // alert("entrar");
      break;

    default:
    // //console.log('LoaderDiv se perdió...')
  }
  // if (scroll == 'bottom') {
  //   let altura = $(document).height();
  //   $("html, body").animate({ scrollTop: altura + "px" });
  // }
}

//Poder ajustar responsivamente una ventana en windows
function autoHeightDiv(div, resta, tipe = 'px') {
  var ventana_alto = $(window).height();
  ventana_alto_porcentaje = Math.floor(ventana_alto * resta) / 100;

  if (div == 0) {
    if (tipe == 'px')
      return (ventana_alto - resta);
    if (tipe == '%')
      return (ventana_alto_porcentaje);
  } else {
    if (tipe == 'px')
      $(div).height(ventana_alto - resta);
    if (tipe == '%')
      $(div).height(ventana_alto_porcentaje);
    return 0;
  }
}

// Mismas funciones, diferentes nombres por no querer cambiar el nombre donde lo llaman xd
function alertSelectTable(msj = 'No ha seleccionado ningún registro', icon = 'error', timer = 2000) {
  Toast.fire({
    icon: icon,
    title: msj,
    timer: timer,
    // width: 'auto'
  });
}

function alertToast(msj = 'No ha seleccionado ningún registro', icon = 'error', timer = 3000) {
  Toast.fire({
    icon: icon,
    title: msj,
    timer: timer,
    // width: 'auto'
  });
}
// 


function alertMensaje(icon = 'success', title = '¡Completado!', text = 'Datos completados', footer = null, html = null, timer = null) {
  Swal.fire({
    icon: icon,
    title: title,
    text: text,
    html: html,
    footer: footer,
    timer: timer
    // width: 'auto',
  })
}

function alertMsj(options, callback = function () { }) {

  if (!options.hasOwnProperty('title'))
    options['title'] = "¿Desea realizar esta acción?"

  if (!options.hasOwnProperty('text'))
    options['text'] = "Probablemente no podrá revertirlo"

  if (!options.hasOwnProperty('icon'))
    options['icon'] = 'warning'

  if (!options.hasOwnProperty('showCancelButton'))
    options['showCancelButton'] = true

  if (!options.hasOwnProperty('confirmButtonColor'))
    options['confirmButtonColor'] = '#3085d6'

  if (!options.hasOwnProperty('cancelButtonColor'))
    options['cancelButtonColor'] = '#d33'

  if (!options.hasOwnProperty('confirmButtonText'))
    options['confirmButtonText'] = 'Aceptar'

  if (!options.hasOwnProperty('cancelButtonText'))
    options['cancelButtonText'] = 'Cancelar'

  if (!options.hasOwnProperty('allowOutsideClick'))
    options['allowOutsideClick'] = false
  // if (!options.hasOwnProperty('timer'))
  //   options['timer'] = 4000
  // if (!options.hasOwnProperty('timerProgressBar'))
  //   options['timerProgressBar'] = true
  //
  Swal.fire(options).then((result) => {
    callback(result);
  })
}

function alertMensajeConfirm(options, callback = function () { }, set = 0, callbackDenied = function () { }) {

  //Options si existe
  switch (set) {
    case 1:
      if (!options.hasOwnProperty('title'))
        options['title'] = "¿Desea realizar esta acción?"

      if (!options.hasOwnProperty('text'))
        options['text'] = "Probablemente no podrá revertirlo"

      if (!options.hasOwnProperty('icon'))
        options['icon'] = 'warning'

      if (!options.hasOwnProperty('showCancelButton'))
        options['showCancelButton'] = true

      if (!options.hasOwnProperty('confirmButtonColor'))
        options['confirmButtonColor'] = '#3085d6'

      if (!options.hasOwnProperty('cancelButtonColor'))
        options['cancelButtonColor'] = '#d33'

      if (!options.hasOwnProperty('confirmButtonText'))
        options['confirmButtonText'] = 'Aceptar'

      if (!options.hasOwnProperty('cancelButtonText'))
        options['cancelButtonText'] = 'Cancelar'

      if (!options.hasOwnProperty('allowOutsideClick'))
        options['allowOutsideClick'] = false
      // if (options.hasOwnProperty('timer'))
      //   options['timer'] = 4000
      // if (options.hasOwnProperty('timerProgressBar'))
      //   options['timerProgressBar'] = true
      //
      break;
    default:
      if (!options) {
        options = {
          title: "¿Desea realizar esta acción?",
          text: "Probablemente no podrá revertirlo",
          icon: "info",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Aceptar",
          cancelButtonText: "Cancelar",
          // allowOutsideClick: false
          // timer: 4000,
          // timerProgressBar: true,
        }
      }
      break;
  }


  Swal.fire(options).then((result) => {
    if (result.isConfirmed || result.dismiss === "timer") {
      callback()
    } else if (result.isDenied) {
      callbackDenied();
    }
  })
}

//Valida la  contraseña del usuario para ejecutar algunas acciones
function alertPassConfirm(alert = {
  title: 'Titulo por defecto :)',
  icon: 'info'
}, callback = () => { }) {
  Swal.fire({
    title: alert['title'],
    // text: 'Se creará el grupo con los pacientes seleccionados, ¡No podrás revertir los cambios',
    icon: alert['icon'],
    showCancelButton: true,
    confirmButtonText: 'Confirmar',
    cancelButtonText: 'Cancelar',
    showLoaderOnConfirm: true,
    // inputAttributes: {
    //   autocomplete: false
    // },
    // input: 'password',
    html: '<form autocomplete="off" onsubmit="formpassword(); return false;"><input type="password" id="password-confirmar" class="form-control input-color" autocomplete="off" placeholder="Ingrese su contraseña para confirmar"></form>',
    // confirmButtonText: 'Sign in',
    focusConfirm: false,
    didOpen: () => {
      const passwordField = document.getElementById('password-confirmar');
      passwordField.setAttribute('autocomplete', 'new-password');
    },
    preConfirm: () => {
      const password = Swal.getPopup().querySelector('#password-confirmar').value;
      return fetch(`${http}${servidor}/${appname}/api/usuarios_api.php?api=9&password=${password}`)
        .then(response => {
          if (!response.ok) {
            throw new Error(response.statusText)
          }
          return response.json()
        })
        .catch(error => {
          Swal.showValidationMessage(
            `Request failed: ${error}`
          )
        });
    },
    allowOutsideClick: () => !Swal.isLoading()
  }).then((result) => {
    if (result.isConfirmed) {
      if (result.value.status == 1) {
        callback();
      } else {
        alertSelectTable('¡Contraseña incorrecta!', 'error')
      }
    }


  })
}


function mensajeAjax(data, modulo = null) {
  if (modulo != null) {
    text = ' No pudimos cargar'
  }

  try {
    switch (data['response']['code']) {
      case 1:
        return 1;
        break;
      case 2:
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: '¡Ha ocurrido un error!',
          footer: 'Codigo: ' + data['response']['msj']
        })
        break;
      case "repetido":
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: '¡Usted ya está registrado!',
          footer: 'Utilice su CURP para registrarse en una nueva prueba'
        })
        break;
      case "login":
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Codigo: ' + data['response']['msj']
        })
        break;
      case "Token": case "Usernovalid":
        alertMensajeConfirm({
          title: "¡Sesión no valida!",
          text: "El token de su sesión ha caducado, vuelva iniciar sesión",
          footer: "Redireccionando pantalla...",
          icon: "info",
          confirmButtonColor: "#d33",
          confirmButtonText: "Aceptar",
          cancelButtonText: false,
          allowOutsideClick: false,
          timer: 4000,
          timerProgressBar: true,
        }, function () {
          destroySession();
          window.location.replace(http + servidor + "/" + appname + "/vista/login/");
        })

        break;
      case "turnero":
        alertMensajeConfirm({
          title: "Oops",
          text: `${data['response']['msj']}`,
          footer: "Tal vez deberias intentarlo nuevamente",
          icon: "warning",
        })

        break;
      default:
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Hubo un problema!',
          footer: 'No sabemos que pasó, reporta este problema...'
        })
    }
  } catch (error) {
    alertMensaje('warning', 'Error:', 'No se puedo resolver un conflicto interno con validación, si el problema persiste reporte al encargado de area de esto.', '[Error: api no valida, "response: {code: XXXX}", no existe]')
    return 0
  }
  return 0;
}

function alertErrorAJAX(jqXHR, exception, data) {
  var msg = '';
  //Status AJAX
  switch (jqXHR.status) {
    case 0: alertToast('Sin conexión a internet', 'warning'); return 0;
    case 404: //console.log('Requested page not found. [404]'); return 0;
    case 500: alertToast('Internal Server Error', 'info'); return 0;
  }

  switch (exception) {
    case 'parsererror': alertMensaje('info', 'Error del servidor', 'Algo ha pasado, estamos trabajando para resolverlo', 'Mensaje de error: ' + data); return 0
    case 'timeout': //console.log('timeout'); return 0
    case 'abort': return 0
  }

  //console.log(jqXHR.responseText);

}

// $(document).on('click', '#btn-beneficiarios-ujat', function (e) {
//   if (session['permiso']['ExcelInfoBeneUjat']) {
//     $.post("", {
//       tipModalDocumento: 'ExcelInfoBeneUjat'
//     }, function (html) {
//       $("#header-js").html(html);
//     });
//   }
// })




let touchtimeFunction
function detectDobleclick() {
  if (touchtimeFunction == 0) {
    // set first click
    touchtimeFunction = new Date().getTime();
    return false;
  } else {
    // compare first click to this click and see if they occurred within double click threshold
    if (((new Date().getTime()) - touchtimeFunction) < 800) {
      // double click occurred
      touchtimeFunction = 0;
      return true;
    } else {
      // not a double click so set as a new first click
      touchtimeFunction = new Date().getTime();
      return false;
    }
  }
}


//FUNCTION OBSOLETA PARA MOBILE
//Control de tablas
function dblclickDatatable(tablename, datatable, callback = function () { }) {
  // Seleccion del registro
  $(tablename).on('dblclick', 'tr', function () {
    callback(datatable.row(this).data())
  });
}
//

//Solo doble click
var dobleClickSelecTable = false; //Ultimo select ()
function selectDatatabledblclick(callback = function () { }, tablename, datatable, disabledDblclick = false) {
  //console.log(tablename)
  if (!disabledDblclick)
    dobleClickSelecTable = false
  $(tablename).on('click', 'tr', function () {
    if (!detectDobleclick())
      return false;
    //Funcion
    if (dobleClickSelecTable != datatable.row(this).data()) {
      //console.log($(this).hasClass('selected'))
      if ($(this).hasClass('selected') == true) {
        dobleClickSelecTable = false
        datatable.$('tr.selected').removeClass('selected');
        // array_selected = datatable.row(this).data()

        return callback(0, null);
      }
    }
    if (disabledDblclick == false)
      dobleClickSelecTable = datatable.row(this).data()
    datatable.$('tr.selected').removeClass('selected');
    $(this).addClass('selected');
    array_selected = datatable.row(this).data()
    return callback(1, array_selected)

  });
}
$.fn.dataTable.ext.errMode = 'throw';
//Doble y de solo un click
var dobleClickSelecTable = false; //Ultimo select ()
function selectDatatable(tablename, datatable, panel, api = {}, tipPanel = {}, idPanel = {
  0: "#panel-informacion"
}, callback = null, callbackDoubleclick = function (data) {
  console.log('hAzZ dAdo dobBlE cLIk aLa TabBlLa')
}) {
  //Se deben enviar las ultimas 3 variables en arreglo y deben coincidir en longitud
  // //console.log(typeof tipPanel);
  if (typeof tipPanel == "string") {
    // Convierte String a Object
    api = {
      0: api
    };
    tipPanel = {
      0: tipPanel
    };
  } else {
    // Coloca por defecto la ID de panel si no existe ID de envio
    if (idPanel[0] == null) {
      idPanel[0] = "#panel-informacion";
    }
  }
  if (typeof tablename === 'string') {
    tablename = '#' + tablename;
  }
  // //console.log(tablename)
  // //console.log(idPanel)
  $(tablename).on('click', 'tr', function () {

    //Doble Click
    if (detectDobleclick()) {
      if (dobleClickSelecTable == datatable.row(this).data()) {
        callbackDoubleclick(datatable.row(this).data())
      }
    }

    //Solo un click
    if (dobleClickSelecTable != datatable.row(this).data()) {
      if ($(this).hasClass('selected')) {
        dobleClickSelecTable = false
        $(this).removeClass('selected');
        for (var i = 0; i < Object.keys(tipPanel).length; i++) {
          obtenerPanelInformacion(0, api, tipPanel[i], idPanel[i])
        }
        if (callback != null) {
          return callback(0, null);
        }
      } else {
        dobleClickSelecTable = datatable.row(this).data();
        datatable.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        array_selected = datatable.row(this).data();
        if (array_selected != null) {
          if (panel) {
            // Lee los 3 objetos para llamar a la funcion
            for (var i = 0; i < Object.keys(tipPanel).length; i++) {
              obtenerPanelInformacion(array_selected['ID_TURNO'], api[i], tipPanel[i], idPanel[i])
            }
          }
          if (callback != null) {
            // alert('select')
            // //console.log(array_selected)
            return callback(1, array_selected); // Primer parametro es seleccion y segundo el arreglo del select del registro
          }
        } else {
          for (var i = 0; i < Object.keys(tipPanel).length; i++) {
            obtenerPanelInformacion(0, api, tipPanel[i], idPanel[i])
          }
          if (callback != null) {
            return callback(0, array_selected);
          }
        }

      }
    } else {
      // //console.log(false)
    }
  })
}

function inputBusquedaTable(
  tablename, //<-- Sin #
  datatable, //<-- TablaObjeto
  tooltip = [
    {
      msj: 'Hola, soy un tooltip por defecto :)',
      place: 'bottom'
    },
    {
      msj: 'Aqui puedo ocultar mensajes para ayudarte',
      place: 'right'
    }
  ], //<- tooltips
  tooltipinput =
    {
      msj: 'Filtra la lista por coincidencias',
      place: 'top'
    },
  classInput = 'col-sm-12 col-md-6',
  classList = 'col-sm-12 col-md-6',
) {

  htmlTooltip = '';
  for (const key in tooltip) {
    if (Object.hasOwnProperty.call(tooltip, key)) {
      const element = tooltip[key];
      htmlTooltip += '<span class="input-span" id="addon-wrapping" data-bs-toggle="tooltip" data-bs-placement="' + element['place'] + '"' +
        'title="' + element['msj'] + '" style="margin-bottom: 0px !important">' +
        '<i class="bi bi-info-circle"></i>' +
        '</span>';
    }
  }

  if (!$(`#${tablename}_filter`).exists()) {
    setTimeout(() => {
      inputBusquedaTable(tablename, datatable, tooltip, tooltipinput, classInput, classList)
    }, 200);
    return false;
  }

  $(`#${tablename}_filter`).parent('div').removeAttr('class');
  $(`#${tablename}_filter`).parent('div').attr('class', classInput);

  // let divList = padre.find('div')[0];
  // divList.removeClass('col-sm-12 col-md-6');
  // divList.addClass(classList)

  tooltipinput['msj'] = tooltipinput['msj'] ? tooltipinput['msj'] : 'Filtra la lista por coincidencias';
  tooltipinput['place'] = tooltipinput['place'] ? tooltipinput['place'] : 'top';

  $(`#${tablename}_filter`).html(
    '<div class="text-center mt-2" style="padding-right: 5%">' +
    '<div class="input-group flex-nowrap">' +
    htmlTooltip +
    '<input type="search" class="input-form form-control" aria-controls="' + tablename + '" style="display: unset !important; margin-left: 0px !important;margin-bottom: 0px !important"' +
    'name="inputBuscarTableListaNuevos" placeholder="Filtrar coincidencias" id="' + tablename + 'BuscarTablaLista"' +
    'data-bs-toggle="tooltip" data-bs-placement="' + tooltipinput['place'] + '" title="' + tooltipinput['msj'] + '">' +
    '</div></div>'
  )

  //Zoom table
  $(`#${tablename}_wrapper`).children('div [class="row"]').eq(1).css('zoom', '90%')

  //Diseño de registros
  $(`#${tablename}_wrapper`).children('div [class="row"]').eq(0).addClass('d-flex align-items-end')

  $('#' + tablename + 'BuscarTablaLista').on('keyup change click focus mouseenter mouseleave', function () {
    datatable.search($(this).val()).draw();
  });



  $('select[name="' + tablename + '_length"]').removeClass('form-select form-select-sm');
  $('select[name="' + tablename + '_length"]').addClass('select-form input-form');
  $('select[name="' + tablename + '_length"]').css('margin-bottom', '0px')

}
//



// Configuraciones por defecto para select table
function configSelectTable(config) {
  //valores por defecto de la funcion ajaxAwait y ajaxAwaitFormData
  const defaults = {
    dblClick: false, // Aceptar doble click
    unSelect: false, // Deseleccionar un registro
    anotherClass: 'other-for-table', //Cuando sea seleccionado, se agrega la clase, sino se quita
    ignoreClass: '',
    tabs: [
      {
        title: 'Pacientes',
        element: '#tab-paciente',
        class: 'active',
      },
      {
        title: 'Información',
        element: '#tab-informacion',
        class: 'disabled tab-select'
      },
      {
        title: 'Reporte',
        element: '#tab-reporte',
        class: 'disabled tab-select'
      },
    ],
    "tab-id": '#tab-button',
    "tab-default": 'Reporte',  //Por default, al dar click, abre aqui
    reload: false, //Activa la rueda
    movil: false, //Activa la version movil
    multipleSelect: false,
    OnlyData: false,
    noColumns: false
  }

  Object.entries(defaults).forEach(([key, value]) => {
    config[key] = config[key] ?? value;
  });
  return config;
}
//Detecta la dimension del dispositivo para saber si es movil o escritorio
function isMovil(callback = (response) => { }) {
  let width = window.innerWidth;
  let height = window.innerHeight;

  if ((width <= 768 && height <= 1366) || (height <= 1366 && width <= 1366)) {
    callback(true);
    return true;
  } else {
    return false;
  }
}

//Visualiza los botones de navegacion
function selecTableTabs() {
  isMovil() ? $('.tab-page-table').fadeIn(0) : $('.tab-page-table').fadeOut(0);;
}

// Para la version movil crea y visualiza columnas
function getBtnTabs(config) {
  if (config.tabs) {
    console.log(config.tabs)
    let row = config.tabs;
    let html = `<ul class="nav nav-tabs mt-2 tab-page-table" style="display:none">`;
    for (const key in row) {
      if (Object.hasOwnProperty.call(row, key)) {
        const element = row[key];

        html += `<li class="nav-item">
                    <a class="nav-link ${element.class ? element.class : ''} tab-table" data-id-column="${element['element']}" id="tab-btn-${element.title}" style="cursor: pointer">${element.title}</a>
                  </li>`;
      }
    }
    html += `</ul>`
    $(config['tab-id']).html(html)

    return true;
  }
}

//Visualiza la columna solo en movil
let dinamicTabFunction = false
function dinamicTabs(loader) {
  dinamicTabFunction = false;
  isMovil(() => {
    dinamicTabFunction = () => {
      console.log('IS MOVIL')
      $(document).on('click', '.tab-table', function () {
        let btn = $(this);
        if (!btn.hasClass('active')) {
          $('.tab-first').fadeOut(100);
          $('.tab-second').fadeOut(0);

          $('.tab-table').removeClass('active');
          btn.addClass('active');

          setTimeout(() => {
            let id = btn.attr('data-id-column');
            console.log(id);
            let loaderVisible = function () {
              if ($(loader).is(":hidden")) {
                $(`${id}`).fadeIn(100);
                loaderVisible = false;
              } else {
                setTimeout(() => {
                  loaderVisible(id);
                }, 150);
              }
            }
            loaderVisible()
          }, 100);
        }

      })
    }

    dinamicTabFunction();
  })

  try {
    $.fn.dataTable
      .tables({
        visible: true,
        api: true
      })
      .columns.adjust();
  } catch (error) {

  }

}

//Agrega el circulo para cargar el panel
function setReloadSelecTable(name, param) {
  let html = `<div class="col-12 col-xl-9 d-flex justify-content-center align-items-center" id='loaderDiv-${name}' style="max-height: 75vh; display:none">
    <div class="preloader" id="loader-${name}"></div>
  </div>`;

  $('#reload-selectable').addClass(`col-12 ${param[0]} d-flex justify-content-center align-items-center`)
  $('#reload-selectable').css('max-height', '75vh')
  $('#reload-selectable').attr("style", "display: none !important");
  $('#reload-selectable').html(`<div class="preloader" id="loader-${name}"></div>`)
  $('#reload-selectable').addClass('loader-tab')

  // $('#reload-selectable').fadeOut('slow');
  $('#reload-selectable').attr('id', `loaderDiv-${name}`)
}

function reloadSelectTable() {
  if (isMovil()) {
    //Manda al principio
    try {
      $(`.tab-table`)[0].click();
    } catch (error) {
      console.log('BTN class: tab-table not found')
    }
    $('.loader-tab').fadeOut(0)
  } else {
    $('.tab-second').fadeOut();
    $('.tab-first').fadeIn();
    $('.loader-tab').fadeOut(0)
  }

}

//selectDataTableMovilEdition
let dataDobleSelect, selectTableTimeOutClick, selectTableClickCount = 0;
function selectTable(tablename, datatable,
  config = {
    dblClick: false,
  },
  callbackClick = (select = 1, dataRow = [], tr = '1', row = []) => { },
  callbackDblClick = (select = 1, dataRow = [], tr = '1', row = []) => { }
) {
  //manda valores por defecto
  config = configSelectTable(config)

  //Nombramiento para usarlo
  let nameTable = tablename.replace('#', '')

  //Permite el reload y lo dibuja
  if (config.reload)
    setReloadSelecTable(nameTable, config.reload)

  //Activa las funciones moviles
  if (config.movil) {
    //Cambia la vista del dispositivo
    getBtnTabs(config);
    //Activa los botones si es movil
    dinamicTabs(`#loaderDiv-${nameTable}`)
    //Evalua el tipo de dispositivo
    selecTableTabs()
  }

  //Callback para procesos, ejemplo: quitar loader y mostrar columnas en escritorio
  let callback = (type = 'Out' || 'In') => {
    if (type === 'In') {
      if (!isMovil() || !config.movil) {
        $('.tab-second').fadeIn(200)
      }
    }
    $(`#loaderDiv-${nameTable}`).attr("style", "display: none !important");
  }


  //Table Click Registro
  $(`${tablename}`).on(`click`, `tr`, function (event) {
    //Obtener datos, tr, row e información del row
    let tr = this
    let row = datatable.row(tr);
    let dataRow = row.data();

    if (config.OnlyData) {
      return callbackClick(1, dataRow, function (data) { return 'No action' }, tr, row);
    }

    // let td = $(event.target).is('td')

    //Evalua donde está dando click el usuario
    var clickedElement = event.target;
    var computedStyle = window.getComputedStyle(clickedElement, '::before');
    computedStyle.getPropertyValue('property') === 'value'
    console.log(computedStyle.getPropertyValue('property') === 'value')
    //Cancela la funcion si el elemento que hace click tiene la siguiente clase
    if (
      $(clickedElement).hasClass('noClicked') //Algun elemento que podamos crear para que no implique selección
      || ($(clickedElement).hasClass('dtr-control')) //Cuando le da click al primer td con el boton + de visualizar mas columnas
      || $(tr).hasClass('child') //Cuando muestra las columnas ocultas de un regitro
      || $(tr).hasClass('dataTables_empty')  //Cuando la  tabla esta vacia, no selecciona
      || $(tr).hasClass(`${config.ignoreClass}`)
      || $(tr).find('td').hasClass('dataTables_empty')
    )

      return false;


    if ($(tr).hasClass('selected')) {
      selectTableClickCount++;
      clearTimeout(selectTableTimeOutClick)

      selectTableTimeOutClick = setTimeout(function () {

        if (selectTableClickCount === 1 && config.unSelect === true) {
          //Manda a cargar la vista
          $('.tab-second').fadeOut()
          $(`#loaderDiv-${nameTable}`).fadeIn(0);
          //Si esta deseleccionando:
          //Resetea los clicks:
          selectTableClickCount = 0;
          dataDobleSelect = false;

          //Reinicia la seleccion:
          $(tr).removeClass('selected');
          $(tr).removeClass(config.anotherClass);
          //

          //Desactivar otros tab
          $(`.tab-select`).addClass('disabled')
          // if (isMovil()) {
          //   let id = $('.tab-first').attr('id');
          //   $(`.tab-table`)
          // }

          // callbackDblClick(0, null, null, null);
          console.log('deselect')
          callbackClick(0, null, callback, null, null);
          //
        } else if (selectTableClickCount === 2 && config.dblClick === true) {
          //Manda a cargar la vista
          // $('.tab-second').fadeOut()
          // $(`#loaderDiv-${nameTable}`).fadeIn(0);
          //Si esta haciendo dobleClick: 
          selectTableClickCount = 0;

          callbackDblClick(1, dataRow, callback, tr, row)

        } else {
          //Reinicia el dobleClick
          selectTableClickCount = 0;
          return 'No action';
        }

      }, 300)

    } else {
      //Manda a cargar la vista
      if (!config.noColumns) {
        $('.tab-second').fadeOut()
        $(`#loaderDiv-${nameTable}`).fadeIn(0);
      }

      //Si esta seleccionando:
      dataDobleSelect = tr;
      selectTableClickCount++;
      setTimeout(() => {
        selectTableClickCount = 0;
      }, 400);



      if (!config.multipleSelect) {
        //Reinicia la seleccion:
        datatable.$('tr.selected').removeClass('selected');
        datatable.$('tr.selected').removeClass(config.anotherClass);
        //
      }

      //Agrega la clase para indicar que lo esta seleccionando
      $(tr).addClass('selected');
      $(tr).addClass(config.anotherClass);


      if (config.multipleSelect) {
        //Multiple Seleccion
        //Hará el callback cada que seleccionan a uno nuevo
        let row_length = datatable.rows('.selected').data().length
        let data = datatable.rows('.selected').data()

        callbackClick(row_length, data, null, null)

      } else {
        //Para una sola seleccion

        //Activar otros tab
        $(`.tab-select`).removeClass('disabled');
        //Reselecciona
        if (config['tab-default']) {
          $(`#tab-btn-${config['tab-default']}`).click();
        }


        callbackClick(1, dataRow, callback, tr, row);
      }

    }

  })
}


//Panel, este panel se usa ahora en la funcion selectTable, resolviendo el bug
function getPanel(divClass, loader, loaderDiv1, selectLista, fade, callback) { //selectLista es una variable que no se usa 
  switch (fade) {
    case 'Out':
      if ($(divClass).is(':visible')) {
        if (selectLista == null) {
          loaderDiv("Out", null, loader, loaderDiv1, 0);
          $(divClass).fadeOut()
          // //console.log('Invisible!')
        }
      } else {
        // //console.log('Todavia visible!')
        setTimeout(function () {
          return getPanel(divClass, loader, loaderDiv1, selectLista, 'Out')
        }, 100);
      }
      break;
    case 'In':
      $(divClass).fadeOut(0)
      loaderDiv("In", null, loader, loaderDiv1, 0);
      // alert('in');
      return callback(divClass);
      // $(divClass).fadeIn(100)
      break;
    default:
      return 0
  }
  return 1
}

function bugGetPanel(divClass, loaderLo, loaderDiv1, table = '') {
  loaderDiv("Out", null, loaderLo, loaderDiv1, 0);
  while (!$(divClass).is(':visible')) {
    if (!$(divClass).is(':visible')) {
      setTimeout(function () {
        $(divClass).fadeIn(0)
        // loader(0, 'bottom')
        // //console.log("Visible!")
      }, 100)
    }
    $(divClass).fadeIn(0)
  }
  // let altura = $(document).height();
  // $("html, body").animate({ scrollTop: altura + "px" });
}
//

// Antecedentes del paciente
function obtenerAntecedentesPaciente(id, curp, tipo = 1) {
  return new Promise(resolve => {
    let arrayDivs = new Array;
    let api = 10;
    //Antecedentes
    var divPatologicos = $('#collapse-Patologicos-Target').find("div[class='row d-flex justify-content-center']")
    arrayDivs['ANTECEDENTES PERSONALES PATOLOGICOS'] = divPatologicos
    var divNoPatologicos = $('#collapse-nopatologicos-Target').find("div[class='row d-flex justify-content-center']")
    arrayDivs['ANTECEDENTES NO PATOLOGICOS'] = divNoPatologicos
    var divHeredofamiliares = $('#collapse-anteHeredo-Target').find("div[class='row d-flex justify-content-center']")
    arrayDivs['ANTECEDENTES HEREDOFAMILIARES'] = divHeredofamiliares
    var divPsicologicos = $('#collapse-antPsico-Target').find("div[class='row d-flex justify-content-center']")
    arrayDivs['ANTECEDENTES PSICOLOGICOS/PSIQUIATRICOS'] = divPsicologicos
    var divNutricionales = $('#collapse-antNutri-Target').find("div[class='row d-flex justify-content-center']")
    arrayDivs['ANTECEDENTES NUTRICIONALES'] = divNutricionales
    var divLaboral = $('#collapse-MedLabo-Target').find("div[class='row d-flex justify-content-center']")
    arrayDivs['MEDIO LABORAL'] = divLaboral

    var divsisteCardio = $('#collapse-sub-sisteCardio-Target').find("div[class='row']")
    arrayDivs['SISTEMA CARDIOVASCULAR'] = divsisteCardio
    var divAparaRespiratorio = $('#collapse-sub-AparaRespiratorio-Target').find("div[class='row']")
    arrayDivs['APARATO RESPIRATORIO'] = divAparaRespiratorio
    var divaparatoDigestivo = $('#collapse-sub-aparatoDigestivo-Target').find("div[class='row']")
    arrayDivs['APARATO DIGESTIVO'] = divaparatoDigestivo
    var divaparatoGenitourina = $('#collapse-sub-aparatoGenitourina-Target').find("div[class='row']")
    arrayDivs['APARATO GENITOURINARIO'] = divaparatoGenitourina
    var divsistemNervios = $('#collapse-sub-sistemNervios-Target').find("div[class='row']")
    arrayDivs['SISTEMA NERVIOSO'] = divsistemNervios
    var divEndrocrinoloMetabolism = $('#collapse-sub-EndrocrinoloMetabolism-Target').find("div[class='row']")
    arrayDivs['ENDOCRINOLOGIA Y METABOLISMO'] = divEndrocrinoloMetabolism
    var divaparatoLocomot = $('#collapse-sub-aparatoLocomot-Target').find("div[class='row']")
    arrayDivs['APARATO LOCOMOTOR'] = divaparatoLocomot
    var divTermoregulacin = $('#collapse-sub-Termoregulacin-Target').find("div[class='row']")
    arrayDivs['TERMOREGULACION'] = divTermoregulacin
    var divpiel = $('#collapse-sub-piel-Target').find("div[class='row']")
    arrayDivs['PIEL'] = divpiel
    // //console.log(arrayDivs)

    // arrayDivs.push(divPatologicos, divNoPatologicos, divHeredofamiliares, divPsicologicos, divNutricionales, divLaboral)
    if (tipo == 2)
      api = 15

    $.ajax({
      url: http + servidor + "/" + appname + "/api/consulta_api.php",
      data: {
        api: api,
        turno_id: id,
        curp: curp
      },
      type: "POST",
      dataType: "json",
      success: function (data) {

        for (const key in data) {
          const element = data[key];
          //console.log(key)

          if (key && key != '¿ERES ALÉRGICO A ALGÚN MEDICAMENTO O ALIMENTO?')
            setValuesAntAnnameMetodo(arrayDivs[key], element, key)
        }
        // //console.log(data);
        // //console.log(arrayDivs)
      },
      complete: function () {
        resolve(1);
      },
      error: function (jqXHR, exception, data) {
        alertErrorAJAX(jqXHR, exception, data)
      },
    })
  });
  // $('#collapse-Patologicos-Target').find("div[class='row']").each(function(){
  //   //console.log($(this).find("input[value='1']").val())
  // })
}

// function obtenerAnamnesisApartadosPaciente(id){
//   return new Promise(resolve => {

//   })
// }

function setValuesAntAnnameMetodo(DIV, array, key) {
  // //console.log(DIV)
  if (array) {
    try {
      if (DIV.length != array.length)
        alertToast('Algunos datos de ' + key + ' se han perdido...', 'info')
    } catch (error) {

    }

    try {
      for (var i = 0; i < DIV.length; i++) {

        try {
          $(DIV[i]).find("input[value='" + array[i][0] + "']").prop("checked", true);
          var collapID = $(DIV[i]).find("div[class='collapse']").attr("id");
          // //console.log(collapID)
          if (array[i][0] == 1) {
            $('#' + collapID).collapse("show")
          }

          if (array[i][0] == 1 || array[i][0] == null) {
            $(DIV[i]).find("textarea[class='form-control input-form']").val(array[i][1])
          } else {
            $(DIV[i]).find("textarea[class='form-control input-form']").val('')
          }
        } catch (error) {
          //console.log(error);
        }

      }
    } catch (error) {

    }
  } else {
    // //console.log(DIV)
    // //console.log(array);
    // alertSelectTable('La seccion ' + key + ' no cargó correctamente', 'info', 6000)
  }
}

function obtenerVistaAntecenetesPaciente(div, cliente, pagina = 1) {
  return new Promise(resolve => {
    $.post(http + servidor + "/" + appname + "/vista/include/acordion/antecedentes-paciente.html", function (html) {
      setTimeout(function () {
        $(div).html(html);
        // //console.log(cliente)
        if (cliente == "Particular" || cliente == "PARTICULAR") {
          $('.onlyProcedencia').fadeOut(0);
        } else {
          $('.onlyProcedencia').fadeIn(0);
        }

        if (pagina == 0) {
          $('.onlyMedico').fadeOut(0);
        } else {
          $('.onlyMedico').fadeIn(0);
        }
        resolve(1)
      }, 100);
    });
  })
}
//

function obtenerVistaEspiroPacientes(div) {
  return new Promise(resolve => {
    $.post(http + servidor + "/" + appname + "/vista/menu/area-master/contenido/forms/form_espiro.html",

      function (html) {
        setTimeout(function () {
          $(div).html(html);

          resolve(1)
        }, 100);
      });
  })
}


function obtenerDatosEspiroPacientes(curp) {
  return new Promise(resolve => {
    ajaxAwait({
      api: 2,
      curp: curp
    }, 'espirometria_api', { callbackAfter: true, returnData: false }, false, function (data) {

      //$('#1pr1').prop('checked', true)
      let row = data.response.data;


      for (const key in row) {
        if (Object.hasOwnProperty.call(row, key)) {
          const element = row[key];

          respuestas = element.ID_R;
          comentario = element.COMENTARIO

          switch (true) {

            // PARA MOSTRAR AQUELLOS QUE SON INPUTS DE TIPO RADIO
            case respuestas == 1 || respuestas == '1' || respuestas == 2 || respuestas == '2':

              $(`input[name="respuestas[${element.ID_P}][${element.ID_R}][valor]"]`).prop('checked', true)

              break;

            // PARA TODOS AQUELLOS INPUTS DE TIPO CHECKBOX QUE NO TIENEN UN COMENTARIO ANEXADO
            case respuestas != 1 && respuestas != '1' && respuestas != 2 && respuestas != '2' && comentario == null:

              $(`input[name="respuestas[${element.ID_P}][${element.ID_R}][valor]"]`).prop('checked', true);

              break;

            // // PARA TODOS AQUELLOS QUE SON INPUTS DE TIPO TEXT  QUE NO TIENEN RESPUESTA Y PARA AQUELLOS INPUTS DE TIPO CHECKBOX QUE CONTIENEN UN COMENTARIO
            case comentario != null:

              $(`input[name="respuestas[${element.ID_P}][${element.ID_R}][valor]"]`).prop('checked', true);
              $(`input[id="p${element.ID_P}"]`).val(comentario);

              //INSERTAMOS LA RESPUESTAS DE AQUELLAS PREGUNTAS QUE NO TIENEN UN ID DE RESPUESTA
              $(`input[name="respuestas[${element.ID_P}][0][comentario]"]`).val(comentario);

              break;

          }

          //MOSTRAMOS LOS COLLAPSE DE TODAS AQUELLAS PREGUNTAS QUE LO CONTIENEN
          let parent = $('div[class="form-check form-check-inline col-12 mb-2"]');
          let children = $(parent).children(`div[id="p${element.ID_P}r${element.ID_R}"]`);
          children.collapse('show');

          $(`textarea[name="respuestas[${element.ID_P}][${element.ID_R}][comentario]"]`).val(comentario)


          let childrenCondiciones = $(parent).children(`div[id="pregunta${element.ID_P}"]`);
          childrenCondiciones.collapse('hide');

        }


      }
      resolve(1)
    })

  });

}



function select2(select, modal = null, placeholder = 'Selecciona una opción', width = '100%') {
  if (!modal) modal = 'body-controlador';
  $(select).select2({
    dropdownParent: $('#' + modal),
    tags: false,
    width: width,
    placeholder: placeholder
  });
}



//Creador vistas
pacienteTurnoActivo = new GuardarArreglo();
function obtenerPanelInformacion(id = null, api = null, tipPanel = null, panel = '#panel-informacion', nivel = null, area = null) {
  return new Promise(resolve => {
    var html = "";
    $(panel).fadeOut(0);
    $.post(http + servidor + "/" + appname + "/vista/include/barra-informacion/info-barra.php", {
      tip: tipPanel,
      nivel: nivel
    },
      function (html) {
        setTimeout(function () {
          $(panel).html(html);
        }, 100);
      }).done(function () {
        setTimeout(async function () {
          if (id > 0) {
            row = array_selected;
            switch (tipPanel) {
              case 'paciente':
                $.ajax({
                  url: http + servidor + "/" + appname + "/api/pacientes_api.php",
                  data: {
                    api: 2,
                    turno_id: id
                  },
                  type: "POST",
                  dataType: 'json',
                  success: function (data) {
                    if (mensajeAjax(data)) {
                      row = data['response']['data'][0];
                      $('#nombre-persona').html(row.NOMBRE_COMPLETO);
                      $('#edad-persona').html(formatoFecha(row.EDAD))
                      $('#nacimiento-persona').html(formatoFecha(row.NACIMIENTO));
                      $('#info-paci-alergias').html(row.ALERGIAS);
                      $('#info-paci-procedencia').html(row.PROCEDENCIA)
                      $('#info-paci-curp').html(row.CURP);
                      $('#info-paci-telefono').html(row.CELULAR);
                      $('#info-paci-correo').html(row.CORREO);
                      $('#info-paci-sexo').html(row.GENERO);
                      if (row.TURNO) {
                        $('#info-paci-turno').html(row.TURNO);
                      } else {
                        $('#info-paci-turno').html('Sin generar');
                      }
                      $('#info-paci-directorio').html(row.CALLE + ", " + row.COLONIA + ", " +
                        row.MUNICIPIO + ", " + row.ESTADO);
                      $('#info-paci-comentario').html(row.COMENTARIO_RECHAZO);

                      $('#info-paci-diagnostico').html(row.DIAGNOSTICO);


                      if (row.FECHA_REAGENDA != null) {
                        $('#info-paci-reagenda').html(formatoFecha(row.FECHA_REAGENDA));
                      }

                      if (row.FECHA_RECEPCION != null) {
                        $('#info-paci-recepcion').html(row.FECHA_RECEPCION);
                      }

                      $('#info-paci-prefolio').html(row.PREFOLIO)

                      if (row['ordenes']) {
                        // let row = row['ordenes']
                        // if ()

                        let ordenes = row['ordenes'][0];

                        let hash = {
                          'LABORATORIO CLÍNICO': 6,
                          'ULTRASONIDO': 11,
                          'RAYOS X': 8
                        }

                        for (const key in ordenes) {
                          if (Object.hasOwnProperty.call(ordenes, key)) {
                            const element = ordenes[key];
                            console.log(hash[element['area']])
                            if (hash[element['area']] == area) {
                              console.log('si');
                              $('#contenedor-btn-ordenes-medicas').append(`
                                <div class="col text-center">
                                  <a type="button" target="_blank" class="btn btn-borrar"
                                      href="${element['url']}">
                                    <i class="bi bi-file-earmark-pdf"></i> ${element['area']}
                                  </a>
                                </div>
                              `)
                            }

                          }
                        }

                        console.log(ordenes)

                        try {
                          let row = row['ordenes'][0]
                        } catch (error) {

                        }
                      } else {
                        console.log(row['ordenes'])
                      }

                    }
                  },
                  complete: function () {
                    $(panel).fadeIn(100);
                    resolve(1);
                  },
                  error: function (jqXHR, exception, data) {
                    alertErrorAJAX(jqXHR, exception, data)
                  },
                })

                break;
              case 'paciente_lab':
                $.ajax({
                  url: http + servidor + "/" + appname + "/api/pacientes_api.php",
                  data: {
                    api: 2,
                    turno_id: id
                  },
                  type: "POST",
                  dataType: 'json',
                  success: function (data) {
                    if (mensajeAjax(data)) {
                      row = data['response']['data'][0];
                      $('#nombre-persona').html(row.NOMBRE_COMPLETO);
                      $('#edad-persona').html(formatoFecha(row.EDAD))
                      $('#nacimiento-persona').html(formatoFecha(row.NACIMIENTO));


                      $('#info-paci-curp').html(row.CURP);
                      $('#info-paci-telefono').html(row.CELULAR);
                      $('#info-paci-correo').html(row.CORREO);
                      $('#info-paci-sexo').html(row.GENERO);
                      if (row.TURNO) {
                        $('#info-paci-turno').html(row.TURNO);
                      } else {
                        $('#info-paci-turno').html('Sin generar');
                      }
                      $('#info-paci-directorio').html(row.CALLE + ", " + row.COLONIA + ", " +
                        row.MUNICIPIO + ", " + row.ESTADO);
                      $('#info-paci-procedencia').html(row.NOMBRE_COMERCIAL);
                      $('#info-paci-prefolio').html(row.PREFOLIO)

                      $('#info-paci-reagenda').val(row.FECHA_RECEPCION);
                      $('#info-paci-reagenda').val(row.FECHA_REAGENDA);


                    }
                  },
                  complete: function () {
                    $(panel).fadeIn(100);
                    resolve(1);
                  },
                  error: function (jqXHR, exception, data) {
                    alertErrorAJAX(jqXHR, exception, data)
                  },
                })
                break;
              case 'equipo':
                $('#nombre-equipo').html(row.MARCA + "-" + row.MODELO);
                // $('#equipo-equipo').html(row.);
                $('#equipo-ingreso').html(formatoFecha(row.FECHA_INGRESO_EQUIPO));
                $('#equipo-inicio').html(formatoFecha(row.FECHA_INICIO_USO));
                $('#equipo-valor').html(row.VALOR_DEL_EQUIPO);
                $('#equipo-mantenimiento').html(row.FRECUENCIA_MANTENIMIENTO + " " + row.NUMERO_PRUEBAS);
                $('#equipo-calibracion').html(row.CALIBRACION + " " + row.NUMERO_PRUEBAS_CALIBRACION);
                $('#equipo-uso').html(row.USO);
                $('#equipo-descripcion').html(row.DESCRIPCION);
                $(panel).fadeIn(100);
                resolve(1);
                break;
              case 'signos-vitales':
                $.ajax({
                  url: http + servidor + "/" + appname + "/api/somatometria_api.php",
                  data: {
                    api: 2,
                    id_turno: id
                  },
                  type: "POST",
                  dataType: 'json',
                  success: function (data) {
                    // data = jQuery.parseJSON(data);
                    row = data['response']['data'];
                    //console.log(row);

                    if (mensajeAjax(data)) {
                      if (Object.keys(row).length > 2) {

                        $('#frecuenciaCardiaca').html(row['FRECUENCIA CARDIACA']['VALOR'] + " <strong>" + row['FRECUENCIA CARDIACA']['UNIDAD_MEDIDA'] + "</strong>")
                        $('#frecuenciaRespiratoria').html(row['FRECUENCIA RESPIRATORIA']['VALOR'] + " <strong>" + row['FRECUENCIA RESPIRATORIA']['UNIDAD_MEDIDA'] + "</strong>")
                        $('#sistolica').html(row['SISTOLICA']['VALOR'] + " <strong>" + row['SISTOLICA']['UNIDAD_MEDIDA'] + "</strong>")
                        $('#diastolica').html(row['DIASTOLICA']['VALOR'] + " <strong>" + row['DIASTOLICA']['UNIDAD_MEDIDA'] + "</strong>")
                        $('#saturacionOxigeno').html(row['SATURACION DE OXIGENO']['VALOR'] + " <strong>" + row['SATURACION DE OXIGENO']['UNIDAD_MEDIDA'] + "</strong>")
                        $('#temperatura').html(row['TEMPERATURA']['VALOR'] + " <strong>" + row['TEMPERATURA']['UNIDAD_MEDIDA'] + "</strong>")
                        $('#estatura').html(row['ESTATURA']['VALOR'] + " <strong>" + row['ESTATURA']['UNIDAD_MEDIDA'] + "</strong>")
                        $('#peso').html(row['PESO']['VALOR'] + " <strong>" + row['PESO']['UNIDAD_MEDIDA'] + "</strong>")
                        $('#masaCorporal').html(row['MASA CORPORAL']['VALOR'] + " <strong>" + row['MASA CORPORAL']['UNIDAD_MEDIDA'] + "</strong>")
                        $('#masaMuscular').html(row['MASA MUSCULAR']['VALOR'] + " <strong>" + row['MASA MUSCULAR']['UNIDAD_MEDIDA'] + "</strong>")
                        $('#porcentajeGrasaVisceral').html(row['PORCENTAJE DE GRASA VISCERAL']['VALOR'] + " <strong>" + row['PORCENTAJE DE GRASA VISCERAL']['UNIDAD_MEDIDA'] + "</strong>")
                        $('#huesos').html(row['HUESOS']['VALOR'] + " <strong>" + row['HUESOS']['UNIDAD_MEDIDA'] + "</strong>")
                        $('#metabolismo').html(row['METABOLISMO']['VALOR'] + " <strong>" + row['METABOLISMO']['UNIDAD_MEDIDA'] + "</strong>")
                        try {
                          $('#edadCuerpo').html(ifnull(row['EDAD DEL CUERPO']['VALOR']) + " <strong>" + row['EDAD DEL CUERPO']['UNIDAD_MEDIDA'] + "</strong>")
                        } catch (error) {
                          //console.log(error);
                        }
                        $('#perimetroCefalico').html(row['PERIMETRO CEFALICO']['VALOR'] + " <strong>" + row['PERIMETRO CEFALICO']['UNIDAD_MEDIDA'] + "</strong>")
                        $('#porcentajeProteinas').html(row['PORCENTAJE DE PROTEINAS']['VALOR'] + " <strong>" + row['PORCENTAJE DE PROTEINAS']['UNIDAD_MEDIDA'] + "</strong>")
                        $('#porcentajeAgua').html(row['PORCENTAJE DE AGUA']['VALOR'] + " <strong>" + row['PORCENTAJE DE AGUA']['UNIDAD_MEDIDA'] + "</strong>")
                      } else {
                        $('#div-panel-signos').html('<p class="none-p"> Sin signos vitales</p>')
                      }
                    }
                  },
                  complete: function () {
                    $(panel).fadeIn(100);
                    resolve(1);
                  },
                  error: function (jqXHR, exception, data) {
                    alertErrorAJAX(jqXHR, exception, data)
                  },
                })
                break;
              case 'cliente':
                // //console.log(row)
                $('#nombreComercial-cliente').html(row.NOMBRE_COMERCIAL);
                $('#nombreSistema-cliente').html(row.NOMBRE_SISTEMA);
                $('#info-cliente-RFC').html(row.RFC);
                $('#info-cliente-CURP').html(row.CURP);
                $('#info-cliente-codigo').html(row.CODIGO);
                $('#info-cliente-credito').html(row.LIMITE_CREDITO);
                $('#info-cliente-tempcredito').html(row.TEMPORALIDAD_DE_CREDITO);
                $('#info-cliente-cuentaContable').html(row.CUENTA_CONTABLE);
                $('#info-cliente-pagweb').attr("href", row.PAGINA_WEB);
                $('#info-cliente-pagweb').text(row.PAGINA_WEB);
                $('#info-cliente-face').attr("href", row.FACEBOOK);
                $('#info-cliente-face').text(row.FACEBOOK);
                $('#info-cliente-twitter').attr("href", row.TWITTER);
                $('#info-cliente-twitter').text(row.TWITTER);
                $('#info-cliente-instragram').attr("href", row.INSTAGRAM);
                $('#info-cliente-instragram').text(row.INSTAGRAM);
                $(panel).fadeIn(100);
                resolve(1);
                break;
              case 'contacto':
                // //console.log(selectContacto)
                $('#nombre-contacto').html(selectContacto.NOMBRE + ' ' + selectContacto.APELLIDOS);
                $('#info-contacto-tel1').html(selectContacto.TELEFONO1);
                $('#info-contacto-tel2').html(selectContacto.TELEFONO2);
                $('#info-contacto-email').html(selectContacto.EMAIL);
                $(panel).fadeIn(100);
                resolve(1);
                break;
              case 'documentos-paciente':
                // //console.log(selectContacto)

                $(panel).fadeIn(100);
                resolve(1);
                break;
              case 'resultados-areas':
                $(panel).fadeIn(100);
                resolve(1);
                break;
              case 'estudios_muestras':
                $.ajax({
                  url: http + servidor + "/" + appname + "/api/recepcion_api.php",
                  type: "POST",
                  dataType: 'json',
                  data: { api: 6, id_turno: row['ID_TURNO'] },
                  success: function (data) {
                    if (!mensajeAjax(data))
                      return false;
                    let row = data.response.data
                    let html = '';

                    // $(panel).html('');

                    function htmlLI(texto) {
                      return '<li class="list-group-item">' + texto + '</li>';
                    }

                    function crearDIV(grupo, id, row) {
                      let html = '';
                      html += '<a class="collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#board-' + id + '" aria-expanded="false">';
                      html += '<div style = "display: block"><div style="margin:0px;background: rgb(0 0 0 / 25%);width: 100%;padding: 10px 0px 10px 0px;text-align: center;""><h4 style="font-size: 20px !important;padding: 0px;margin: 0px;">' + grupo + '</h4></div></div>';
                      html += '</a>'

                      html += '<div class="collapse bg-white-canvas" id="board-' + id + '">'
                      let area = 0;
                      for (const key in row) {
                        const element = row[key];
                        // //console.log(element)
                        if (element['AREA_ID'] == id) {
                          area = 1;
                          html += htmlLI(element['GRUPO']);
                        }

                        if (
                          element['AREA_ID'] != '6' &&
                          element['AREA_ID'] != '12' &&
                          element['AREA_ID'] != '8' &&
                          element['AREA_ID'] != '11' &&
                          id == 0
                        ) {
                          area = 1;
                          html += htmlLI(element['GRUPO']);
                        }
                      }
                      html += '</div>';

                      if (area)
                        return html;
                      return '';
                    }

                    //Lab
                    html += crearDIV('<i class="bi bi-heart-pulse"></i> Laboratorio Clínico', 6, row);
                    //Lab Bio
                    html += crearDIV('<i class="bi bi-heart-pulse"></i> Laboratorio Biomolecular', 12, row);
                    //Ultrasonido
                    html += crearDIV('<i class="bi bi-person-video"></i>  Ultrasonido', 11, row);
                    //RayosX
                    html += crearDIV('<i class="bi bi-universal-access"></i>  Rayos X', 8, row);
                    //Otros
                    html += crearDIV('<i class="bi bi-window-stack"></i> Otros Servicios', 0, row);



                    $('#lista-estudios-paciente').html(html);


                    $(panel).fadeIn(100);
                    resolve(1);



                    // let html = '';
                    // for (var i = 0; i < row.length; i++) {
                    //   //console.log(row[i]);
                    //   html += '<li class="list-group-item">';
                    //   html += row[i]['GRUPO'];
                    //   html += '</li>';
                    //   //<i class="bi bi-arrow-right-short"></i>
                    //   //<strong>' + row[i]['MUESTRA'] + '</strong> - <strong>' + row[i]['CONTENEDOR'] + '</strong>
                    // }
                    // $('#lista-estudios-paciente').html(html);


                    // $(panel).fadeIn(100);
                    // resolve(1);


                  },
                  complete: function () {
                    loaderDiv("Out", null, "#loader-muestras", '#loaderDivmuestras');
                    resolve(1);
                  },
                  error: function (jqXHR, exception, data) {
                    alertErrorAJAX(jqXHR, exception, data)
                  },
                });
                break;

              case 'turnos_panel':
                // id <-- area fisica
                ajaxTurnosActualArea()
                getStatusOptimizador()

                function getStatusOptimizador() {
                  if (api != 'vistas')
                    activoConsultadorTurnero = true
                  if (activoConsultadorTurnero) {
                    $.ajax({
                      url: http + servidor + '/' + appname + '/archivos/sistema/json/turnero_optimizador.json',
                      type: 'POST',
                      dataType: 'JSON',
                      success: function (data) {
                        // let data = JSON.parse(data);
                        // //console.log(data)
                        if (data['Optimizador'][id]) {
                          setTimeout(() => {
                            ajaxTurnosActualArea()
                          }, 500);
                        }
                        setTimeout(() => {
                          getStatusOptimizador()
                        }, 2000);
                      }
                    })
                  } else {
                    setTimeout(() => {
                      getStatusOptimizador()
                    }, 2000);
                  }
                }


                function ajaxTurnosActualArea() {
                  $.ajax({
                    url: http + servidor + "/" + appname + "/api/turnero_api.php",
                    type: "POST",
                    dataType: 'json',
                    data: { api: 6, area_fisica_id: id },
                    success: function (data) {
                      if (mensajeAjax(data, 'Turnero')) {
                        let row = data.response.data;
                        //console.log(row);
                        if (row[0]) {


                          pacienteTurnoActivo.selectID = row[0]['ID_TURNO'];
                          pacienteTurnoActivo.setguardado(row[0]['PACIENTE']);


                          $('#paciente_turno').html(row[0]['PACIENTE'])
                          // miStorage.setItem('paciente_actual_turno', row[0]['ID_TURNO']);
                          alertMsj({
                            title: row[0]['PACIENTE'],
                            text: 'Es su siguiente paciente',
                            icon: 'success',
                            timer: 5000,
                            showCancelButton: false,
                            timerProgressBar: true,
                          })
                        } else {
                          $('#paciente_turno').html('Ninguno')
                          // miStorage.setItem('paciente_actual_turno', null);
                        }

                        // Control de turnos
                        $('#omitir-paciente').on('click', function () {
                          omitirPaciente(id); //case 3
                        })

                        $('#llamar-paciente').on('click', function () {
                          llamarPaciente(id); //case 2
                        })


                        $('#liberar-paciente').on('click', function () {
                          if (pacienteTurnoActivo.selectID === null) {
                            alertMensaje('info', 'Paciente no disponible', 'No has llamado ningún paciente o no hay paciente en tu area')
                          } else {
                            liberarPaciente(id, pacienteTurnoActivo.selectID); //case 1
                          }
                        })
                      }
                    }, complete: function () {
                      $(panel).fadeIn(100);
                      resolve(1);
                    },
                    error: function (jqXHR, exception, data) {
                      alertErrorAJAX(jqXHR, exception, data)
                    },
                  })
                }



                break;

              case 'listado_resultados':
                $.ajax({
                  url: http + servidor + "/" + appname + "/api/consulta_api.php",
                  type: "POST",
                  dataType: 'json',
                  data: { api: 21, turno_id: id },
                  success: function (data) {
                    if (mensajeAjax(data)) {
                      //console.log(data)

                      let array = {
                        1: 'CONSULTORIO',
                        2: 'SOMATOMETRÍA',
                        3: 'OFTALMOLOGÍA',
                        4: 'AUDIOMETRÍA',
                        5: 'ESPIROMETRÍA',
                        6: 'LABORATORIO CLÍNICO',
                        7: 'RAYOS X',
                        8: 'ELECTROCARDIOGRAMA',
                        9: 'ELECTRO_CAPTURAS',
                        10: 'ULTRASONIDO',
                        11: 'LABORATORIO BIOMOLECULAR',
                        12: 'CITOLOGÍA',
                        13: 'NUTRICIÓN',
                        14: 'INBODY',
                      }
                      let row = data.response.data;
                      $('#append-html-historial-estudios').html('');

                      for (const key in array) {
                        if (Object.hasOwnProperty.call(array, key)) {
                          const element = array[key];

                          let arrayArea = $.grep(row, function (n, i) {
                            return n.AREA_LABEL === element;
                          });

                          //console.log(element, arrayArea)
                          setListResultadosAreas('#append-html-historial-estudios', element, arrayArea)
                        }
                      }



                    }
                    $(panel).fadeIn(100);
                    resolve(1);
                  },
                  complete: function () {
                    resolve(1);
                  },
                  error: function (jqXHR, exception, data) {
                    alertErrorAJAX(jqXHR, exception, data)
                  },
                });

                function setListResultadosAreas(div, titulo, array) {
                  let html = '';
                  //titulo
                  let lenghtArray = array.length;
                  if (!lenghtArray)
                    return false;
                  html += `<li class="list-group-item d-flex justify-content-between align-items-start">
                              <div class="ms-2 me-auto">`
                  html += `<div class="fw-bold">
                                <a class="" data-bs-toggle="collapse" href="#collapseEstudios${deleteSpace(titulo)}" role="button"
                                    aria-expanded="false" aria-controls="collapseEstudios${deleteSpace(titulo)}">
                                    ${titulo}
                                </a>
                            </div>`
                  //Body 
                  html += `<div class="collapse" id="collapseEstudios${deleteSpace(titulo)}">
                                <ul style="list-style: disc;">`

                  for (const key in array) {
                    if (Object.hasOwnProperty.call(array, key)) {
                      const element = array[key];
                      html += `<li><a href="${element['RUTA']}" target="_blank">${formatoFecha2(element['FECHA_RECEPCION'], [0, 1, 2, 2, 0, 0, 0])}</a></li>`
                    }
                  }

                  html += `</ul> </div>`

                  //Finish and number span 
                  html += `</div>
                        <span class="badge bg-primary rounded-pill">${lenghtArray}</span>
                    </li>`

                  $(div).append(html);

                }

                break;

              //Antiguo por datatable
              case 'estudio':
                $('#nombre-estudio').html(row['DESCRIPCION']);
                $('#clasificacion-estudio').html(row.CLASIFICACION_EXAMEN);
                $('#estudio-metodo').html(row.METODO);
                $('#estudio-medida').html(row.MEDIDA);
                $('#estudio-entrega').html(row.DIAS_DE_ENTREGA);
                if (row.LOCAL == 1) {
                  $('#estudio-subroga').html('Si');
                } else {
                  $('#estudio-subroga').html('No');
                }
                if (row.MUESTRA_VALORES_REFERENCIA == 1) {
                  $('#estudio-valorvista').html('Si');
                } else {
                  $('#estudio-valorvista').html('No');
                }
                $('#estudio-indicaciones').html(row.INDICACIONES);
                $('#estudio-codigo-sat').html(row.DESCRIPCION_SAT);
                $('#estudio-venta').html(row.PRECIO_VENTA);
                $(panel).fadeIn(100);
                resolve(1);
                break;
              //Renovado para laboratorio
              case 'info-estudio-lab-clinico':
                // No  recuerdo para que  sevia...

                break;

              case 'lista-documentos-paciente':
                // $.ajax({

                //   url: `${http}${servidor}/${appname}/api/recepcion_api.php`,
                //   data: {
                //     api: 11,
                //     turno_id: id
                //   },
                //   type: "POST",
                //   dataType: 'json',
                //   success: function (data) {
                //     if (mensajeAjax(data)) {

                //     }
                //   },
                //   complete: function () {
                //     $(panel).fadeIn(100);
                //     resolve(1);
                //   },
                //   error: function (jqXHR, exception, data) {
                //     alertErrorAJAX(jqXHR, exception, data)
                //   },
                // })

                let dataDocumentos = false;

                dataDocumentos = await ajaxAwait({
                  api: 11, turno_id: id
                }, 'recepcion_api')

                dataDocumentos = dataDocumentos.response.data[0];
                //console.log(dataDocumentos)

                if (dataDocumentos) {
                  $('button[class="btn_documentacion_paciente list-group-item list-group-item-action"]').fadeOut('slow');

                  //console.log(dataDocumentos['IDENTIFICACION'])
                  if (dataDocumentos['VERIFICACION_UJAT'])
                    $(`#btn-VERIFICACION_UJAT`).fadeIn();

                  if (dataDocumentos['PASE_UJAT'])
                    $(`#btn-PASE_UJAT`).fadeIn();

                  if (dataDocumentos['PASE_UJAT'])
                    $(`#btn-PASE_UJAT`).fadeIn();

                  if (dataDocumentos['PERFIL'])
                    $(`#btn-PERFIL`).fadeIn();


                  //Credencial
                  try {
                    if (dataDocumentos['IDENTIFICACION'][0]) {
                      if (dataDocumentos['IDENTIFICACION'][0]['front'].length) {
                        $('#btn-credenciales').fadeIn();
                        // //console.log(dataDocumentos['IDENTIFICACION'][0]['back']);
                        // if (dataDocumentos['IDENTIFICACION'][0]['back'].length)
                        //   $(`#btn-back`).fadeIn();
                        if (dataDocumentos['IDENTIFICACION'][0]['front'].length)
                          $(`#btn-front`).fadeIn();
                      }
                    }
                  } catch (error) {

                  }

                  //Ordenes_medicas
                  try {
                    for (const key in dataDocumentos['ORDENES_MEDICAS'][0]) {
                      $('#btn-orden-medicas').fadeIn();
                      if (Object.hasOwnProperty.call(dataDocumentos['ORDENES_MEDICAS'][0], key)) {
                        const element = dataDocumentos['ORDENES_MEDICAS'][0][key];
                        if (element.area) {
                          element.area = element.area.replace(' ', '')
                          $(`#btn-${element.area}`).fadeIn();
                          $(`#btn-${element.area}`).attr('href', element.url);
                        }

                      }
                    }
                  } catch (error) {

                  }



                } else {
                  return false;
                }

                $('.btn_documentacion_paciente, #btn-laboratorio-etiquetas').on('click', function (event) {
                  event.preventDefault();

                  let btn = $(this);
                  //console.log(btn.attr('id'));
                  switch (btn.attr('id')) {
                    case 'btn-laboratorio-etiquetas':
                      area_nombre = 'etiquetas'
                      api = encodeURIComponent(window.btoa(area_nombre));
                      turno = encodeURIComponent(window.btoa(array_selected['ID_TURNO'],));

                      window.open(http + servidor + "/nuevo_checkup/visualizar_reporte/?api=" + api + "&turno=" + turno, "_blank");
                      break;

                    case 'btn-PERFIL':
                      window.open(`${dataDocumentos['PERFIL']}`);
                      break;

                    case 'btn-VERIFICACION_UJAT':
                      window.open(`${dataDocumentos['VERIFICACION_UJAT']}`);
                      break;

                    case 'btn-PASE_UJAT':
                      window.open(`${dataDocumentos['PASE_UJAT']}`);
                      break;

                    case 'btn-front':
                      window.open(`${dataDocumentos['IDENTIFICACION'][0]['front']}`);
                      break;

                    case 'btn-back':
                      window.open(`${dataDocumentos['IDENTIFICACION'][0]['back']}`);
                      break;

                    default:
                      //console.log('boton incorrecto')
                      break;
                  }
                  event.preventDefault();
                })
                $(panel).fadeIn(100);
                resolve(1);
                break;

              case 'Estudios_Estatus':
                setTimeout(function () {
                  $(panel).fadeIn(100);
                }, 100);
                resolve(1);

                break;


              case 'PanelTickets':

                await ajaxAwait({
                  api: 2,
                  turno_id: id
                }, 'tickets_api', { callbackAfter: true }, false, function (data) {
                  data = data.response.data[0]

                  $('#info-ticket-total_cargos').html(data['TOTAL_CARGOS'])
                  $('#info-ticket-descuento').html(data['DESCUENTO'])
                  $('#info-ticket-subtotal').html(data['SUBTOTAL'])
                  $('#info-ticket-iva').html(data['IVA'])
                  $('#info-ticket-total').html(data['TOTAL'])
                  $('#info-ticket-tipopago').html(data['TIPO_PAGO'])

                  if (ifnull(data['RAZON_SOCIAL']) ||
                    ifnull(data['DOMICILIO_FISCAL']) ||
                    ifnull(data['REGIMEN_FISCAL']) ||
                    ifnull(data['USO_DESCRIPCION']) ||
                    ifnull(data['RFC']) ||
                    ifnull(data['METODO_PAGO'])) {

                    $('#info-factura-razon_social').html(data['RAZON_SOCIAL']);
                    $('#info-factura-domicilio_fiscal').html(data['DOMICILIO_FISCAL']);
                    $('#info-factura-regimen_fiscal').html(data['REGIMEN_FISCAL']);
                    $('#info-factura-uso').html(data['USO_DESCRIPCION']);
                    $('#info-factura-rfc').html(data['RFC']);
                    $('#info-factura-metodo_pago').html(data['METODO_PAGO']);

                    $('.panel-contenedor-factura').fadeIn(0);
                  }
                }
                )



                setTimeout(function () {
                  $(panel).fadeIn(100);
                }, 100);
                resolve(1);
                break;

              case 'PanelTemperaturas':
                setTimeout(function () {
                  $(panel).fadeIn(100);
                }, 100);
                resolve(1);
                break;


              default:
                console.log('Sin opción panel')
                setTimeout(function () {
                  $(panel).fadeOut(100);
                }, 100);
                resolve(false);
                break;
            }
          } else {
            setTimeout(function () {
              $(panel).fadeOut(100);
            }, 100);
            resolve(false);
          }
        }, 110);
      });
    // resolve(0);
  });
}




function selectedTrTable(text, column = 1, table) {
  filter = text.toUpperCase();
  tablesearch = document.getElementById(table);
  tr = tablesearch.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[column];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].classList.add("selected");
        return tr[i];
      }
    }
  }
}



//Vista de un solo valor
function getAreaUnValor(titulo, titulosingular, api_url, registro_id, divContenedor) {
  //Plantilla 
  html = '<div class="modal fade" id="modalRegistrar' + titulo + '" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"' +
    'data-bs-keyboard="false">' +
    '<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">' +
    '<div class="modal-content">';

  //Header
  html += '<div class="modal-header header-modal">' +
    '<h5 class="modal-title">' + firstMayus(titulo) + '</h5>' +
    '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>' +
    '</div>';

  //Cuerpo
  html += '<div class="modal-body" id="' + titulo + '-body">' +
    // '<p class="none-p">Doble click para editar <i class="bi bi-pencil"></i></p>' +
    '<div class="text-center mt-2">' +
    '<div class="input-group flex-nowrap">' +
    '<input type="text" class="form-control input-color" style="display: unset !important;"' +
    'name="inputBuscarTable' + titulo + '" placeholder="Filtrar tabla" autocomplete="off" id="BuscarTabla' + titulo + '"' +
    'data-bs-toggle="tooltip" data-bs-placement="top" title="Filtra la lista por coincidencias">' +
    // '<span class="input-group-text" id="addon-wrapping" data-bs-toggle="tooltip" data-bs-placement="top"'+
    //   'title="Seleccione un paciente para visualizar su información">'+
    //   '<i class="bi bi-info-circle"></i> </span>'+
    '<span class="input-group-text" id="addon-wrapping" data-bs-toggle="tooltip" data-bs-placement="top"' +
    'title="Doble click a un registro para modificarlo">' +
    '<i class="bi bi-pencil"></i> </span>' +
    '</div> </div>' +
    '<div class="row mt-3">' +

    //Tabla contenido
    '<div class="col-6">' +
    '<table class="table tableContenido" id="Tabla' + titulo + '" style="width:100%">' +
    '<thead class="">' +
    '<tr>' +
    '<th scope="col d-flex justify-content-center">#</th>' +
    '<th scope="col d-flex justify-content-center">' + firstMayus(titulo) + '</th>' +
    '<th scope="col d-flex justify-content-center"><i class="bi bi-collection"></i></th>' +
    '</tr>' +
    '</thead>' +
    '<tbody>' +
    '</tbody>' +
    '</table>' +
    '</div>' +
    //

    //Formularios Registrar
    '<div class="col-6" id="RegistrarMetodo' + titulo + '">' +
    '<p>Crear nuevo registro:</p>' +
    '<form class="row" id="formRegistrar' + titulo + '">' +
    '<div class="col-12">' +
    '<label for="descripcion" class="form-label">Nombre ' + titulosingular + '</label>' +
    '<input type="text" name="descripcion" required value="" class="form-control input-form">' +
    '</div>' +
    '<div class="text-center">' +
    '<button type="submit" class="btn btn-hover me-2" style="margin-bottom:4px">' +
    '<i class="bi bi-send-plus"></i> Guardar' +
    '</button>' +
    '</div>' +
    '</form>' +
    '</div>' +
    //

    //Formulario Actualizar
    '<div class="col-6" id="editarMetodo' + titulo + '" style="display:none">' +
    '<p>Actualizar registro:</p>' +
    '<form class="row" id="formEditar' + titulo + '">' +
    '<div class="col-12">' +
    '<label for="descripcion" class="form-label">Nombre ' + titulosingular + '</label>' +
    '<input type="text" name="descripcion" required id="edit-' + titulo + '-descripcion" ' +
    'class="form-control input-form">' +
    '</div>' +
    '<div class="text-center">' +
    '<button type="submit" class="btn btn-hover me-2" style="margin-bottom:4px">' +
    '<i class="bi bi-pencil-square"></i> Actualizar' +
    '</button>' +
    '<button type="button" class="btn btn-hover btn-activo me-2" style="margin-bottom:4px; display: none" id="desactivar-' + titulo + '">' +
    '<i class="bi bi-collection"></i> Desactivar' +
    '</button>' +
    '<button type="button" class="btn btn-hover btn-activo me-2" style="margin-bottom:4px; display: none" id="activar-' + titulo + '">' +
    '<i class="bi bi-collection"></i> Activar' +
    '</button>' +
    '</div>' +
    '</form>' +
    '</div>' +
    //

    '<style>' +
    '#Tabla' + titulo + '_filter {' +
    'display: none;' +
    '}' +
    '</style>' +

    '</div>' + // Etiquetas de cierres
    '</div>';

  //Footer
  html += '<div class="modal-footer">' +
    '<button type="button" class="btn btn-cancelar" data-bs-dismiss="modal"><i class="bi bi-arrow-left-short"></i>' +
    'Cerrar</button>' +
    '</div>' +
    '</div>' +
    '</div>' +
    '</div>';

  //Crea el html en DOM
  $(divContenedor).html(html);

  vistaAreaUnValor(api_url, '#Tabla' + titulo, registro_id, titulo)


}

function vistaAreaUnValor(api_url, tabla_id, registro_id, titulo) {
  let dataAreaValor;
  //Vista table {-
  let TablaContenido = $(tabla_id).DataTable({
    processing: true,
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
      loadingRecords: '&nbsp;',
      processing: '<div class="spinner"></div>'
    },
    lengthMenu: [
      [5, 10, -1],
      [5, 10, "All"]
    ],
    autoWidth: false,
    // searching: false,
    lengthChange: false,
    info: false,
    paging: false,
    scrollY: autoHeightDiv(0, 348),
    scrollCollapse: true,
    ajax: {
      dataType: 'json',
      data: { api: 2, ACTIVO: 1 },
      method: 'POST',
      url: http + servidor + "/" + appname + "/api/" + api_url + ".php",
      beforeSend: function () { },
      // success: function (data) { mensajeAjax(data) },
      complete: function () { cambiarFormMetodo(0, titulo, "formEditar" + titulo); },
      dataSrc: 'response.data'
    },
    createdRow: function (row, data, dataIndex) {
      // mensajeAjax(data)
      if (data.ACTIVO == 1) {
        $(row).addClass('bg-success text-white');
      } else {
        $(row).addClass('bg-danger text-white');
      }
    },
    columns: [
      { data: 'COUNT' },
      { data: 'DESCRIPCION' },
      {
        data: 'ACTIVO', render: function (data) {
          if (data == 1) {
            return '<i class="bi bi-check-circle"></i>';
          } else {
            return '<i class="bi bi-x-circle"></i>';
          }
        }
      },
    ],
    columnDefs: [{
      "width": "3px",
      "targets": 0
    },],

  });

  //Buscador
  $('#BuscarTabla' + titulo).keyup(function () {
    // //console.log($(this).val())
    TablaContenido.search($(this).val()).draw();
  });

  selectDatatabledblclick(function (select, data) {
    dataAreaValor = data;
    $('.btn-activo').fadeOut()
    $('.btn-activo').prop('disabled', true);
    if (!select) {
      cambiarFormMetodo(0, titulo, "formEditar" + titulo);
    } else {
      switch (dataAreaValor.ACTIVO) {
        case 1: case '1':
          $('#desactivar-' + titulo).fadeIn(100);
          setTimeout(() => {
            $('#desactivar-' + titulo).prop('disabled', false);
          }, 100);
          break;
        case 0: case '0':
          $('#activar-' + titulo).fadeIn(100);
          setTimeout(() => {
            $('#activar-' + titulo).prop('disabled', false);
          }, 100);
          break;
      }
      document.getElementById("edit-" + titulo + "-descripcion").value = dataAreaValor['DESCRIPCION'];
      cambiarFormMetodo(1, titulo);
    }
  }, tabla_id, TablaContenido, true)
  // -}


  //Modal vista {-
  // let modal = document.getElementById('modalRegistrar' + titulo)
  // modal.addEventListener('show.bs.modal', event => {
  //     TablaContenido.ajax.reload();
  // })

  //Ajusta el ancho del encabezado cuando es dinamico
  let modal = $('#modalRegistrar' + titulo);
  modal.on('shown.bs.modal', function (e) {
    TablaContenido.ajax.reload();
    $.fn.dataTable
      .tables({
        visible: true,
        api: true
      })
      .columns.adjust();
  })



  // -}

  //Formulario de registro de cargo
  $("#formRegistrar" + titulo).submit(function (event) {
    event.preventDefault();
    /*DATOS Y VALIDACION DEL REGISTRO*/
    var form = document.getElementById("formRegistrar" + titulo);
    var formData = new FormData(form);
    formData.set('api', 1);

    alertMensajeConfirm({
      title: '¿Está seguro que todos los datos están correctos?',
      text: "No podrá eliminar el registro",
      icon: 'warning'
    }, function () {
      $.ajax({
        data: formData,
        url: http + servidor + "/" + appname + "/api/" + api_url + ".php",
        type: "POST",
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (data) {
          if (mensajeAjax(data)) {
            alertToast('¡' + firstMayus(titulo) + ' registrado!', 'success')
            document.getElementById("formRegistrar" + titulo).reset();
            TablaContenido.ajax.reload();
            cambiarFormMetodo(0, titulo, "formEditar" + titulo);
            // selectMetodo()
          }
        },
        error: function (jqXHR, exception, data) {
          alertErrorAJAX(jqXHR, exception, data)
        },
      });
    }, 1)
    event.preventDefault();
  });


  //Formulario de actualizar cargo
  $("#formEditar" + titulo).submit(function (event) {
    event.preventDefault();
    /*DATOS Y VALIDACION DEL REGISTRO*/
    var form = document.getElementById("formEditar" + titulo);
    var formData = new FormData(form);
    formData.set(registro_id, dataAreaValor[registro_id])
    formData.set('api', 1);

    alertMensajeConfirm({
      title: '¿Está seguro de cambiar la descripcion?',
      text: "¡Se cambiará en todas las vistas!",
      icon: 'warning'
    }, function () {
      //$("#btn-registrarse").prop('disabled', true);
      // Esto va dentro del AJAX
      $.ajax({
        data: formData,
        url: http + servidor + "/" + appname + "/api/" + api_url + ".php",
        type: "POST",
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (data) {
          if (mensajeAjax(data)) {
            alertToast('¡' + firstMayus(titulo) + ' actualizado!', 'success')
            document.getElementById("formEditar" + titulo).reset();
            TablaContenido.ajax.reload();
            cambiarFormMetodo(0, titulo, "formEditar" + titulo);
            // selectMetodo()
          }
        },
        error: function (jqXHR, exception, data) {
          alertErrorAJAX(jqXHR, exception, data)
        },
      });
    }, 1)
    event.preventDefault();
  });

  //Desactivar valor
  $('#desactivar-' + titulo).click(function () {
    if (dataAreaValor != null) {
      alertMensajeConfirm({
        title: "¿Está seguro que desea desactivar este registro?",
        text: "No podrán volver a elegir el registro",
        icon: 'warning',
      }, function () {
        $.ajax({
          data: {
            id: dataAreaValor[registro_id],
            api: 4,
            ACTIVO: 0
          },
          url: http + servidor + "/" + appname + "/api/" + api_url + ".php",
          type: "POST",
          dataType: 'json',
          success: function (data) {
            if (mensajeAjax(data)) {
              alertToast('¡' + firstMayus(titulo) + ' eliminado!', 'success')
              document.getElementById("formEditar" + titulo).reset();
              TablaContenido.ajax.reload();
              cambiarFormMetodo(0, titulo, "formEditar" + titulo);
            }
          },
          error: function (jqXHR, exception, data) {
            alertErrorAJAX(jqXHR, exception, data)
          },
        });
      }, 1)
    } else {
      alertSelectTable();
    }
  })

  //Desactivar valor
  $('#activar-' + titulo).click(function () {
    if (dataAreaValor != null) {
      alertMensajeConfirm({
        title: "¿Está seguro que desea desactivar este registro?",
        text: "No podrán volver a elegir el registro",
        icon: 'warning',
      }, function () {
        $.ajax({
          data: {
            id: dataAreaValor[registro_id],
            api: 4,
            ACTIVO: 1
          },
          url: http + servidor + "/" + appname + "/api/" + api_url + ".php",
          type: "POST",
          dataType: 'json',
          success: function (data) {
            if (mensajeAjax(data)) {
              alertToast('¡' + firstMayus(titulo) + ' eliminado!', 'success')
              document.getElementById("formEditar" + titulo).reset();
              TablaContenido.ajax.reload();
              cambiarFormMetodo(0, titulo, "formEditar" + titulo);
            }
          },
          error: function (jqXHR, exception, data) {
            alertErrorAJAX(jqXHR, exception, data)
          },
        });
      }, 1)
    } else {
      alertSelectTable();
    }
  })

}


/*EN PROCESO */
//Genera un modal de varios valores
function generarCatalogoModal(
  CONTENT = {
    divContenedor,
    ID_CATALOGO: 'ID_CATALOGO',
    titulos: {
      IDSDIVS: 'Nuevo',
      HeaderTitle: 'Catalogo de especialidades',
      titulo: 'especialidad',
      titulos: 'especialidades'
    },
    formLabels: {
      DESCRIPCION: {
        LABEL: 'Nombre de especialidad',
        STRING: 'DESCRIPCION',
        CLASS: {
          input: '',
          div: 'col-12'
        }
      }
    },
    tableContent: {
      COUNT: {
        HEADER: '#',
        ID: 'COUNT',
        CLASS: ''
      },
      DESCRIPCION: {
        HEADER: 'DESCRIPCION',
        ID: 'DESCRIPCION',
        CLASS: ''
      },
      ACTIVO: {
        HEADER: '<i class="bi bi-collection"></i>',
        ID: 'ACTIVO',
        CLASS: ''
      }
    },
    diseño: {
      MODALCLASS: 'modal-lg modal-dialog-centered modal-dialog-scrollable',
    },
  },
  ajax = {
    data: {
      api: 2, ACTIVO: 1
    },
    api_url: '',
    dataSrc: 'response.data',
  },

  columnsData = [
    { data: 'COUNT' },
    { data: 'DESCRIPCION' },
    {
      data: 'ACTIVO', render: function (data) {
        if (data == 1) {
          return '<i class="bi bi-check-circle"></i>';
        } else {
          return '<i class="bi bi-x-circle"></i>';
        }
      }
    }
  ],
  columnsDefData = [
    {
      "width": "3px",
      "targets": 0
    },
  ],
  configTable = {
    processing: true,
    autoWidth: false,
    searching: false,
    info: false,
    paging: false,
    scrollY: '30vh',
    scrollCollapse: true,
  },

  createdRow = {
    IDCOMPARADOR: 'ACTIVO',
    VALUE: 1,
    CLASSTRUE: 'bg-success text-white',
    CLASSFALSE: 'bg-danger text-white'
  },

  tagTable = {
    table_id: '',
    titulo: ''

  }


) {

  let id = CONTENT['ID_CATALOGO'];
  getHTMLCatalogo(CONTENT['divContenedor'], CONTENT['titulos'], CONTENT['formLabels'], CONTENT['tableContent'], CONTENT['diseño'])

  setTimeout(() => {
    //console.log('timeOut')
    getTableControlador(tagTable, CONTENT, id, CONTENT['formLabels'], configTable, ajax['table'], createdRow, columnsData, columnsDefData)
  }, 200);
}

//Crear HTML 
//Modal de catalogos
function getHTMLCatalogo(divContenedor, titulos, formLabels, tableContent, diseño) {
  let html = '';
  // //console.log(divContenedor)
  //Plantilla 
  html = '<div class="modal fade" id="modalVista' + titulos['IDSDIVS'] + '" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"' +
    'data-bs-keyboard="false">' +
    '<div class="modal-dialog ' + diseño['MODALCLASS'] + '">' +
    '<div class="modal-content">';

  //Header
  html += '<div class="modal-header header-modal">' +
    '<h5 class="modal-title">' + firstMayus(titulos['HeaderTitle']) + '</h5>' +
    '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>' +
    '</div>';

  //Cuerpo
  html += '<div class="modal-body" id="' + titulos['IDSDIVS'] + '-body">' +
    '<p class="none-p">Edite un registro dando doble click <i class="bi bi-pencil"></i></p>' +
    '<div class="row mt-3">' +

    //Tabla contenido
    '<div class="col-6">' +
    '<table class="table table-hover tableContenido" id="Tabla' + titulos['IDSDIVS'] + '" style="width:100%">' +
    '<thead class="">' +
    '<tr>';

  //th
  for (const key in tableContent) {
    if (Object.hasOwnProperty.call(tableContent, key)) {
      const th = tableContent[key];
      html += '<th scope="col d-flex justify-content-center" class="' + th['CLASS'] + '">' + th['HEADER'] + '</th>';
      // '<th scope="col d-flex justify-content-center">' + firstMayus(titulo) + '</th>' +
      // '<th scope="col d-flex justify-content-center"><i class="bi bi-collection"></i></th>';
    }
  }

  //Cierre tabla
  html += '</tr> </thead>' +
    '<tbody>' +
    '</tbody>' +
    '</table>' +
    '</div>' +
    //

    //Formularios Registrar
    '<div class="col-6" id="RegistrarModal' + titulos['IDSDIVS'] + '">' +
    '<p>Crear nuevo registro:</p>' +
    '<form class="row" id="formRegistrar' + titulos['IDSDIVS'] + '">';

  //LABELS
  for (const key in formLabels) {
    if (Object.hasOwnProperty.call(formLabels, key)) {
      const input = formLabels[key];
      html += '<div class="' + input['CLASS']['div'] + '">' +
        '<label for="' + input['STRING'] + '" class="form-label">' + input['LABEL'] + '</label>' +
        '<input type="text" name="' + input['STRING'] + '" required value="" class="form-control input-form">' +
        '</div>';
    }
  }

  //Botones
  html += '<div class="text-center">' +
    '<button type="submit" class="btn btn-hover me-2" style="margin-bottom:4px">' +
    '<i class="bi bi-send-plus"></i> Guardar' +
    '</button>' +
    '</div>' +
    '</form>' +
    '</div>' +
    //

    //Formulario Actualizar
    '<div class="col-6" id="editarModal' + titulos['IDSDIVS'] + '" style="display:none">' +
    '<p>Actualizar registro:</p>' +
    '<form class="row" id="formEditar' + titulos['IDSDIVS'] + '">';

  //LABELS
  for (const key in formLabels) {
    if (Object.hasOwnProperty.call(formLabels, key)) {
      const input = formLabels[key];
      html += '<div class="col-12">' +
        '<label for="' + input['STRING'] + '" class="form-label">' + input['LABEL'] + '</label>' +
        '<input type="text" name="' + input['STRING'] + '" required id="edit-' + formLabels['DESCRIPCION']['STRING'] + '-input" class="form-control input-form">' +
        '</div>';
    }
  }

  //Botones
  html += '<div class="text-center">' +
    '<button type="submit" class="btn btn-hover me-2" style="margin-bottom:4px">' +
    '<i class="bi bi-pencil-square"></i> Actualizar' +
    '</button>' +
    '<button type="button" class="btn btn-hover btn-activo me-2" style="margin-bottom:4px; display: none" id="desactivar-' + titulos['IDSDIVS'] + '">' +
    '<i class="bi bi-collection"></i> Desactivar' +
    '</button>' +
    '<button type="button" class="btn btn-hover btn-activo me-2" style="margin-bottom:4px; display: none" id="activar-' + titulos['IDSDIVS'] + '">' +
    '<i class="bi bi-collection"></i> Activar' +
    '</button>' +
    '</div>' +
    '</form>' +
    '</div>' +
    //

    '</div>' + // Etiquetas de cierres
    '</div>';

  //Footer
  html += '<div class="modal-footer">' +
    '<button type="button" class="btn btn-cancelar" data-bs-dismiss="modal"><i class="bi bi-arrow-left-short"></i>' +
    'Cerrar</button>' +
    '</div>' +
    '</div>' +
    '</div>' +
    '</div>';

  //Crea el html en DOM
  //console.log($(divContenedor))
  $(divContenedor).html(html);

}


function getTableControlador(tagTable, CONTENT, id_primario, formLabels, configTable, ajax, createdRow, columnsData, columnsDefData) {
  let TablaContenido = $(tagTable['table_id']).DataTable({
    processing: configTable['processing'],
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
      loadingRecords: '&nbsp;',
      processing: '<div class="spinner"></div>'
    },
    lengthMenu: [
      [5, 10, -1],
      [5, 10, "All"]
    ],
    autoWidth: configTable['autoWidth'],
    searching: configTable['searching'],
    lengthChange: configTable[''],
    info: configTable['info'],
    paging: configTable['paging'],
    scrollY: configTable['scrollY'],
    scrollCollapse: configTable['scrollCollapse'],
    ajax: {
      dataType: 'json',
      data: ajax['data'],
      method: 'POST',
      url: http + servidor + "/" + appname + "/api/" + ajax['api_url'] + ".php",
      beforeSend: function () { },
      // success: function (data) { mensajeAjax(data) },
      complete: function () {
        cambiarFormMetodo(0, `${CONTENT['titulos']['IDSDIVS']}`, `formEditar${CONTENT['titulos']['IDSDIVS']}`);
      },
      dataSrc: ajax['dataSrc']
    },
    createdRow: function (row, data, dataIndex) {
      // mensajeAjax(data)
      if (data[createdRow['IDCOMPARADOR']] == createdRow['VALUE']) {
        $(row).addClass(createdRow['CLASSTRUE']);
      } else {
        $(row).addClass(createdRow['CLASSFALSE']);
      }
    },
    columns: columnsData,
    columnDefs: columnsDefData,

  });


  selectDatatabledblclick(function (select, dataSelect) {
    //console.log(dataSelect);
    // var dataSelect = data;
    $('.btn-activo').fadeOut()
    $('.btn-activo').prop('disabled', true);
    if (!select) {
      cambiarFormMetodo(0, `${CONTENT['titulos']['IDSDIVS']}`, `formEditar${CONTENT['titulos']['IDSDIVS']}`);
    } else {
      switch (dataSelect.ACTIVO) {
        case 1: case '1': case '<i class="bi bi-check-circle"></i>':
          $('#desactivar-' + tagTable['titulo']).fadeIn(100);
          setTimeout(() => {
            $('#desactivar-' + tagTable['titulo']).prop('disabled', false);
          }, 100);
          break;
        case 0: case '0': case '<i class="bi bi-x-circle"></i>':
          $('#activar-' + tagTable['titulo']).fadeIn(100);
          setTimeout(() => {
            $('#activar-' + tagTable['titulo']).prop('disabled', false);
          }, 100);
          break;
      }
      document.getElementById("edit-" + formLabels['DESCRIPCION']['STRING'] + "-input").value = dataSelect['DESCRIPCION'];
      cambiarFormMetodo(1, tagTable['titulo']);
    }
  }, tagTable['table_id'], TablaContenido)
  let modal = $('#modalVista' + tagTable['titulo']);
  //console.log('#modalVista' + tagTable['titulo'])
  modal.on('shown.bs.modal', function (e) {
    //console.log('si');
    TablaContenido.ajax.reload();
    $.fn.dataTable
      .tables({
        visible: true,
        api: true
      })
      .columns.adjust();
  })
  $("#formRegistrar" + CONTENT['titulos']['IDSDIVS']).submit(function (event) {
    event.preventDefault();
    /*DATOS Y VALIDACION DEL REGISTRO*/
    var form = document.getElementById("formRegistrar" + CONTENT['titulos']['IDSDIVS']);
    var formData = new FormData(form);
    formData.set('api', ajax['registrar']['data']['api']);

    alertMensajeConfirm({
      title: '¿Está seguro que todos los datos están correctos?',
      text: "No podrá eliminar el registro",
      icon: 'warning'
    }, function () {
      $.ajax({
        data: formData,
        url: http + servidor + "/" + appname + "/api/" + ajax['registrar']['api_url'] + ".php",
        type: "POST",
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (data) {
          if (mensajeAjax(data)) {
            alertToast('¡' + firstMayus(CONTENT['titulos']['titulo']) + ' registrado!', 'success')
            document.getElementById("formRegistrar" + CONTENT['titulos']['IDSDIVS']).reset();
            TablaContenido.ajax.reload();
            cambiarFormMetodo(0, `${CONTENT['titulos']['IDSDIVS']}`, `formEditar${CONTENT['titulos']['IDSDIVS']}`);
            // selectMetodo()
          }
        },
        error: function (jqXHR, exception, data) {
          alertErrorAJAX(jqXHR, exception, data)
        },
      });
    }, 1)
    event.preventDefault();
  });


  //Formulario de actualizar cargo
  $("#formEditar" + CONTENT['titulos']['IDSDIVS']).submit(function (event) {
    event.preventDefault();
    /*DATOS Y VALIDACION DEL REGISTRO*/
    var form = document.getElementById("formEditar" + CONTENT['titulos']['IDSDIVS']);
    var formData = new FormData(form);
    formData.set(id, dataSelect[`${id_primario}`])
    formData.set('api', ajax['editar']['data']['api']);

    alertMensajeConfirm({
      title: '¿Está seguro de cambiar la descripcion?',
      text: "¡Se cambiará en todas las vistas!",
      icon: 'warning'
    }, function () {
      //$("#btn-registrarse").prop('disabled', true);
      // Esto va dentro del AJAX
      $.ajax({
        data: formData,
        url: http + servidor + "/" + appname + "/api/" + ajax['editar']['api_url'] + ".php",
        type: "POST",
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (data) {
          if (mensajeAjax(data)) {
            alertToast('¡' + firstMayus(titulos['titulo']) + ' actualizado!', 'success')
            document.getElementById("formEditar" + CONTENT['titulos']['IDSDIVS']).reset();
            TablaContenido.ajax.reload();
            cambiarFormMetodo(0, `${CONTENT['titulos']['IDSDIVS']}`, `formEditar${CONTENT['titulos']['IDSDIVS']}`);
            // selectMetodo()
          }
        },
        error: function (jqXHR, exception, data) {
          alertErrorAJAX(jqXHR, exception, data)
        },
      });
    }, 1)
    event.preventDefault();
  });

  //Desactivar valor
  $('#desactivar-' + CONTENT['titulos']['IDSDIVS']).click(function () {
    if (dataSelect != null) {
      alertMensajeConfirm({
        title: "¿Está seguro que desea desactivar este registro?",
        text: "No podrán volver a elegir el registro",
        icon: 'warning',
      }, function () {
        $.ajax({
          data: {
            id: dataSelect[`${id_primario}`],
            api: ajax['desactivar']['data']['api'],
            ACTIVO: 0
          },
          url: http + servidor + "/" + appname + "/api/" + ajax['desactivar']['api_url'] + ".php",
          type: "POST",
          dataType: 'json',
          success: function (data) {
            if (mensajeAjax(data)) {
              alertToast('¡' + firstMayus(titulos['titulo']) + ' eliminado!', 'success')
              document.getElementById("formEditar" + CONTENT['titulos']['IDSDIVS']).reset();
              TablaContenido.ajax.reload();
              cambiarFormMetodo(0, `${CONTENT['titulos']['IDSDIVS']}`, `formEditar${CONTENT['titulos']['IDSDIVS']}`);
            }
          },
          error: function (jqXHR, exception, data) {
            alertErrorAJAX(jqXHR, exception, data)
          },
        });
      }, 1)
    } else {
      alertSelectTable();
    }
  })

  //Desactivar valor
  $('#activar-' + CONTENT['titulos']['IDSDIVS']).click(function () {
    if (dataSelect != null) {
      alertMensajeConfirm({
        title: "¿Está seguro que desea desactivar este registro?",
        text: "No podrán volver a elegir el registro",
        icon: 'warning',
      }, function () {
        $.ajax({
          data: {
            id: dataSelect[`${id_primario}`],
            api: ajax['desactivar']['data']['api'],
            ACTIVO: 1
          },
          url: http + servidor + "/" + appname + "/api/" + ajax['desactivar']['api_url'] + ".php",
          type: "POST",
          dataType: 'json',
          success: function (data) {
            if (mensajeAjax(data)) {
              alertToast('¡' + firstMayus(titulos['titulo']) + ' eliminado!', 'success')
              document.getElementById("formEditar" + CONTENT['titulos']['IDSDIVS']).reset();
              TablaContenido.ajax.reload();
              cambiarFormMetodo(0, `${CONTENT['titulos']['IDSDIVS']}`, `formEditar${CONTENT['titulos']['IDSDIVS']}`);
            }
          },
          error: function (jqXHR, exception, data) {
            alertErrorAJAX(jqXHR, exception, data)
          },
        });
      }, 1)
    } else {
      alertSelectTable();
    }
  })
}






function vistaPDF(divContenedor, url, nombreArchivo, callback = function () { }, tipo = {}) {
  $.post(http + servidor + '/' + appname + '/vista/include/funciones/viewer-pdf.php', {
    url: url, nombreArchivo: nombreArchivo, tipo: tipo
  }, function (html) {
    $(divContenedor).html(html);
  }).done(async function () {
    callback()
  })
  // let htmlPDF = '<div id="adobe-dc-view" style="height: 100%"></div>' +
  //   '<script src="https://documentservices.adobe.com/view-sdk/viewer.js"></script>' +
  //   '<script type="text/javascript">' +
  //   'document.addEventListener("adobe_dc_view_sdk.ready", function(){ ' +
  //   'var adobeDCView = new AdobeDC.View({clientId: "cd0a5ec82af74d85b589bbb7f1175ce3", divId: "' + div + '"});' +
  //   'adobeDCView.previewFile({' +
  //   'content:{location: {url: "' + url + '"}},' +
  //   'metaData:{fileName: "' + nombreArchivo + '"}' +
  //   '});' +
  //   '});' +
  //   '</script>';
  // $(divContenedor).html(htmlPDF);
}


//Metodo global
function cambiarFormMetodo(fade, titulo, form = "formEditar") {
  if (fade == 1) {
    $('#RegistrarMetodo' + titulo).fadeOut();
    setTimeout(function () {
      $('#editarMetodo' + titulo).fadeIn();
    }, 400);
  } else {
    //console.log(form)
    document.getElementById(form).reset();
    $('#editarMetodo' + titulo).fadeOut();
    setTimeout(function () {
      $('#RegistrarMetodo' + titulo).fadeIn();
    }, 400);
  }
}

//Scroll zoom images
function ScrollZoom(container, max_scale, factor) {
  var target = container
  var size = {
    w: target.width(),
    h: target.height()
  }
  var pos = {
    x: 0,
    y: 0
  }
  var scale = 1
  var zoom_target = {
    x: 0,
    y: 0
  }
  var zoom_point = {
    x: 0,
    y: 0
  }
  var curr_tranform = target.css('transition')
  var last_mouse_position = {
    x: 0,
    y: 0
  }
  var drag_started = 0

  target.css('transform-origin', '0 0')
  target.on("mousewheel DOMMouseScroll", scrolled)
  target.on('mousemove', moved)
  target.on('mousedown', function () {
    drag_started = 1;
    target.css({
      'cursor': 'move',
      'transition': 'transform 0s'
    });
    /* Save mouse position */
    last_mouse_position = {
      x: event.pageX,
      y: event.pageY
    };
  });

  target.on('mouseup mouseout', function () {
    drag_started = 0;
    target.css({
      'cursor': 'default',
      'transition': curr_tranform
    });
  });

  function scrolled(e) {
    var offset = container.offset()
    zoom_point.x = e.pageX - offset.left
    zoom_point.y = e.pageY - offset.top

    e.preventDefault();
    var delta = e.delta || e.originalEvent.wheelDelta;
    if (delta === undefined) {
      //we are on firefox
      delta = e.originalEvent.detail;
    }
    delta = Math.max(-1, Math.min(1, delta)) // cap the delta to [-1,1] for cross browser consistency

    // determine the point on where the slide is zoomed in
    zoom_target.x = (zoom_point.x - pos.x) / scale
    zoom_target.y = (zoom_point.y - pos.y) / scale

    // apply zoom
    scale += delta * factor * scale
    scale = Math.max(1, Math.min(max_scale, scale))

    // calculate x and y based on zoom
    pos.x = -zoom_target.x * scale + zoom_point.x
    pos.y = -zoom_target.y * scale + zoom_point.y

    update()
  }

  function moved(event) {
    if (drag_started == 1) {
      var current_mouse_position = {
        x: event.pageX,
        y: event.pageY
      };
      var change_x = current_mouse_position.x - last_mouse_position.x;
      var change_y = current_mouse_position.y - last_mouse_position.y;

      /* Save mouse position */
      last_mouse_position = current_mouse_position;
      //Add the position change
      pos.x += change_x;
      pos.y += change_y;

      update()
    }
  }

  function update() {
    // Make sure the slide stays in its container area when zooming out
    if (pos.x > 0)
      pos.x = 0
    if (pos.x + size.w * scale < size.w)
      pos.x = -size.w * (scale - 1)
    if (pos.y > 0)
      pos.y = 0
    if (pos.y + size.h * scale < size.h)
      pos.y = -size.h * (scale - 1)

    target.css('transform', 'translate(' + (pos.x) + 'px,' + (pos.y) + 'px) scale(' + scale + ',' + scale + ')')
  }
}

//Servicios en cargar estudios con popper

function cargarServiciosEstudios(button, tooltip, servicio_id) {

  const arrow = $('#arrow');

  const popperInstance = Popper.createPopper(button, tooltip, {
    placement: 'right',
    options: {
      element: arrow,
    },
    modifiers: [
      {
        name: 'offset',
        options: {
          offset: [0, 20],
        },
      },
    ],
  });

  function show() {
    tooltip.setAttribute('data-show', '');
    popperInstance.update();

    ajaxAwait({
      api: 0,
      id: servicio_id
    }, "servicios_api", { callbackAfter: true }, false, function (data) {

    })

  }

  function hide() {
    tooltip.removeAttribute('data-show');
  }

  const showEvents = ['mouseenter', 'focus'];
  const hideEvents = ['mouseleave', 'blur'];

  showEvents.forEach((event) => {
    $(button).on(event, show);
  });

  hideEvents.forEach((event) => {
    $(button).on(event, hide);
  });
}


//Funcion para crear un tooltip grande
function popperHover(container = 'ID_CLASS', tooltip = 'ID_CLASS', callback = (show_hide) => { }, config = { directShow: false }) {

  $(tooltip).append(`<div id="arrow" class="arrow" data-popper-arrow></div>`);
  const arrow = $('#arrow'); // Siempre Introducir un arrow

  const reference = $(container)[0];
  const popper = $(tooltip)[0];

  let popperInstance = null;
  let timeoutId = null;

  function createPopper() {
    popperInstance = Popper.createPopper(reference, popper, {
      placement: 'right-start',
      modifiers: [
        {
          name: 'offset',
          options: {
            offset: [0, 20],
          },
        },
      ],
    });
  }

  function destroyPopper() {
    if (popperInstance) {
      popperInstance.destroy();
      popperInstance = null;
    }
  }

  function show() {
    if (!popperInstance) {
      createPopper();
    }

    $(document).on('click', hide);
    tooltip.setAttribute('data-show', '');
    popperInstance.update();

    // Iniciar temporizador para retrasar el callback
    timeoutId = setTimeout(() => {
      callback(true);
    }, 1000); // Cambia el valor de 500 a la cantidad de milisegundos que desees como retraso antes de ejecutar el callback
  }

  function hide(event) {
    if (!$(event.target).closest(container).length) {
      $(document).off('click', hide);
      tooltip.removeAttribute('data-show');
      destroyPopper();

      // Cancelar el temporizador si el usuario sale antes de que se ejecute el callback
      clearTimeout(timeoutId);
      callback(false);
    }
  }

  function leave(event) {
    if (!$(event.target).closest(container).length) {
      $(document).off('click', leave);

      // Cancelar el temporizador si el usuario sale antes de que se ejecute el callback
      clearTimeout(timeoutId);
      callback(false);
    }
  }

  $(container).on('click', hide);
  $(container).on('mouseenter', show);
  $(container).on('mouseleave', hide);
}



function validarCuestionarioEspiro() {
  // return new Promise(function (resolve) {

  situacion1 = '#no_aplica1'
  situacion1 = $(situacion1).is(':checked');

  let situacion2 = '#no_aplica2'
  situacion2 = $(situacion2).is(':checked');


  if (!detectPreguntasNivel('.independiente')) {
    // resolve(true);
    return true;
  }

  console.log(situacion2)

  if (!situacion2) {
    if (!detectPreguntasNivel('.situaciones2')) {
      // resolve(true);
      return true;
    }
  }

  if (!situacion1) {
    if (!detectPreguntasNivel('.situaciones1')) {
      // resolve(true);
      return true;
    }
  }


  // resolve(false);
  return false;
  // })
}


function detectPreguntasNivel(situacion) {
  let hasUnansweredQuestion = false; // Variable auxiliar para indicar si hay una pregunta sin contestar

  // let label = $('.titulo')[0];
  // label.scrollIntoView({ behavior: 'smooth', block: 'center' });

  $(situacion).each(function () {
    let hasChecked = $(this).find('input[type="checkbox"], input[type="radio"]').is(':checked');
    let preguntaElement = $(this).find('.titulo')[0];

    if (!hasChecked) {
      //Scroll
      scrollContentInView(preguntaElement)
      hasUnansweredQuestion = true; // Establecer la variable auxiliar en true
      return false; // Salir del each()
    }

    // Si también necesitas comprobar otras condiciones, puedes hacerlo aquí

  });

  return !hasUnansweredQuestion; // Retornar el valor invertido de la variable auxiliar
}

//para formulario  de espiro
function scrollContentInView(pregunta) {
  pregunta.scrollIntoView({ behavior: 'smooth', block: 'center' });

  $(pregunta).css('border-bottom', '2px solid red');


  setTimeout(() => {
    $(pregunta).animate({
      marginLeft: '10px'
    }, 100, function () {
      $(this).animate({
        marginLeft: '-10px'
      }, 100, function () {
        $(this).animate({
          marginLeft: '0'
        }, 100);
      });
    });
  }, 500);

}