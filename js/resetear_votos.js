function resetVotos() {
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Estás seguro de reiniciar los votos? Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, reiniciar',
        cancelButtonText: 'Cancelar',
        width: '40%', // ancho del cuadro de diálogo
        padding: '5em', // margen interno para aumentar el tamaño del cuadro de diálogo
        customClass: {
            title: 'swal-title', // clase para el título del cuadro de diálogo
            text: 'swal-text', // clase para el texto del cuadro de diálogo
            confirmButton: 'btn btn-danger', // clase para el botón de confirmación
            cancelButton: 'btn btn-secondary' // clase para el botón de cancelación
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Hacer una solicitud AJAX para reiniciar los votos en el servidor
            $.ajax({
                url: '../Formularios/resetear_votos.php', // Ruta al archivo PHP que maneja el reinicio de votos
                type: 'POST',
                success: function(response) {
                    // Recargar la página después de reiniciar los votos
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        width: '40%', // ancho del cuadro de diálogo
                        padding: '5em', // margen interno para aumentar el tamaño del cuadro de diálogo
                        text: response,
                        onClose: () => {
                            location.reload();
                        }
                    });
                },
                error: function(xhr, status, error) {
                    // Manejar errores si la solicitud falla
                    console.error(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un error al reiniciar los votos. Por favor, inténtalo de nuevo.'
                    });
                }
            });
        }
    });
}


