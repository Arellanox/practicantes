$(tablePaquetesHTML).on('dblclick', 'tr', function () {
  if (!$("input[name='cantidad-paquete'], input[name='descuento-paquete']").is(":focus")) {
    let data = tablaContenidoPaquete.row($(this)).data()

    dataEliminados.push(data[7])
    console.log(dataEliminados);
    tablaContenidoPaquete.row($(this)).remove().draw();
    // if (tablaContenidoPaquete.data().count()) {
    calcularFilasTR()
    // }


  }
});
