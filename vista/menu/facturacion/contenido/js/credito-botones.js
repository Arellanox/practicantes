$(document).on('click', '#ticketDataButton', function (event) {
    event.preventDefault();
    event.stopPropagation();


    $("#ModalTicketCredito").modal('show');

    console.log("estas precionando ticketDataButton")
})