// Detecta si lo que esta escribiendo es negativo si es asi lo manda a la verga
$(document).ready(function () {
    $('#number').on('keydown', function (event) {
        if (event.key === '-' || event.key === 'e') {
            event.preventDefault();
        }
    });
});