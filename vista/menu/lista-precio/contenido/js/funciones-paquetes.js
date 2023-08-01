async function mantenimientoPaquete() {
  $('#btn-excel-previa').attr('disabled', false)
  loader("In");
  await rellenarSelect('#seleccion-paquete', 'paquetes_api', 2, 0, 'DESCRIPCION.CLIENTE', {
    contenido: 1
  });
  tablaContenido();


  $('#seleccion-paquete').prop('disabled', false);
  $("#selectDisabled").removeClass("disable-element");
  $("#formPaqueteBotonesArea").addClass("disable-element");
  $("#formPaqueteSelectEstudio").addClass("disable-element");
  $("#informacionPaquete").addClass("disable-element");

  $('input[type=radio][name=selectChecko]:checked').prop('checked', false);
  $("#seleccion-estudio").find('option').remove().end()
  loader("Out");
}

async function contenidoPaquete(select = null) {
  loader("In");
  $('#btn-excel-previa').attr('disabled', true)
  await rellenarSelect('#seleccion-paquete', 'paquetes_api', 2, 0, 'DESCRIPCION.CLIENTE', {
    contenido: 0
  });
  $('#seleccion-paquete').prop('disabled', false);
  $("#selectDisabled").removeClass("disable-element");
  $("#formPaqueteBotonesArea").addClass("disable-element");
  $("#formPaqueteSelectEstudio").addClass("disable-element");
  $("#informacionPaquete").addClass("disable-element");

  $('input[type=radio][name=selectChecko]:checked').prop('checked', false);
  $("#seleccion-estudio").find('option').remove().end()
  tablaContenido()
}

// Agrega Un nuevo TR a la tabla de paquetes
function meterDato(DESCRIPCION, CVE, costo_total, precio_venta, CANTIDAD, ID_SERVICIO, ABREVIATURA, tablaContenidoPaquete) {
  let longitud = dataSet.length + 1;
  if (costo_total == null) {
    costo_total = 0;
  } else {
    costo_total = costo_total;
  }

  if (precio_venta == null) {
    precio_venta = 0;
  } else {
    precio_venta = precio_venta;
  }
  console.log(ID_SERVICIO)
  tablaContenidoPaquete.row.add([
    DESCRIPCION,
    CVE,
    `<div class="input-group"><input type="number" class="form-control input-form cantidad-paquete text-center" name="cantidad-paquete" placeholder="0%" value="${CANTIDAD}"><span class="input-span">ud</span></div>`,
    `<div class="costo-paquete text-center">$${costo_total}</div>`,
    `<div class="costototal-paquete text-center">$${costo_total}</div>`, null,
    `<div class="precioventa-paquete text-center">$${precio_venta}</div>`,
    `<div class="subtotal-paquete text-center">$0</div>`, ID_SERVICIO
  ]).draw();
  // $('#TablaListaPaquetes tbody').append(html);


}




