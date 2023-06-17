//Recuperar / funciones generales
 

function mostrarInformacionPaciente(data) {
    return new Promise(resolve => {



        resolve(1);
    })
}


function recuperarDatosCampos(turno_id, id_consulta2) {
    return new Promise(resolve => {

                // Mostrar la informacion en panel superior

            resolve(1)


    })
}

//de varios
function recuperarExploracionFisicaConsulta2(id_turno, id_consulta) {
    return new Promise(resolve => {

        ajaxAwait({}, '', { callbackAfter: true }, false, () => {


            let row = data.response.data;
            for (let i = 0; i < row.length; i++) {
                agregarNotaConsulta(row[i]['EXPLORACION_TIPO'], null, row[i]['EXPLORACION'], '#notas-historial-consultorio', row[i]['ID_EXPLORACION_CLINICA'], 'eliminarExploracion')
            }

            resolve(1)
        })

    })
}