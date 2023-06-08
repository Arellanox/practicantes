$(document).on('click', '.btn-facturar', function (event) {
    event.preventDefault();
    event.stopPropagation();
    let btn = $(this);

    if (selectCuenta) {
        $('#').modal('show');
    } else {
        alertToast('Selecciona un registro', 'info', 4000)
    }




})