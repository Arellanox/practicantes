$("#btnfiltrofechaujat").on("click", function (e) {
    e.preventDefault();


    $("#modalFiltrarTabla").modal("show");
})



$("#filtroTablaForm").on("submit", function (e) {
    e.preventDefault();
    
    data = new FormData(document.getElementById("filtroTablaForm"));

    console.log(data)
})