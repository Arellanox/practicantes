// Datos de ejemplo para cada día (puedes modificar estos valores según tus necesidades)
const datosPorDia = [
    { dia: 1, valores: [2, 4, -1] },
    { dia: 2, valores: [3, -2, 1] },
    // ... completar los datos para los 31 días
];

const tabla = document.getElementById('tablaGraficas');

datosPorDia.forEach((dato) => {
    const fila = document.createElement('tr');

    const celdaDia = document.createElement('td');
    celdaDia.textContent = dato.dia;
    fila.appendChild(celdaDia);

    const celdaGrafica = document.createElement('td');
    const canvas = document.createElement('canvas');
    canvas.width = 200;
    canvas.height = 100;
    celdaGrafica.appendChild(canvas);
    fila.appendChild(celdaGrafica);

    const valores = dato.valores;
    const ctx = canvas.getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Valor 1', 'Valor 2', 'Valor 3'],
            datasets: [{
                label: 'Valores',
                data: valores,
                borderColor: 'blue',
                borderWidth: 1,
                fill: false
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: false
                }
            }
        }
    });

    tabla.appendChild(fila);
});
