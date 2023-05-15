
var TrabajadorData = false;
var trabajador_id_modal = 0
// Obtener datos del paciente seleccionado
const ModalBeneficiario = document.getElementById('ModalBeneficiario')
ModalBeneficiario.addEventListener('show.bs.modal', event => {
    cargarModal()
    resetInputFile()
    TrabajadorData = false
    // document.getElementById('formBeneficiadoTrabajador').reset
    $('#formBeneficiadoTrabajador').trigger("reset");
    $('#datos-nuevo-trabajador').fadeOut(200)
})

async function cargarModal() {
    await rellenarSelect('#lista-pacientes-trabajadores', 'recepcion_api', 8, 'ID_TRABAJADOR', 'CURP.PASAPORTE.NOMBRE_COMPLETO.NACIMIENTO.NUMBER_TRABAJADOR', {})
    if (array_selected['ID_TURNO'])
        await datosPacienteBeneficiado(array_selected['ID_TURNO']);
}


async function datosPacienteBeneficiado(turno) {
    return new Promise(function (resolve) {
        $.ajax({
            type: 'POST',
            url: `${http}${servidor}/${appname}/api/recepcion_api.php`,
            dataType: 'json',
            data: {
                api: 8,
                turno_id: turno
            },
            beforeSend: function () {
                alertToast('Verificando si existen datos previos...', 'info', 4000);
            },
            success: function (data) {
                if (mensajeAjax(data)) {
                    if (data.response.data.length > 0) {
                        let row = data.response.data[0];

                        $('#clave_beneficiado').val(row.CLAVE_BENEFICIARIO)

                        $('#parentesco_beneficiado option').prop('selected', false);
                        $("#parentesco_beneficiado option").filter(function () {
                            //may want to use $.trim in here
                            return $(this).text() == row.PARENTESCO;
                        }).prop('selected', true)

                        $('#numero_pase').val(row.NUMERO_PASE);
                        $('#medico_envia').val(row.MEDICO_QUE_ENVIA);
                        $('#cedula_medico').val(row.CEDULA_MEDICO);
                        $('#diagnostico_beneficiado').val(row.DIAGNOSTICO);
                        $('#ures_beneficiado').val(row.URES);

                        if (row.ID_TRABAJADOR) {
                            trabajador_id_modal = row.ID_TRABAJADOR;
                            $("#lista-pacientes-trabajadores").val(row.ID_TRABAJADOR).trigger('change'); // <-- trabajador
                            $("#lista-pacientes-trabajadores").prop('disabled', true);
                            $('#checkPacienteBeneficia').prop('checked', true);
                            $('#checkPacienteBeneficia').prop('disabled', true);
                            $('#datos-nuevo-trabajador').fadeIn(200)

                            $('#input-name-trabajador').val(row.NOMBRE);
                            $('#input-paterno-trabajador').val(row.PATERNO)
                            $('#input-materno-trabajador').val(row.MATERNO)
                            $('#input-nacimiento-trabajador').val(row.FECHA_NACIMIENTO)
                            $('#input-edad-trabajador').val(row.EDAD)
                            $('#input-numero_trabajador-trabajador').val(row.NUMBER_TRABAJADOR)
                            $('#curp-trabajador').val(row.CURP)
                            $('#input-pasaporte-trabajador').val(row.PASAPORTE)

                        } else {
                            trabajador_id_modal = 0;
                            $("#lista-pacientes-trabajadores").prop('disabled', false);
                            $('#checkPacienteBeneficia').prop('disabled', false);
                            $('#checkPacienteBeneficia').prop('checked', false);
                        }



                        // $("#lista-pacientes-trabajadores option").filter(function () {
                        //     //may want to use $.trim in here
                        //     return $(this).text() == row.ID_TRABAJADOR;
                        // }).prop('selected', true).trigger('change');

                        $('#categoria_trabajador').val(row.CATEGORIA);

                        if (!parseInt(session.permisos.DatosBeneficiario)) {
                            $("form#formBeneficiadoTrabajador :input").each(function () {
                                var input = $(this); // This is the jquery object of the input, do what you will
                                if (ifnull(input.val())) {
                                    input.prop('disabled', true);
                                }
                            });
                        }

                        if (row.GENERO == 'MASCULINO' || row.GENERO == 'FEMENINO') {
                            $(`input[name="genero"][type="radio"][value="${row.GENERO}"]`).prop('checked', true)
                            if (!parseInt(session.permisos.DatosBeneficiario))
                                $(`input[name="genero"][type="radio"]`).prop('disabled', true)
                        } else {
                            $(`input[name="genero"][type="radio"]`).prop('disabled', false)
                            $(`input[name="genero"][type="radio"]`).prop('checked', false)
                        }

                        if (row.RUTA_PASE) {
                            $('#contenedor-pase-ujat').fadeOut(0);
                            $('#contenedor-url-pase').fadeIn(0);
                            $('#button-pase-ujat').attr('href', row.RUTA_PASE)
                            $('#pase-ujat').prop('disabled', true)
                            // if (!parseInt(session.permisos.DatosBeneficiario))
                            //     $('#pase-ujat').prop('disabled', true)
                        } else {
                            $('#contenedor-pase-ujat').fadeIn(0);
                            $('#contenedor-url-pase').fadeOut(0);
                            $('#pase-ujat').prop('disabled', false)
                            $('#button-pase-ujat').removeAttr('href')
                        }

                        if (row.VERIFICACION) {
                            // $('#contenedor-verificacion-ujat').fadeOut(0);
                            $('#contenedor-url-Verificacion').fadeIn(0);
                            $('#button-Verificacion-ujat').attr('href', row.VERIFICACION)
                            if (!parseInt(session.permisos.DatosBeneficiario)) {
                                $('#contenedor-verificacion-ujat').fadeOut(0);
                                $('#Verificacion-ujat').prop('disabled', true)
                            }
                            //     $('#pase-ujat').prop('disabled', true)
                        } else {
                            $('#contenedor-verificacion-ujat').fadeIn(0);
                            $('#contenedor-url-Verificacion').fadeOut(0);
                            $('#Verificacion-ujat').prop('checked', false)
                            $('#button-Verificacion-ujat').removeAttr('href')
                        }

                        // alertMensaje('success')
                        alertToast('Datos completos', 'success', 4000)
                        TrabajadorData = true;
                    } else {
                        TrabajadorData = false;
                        $("form#formBeneficiadoTrabajador :input").each(function () {
                            var input = $(this); // This is the jquery object of the input, do what you will
                            input.prop('disabled', false);

                            $('#contenedor-pase-ujat').fadeIn(0);
                            $('#contenedor-url-Verificacion').fadeOut(0);
                            $('#Verificacion-ujat').prop('checked', false)
                            $('#button-Verificacion-ujat').removeAttr('href')

                            $('#contenedor-verificacion-ujat').fadeIn(0);
                            $('#contenedor-url-pase').fadeOut(0);
                            $('#pase-ujat').prop('disabled', false)
                            $('#button-pase-ujat').removeAttr('href')

                        });
                        alertToast('No existe datos previos...', 'info', 4000);
                    }

                }
            },
            complete: function () {
                resolve(1);
            }
        })
    });

}




