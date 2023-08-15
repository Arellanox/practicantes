tablaListaPaciente = $('#TablaLaboratorio').DataTable({
  language: {
    url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
  },
  lengthChange: false,
  info: false,
  paging: false,
  scrollY: '73vh',
  scrollCollapse: true,
  ajax: {
    dataType: 'json',
    data: function (d) {
      return $.extend(d, dataListaPaciente);
    },
    method: 'POST',
    url: '../../../api/turnos_api.php',
    beforeSend: function () {
      loader("In")
    },
    complete: function () {
      loader("Out", 'bottom')
      //Para ocultar segunda columna
      reloadSelectTable()
    },
    dataSrc: 'response.data'
  },
  createdRow: function (row, data, dataIndex) {
    if (data.CONFIRMADO == 1) {
      $(row).addClass('bg-success text-white');
    } else {
      $(row).addClass('bg-warning');
    }
  },
  columns: [
    { data: 'COUNT' },
    { data: 'NOMBRE_COMPLETO' },
    { data: 'PREFOLIO' },
    { data: 'CLIENTE' },
    { data: 'SEGMENTO' },
    { data: 'turno' },
    { data: 'GENERO' },
    { data: 'EXPEDIENTE' },
    // {defaultContent: 'En progreso...'}
  ],
  columnDefs: [
    { "width": "10px", "targets": 0 },
  ],

})
loaderDiv("Out", null, "#loader-Lab", '#loaderDivLab');

selectTable('#TablaLaboratorio', tablaListaPaciente, { unSelect: true, movil: true, reload: ['col-xl-8'] }, async (selectTR, array, callback) => {
  // selectDatatable('TablaLaboratorio', tablaListaPaciente, 0, 0, 0, 0, function (selectTR = null, array = null) {
  selectListaLab = array;
  if (selectTR == 1) {
    try {

      await obtenerPanelInformacion(selectListaLab['ID_TURNO'], 'pacientes_api', 'paciente', '#panel-informacion', '_lab', 6)
      await generarHistorialResultados(selectListaLab['ID_PACIENTE'])
      await generarFormularioPaciente(selectListaLab['ID_TURNO'])

      if (selectListaLab.CONFIRMADO == 1) {
        $('button[type="submit"][form="formAnalisisLaboratorio"]').prop('disabled', true)
        $('#formAnalisisLaboratorio :input').prop('disabled', true)
      } else {
        $('button[type="submit"][form="formAnalisisLaboratorio"]').prop('disabled', false)
        $('#formAnalisisLaboratorio :input').prop('disabled', false)
      }


    } catch (error) {
      console.log(error)
      alertMensaje('warning', 'Hubo un error', 'Hubo un error al recuperar los datos del paciente, contacte con los coordinadores de TI')
    }
    callback('In')
  } else {
    callback('Out')
  }
})

inputBusquedaTable('TablaLaboratorio', tablaListaPaciente, [{
  msj: 'Una vez confirmado el reporte, el registro se dibujará en verde',
  place: 'top'
}], [], 'col-12')

