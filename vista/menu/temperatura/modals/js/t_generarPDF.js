// Folio del mes que se esta seleccionando en la tabla
FolioMesEquipo = {}, DatosAjax = {}, observaciones = "";
// Evento Click para abrir el modal de exportar PDF
$("#GenerarPDFTemperatura").on("click", function (e) {
    e.preventDefault();

    // En SelectedFoliosData esta toda la informacion del mes
    FolioMesEquipo = SelectedFoliosData['FOLIO']


    $("#TemperaturaModalGeneralFirma").modal("show");

})

let dataJson = {
    api: 15
};

// Evento Click para generar el PDF y mostralo en una ventana nueva
$("#btn-generar-formato-temperatura").on('click', async function (e) {
    // body...
    e.preventDefault();

    // data = new FormData(document.getElementById("GenerarPdfForm"));

    alertMensajeConfirm({
        title: 'Esta seguro de realizar esta accion',
        text: `Se generar el formato para el folio ${FolioMesEquipo}`,
        icon: 'info'
    }, async function () {
        alertToast('Tomando Captura de la tabla', 'info', 2000);

        await tomarCapturaPantalla({
            type: 'div',
            name: `TablaDePuntos_Temperatura_folio${FolioMesEquipo}`,
            elementId: 'grafica'
        });

        setTimeout(async function () {
            await ajaxAwait(DatosAjax, 'temperatura_api', { callbackAfter: true }, false, (data) => {
                api = encodeURIComponent(window.btoa('temperatura'));
                area = encodeURIComponent(window.btoa(-1));
                turno = encodeURIComponent(window.btoa(FolioMesEquipo));

                var win = window.open(`http://localhost/practicantes/visualizar_reporte/index-pruebas.php/?api=${api}&turno=${turno}&area=${area}`, '_blank')

                win.focus();
            });
        }, 3000)

    }, 1)

})


// Funcion para tomar captura de pantalla a la tabla de temperaturas en 3 capas Tabla, Dots, Canvas
async function tomarCapturaPantalla(data = {}) {
    return await new Promise(function (resolve, reject) {
        var element = document.getElementById(data['elementId']);
        var zoom = 1 / (window.devicePixelRatio || 1); // Nivel de zoom actual de la página

        // Ajustar el tamaño del elemento según el nivel de zoom
        element.style.transform = 'scale(' + zoom + ')';
        element.style.transformOrigin = 'top left';

        var scale = 2; // Ajusta este valor según tus necesidades
        var options = {
            scale: scale * zoom, // Considerar el nivel de zoom actual
            useCORS: true,
            allowTaint: true,
            scrollX: 0,
            scrollY: 0,
        };

        html2canvas(element, options).then(function (canvas) {
            // Restaurar el tamaño original del elemento
            element.style.transform = '';
            element.style.transformOrigin = '';
            elementImg = canvas.toDataURL();
            elementName = data['name'];

            DatosAjax.api = 15
            DatosAjax.UrlImg = elementImg
            DatosAjax.NameImg = elementName
            DatosAjax.folio = FolioMesEquipo
            DatosAjax.observaciones = observaciones

            swal.close();
            resolve(1)
        });


    })
}

$("#observaciones_pdf").change(function () {
    observaciones = $(this).val();
})
