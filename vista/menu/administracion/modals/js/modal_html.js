


// NO USAR


// getAreaUnValor('cargos', 'cargos_api', 2, 'ID_CARGO', '#MODAL_CARGOS_VISTA')
function getAreaUnValor(titulo, api_url, api_case, registro_id, divContenedor) {
    html = '<div class="modal fade" id="modalRegistrar' + titulo + '" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"' +
        'data-bs-keyboard="false">' +
        '<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">' +
        '<div class="modal-content">' +
        '<div class="modal-header header-modal">' +
        '<h5 class="modal-title">' + firstMayus(titulo) + '</h5>' +
        '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>' +
        '</div>' +
        '<div class="modal-body" id="' + titulo + '-body">' +
        '<p class="none-p">Doble click para editar <i class="bi bi-pencil"></i></p>' +
        '<div class="row mt-3">' +
        '<div class="col-6">' +
        //Tabla contenido
        '<table class="table table-hover tableContenido" id="Tabla' + titulo + '" style="width:100%">' +
        '<thead class="">' +
        '<tr>' +
        '<th scope="col d-flex justify-content-center">#</th>' +
        '<th scope="col d-flex justify-content-center">' + firstMayus(titulo) + '</th>' +
        '<th scope="col d-flex justify-content-center"><i class="bi bi-collection"></i></th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>' +
        '</tbody>' +
        '</table>' +
        //
        '</div>' +
        '<div class="col-6" id="RegistrarMetodo' + titulo + '">' +
        '<p>Crear nuevo ' + titulo + ':</p>' +
        //Registrar
        '<form class="row" id="formRegistrar' + titulo + '">' +
        '<div class="col-12">' +
        '<label for="descripcion" class="form-label">Nombre del ' + deletePositionString(titulo, -1) + '</label>' +
        '<input type="text" name="descripcion" required value="" class="form-control input-form">' +
        '</div>' +
        '<div class="text-center">' +
        '<button type="submit" class="btn btn-hover me-2" style="margin-bottom:4px">' +
        '<i class="bi bi-send-plus"></i> Guardar' +
        '</button>' +
        '</div>' +
        '</form>' +
        //
        '</div>' +
        '<div class="col-6" id="editarMetodo' + titulo + '" style="display:none">' +
        '<p>Actualizar ' + titulo + ':</p>' +
        //Editar
        '<form class="row" id="formEditar' + titulo + '">' +
        '<div class="col-12">' +
        '<label for="descripcion" class="form-label">Nombre del ' + deletePositionString(titulo, -1) + '</label>' +
        '<input type="text" name="descripcion" required id="edit-' + titulo + '-descripcion" ' +
        'class="form-control input-form">' +
        '</div>' +
        '<div class="text-center">' +
        '<button type="submit" class="btn btn-hover me-2" style="margin-bottom:4px">' +
        '<i class="bi bi-pencil-square"></i> Actualizar' +
        '</button>' +
        '<button type="button" class="btn btn-hover me-2" style="margin-bottom:4px" id="desactivar-' + titulo + '">' +
        '<i class="bi bi-collection"></i> Desactivar' +
        '</button>' +
        '</div>' +
        '</form>' +
        //
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="modal-footer">' +
        '<button type="button" class="btn btn-cancelar" data-bs-dismiss="modal"><i class="bi bi-arrow-left-short"></i>' +
        'Cerrar</button>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>';

    //Crea el html en DOM
    $(divContenedor).html(html);

    vistaAreaUnValor(api_url, api_case, '#Tabla' + titulo, registro_id, titulo)


}