function generarHistorialResultados(id) {
  return new Promise(resolve => {
    // $('#accordionResultadosAnteriores').html('')
    $.ajax({
      url: `${http}${servidor}/${appname}/api/turnos_api.php`,
      type: "POST",
      dataType: 'json',
      data: {
        id_paciente: id,
        api: 6,
        id_area: areaActiva
      },
      success: function (data) {
        row = data.response.data;
        // console.log("Haciendo el historial de resultados")
        // console.log(data.response.data)
        // console.log(row)
        let itemStart = '<div class="accordion-item bg-acordion">';
        let itemEnd = '</div>';

        let bodyStart = '<div class="accordion-body">' +
          '<div class="row">';
        let bodyEnd = '</div>' +
          '</div>';
        let html = '';

        for (var i = 0; i < row.length; i++) {
          html += itemStart;
          html += '<h2 class="accordion-header" id="collap-historial-estudios' + i + '">' +
            '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-estudio' + i + '-Target" aria-expanded="false" aria-controls="accordionEstudios">' +
            '<div class="row">' +
            '<div class="col-12">' +
            '<i class="bi bi-box-seam"></i> &nbsp;&nbsp;&nbsp; Cargado: <strong>' + row[i]['NOMBRE_COMPLETO'] + '</strong>' +
            '</div>' +
            '<div class="col-12">' +
            '<i class="bi bi-calendar3"></i> &nbsp;&nbsp;&nbsp; Fecha: <strong>' + formatoFecha2(row[i]['FECHA_CONFIRMADO']) + '</strong> ' + //<strong>12:00 '+i+'</strong>
            '</div>' +
            '</div>' +
            '</button>' +
            '</h2>' +
            '<div id="collapse-estudio' + i + '-Target" class="accordion-collapse collapse overflow-auto" aria-labelledby="collap-historial-estudios' + i + '" style="max-height: 70vh"> ';
          html += '<p class="none-p" style="margin: 12px 0px 0px 15px;">Ver <a class="" href="' + row[i]['RUTA_REPORTE'] + '" target="_blank" data-bs-id="' + row[i]['ID_TURNO '] + '">RESULTADO</a> aquí</p>';
          html += bodyStart;
          for (var k in row[i]['servicios']) {
            // console.log(k)
            html += '<div class="col-8 text-start info-detalle"><p>' + row[i]['servicios'][k]['SERVICIO'] + ':</p></div><div class="col-4 text-start d-flex align-items-center">' + row[i]['servicios'][k]['RESULTADO'] + ' ' + row[i]['servicios'][k]['MEDIDA_ABREVIATURA'] + '</div> <hr style="margin: 3px"/>'; //
          }
          // for (var l = 0; l < row[i]['servicios'].length; l++) {
          //   html += '<div class="col-8 text-start info-detalle"><p>' + row[i]['servicios'][l]['SERVICIO'] + ':</p></div><div class="col-4 text-start d-flex align-items-center">' + row[i]['servicios'][l]['RESULTADO'] + ' ' + row[i]['servicios'][l]['MEDIDA_ABREVIATURA'] + '</div> <hr style="margin: 3px"/>'; //
          // }
          html += bodyEnd + '</div>';
          html += itemEnd;
        }
        $('#accordionResultadosAnteriores').html(html);

      },
      complete: function () {
        resolve(1);
      }
    });
  });
}

