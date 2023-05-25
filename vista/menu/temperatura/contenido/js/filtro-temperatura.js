
// Obtener la fecha actual
var fechaActual = new Date();

// Obtener los componentes de la fecha (día, mes, año)
var dia = fechaActual.getDate();
var mes = fechaActual.getMonth() + 1; // Los meses en JavaScript comienzan desde 0
var ano = fechaActual.getFullYear();

// Formatear los componentes de la fecha si es necesario (por ejemplo, agregar ceros iniciales)
dia = agregarCerosIniciales(dia);
mes = agregarCerosIniciales(mes);

function agregarCerosIniciales(numero) {
    return numero < 10 ? "0" + numero : numero;
}

// Construir la fecha en el formato deseado
var fechaFormateada = ano + "-" + mes + "-" + dia;

// Asignarle la fecha en el formato requerido al input
$("#fechaFiltroTemperatura").val(fechaFormateada);

$("#FechaTemperatura").html(formatoFecha2(fechaFormateada,[0,1,3,1]))