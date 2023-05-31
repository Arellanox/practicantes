// //Estudios laboratorio clinico
// setTimeout(() => {
//     const button = document.querySelector('#select2-select-lab-container');
//     const tooltip = document.querySelector('#tooltip');
//     cargarServiciosEstudios(button, tooltip);
//   }, 5000);

const selectLab = document.querySelector('#select2-select-lab-container');
const selectLabBio = document.querySelector('#select2-select-labbio-container')
const selectRX = document.querySelector('#select2-select-rx-container')
const selectUltras = document.querySelector('#select2-select-us-container')
const selectOtros = document.querySelector('#select2-select-otros-container')
//Contenido
const tooltip = document.querySelector('#tooltip');

//Hover Lab
popperHover(selectLab, tooltip, function (event) {
    if (event) {
        ListaEstudiosShow('#select-lab', estudiosLab);
    }
})

// //Hover LabBio
// popperHover(selectLabBio, tooltip, function (event) {
//     if (event) {
//         ListaEstudiosShow('#select-labbio', estudiosLabBio);
//     }
// })

//hover rayos x
popperHover(selectRX, tooltip, function (event) {
    if (event) {
        ListaEstudiosShow('#select-rx', estudiosRX);
    }
})

//hover estudios ultrasonido
popperHover(selectUltras, tooltip, function (event) {
    if (event) {
        ListaEstudiosShow('#select-us', estudiosUltra);


    }
})

//hover estudios otros
popperHover(selectOtros, tooltip, function (event) {
    if (event) {
        ListaEstudiosShow('#select-otros', estudiosOtros);

    }
})


function ListaEstudiosShow(select, estudioData) {
    let dataJSON = {
        api: 16
    }


    let id = $(select).prop('selectedIndex');
    parseInt(estudioData[id]['ES_GRUPO']) ? dataJSON['id_grupo'] = estudioData[id]['ID_SERVICIO'] : dataJSON['id_servicio'] = estudioData[id]['ID_SERVICIO'];
    ajaxAwait(dataJSON, "servicios_api", { callbackAfter: true, callbackBefore: true }, function () {
        //Antes de llamar 
        //vaciar la lista de estudios
        $('#container-label').fadeIn(0);
        $('#container-estudios').fadeOut(0);
        $('#container-grupos').fadeOut(0);

        $('#listaContenidoEstudios').html('')
        $('#listContenidoGrupos').html('')

    }, function (data) {
        //Despues de llamar
        $('#listaContenidoEstudios').html('')
        $('#listContenidoGrupos').html('')
        let row = data.response.data
        let grupo = false;
        let servicio = false;
        for (const key in row) {
            if (Object.hasOwnProperty.call(row, key)) {
                const element = row[key];
                if (element['ES_GRUPO'] == 0) {
                    $('#listaContenidoEstudios').append(`<li class="list-group-item">${element['DESCRIPCION']}</li>`)
                    servicio = true;
                } else {
                    $('#listContenidoGrupos').append(`<li class="list-group-item">${element['DESCRIPCION']}</li>`)
                    grupo = true;
                }


            }


        }

        $('#container-label').fadeOut(0);
        if (servicio) $('#container-estudios').fadeIn(0);
        if (grupo) $('#container-grupos').fadeIn(0);

    })

}

