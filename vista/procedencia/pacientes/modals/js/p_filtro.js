


$("#filtroTablaForm").on("submit", function (e) {
    e.preventDefault();
    alertToast('Aplicando filtro, espere un momento', 'info', 4000)

    formData = new FormData(document.getElementById("filtroTablaForm"));

    datapacientes['fecha_inicial'] = formData.get('fecha_inicial');
    datapacientes['fecha_final'] = formData.get('fecha_final');

    tablaPacientes.ajax.reload();

    $('#modalFiltrarTabla').modal('hide')
})