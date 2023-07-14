// Folio del mes que se esta seleccionando en la tabla
FolioMesEquipo = {};
// Evento Click para abrir el modal de exportar PDF
$("#GenerarPDFTemperatura").on("click", function(e) {
    e.preventDefault();

    // En SelectedFoliosData esta toda la informacion del mes
    FolioMesEquipo = SelectedFoliosData['FOLIO']

    $("#TemperaturaModalGeneralFirma").modal("show");
})

let dataJson = {
    api: 15
};

// Evento Click para generar el PDF y mostralo en una ventana nueva
$("#btn-generar-formato-temperatura").on('click', async function(e) {
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
    }, async function() {
        // Toma captura de pantalla solo al canvas 
        await tomarCapturaPantalla(null, 'canvas');
        // Toma captura de pantalla solo a la tabla sin los dots
        await tomarCapturaPantalla(tabla, 'tabla_sin_dot');
        // Toma captura de pantalla solo a los dots sin la tabla
        // tomarCapturaPantalla(dots,'tabla_dot');
        alertToast('Elementos Capturados', 'success', 2000);
    }, 1)

})


// Funcion para tomar captura de pantalla a la tabla de temperaturas en 3 capas Tabla, Dots, Canvas
async function tomarCapturaPantalla(name, elementId) {

    return await () => {
        var element = document.getElementById(elementId);

        // Validar si el nombre viene vacio, si es asi es por que es un canvas el que se esta enviando, de lo contrario es por que es un elemento html
        if (name == null) {
            image = element.toDataURL('image/png');
            EnviarCaptura({
                api: 15,
                image: image
            });
        } else {
            name = `${name}.png`;

            domtoimage.toPng(element)
                .then(function(dataUrl) {
                    EnviarCaptura({
                        api: 15,
                        image: dataUrl
                    });
                });
        };
    }


}

// Funcion para enviar la captura a la API y que se guarde en el directorio
function EnviarCaptura(DataConfig = {}) {
    // console.log(DataConfig)
    // return false;

    // Hace la peticion AJAX a la api 15 para guardar la imagen en la carpeta archivos/sistema/capas_temperaturas
    ajaxAwait(DataConfig, 'temperatura_api', { callbackAfter: true }, false, (data) => {

        
    })
}