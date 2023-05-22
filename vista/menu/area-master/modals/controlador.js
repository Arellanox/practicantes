$.post("modals/a_modals.php", function (html) {
  $("#modals-js").html(html);
  // Modal para agregar capturas
  $.getScript("modals/js/ar_subircapturas_area.js");
  // Modal para agregar capturas
  $.getScript("modals/js/ar_mostrar-capturas.js");


  //ELectro 
  $.getScript("modals/js/electro_mostrar_carpeta.js")

  //Nutricion inbody
  $.getScript('modals/js/nutri_inbody_capturas.js');
});