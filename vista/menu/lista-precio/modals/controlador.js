$.post("modals/modals.php", function(html){
   $("#modals-js").html(html);
   // Modal para crear Paquete
  $.getScript('modals/js/pa_crearPaquete.js');
  $.getScript('modals/js/lista_precios.js');

   //Modal para crear Relacion
   // $.getScript('modals/js/pa_crearRelacion.js');
   // Modal para rechazar
   //$.getScript('modals/js/p_rechazar.js');
   // Modal para rechazar
  // $.getScript('modals/js/subir-perfil.js');

  $.getScript('modals/js/mo_vista_paquetes.js')
});