function generarFormularioPaciente(id) {
  return new Promise(resolve => {
    // $('#accordionResultadosAnteriores').html('')
    $.ajax({
      url: `${http}${servidor}/${appname}/api/turnos_api.php`,
      type: "POST",
      dataType: 'json',
      data: {
        id_turno: id,
        api: 8,
        id_area: areaActiva,
        tipo: 1
      },
      success: function (data) {
        $('#formulario-estudios').html('')
        data = data.response.data;

        let colStart = '<div class="col-12 col-lg-6">';
        let endDiv = '</div>';
        let colreStart = '<div class="col-12 col-lg-6 d-flex justify-content-end align-items-center">';
        let html = '';



        // <ul class = "list-group m-4 overflow-auto hover-list info-detalle"
        // style = "max-width: 100%; max-height: 70vh;margin-bottom:10px;"
        // id = "list-group-form-resultado-laboro" >

        //   </ul>

        //Lee cada grupo
        for (var i = 0; i < data.length; i++) {
          // console.log('FOR')
          let row = data[i]

          //Biomolecular 
          let kitDiag = null;
          resultado = {
            0: {
              'descripcion': 'NEGATIVO',
            },
            1: {
              'descripcion': 'POSITIVO',
            }
          }

          //Clinico
          let Tipo = '';

          // equipo = {
          //   0: {

          //   }
          // }

          //Creo valores por defecto para Biomolecular
          switch (row['ID_GRUPO']) {
            case '685': case '684': // <-- PCR -->
              kitDiag = {
                0: {
                  'descripcion': 'CoviFlu Kit Multiplex',
                  'clave': 'DGE-DSAT-01498-2021'
                },
                1: {
                  'descripcion': 'DeCoV19 Kit Triplex',
                  'clave': 'DGE-DSAT-02874-2020'
                }
              }
              classSelect = 'selectTipoMuestraPCR';
              muestras = {
                0: {
                  'descripcion': 'NASOFARINGEO',
                },
                1: {
                  'descripcion': 'FARÍNGEA',
                },
                2: {
                  'descripcion': 'NASAL',
                },
                3: {
                  'descripcion': 'LAVADO BRONQUEOALVEOLAR',
                },
                4: {
                  'descripcion': 'HISOPADO NASOFARÍNGEO'
                }
              }
              break;

            case '697': // <-- ANTIGENO -->
              muestras = {
                0: {
                  'descripcion': 'HISOPADO NASAL',
                }
              }
              classSelect = 'selectTipoAntigeno';
              break;

            case '698': // <-- VPH -->
              kitDiag = {
                0: {
                  'descripcion': 'GeneProof para el virus del papiloma humano (VPH)',
                  'clave': '2002R2019 SSA'
                }
              }
              classSelect = 'selectTipoMuestraVPH';
              muestras = {
                0: {
                  'descripcion': 'CERVICAL',
                },
                1: {
                  'descripcion': 'ANAL'
                },
                2: {
                  'descripcion': 'URETRAL'
                },
                3: {
                  'descripcion': 'LBC'
                },
                4: {
                  'descripcion': 'HISOPADO NASOFARÍNGEO'
                }
              }
              break;

            case '709': // <-- PANEL21 -->
              kitDiag = {
                0: {
                  'descripcion': 'FTD™ Respiratory Pathogens 21',
                  'clave': 'N/A'
                }
              }
              classSelect = 'selectTipoMuestraPanel21';
              muestras = {
                0: {
                  'descripcion': 'HISOPADO NASOFARÍNGEO',
                },
                1: {
                  'descripcion': 'FARÍNGEA',
                }
              }
              break;
            case '743':
              classSelect = 'selectTipoMuestraCitologia';
              muestras = {
                0: {
                  'descripcion': 'CERVICAL',
                },
                1: {
                  'descripcion': 'ANAL'
                },
                2: {
                  'descripcion': 'URETRAL'
                },
                3: {
                  'descripcion': 'LBC'
                }
              }

              break;

            case '980': // <!-- rT-PCR-ETS -->
              classSelect = 'selectTipoMuestraETS';
              kitDiag = {
                0: {
                  'descripcion': 'FTD STD9 Multiplex',
                  'clave': ''
                }
              }
              muestras = {
                0: {
                  'descripcion': 'CERVICAL',
                },
                1: {
                  'descripcion': 'ANAL'
                },
                2: {
                  'descripcion': 'URETRAL'
                },
                3: {
                  'descripcion': 'LBC'
                },
                4: {
                  'descripcion': 'HISOPADO NASOFARÍNGEO'
                }
              }
              break;
            case '972': case '973':
              //Sin cambios
              break;
            case '1074':
              kitDiag = {
                0: {
                  'descripcion': 'FTD Fiebre Tropical Multiplex',
                  'clave': ''
                }
              }
              classSelect = 'selectTipoMuestraFTD';
              muestras = {
                0: {
                  'descripcion': 'SUERO',
                },
                1: {
                  'descripcion': 'PLASMA',
                },
                2: {
                  'descripcion': 'SANGRE TOTAL',
                },
                3: {
                  'descripcion': 'EXUDADO NASOFARÍNGEO',
                }
              }

            //Laboratorio Clinico
            case '1':
              Tipo = '_BH'
              break;
            default: input = null;
              if (areaActiva == 12) {
                alert('El paciente no tiene estudios compatibles, hay un problema con la compatibilidad de los estudios con biomolecular, presente el error con el area de TI para solucionar este problema con el  paciente');
              }
              break;
          }










          // console.log(row)
          var count = Object.keys(row).length;
          // console.log(count);
          html += '<ul class = "list-group hover-list info-detalle mt-3" style="padding: 3px;" >';
          html += '<div style = "margin-bottom: 10px; display: block"><div style="border-radius: 8px;margin:0px;background: rgb(0 0 0 / 5%);width: 100%;padding: 10px 0px 10px 0px;text-align: center;""><h4 style="font-size: 20px !important;font-weight: 600 !important;padding: 0px;margin: 0px;">' + row['NombreGrupo'] + '</h4> <p>' + row['CLASIFICACION'] + '</p> </div></div>';
          for (var k in row) { //Empieza cada estudio del grupo
            // console.log(k, row[k])
            let inputname = getRandomInt(1000000000000);
            if (Number.isInteger(parseInt(k))) {
              // console.log(2)
              html += '<li class="list-group-item" style="zoom: 95%">';
              html += '<div class="row d-flex align-items-center">';


              //Formulario
              //Configuracion por ID_SERVICIO
              let nameInput = `servicios[${inputname}][RESULTADO]`;
              let onlyLabel = false;
              let anotherValue = '';
              let anotherInput = null;
              let anotherClassInput = null;
              let anotherAttr = '';

              let anotherClassInputAbsoluto = '';
              let typeInput = '';
              switch (row[k]['ID_SERVICIO']) {
                case '686': case '687': case '688':
                  anotherValue = 'NEGATIVO'; break;

                case '690': case '699': case '702': case '726': case '727': case '728':
                case '703': case '704': case '705': case '711': case '712': case '732':
                case '713': case '714': case '716': case '717': case '718': case '731':
                case '719': case '721': case '722': case '723': case '733': case '730':
                case '725': case '744':
                //ETS

                case '981': case '982': case '983': case '984': case '985': case '986': case '987': case '988': case '989':
                // los siguientes FTD
                case '1075': case '1076': case '1077': case '1078': case '1079': case '1080':
                case '1081':
                  anotherInput = crearSelectCamposMolecular(resultado, nameInput, row[k]['RESULTADO']); break;

                case '710': case '715': case '720': case '724': case '729':
                  onlyLabel = true; break;

                //FTD KIT DIAGNOSTICO
                case '1082': anotherValue = 'TF22-64-09R'; break;

                case '694': anotherValue = 'KCFMP110123'; break; // <-- PCR -->
                case '737': anotherValue = 'E160-22071101'; break; // <-- PANEL RESPIRATORIO POR PCR -->

                case '692': case '706': case '734': case '991': case '1083':
                  anotherInput = crearSelectCamposMolecular(kitDiag, nameInput, row[k]['RESULTADO'], ifnull(classSelect)); break;
                case '693': case '707': case '735': case '992':
                  anotherValue = ifnull(kitDiag[0]['clave']); anotherClassInput = 'ClaveAutorizacion'; anotherAttr = 'disabled'; break;

                case '743':
                  anotherValue = ifnull(row[k]['RESULTADO'], 'A QUIEN CORRESPONDA')
                  break;

                case '695': case '700': case '708': case '736': case '756': case '994': case '1084':
                  anotherInput = crearSelectCamposMolecular(muestras, nameInput, row[k]['RESULTADO']); break;

                //Laboratorio Clinico:
                case '70':
                  anotherClassInput = `LEUCOCITOS_VALUE${Tipo}`;
                  // typeInput = 'number'
                  break;

                case '71': case '72': case '73': case '74': case '75': case '76': case '77': case '78': case '79':
                  // typeInput = 'number'
                  anotherClassInput = `VALOR_ABSOLUTO${Tipo}`;
                  anotherClassInputAbsoluto = `RESULTADO_ABSOLUTO${Tipo}`;
                  break;
                default: anotherValue = ''; break;
              }
              //

              if (!onlyLabel) {
                html += colStart;
                html += '<p><i class="bi bi-box-arrow-in-right" style=""></i> ' + row[k]['DESCRIPCION_SERVICIO'] + '</p>';
                html += endDiv;
                html += colreStart;
                html += '<div class="input-group">';

                if (anotherInput) {
                  html += anotherInput;
                  html += `<input type="text" style="display: none" name="servicios[${inputname}][ID_GRUPO]" value="${row['ID_GRUPO']}">`
                  html += `<input type="text" style="display: none" name="servicios[${inputname}][ID_SERVICIO]" value="${row[k]['ID_SERVICIO']}">`
                } else {
                  html += `<input type="text" style="display: none" name="servicios[${inputname}][ID_GRUPO]" value="${row['ID_GRUPO']}">`
                  html += `<input type="text" style="display: none" name="servicios[${inputname}][ID_SERVICIO]" value="${row[k]['ID_SERVICIO']}">`
                  html += `<input class="form-control input-form text-end inputFormRequired ${anotherClassInput}" ${anotherAttr} name="servicios[${inputname}][RESULTADO]" value="` + ifnull(row[k]['RESULTADO'], anotherValue) + `" type="${ifnull(typeInput, 'text')}" autocomplete="off" >`;
                }




                if (row[k]['MEDIDA']) {
                  if ((row[k]['TIENE_VALOR_ABSOLUTO'] == 1)) {
                    html += '<span class="input-span">%</span>';
                  } else {
                    html += '<span class="input-span">' + row[k]['MEDIDA'] + '</span>';
                  }
                }

                html += '</div>';
                html += endDiv;

                //Valor Absoluto
                if (row[k]['TIENE_VALOR_ABSOLUTO'] == 1) {
                  html += colStart;
                  html += '<p  style="padding-left: 40px;"><i class="bi bi-box-arrow-in-right"></i> Valor absoluto</p>';
                  html += endDiv;
                  html += colreStart;
                  html += '<div class="input-group">';

                  html += `<input type="${ifnull(typeInput, 'text')}" class="form-control input-form text-end inputFormRequired ${anotherClassInputAbsoluto}" name="servicios[${inputname}][VALOR]" value="${ifnull(row[k]['VALOR_ABSOLUTO'])}" autocomplete="off">`;

                  if (row[k]['MEDIDA_ABS']) {
                    html += '<span class="input-span">' + row[k]['MEDIDA_ABS'] + '</span>';
                  }

                  html += '</div>';
                  html += endDiv;
                }

              } else {
                html += '<div class="col-12 col-lg-12 text-center">';
                html += '<p style="font-size: 19px; font-wieght: bolder">' + row[k]['DESCRIPCION_SERVICIO'] + '</p>';
                html += `<input type="text" style="display: none" name="servicios[${inputname}][ID_GRUPO]" value="${row['ID_GRUPO']}">`
                html += `<input type="text" style="display: none" name="servicios[${inputname}][ID_SERVICIO]" value="${row[k]['ID_SERVICIO']}">`
                html += `<input type="text" style="display: none" name="servicios[${inputname}][RESULTADO]" value="N/A">`
                html += endDiv;
              }


              html += endDiv;
              html += '</li>';

              if (row[k]['LLEVA_COMENTARIO'] == true) {
                html += `<div class="d-flex justify-content-center"><div style="padding-top: 15px;"><p style = "/* font-size: 18px; */" > Observaciones:</p><textarea name="observacionesServicios[${row[k]['ID_SERVICIO']}]" rows="2;" cols="90" class="input-form" value="">${ifnull(row[k]['OBSERVACIONES'], '')}</textarea></div ></div > `;

              }
            }

          }


          if (row['ID_GRUPO'] != null) {
            if (row['OBSERVACIONES'] == null) {
              row['OBSERVACIONES'] = '';
            }
            html += '<div class="d-flex justify-content-center"><div style="padding-top: 15px;">' +
              '<p style = "/* font-size: 18px; */" > Observaciones:</p>' +
              '<textarea name="observacionesGrupos[' + row['ID_GRUPO'] + ']" rows="2;" cols="90" class="input-form">' + ifnull(row['OBSERVACIONES']) + '</textarea></div ></div > ';
          }
          html += '</ul>';

          // idsEstudios.push[data[i]['ID_SERVICIO']]
        }
        $('#formulario-estudios').html(html)
      },
      complete: function () {
        resolve(1);
      }
    });
  });
}

