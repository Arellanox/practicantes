

$('#formCapturaInbody').submit(function (event) {
    event.preventDefault();
    alertMensajeConfirm({
        title: '¿Está seguro de capturar este archivo?',
        text: 'No podrá modificar este archivo de nuevo',
        icon: 'warning'
    }, async function () {
        let dataAjax = await ajaxAwaitFormData({
            turno_id: dataSelect.array['turno'],
            api: 1
        }, 'inbody_api', 'formCapturaInbody')

        if (dataAjax) {
            alertToast('Captura cargada', 'success', 4000)
            await obtenerServicios(areaActiva, dataSelect.array['turno'])
            btnNutricionInbody(0)
        }

        $('#ModalInterpretacionInbody').modal('hide');
    }, 1)

    event.preventDefault();
})

$(document).on('click', '#confirmar-inbody-nutricion', async function (event) {
    event.preventDefault();

    alertMensajeConfirm({
        title: '¿Está seguro de capturar este archivo?',
        text: 'No podrá modificar este archivo de nuevo',
        icon: 'warning'
    }, async function () {
        let dataAjax = await ajaxAwait({
            turno_id: dataSelect.array['turno'],
            api: 3
        }, 'inbody_api', true)

        if (dataAjax) {
            // alertToast('Co', 'success', 4000)
            alertMsj({
                title: '¡Resultado enviado!',
                text: '¡La captura de InBody a sido confirmado y enviado al paciente!',
                icon: 'success',
                showCancelButton: false
            })
        }
    }, 1)

    event.preventDefault();
})




const ModalViewInbody = document.getElementById('ModalViewInbody')
ModalViewInbody.addEventListener('show.bs.modal', event => {
    // console.log(dataSelect)
    $('#nombre-paciente-nutricion').html(`${dataSelect.array['nombre_paciente']}`)
    let imgURL = selectEstudio.array[0]['INBODY_PDF'];
    $('#contenedor-imagenInbody').html(`<div class="col-12 d-flex justify-content-center"><img src="${imgURL}" class="img-thumbnail" alt=""></div>`)
})