function resetVotos() {

    var style = $('<style>.my-swal { font-size: 16px; } .my-swal .swal-button { font-size: 16px; } .swal2-popup { height: auto !important; }</style>');

    $('head').append(style);

    Swal.fire({
        title: '¿Está seguro?',
        text: '¿Está seguro de reiniciar los votos? Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, reiniciar',
        cancelButtonText: 'Cancelar',
        width: '40%', 
        padding: '1em', 
        customClass: {
            title: 'swal-title', 
            text: 'swal-text',
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary', 
            popup: 'my-swal' 
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Hacer una solicitud AJAX para reiniciar los votos en el servidor
            $.ajax({
                url: '../Formularios/resetear_votos.php', // Ruta al archivo PHP que maneja el reinicio de votos
                type: 'POST',
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        width: '40%',
                        padding: '1em',
                        text: response,
                        customClass: {
                            title: 'swal-title', 
                            text: 'swal-text',
                            confirmButton: 'btn btn-danger', 
                            cancelButton: 'btn btn-secondary', 
                            popup: 'my-swal' 
                        }
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un error al reiniciar los votos. Por favor, inténtalo de nuevo.',
                        customClass: {
                            title: 'swal-title', 
                            text: 'swal-text', 
                            confirmButton: 'btn btn-danger', 
                            cancelButton: 'btn btn-secondary', 
                            popup: 'my-swal' 
                        }
                    });
                }
            });
        }
    });
}
