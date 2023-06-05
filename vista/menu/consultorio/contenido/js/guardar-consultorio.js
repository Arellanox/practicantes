 function alertaConsultorio(btn){

    alertMensajeConfirm({
        title: '¿Está seguro que relleno bien el o los campos?',
        text: 'No podrá modificarlo despues',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }, function(){
        //return
       guardarDatosConsultorio(btn)
    } ,1)
 }

$(document).on('click', '#btn-guardar-nota-consulta', function(event){
    event.preventDefault()
    alertaConsultorio('nota_consulta')
})
$(document).on('click', '#btn-agregar-exploracion-clinina', function(event){
    event.preventDefault()
    alertaConsultorio('exploracion_clinica')
})
$(document).on('click', '#btn-guardar-Diagnostico', function(event){
    event.preventDefault()
    alertaConsultorio('diagostico')
})
//aqui va solicitud de estudios


$(document).on('click', '#btn-guardar-Receta', function(event){
    event.preventDefault()
    alertaConsultorio('receta')
})
$(document).on('click', '#btn-guardar-plan-tratamiento', function(event){
    event.preventDefault()
    alertaConsultorio('plan_tratamiento')
})


//Insertar datos en consultorio
function guardarDatosConsultorio(btn){

    switch(btn){

        case 'nota_consulta':
            alert ('nota_consulta')
            break;

        case 'exploracion_clinica':
            
            //Exploracion clinica
            let dataJson_clinica = {
                api: 1,
                exploracion_tipo_id: $("#select-exploracion-clinica").val(),
                exploracion: $("#text-exploracion-clinica").val()
            }

            //Ajax de Exploracion clinicas
            ajaxAwait(dataJson_clinica, 'exploracion_clinica_api', { callbackAfter: true }, false, function (data) {
                alertMensaje('success', 'Datos guardados', 'Espere un momento...', null, null, 2000)
            })
            break;

        case 'diagostico':
            alert('diagostico')
            break;
        
        case 'receta':

            //Consultorio recetas
            let dataJson_recetas = {
                api: 1,
                nombre_generico : $("#nombre_generico").val(),
                nombre_comercial : $("#nombre_comercial").val(),
                forma_farmaceutica : $("#forma_farmaceuticaval").val(),
                dosis : $("#dosis").val(),
                presentacion : $("#presentacion").val(),
                frecuencia : $("#frecuencia").val(),
                via_de_administracion : $("#via_de_administracion").val(),
                duracion_de_tratamiento : $("#duracion_de_tratamiento").val(),
                indicaciones_de_uso : $("#indicaciones_de_uso").val()
            }

            //Ajax de Nuevas recetas
            ajaxAwait(dataJson_recetas, 'consultorio_recetas_api', { callbackAfter: true }, false, function (data) {
                alertMensaje('success', 'Datos guardados', 'Espere un momento...', null, null, 2000)
            })
            break;
        
        case 'plan_tratamiento':
            alert('plan_tratamiento')
            break;    
            
        default:
            alertToast()
            break;    
    }
}

