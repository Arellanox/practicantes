// Folio del mes que se esta seleccionando en la tabla
FolioMesEquipo = {};
// Evento Click para abrir el modal de exportar PDF
$("#GenerarPDFTemperatura").on("click", function (e) {
    e.preventDefault();

    // En SelectedFoliosData esta toda la informacion del mes
    FolioMesEquipo = SelectedFoliosData['FOLIO']
    alertToast('Tomando Captura de la tabla', 'info', 2000);

    tomarCapturaPantalla({
        type: 'div',
        name: 'TablaDePuntos_Temperatura',
        elementId: 'grafica'
    });


})

let dataJson = {
    api: 15
};

// Evento Click para generar el PDF y mostralo en una ventana nueva
$("#btn-generar-formato-temperatura").on('click', function (e) {
    // body...
    e.preventDefault();

    // Nombre de la captura de pantalla de la tabla
    tabla = `tabla-${FolioMesEquipo}`;
    // Nombre de la captura de pantalla de los dots
    dots = `dots-${FolioMesEquipo}`;

    alertMensajeConfirm({
        title: 'Esta seguro de realizar esta accion',
        text: `Se generar el formato para el folio ${FolioMesEquipo}`,
        icon: 'info'
    }, function () {
        // Toma captura de pantalla solo al canvas 

        alertToast('Elementos Capturados', 'success', 2000);
    }, 1)

})


// Funcion para tomar captura de pantalla a la tabla de temperaturas en 3 capas Tabla, Dots, Canvas
var DatosAjax = {};
function tomarCapturaPantalla(data = {}) {
    var element = document.getElementById(data['elementId']);
    var zoom = 1 / (window.devicePixelRatio || 1); // Nivel de zoom actual de la página

    // Ajustar el tamaño del elemento según el nivel de zoom
    element.style.transform = 'scale(' + zoom + ')';
    element.style.transformOrigin = 'top left';

    html2canvas(element, {
        useCORS: true,
        allowTaint: true,
        scrollX: 0,
        scrollY: 0,
    }).then(function (canvas) {
        // Restaurar el tamaño original del elemento
        element.style.transform = '';
        element.style.transformOrigin = '';
        elementImg = canvas.toDataURL();
        elementName = data['name'];

        DatosAjax = {
            api: 15,
            UrlImg: elementImg,
            NameImg: elementName
        }

        ajaxAwait(DatosAjax, 'temperatura_api', { callbackAfter: true }, false, (data) => {

            swal.close()
            $("#TemperaturaModalGeneralFirma").modal("show");
        })
    });



}
