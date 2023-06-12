$(document).on('click', '.btn-facturar', function (event) {
    event.preventDefault();
    event.stopPropagation();
    let btn = $(this);

    if (selectCuenta) {
        $('#modalFacturarCuenta').modal('show');
    } else {
        alertToast('Selecciona un registro', 'info', 4000)
    }




})

