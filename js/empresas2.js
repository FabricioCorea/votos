var empresas = []; // Aquí se almacenarán todas las empresas obtenidas

        // Función para mostrar las empresas según la página actual y el tamaño de página
        function showPage(pageNumber, pageSize) {
            var startIndex = (pageNumber - 1) * pageSize;
            var endIndex = startIndex + pageSize;
            var currentPageData = empresas.slice(startIndex, endIndex);

            var listaEmpresas = document.getElementById('listaEmpresas');
            listaEmpresas.innerHTML = ''; // Limpiar la tabla antes de agregar las filas


            currentPageData.forEach(function(empresa) {
    var row = document.createElement('tr');
    row.innerHTML = '<td>' + empresa.id + '</td>' +
                    '<td>' + empresa.empresa + '</td>' +
                    '<td>' + empresa.representante + '</td>' +
                    '<td>' +
                        '<button class="btn btn-icon btn-edit" data-toggle="tooltip" title="Editar" onclick="editarEmpresa(' + empresa.id + ')">' +
                            '<i class="material-icons">edit</i>' +
                        '</button>' +
                        '<button class="btn btn-icon btn-delete" data-toggle="tooltip" title="Eliminar" onclick="eliminarEmpresa(' + empresa.id + ')">' +
                            '<i class="material-icons">delete</i>' +
                        '</button>' +
                    '</td>';

    listaEmpresas.appendChild(row);
});


            // Actualizar el número de página visible
            document.getElementById('pageNumber').innerText = pageNumber;
        }

        // Función para cambiar al página anterior
        function previousPage() {
            var pageNumber = parseInt(document.getElementById('pageNumber').innerText);
            if (pageNumber > 1) {
                showPage(pageNumber - 1, parseInt(document.getElementById('pageSize').value));
            }
        }

        // Función para cambiar a la página siguiente
        function nextPage() {
            var pageNumber = parseInt(document.getElementById('pageNumber').innerText);
            var pageSize = parseInt(document.getElementById('pageSize').value);
            var totalPages = Math.ceil(empresas.length / pageSize);
            if (pageNumber < totalPages) {
                showPage(pageNumber + 1, pageSize);
            }
        }

        // Función para cambiar el tamaño de página
        function changePageSize() {
            var pageSize = parseInt(document.getElementById('pageSize').value);
            showPage(1, pageSize);
        }

        // Obtener las empresas mediante una solicitud AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../controller/empresas2.php', true);
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                empresas = JSON.parse(xhr.responseText);
                showPage(1, parseInt(document.getElementById('pageSize').value)); // Mostrar la primera página al cargar
            } else {
                console.error('Error al obtener las empresas');
            }
        };
        xhr.send();





// Función para agregar una nueva empresa
function AgregarEmpresa() {
    // Recoger los datos del formulario
    var empresa = document.getElementById('empresaModal').value.trim();
    var representante = document.getElementById('representanteModal').value.trim();

    // Verificar que se hayan ingresado los datos
    if (empresa === '' || representante === '') {
        alert('Por favor, ingrese el nombre de la empresa y el representante.');
        return;
    }

    // Crear un objeto para los datos que se enviarán
    var data = {
        empresa: empresa,
        representante: representante
    };

    // Realizar una solicitud POST al servidor
    fetch('../controller/empresas2.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(response => {
        if (response.mensaje === 'Empresa agregada correctamente') {
            alert(response.mensaje);
            // Cerrar el modal
            document.getElementById('formAgregarEmpresa').reset();
            $('#addEmpresaModal').modal('hide');
            // Recargar la página
            location.reload();
        } else {
            alert('Error: ' + response.mensaje);
        }
    })
    .catch(error => {
        console.error('Error en la solicitud:', error);
    });
}



// Función para eliminar una empresa
function eliminarEmpresa(idEmpresa) {
    if (confirm('¿Está seguro de que desea eliminar esta empresa?')) {
        // Realizar una solicitud DELETE al servidor
        fetch('../controller/empresas2.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: idEmpresa })
        })
        .then(response => response.json())
        .then(response => {
            if (response.mensaje === 'Empresa eliminada correctamente') {
                alert(response.mensaje);
                // Recargar la página
                location.reload();
            } else {
                alert('Error: ' + response.mensaje);
            }
        })
        .catch(error => {
            console.error('Error en la solicitud:', error);
        });
    }
}


// Función para editar una empresa
function editarEmpresa(idEmpresa) {
    var empresa = prompt('Ingrese el nuevo nombre de la empresa:');
    var representante = prompt('Ingrese el nuevo representante de la empresa:');

    // Verificar si se ingresaron los datos
    if (empresa !== null && representante !== null) {
        // Crear un objeto con los datos de la empresa a actualizar
        var data = {
            id: idEmpresa,
            empresa: empresa,
            representante: representante
        };

        // Realizar una solicitud PUT al servidor
        fetch('../controller/empresas2.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(response => {
            if (response.mensaje === 'Empresa actualizada correctamente') {
                alert(response.mensaje);
                // Recargar la página
                location.reload();
            } else {
                alert('Error: ' + response.mensaje);
            }
        })
        .catch(error => {
            console.error('Error en la solicitud:', error);
        });
    }
}
