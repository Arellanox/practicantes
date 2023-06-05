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
    alertaConsultorio('exploracion_fisica')
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
            let dataJson_nota ={
                api: 1,
                turno_id: pacienteActivo.array['ID_TURNO'],
                notas_consulta: $('#nota-consulta-campo-consulta').val(),
            }
            ajaxAwait(dataJson_nota, 'consultorio2_api', {callbackAfter: true}, false, function(data){
                alertMensaje('success', 'Datos guardados', 'Espere un momento...', null, null, 2000)
            })
            break;

        case 'exploracion_fisica':
            let dataJson_fisica = {
                api: 1,
                turno_id: pacienteActivo.array['ID_TURNO'],
                exploracion_tipo_id: $("#select-exploracion-clinica").val(),
                exploracion: $("#text-exploracion-clinica").val()
            }
            ajaxAwait(dataJson_fisica, 'exploracion_clinica_api', { callbackAfter: true }, false, function (data) {
                alertMensaje('success', 'Datos guardados', 'Espere un momento...', null, null, 2000)
            })
            break;

        case 'diagostico':
            dataJson_diagnostico = {
                api: 1,
                turno_id: pacienteActivo.array['ID_TURNO'],
                diagnostico: $("#diagnostico-campo-consulta-1").val(),
                diagnostico2: $("#diagnostico-campo-consulta-2").val()
            }
            ajaxAwait(dataJson_diagnostico, 'consultorio2_api', { callbackAfter: true }, false, function (data) {
                alertMensaje('success', 'Datos guardados', 'Espere un momento...', null, null, 2000)
            })
            break;

        case 'receta':
            let dataJson_recetas = {
                api: 1,
                turno_id: pacienteActivo.array['ID_TURNO'],
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
            ajaxAwait(dataJson_recetas, 'consultorio_recetas_api', { callbackAfter: true }, false, function (data) {
                alertMensaje('success', 'Datos guardados', 'Espere un momento...', null, null, 2000)
            })
            break;
        
        case 'plan_tratamiento':
            dataJson_tratatiento = {
                api: 1,
                turno_id: pacienteActivo.array['ID_TURNO'],
                plan_tratamiento: $("#plan-tratamiento-campo-consulta").val()
            }
            ajaxAwait(dataJson_tratatiento, 'consultorio2_api', { callbackAfter: true }, false, function (data) {
                alertMensaje('success', 'Datos guardados', 'Espere un momento...', null, null, 2000)
            })
            break;    
            
        default:
            alertToast()
            break;    
    }
}

function mostrarTablaRecetas(){

}

