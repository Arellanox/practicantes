$(document).on("change ,  keyup" , "input[name='costo'] , input[name='margen']" ,function(){
     var parent_element = $(this).closest("tr");
     var costo = parseFloat($(parent_element).find("input[name='costo']").val());
     var margen = parseFloat($(parent_element).find("input[name='margen']").val());
     if( costo > 0 && margen > 0)
      {
        total = costo + (costo*margen/100);
        $(parent_element).find(".total").html('<div class="total">$'+ total.toFixed(2) +'</div>');
      }
      else
      {
        $(parent_element).find(".total").html('<div class="total">$0</div>');
      }
});

$(document).on("change", "input[name='selectTipLista'] , #seleccionar-cliente , input[name='selectChecko']" , function(){
  let tipo = $('input[type=radio][name=selectTipLista]:checked').val();
  let cliente = $('#seleccionar-cliente').val();
  let area = $('input[type=radio][name=selectChecko]:checked').val();
  if (tipo != null && cliente != null && area != null) {
    // if (true) {
    //
    // }else{
    //   obtenertablaListaPrecios(columnsDefinidas, columnasData, apiurl, {api:2, id_area: $('input[type=radio][name=selectChecko]:checked').val(), cliente_id})
    // }
  }else{
    console.log("Necesita seleccionar una opcion")
  }
})