// Calular toda la tabla y filas
function calcularFilasTR() {
  subtotalCosto = 0, subtotalPrecioventa = 0, iva = 0, total = 0;
  var paqueteEstudios = new Array();
  try {
    $('#TablaListaPaquetes tbody tr').each(function () {
      tabledata = tablaContenidoPaquete.row(this).data();


      var arregloEstudios = new Array();
      let id_servicio;
      let calculo = caluloFila(this)
      subtotalCosto += calculo[0];
      subtotalPrecioventa += calculo[1];
      id_servicio = tabledata[8]
      arregloEstudios = {
        'id': id_servicio,
        'cantidad': calculo[2],
        'costo': calculo[3],
        'costototal': calculo[0],
        'precioventa': calculo[4],
        'subtotal': calculo[1]
      }
      // console.log(arregloEstudios)
      paqueteEstudios.push(arregloEstudios)
    });
  } catch (error) {

  }
  // console.log(paqueteEstudios);
  iva = (subtotalPrecioventa * 16) / 100;
  total = subtotalPrecioventa + iva;
  console.log(subtotalCosto)
  if (!checkNumber(subtotalCosto)) {
    subtotalCosto = 0;
  } else {
    subtotalCosto = subtotalCosto;
  }
  if (!checkNumber(subtotalPrecioventa)) {
    subtotalPrecioventa = 0;
  } else {
    subtotalPrecioventa = subtotalPrecioventa;
  }
  if (!checkNumber(total)) {
    total = 0;
  } else {
    total = total;
  }
  $('#subtotal-costo-paquete').html('$' + subtotalCosto.toFixed(2));
  $('#subtotal-precioventa-paquete').html('$' + subtotalPrecioventa.toFixed(2));
  $('#total-paquete').html(`$${total.toFixed(2)}`);
  paqueteEstudios.push({
    'total': total,
    'subtotal-costo': subtotalCosto,
    'subtotal.precioventa': subtotalPrecioventa,
    'iva': iva,
    'id_paquete': $('#seleccion-paquete').val()
  })
  return paqueteEstudios
}

function caluloFila(parent_element) {
  // Calcula la fila de una tabla
  let cantidad = parseFloat($(parent_element).find("input[name='cantidad-paquete']").val());
  let costo = parseFloat($(parent_element).find("div[class='costo-paquete text-center']").text().slice(1));
  let precioventa = parseFloat($(parent_element).find("div[class='precioventa-paquete text-center']").text().slice(1));
  // Dar valor a costo total
  let costoTotal = cantidad * costo;
  if (checkNumber(costoTotal)) {
    $(parent_element).find("div[class='costototal-paquete text-center']").html('$' + costoTotal.toFixed(2))
    costoTotal = costoTotal.toFixed(2)
  } else {
    $(parent_element).find("div[class='costototal-paquete text-center']").html('$0')
    costoTotal = 0
  }
  let subtotal = cantidad * precioventa;
  if (checkNumber(subtotal)) {
    $(parent_element).find("div[class='subtotal-paquete text-center']").html('$' + subtotal.toFixed(2))
    subtotal = subtotal.toFixed(2);
  } else {
    $(parent_element).find("div[class='subtotal-paquete text-center']").html('$0')
    subtotal = 0
  }
  let row = tablaContenidoPaquete.row(parent_element)
  // Invalida el row modificado en lugar de dibujar toda la tabla
  // row.invalidate();
  row.data({
    0: row.data()[0],
    1: row.data()[1],
    2: `<div class="input-group"><input type="number" class="form-control input-form cantidad-paquete text-center" name="cantidad-paquete" placeholder="0%" value="${cantidad}"><span class="input-span">ud</span></div>`,
    3: `<div class="costo-paquete text-center">$${costo}</div>`,
    4: `<div class="costototal-paquete text-center">$${costoTotal}</div>`,
    5: row.data()[5],
    6: `<div class="precioventa-paquete text-center">$${precioventa}</div>`,
    7: `<div class="subtotal-paquete text-center">$${subtotal}</div>`,
    8: row.data()[8]
  }).invalidate().draw(false);
  return data = [costoTotal, subtotal, cantidad, costo, precioventa]
}

// Precargar listado
function cargarpaquetes() {
  tablaPrecio.ajax.url('../../../api/paquetes_api.php').load();
  data = {
    api: 2,
    cliente_id: $('#seleccion-cliente').val()
  };
  tablaPrecio.ajax.reload();
}

// Precargar tabla
function cargarTabla(dataSet) {
  tablaContenidoPaquete.clear();
  tablaContenidoPaquete.rows.add(dataSet);
  tablaContenidoPaquete.draw();
  calcularFilasTR();
}

function checkNumber(x) {

  // check if the passed value is a number
  if (typeof x == 'number' && !isNaN(x)) {

    // check if it is integer
    if (Number.isInteger(x)) {
      return 1
    } else {
      return 1
    }

  } else {
    return 0
  }
}