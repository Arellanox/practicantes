const modalRegistrarPrueba = document.getElementById('ModalRegistrarPrueba')
modalRegistrarPrueba.addEventListener('show.bs.modal', event => {
    rellenarSelect('#selectProcedencia', 'clientes_api', 2, 'ID_CLIENTE', 'NOMBRE_COMERCIAL')
    select2('#selectSegmentos', "ModalRegistrarPrueba")

    $('#selectProcedencia').change(function () {
        // select2('#selectSegmentos', "ModalRegistrarPrueba", 'Cargando...')
        rellenarSelect('#selectSegmentos', 'segmentos_api', 2, 'ID_SEGMENTO', 'DESCRIPCION', {
            'cliente_id': $(this).val()
        })
    })

    select2('#selectProcedencia', "ModalRegistrarPrueba", 'Cargando...')
})

