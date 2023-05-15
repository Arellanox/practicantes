//Formulario de Preregistro
$("#formRegistrarCargo").submit(function(event){
   event.preventDefault();
   /*DATOS Y VALIDACION DEL REGISTRO*/
   var form = document.getElementById("formRegistrarCargo");
   var formData = new FormData(form);
   formData.set('api', 1);

   $.ajax({
     data: formData,
     url: "../../../api/cargos_api.php",
     type: "POST",
     processData: false,
     contentType: false,
     success: function(data) {
       data = jQuery.parseJSON(data);
       console.log(data);
       switch (data['response']['code']) {
         case 1:
           Toast.fire({
             icon: 'success',
             title: '¡Cargo registrado!',
             timer: 2000
           });
           document.getElementById("formRegistrarCargo").reset();
           $("#modalRegistrarCargo").modal('hide');
         break;
         case 2:
           Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: '¡Ha ocurrido un error!',
              footer: 'Codigo: '+data['response']['msj']
           })
         break;
         default:
           Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Hubo un problema!',
              footer: 'Reporte este error con el personal :)'
           })
       }
     },
   });
   event.preventDefault();
 });
