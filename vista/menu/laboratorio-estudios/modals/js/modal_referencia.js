// Detecta si lo que esta escribiendo es negativo si es asi lo manda a la verga
$(document).ready(function () {
    $(document).on('keydown', '#edad-minima-referencia, #edad-maxima-referencia', function (event) {
        if (event.key === '-' || event.key === 'e') {
            event.preventDefault();
        }
    });
});

//Desactiva los imput de maximo y minimo de edad
$('#SinEdad').on('click', function (e) {
    $('#edad-minima-referencia').addClass('disable-element');
    $('#edad-maxima-referencia').addClass('disable-element');
})