function crearSelectCamposMolecular(data, nameInput, valueInput, classInput = '') {


  let selectHtml = `<select name="${nameInput}" class="input-form selectMolecular ${classInput} text-end" required="">`
  for (const key in data) {
    if (Object.hasOwnProperty.call(data, key)) {
      const element = data[key];
      let optionSelect = '';
      if (valueInput == element['descripcion'])
        optionSelect = 'selected';

      console.log(valueInput == element['descripcion'])

      selectHtml += '<option value="' + element['descripcion'] + '" claveOption = "' + ifnull(element['clave']) + '" ' + optionSelect + '>' + element['descripcion'] + '</option>'
    }
  }
  selectHtml += '</select>';

  return selectHtml;
}

$(document).on('keyup', '.VALOR_ABSOLUTO_BH', function () {
  let input = $(this);
  let val = (input.val()).replace(/,/g, "");

  //Buscar el Leucocito
  let ul = $(input).closest('ul');
  let valorLeucocitos = (ul.find('li input.LEUCOCITOS_VALUE_BH').val()).replace(/,/g, "");;


  // Convierte el valor a un entero
  let val_leuco = parseInt(valorLeucocitos, 10);

  let li = $(input).closest('li');
  let input_absolut = li.find('input.RESULTADO_ABSOLUTO_BH');

  // Verifica si el valor es un número entero o una cadena de texto
  if (!isNaN(val_leuco)) {
    // El valor es un número entero
    let value = val_leuco * val / 100
    input_absolut.val(value.toLocaleString('en-US'));

  } else {
    // El valor es una cadena de texto o no se puede convertir a entero
    alertMensaje('info', 'El valor del LEUCOCITOS no es numerico', 'No se ha podido calcular')
  }


})


$(document).on('click', '.selectMolecular', function () {
  value = $(this).find(':selected').attr('claveOption')
  if (value) {
    let parent_element = $(this).closest("ul");
    input = $(parent_element).find('input[class="form-control input-form text-end inputFormRequired ClaveAutorizacion"]');
    input.val(value)
  }
  // let id = $(this).attr('data-bs-id');
  // eliminarElementoArray(id);
  // console.log(id);
  // var parent_element = $(this).closest("li[class='list-group-item']");
  // $(parent_element).remove()

});