var hash = window.location.hash.substring(1);
var tableData;




// if (tableData != false)
//     alertMensaje('info', 'No puede usar esta ventana', 'No es el area correcta', 'Este mensaje no deberia existir'); return false;



checkPacienteBeneficia


$('#checkPacienteBeneficia').change(function () {
    if ($(this).is(":checked")) {
        $('#datos-nuevo-trabajador').fadeIn(200)
    } else {
        $('#datos-nuevo-trabajador').fadeOut(200)
    }

});

//Rechazados
$("#formBeneficiadoTrabajador").submit(function (event) {
    event.preventDefault();

    if (!isJson(array_selected)) {
        alertMensaje('error', 'No ha seleccionado ningun paciente', 'No puedes continuar con esta accion');
        return false;
    }

    var form = document.getElementById("formBeneficiadoTrabajador");
    var formData = new FormData(form);
    formData.set('turno_id', array_selected['ID_TURNO'])
    formData.set('api', 7);

    // console.log(checkNumber(formData.get('trabajador_id'), 1))
    if (!formData.get('trabajador_id') && !document.getElementById('checkPacienteBeneficia').checked) {
        alertMensaje('warning', 'No puedes agregar estos datos', 'No ha seleccionado el trabajador')
        return false;
    }

    if (document.getElementById('checkPacienteBeneficia').checked) {
        if (trabajador_id_modal) {
            formData.set('trabajador_id', trabajador_id_modal)
        } else {
            formData.set('trabajador_id', false);
        }
    }


    if (array_selected['CLIENTE_ID'] != '18') {
        alertMensaje('info', 'No tienes permtido hacer esta acción')
        return false
    }


    /*DATOS Y VALIDACION DEL REGISTRO*/
    alertMensajeConfirm({
        title: '¿Estás seguro de que todos los datos están correctos?',
        text: '¡Probablemente no podrás revertir los cambios!',
        icon: 'warning'
    }, function () {
        $.ajax({
            data: formData,
            processData: false,
            contentType: false,
            url: "../../../api/recepcion_api.php",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                if (mensajeAjax(data)) {
                    // alertMensaje('success', '¡Información cargada!', 'Los datos de beneficiario ya estan listos.');
                    // rellenarSelect('#lista-pacientes-trabajadores', 'recepcion_api', 8, 'ID_PACIENTE', 'CURP.PASAPORTE.NOMBRE_COMPLETO.NACIMIENTO.NUMBER_TRABAJADOR', {})
                    // document.getElementById("btn-rechazar-paciente").disabled = false;
                    // $("#ModalBeneficiario").modal("hide");
                    // alertMensaje('info', 'Informacion cargada', 'Estamos actualiz')
                    // tablaRecepcionPacientes.ajax.reload();


                    if (TrabajadorData) {
                        $.ajax({
                            data: {
                                nombre: $('#input-name-trabajador').val(),
                                paterno: $('#input-paterno-trabajador').val(),
                                materno: $('#input-materno-trabajador').val(),
                                nacimiento: $('#input-nacimiento-trabajador').val(),
                                edad: $('#input-edad-trabajador').val(),
                                curp: $('#curp-trabajador').val(),
                                pasaporte: $('#input-pasaporte-trabajador').val(),
                                numero_trabajador: $('#input-numero_trabajador-trabajador').val(),
                                trabajador_id: trabajador_id_modal ? trabajador_id_modal : $('#lista-pacientes-trabajadores').val(),
                                api: 9
                            },
                            url: "../../../api/recepcion_api.php",
                            type: "POST",
                            dataType: "json",
                            success: function (data) {
                                if (mensajeAjax(data)) {
                                    alertMensaje('success', 'Información cargada', 'Todos los datos han sido actualizados');
                                    $("#ModalBeneficiario").modal("hide");
                                }
                            }
                        })
                    } else {
                        alertMensaje('success', '¡Información cargada!', 'Los datos de beneficiario ya estan listos.');
                        $("#ModalBeneficiario").modal("hide");
                    }
                }
            }
        });

    }, 1)
    event.preventDefault();
});

// select2('#lista-pacientes-trabajadores', "ModalBeneficiario", 'Seleccione un trabajador', 'default')

$('#lista-pacientes-trabajadores').select2({
    dropdownParent: $('#ModalBeneficiario'),
    tags: false,
    placeholder: 'Seleccione un trabajador',
    with: '550px'
});
// rellenarSelect('#lista-pacientes-trabajadores', 'pacientes_api', 2, 'ID_PACIENTE', 'CURP.PASAPORTE.NOMBRE_COMPLETO.NACIMIENTO.EXPEDIENTE', { cliente_id: 1, onlyTrabajadores: true })