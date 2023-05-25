// //Estudios laboratorio clinico
// setTimeout(() => {
//     const button = document.querySelector('#select2-select-lab-container');
//     const tooltip = document.querySelector('#tooltip');
//     cargarServiciosEstudios(button, tooltip);
//   }, 5000);

//  //Estudios laboratorio biomolecular
//   setTimeout(() => {
//     const button = document.querySelector('#select2-select-labbio-container');
//     const tooltip = document.querySelector('#tooltip');
//     cargarServiciosEstudios(button, tooltip);
//   }, 5000);

//  //Estudios de rayos x
//   setTimeout(() => {
//     const button = document.querySelector('#select2-select-rx-container');
//     const tooltip = document.querySelector('#tooltip');
//     cargarServiciosEstudios(button, tooltip);
//   }, 5000);

//    //Estudios de ultrasonido
//   setTimeout(() => {
//     const button = document.querySelector('#select2-select-us-container');
//     const tooltip = document.querySelector('#tooltip');
//     cargarServiciosEstudios(button, tooltip);
//   }, 5000);

//   //Otros estudios
//   setTimeout(() => {
//     const button = document.querySelector('#select2-select-otros-container');
//     const tooltip = document.querySelector('#tooltip');
//     cargarServiciosEstudios(button, tooltip);
//   }, 5000);



const selectLab = document.querySelector('#select2-select-lab-container');
const selectLabBio = document.querySelector('#select2-select-labbio-container')
const selectRX = document.querySelector('#select2-select-rx-container')
const selectUltras = document.querySelector('#select2-select-us-container')

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
        ListaEstudiosShow('#estudiosUltra', estudiosUltra);
    }
})


function ListaEstudiosShow(select, estudioData) {
    let dataJSON = {
        api: 15
    }
    let id = $(select).prop('selectedIndex');
    parseInt(estudioData[id]['ES_GRUPO']) ? dataJSON['id_grupo'] = estudioData[id]['ID_SERVICIO'] : dataJSON['id_servicio'] = estudioData[id]['ID_SERVICIO'];
    ajaxAwait(dataJSON, "servicios_api", { callbackAfter: true }, false, function (data) {

    })
}