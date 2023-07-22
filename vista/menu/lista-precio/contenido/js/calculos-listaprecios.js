
$(document).on("change keyup" , "input[name='utilidad'] , input[name='total']", function(){
  let parent_element = $(this).closest("tr");
  let costo = parseFloat($(parent_element).find("div[class='costo text-center']").text().slice(1));
  let utilidad = parseFloat($(parent_element).find("input[name='utilidad']").val());
  let total = parseFloat($(parent_element).find("input[name='total']").val());

  switch ($(this).attr("name")) {
    case "utilidad":
        if (costo > 0 && utilidad != 0 && !isNaN(utilidad)) {
            totalInput = costo + (costo * utilidad / 100);
            $(parent_element).find("input[name='total']").val(totalInput.toFixed(2));
        }else{
          $(parent_element).find("input[name='total']").val(0);

        }
      break;
    case "total":
        if (costo > 0 && total > 0 && !isNaN(total)) {
          utilidadInput = (total-costo) / costo * 100;
          // utilidadInput = costo + (costo/100 * utilidad);
          $(parent_element).find("input[name='utilidad']").val(utilidadInput.toFixed(2));
        }else{
          $(parent_element).find("input[name='utilidad']").val(0);
        }
      break;
    default:
      confirm('Error, campo no detectado')
  }
})

$(document).on("change" , "input[name='utilidad'] , input[name='total']", function(){
  let parent_element = $(this).closest("tr");
  let utilidad = parseFloat($(parent_element).find("input[name='utilidad']").val());
  let total = parseFloat($(parent_element).find("input[name='total']").val());
  switch ($(this).attr("name")) {
    case "utilidad":
        if (isNaN(utilidad)) {
          $(parent_element).find("input[name='utilidad']").val(0);
        }
      break;
    case "total":
        if (isNaN(total)) {
          $(parent_element).find("input[name='total']").val(0);
        }
      break;
    default:
      confirm('Error, campo no detectado')
  }
})
