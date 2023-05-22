const CapturasdeArea = document.getElementById('CapturasdeArea')
CapturasdeArea.addEventListener('show.bs.modal', event => {
    // $('#capturasIMG').html('')
    $('#NombrePacienteCapturas').html(dataSelect.array['nombre_paciente']);
    // let rowImg = selectEstudio.array[0]['IMAGENES'], htmlImg = '', htmlPdf = '';
    console.log(selectEstudio.array);
    let html = '';
    for (const i in selectEstudio.array) {
        let row = selectEstudio.array[i]
        if (row.CAPTURAS.length) {
            html += '<h4>' + row.SERVICIO + '</h4>';
            console.log(row);
            let rowInf = row.CAPTURAS[0]
            let rowImg = row.CAPTURAS[0].CAPTURAS[0]
            let htmlPDF = '';
            let htmlimg = '';
            console.log(rowImg)
            let pdf = 0;
            let img = 0;

            html += '<div class="row">' +
                //Nombre quien cargó
                '<div class="row col-12 col-lg-6">' +
                '<div class="col-6 text-end info-detalle">' +
                '<p>Captura cargada por:</p>' +
                '</div>' +
                '<div class="col-6" id="info-paci-procedencia"> ' + rowInf['CARGADO_POR_CAP'] + '</div>' +
                '</div>' +

                //fecha de cargado
                '<div class="row col-12 col-lg-6">' +
                '<div class="col-6 text-end info-detalle">' +
                '<p>Fecha de subida:</p>' +
                '</div>' +
                '<div class="col-6" id="info-paci-procedencia"> ' + formatoFecha2(rowInf['FECHA_RESULTADO_CAP'], [0, 1, 2, 2, 1, 1, 1]) + '</div>' +
                '</div>' +

                //Profesion del usuario
                '<div class="row col-12 col-lg-6">' +
                '<div class="col-6 text-end info-detalle">' +
                '<p>Profesión:</p>' +
                '</div>' +
                '<div class="col-6" id="info-paci-procedencia"> ' + rowInf['PROFESION'] + '</div>' +
                '</div>' +

                '</div>';

            for (const im in rowImg) {
                switch (rowImg[im]['tipo']) {
                    case 'pdf':
                        pdf = 1;
                        htmlPDF += '<div class="col-auto">' +
                            '<a type="button"a target="_blank" class="btn btn-borrar me-2" href="' + rowImg[im]['url'] + '" style="margin-bottom:4px">' +
                            '<i class="bi bi-file-earmark-pdf"></i>' +
                            '</a>' +
                            '</div>';
                        break;

                    // case 'png': case 'jpg': case 'jpeg':
                    default:
                        img = 1;
                        htmlimg += '<div class="col-12 d-flex justify-content-center"><img src="' + rowImg[im]['url'] + '" class="img-thumbnail" alt=""></div>';
                        break;
                }
            }

            if (pdf == 1) {
                html += '<div class="col-12 d-flex justify-content-left row"> <div class="col-3 align-items-center"><p>Capturas por documento pdf: </p></div> <div class="col-9 d-flex justify-content-start">' +
                    htmlPDF +
                    '</div > </div >';
            }
            if (img == 1) {
                html += htmlimg;
                html += '<hr class="dropdown-divider">';
            }
        }

    }
    $('#capturasIMG').html(html)
    // for (let i = 0; i < rowImg.length; i++) {
    //     let row = rowImg;
    //     if (row[i]['EXTENSION'] == 'pdf') {
    //         htmlPdf += '<p style="font-size:25px">Capturas por documento pdf:</p> <div class="col-12 d-flex justify-content-center">'+
    //         '<a type="button"a target="_blank" class="btn btn-borrar me-2" href="'+row[i]['URL']+'" style="margin-bottom:4px">'+
    //           '<i class="bi bi-file-earmark-pdf"></i>'+
    //         '</a>'+
    //       '</div>';
    //     }else{
    //         htmlImg += '<div class="col-12 d-flex justify-content-center"><img src="'+row[i]['URL']+'" class="img-thumbnail" alt=""></div>';
    //     }
    //     $('#capturasPDF').html(htmlPdf);
    //     $('#capturasIMG').html(htmlImg);
    // }

})