function vistaAreaUnValor(api_url, api_case, tabla_id, registro_id, titulo) {
    let dataAreaValor;
    //Vista table {-
    let TablaContenido = $(tabla_id).DataTable({
        processing: true,
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
            loadingRecords: '&nbsp;',
            processing: '<div class="spinner"></div>'
        },
        lengthMenu: [
            [5, 10, -1],
            [5, 10, "All"]
        ],
        autoWidth: false,
        searching: false,
        lengthChange: false,
        info: false,
        paging: false,
        scrollY: "30vh",
        scrollCollapse: true,
        ajax: {
            dataType: 'json',
            data: { api: api_case, ACTIVO: 1 },
            method: 'POST',
            url: http + servidor + "/nuevo_checkup/api/" + api_url + ".php",
            beforeSend: function () { },
            complete: function () { cambiarFormMetodo(0, titulo); },
            dataSrc: 'response.data'
        },
        columns: [
            { data: 'COUNT' },
            { data: 'DESCRIPCION' },
            {
                data: 'ACTIVO', render: function (data) {
                    if (data == 1) {
                        return '<i class="bi bi-check-circle"></i>';
                    } else {
                        return '<i class="bi bi-x-circle"></i>';
                    }
                }
            },
        ],
        columnDefs: [{
            "width": "3px",
            "targets": 0
        },],

    });


    selectDatatabledblclick(function (select, data) {
        dataAreaValor = data;
        console.log(dataAreaValor)
        console.log(select)
        if (!select) {
            cambiarFormMetodo(0, titulo);
        } else {
            document.getElementById("edit-" + titulo + "-descripcion").value = dataAreaValor['DESCRIPCION'];
            cambiarFormMetodo(1, titulo);
        }
    }, tabla_id, TablaContenido)
    // -}


    //Modal vista {-
    // let modal = document.getElementById('modalRegistrar' + titulo)
    // modal.addEventListener('show.bs.modal', event => {
    //     TablaContenido.ajax.reload();
    // })

    //Ajusta el ancho del encabezado cuando es dinamico
    let modal = $('#modalRegistrar' + titulo);
    modal.on('shown.bs.modal', function (e) {
        TablaContenido.ajax.reload();
        $.fn.dataTable
            .tables({
                visible: true,
                api: true
            })
            .columns.adjust();
    })



    // -}

    //Formulario de registro de cargo
    $("#formRegistrar" + titulo).submit(function (event) {
        event.preventDefault();
        /*DATOS Y VALIDACION DEL REGISTRO*/
        var form = document.getElementById("formRegistrar" + titulo);
        var formData = new FormData(form);
        formData.set('api', 1);

        alertMensajeConfirm({
            title: '¿Está seguro que todos los datos están correctos?',
            text: "No podrá eliminar el registro",
            icon: 'warning'
        }, function () {
            $.ajax({
                data: formData,
                url: http + servidor + "/nuevo_checkup/api/" + api_url + ".php",
                type: "POST",
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (data) {
                    if (mensajeAjax(data)) {
                        alertToast('¡' + firstMayus(titulo) + ' registrado!', 'success')
                        document.getElementById("formRegistrar" + titulo).reset();
                        TablaContenido.ajax.reload();
                        cambiarFormMetodo(0, titulo);
                        // selectMetodo()
                    }
                },
            });
        })
        event.preventDefault();
    });


    //Formulario de actualizar cargo
    $("#formEditar" + titulo).submit(function (event) {
        event.preventDefault();
        /*DATOS Y VALIDACION DEL REGISTRO*/
        var form = document.getElementById("formEditar" + titulo);
        var formData = new FormData(form);
        formData.set('ID_CARGO', dataAreaValor[registro_id])
        formData.set('api', 1);

        alertMensajeConfirm({
            title: '¿Está seguro de cambiar la descripcion?',
            text: "¡Se cambiará en todas las vistas!",
            icon: 'warning'
        }, function () {
            //$("#btn-registrarse").prop('disabled', true);
            // Esto va dentro del AJAX
            $.ajax({
                data: formData,
                url: http + servidor + "/nuevo_checkup/api/" + api_url + ".php",
                type: "POST",
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (data) {
                    if (mensajeAjax(data)) {
                        alertToast('¡' + firstMayus(titulo) + ' actualizado!', 'success')
                        document.getElementById("formEditar" + titulo).reset();
                        TablaContenido.ajax.reload();
                        cambiarFormMetodo(0, titulo);
                        // selectMetodo()
                    }
                },
            });
        })
        event.preventDefault();
    });

    //Desactivar valor
    $('#desactivar-' + titulo).click(function () {
        if (dataAreaValor != null) {
            alertMensajeConfirm({
                title: "¿Está seguro que desea desactivar este registro?",
                text: "No podrán volver a elegir el registro",
                icon: 'warning',
            }, function () {
                $.ajax({
                    data: {
                        id: dataAreaValor[registro_id],
                        api: 4
                    },
                    url: http + servidor + "/nuevo_checkup/api/" + api_url + ".php",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        if (mensajeAjax(data)) {
                            alertToast('¡' + firstMayus(titulo) + ' eliminado!', 'success')
                            document.getElementById("formEditar" + titulo).reset();
                            TablaContenido.ajax.reload();
                            cambiarFormMetodo(0, titulo);
                        }
                    },
                });
            })
        } else {
            alertSelectTable();
        }
    })

}

//Metodo global
function cambiarFormMetodo(fade, titulo) {
    if (fade == 1) {
        $('#RegistrarMetodo' + titulo).fadeOut();
        setTimeout(function () {
            $('#editarMetodo' + titulo).fadeIn();
        }, 400);
    } else {
        document.getElementById("formEditar" + titulo).reset();
        $('#editarMetodo' + titulo).fadeOut();
        setTimeout(function () {
            $('#RegistrarMetodo' + titulo).fadeIn();
        }, 400);
    }
}
