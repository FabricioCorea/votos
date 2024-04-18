    var empresas = []; // Almacenamiento de empresas obtenidas

    // Función para mostrar información sobre los registros
    function mostrarInfoRegistros(totalRegistros, pageNumber, pageSize) {
    var startIndex = (pageNumber - 1) * pageSize + 1;
    var endIndex = Math.min(pageNumber * pageSize, totalRegistros);
    var total = totalRegistros;

    if (totalRegistros === 0) {
        return 'Mostrando registros del 0 al 0 de un total de 0 registros';
    } else {
        return 'Mostrando registros del ' + startIndex + ' al ' + endIndex + ' de un total de ' + total + ' registros';
    }
    }

    // Función para mostrar las empresas según la página actual y el tamaño de página
    function showPage(pageNumber, pageSize) {
    var totalPages = Math.ceil(empresas.length / pageSize); // Calcular el número total de páginas
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
            //Botones de editar y eliminar
            '<td>' +
            '<button class="btn btn-icon btn-edit" data-toggle="tooltip" title="Editar" onclick="mostrarModalEditar(' + empresa.id + ', \'' + empresa.empresa + '\', \'' + empresa.representante + '\')">' +
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

    // Actualizar la información sobre los registros
    document.getElementById('infoRegistros').innerText = mostrarInfoRegistros(empresas.length, pageNumber, pageSize);

    // Habilitar o deshabilitar los botones de paginación según sea necesario
    document.getElementById('previousPageButton').disabled = pageNumber === 1;
    document.getElementById('nextPageButton').disabled = pageNumber === totalPages;
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

//-----------------------------------------------------------------------------------------------------------------//


    // Obtener las empresas 
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../controller/empresas2.php', true);
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            empresas = JSON.parse(xhr.responseText);
            showPage(1, parseInt(document.getElementById('pageSize').value));
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
            Swal.fire("Advertencia", "Debe llenar todos los campos", "warning");
            return;
        }
        // Verificar que el representante no contenga números ni caracteres especiales
        if (!/^[a-zA-Z\s]+$/.test(representante)) {
            Swal.fire("Advertencia", "El campo representante no puede contener números", "warning");
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
                    Swal.fire({
                        icon: 'success',
                        title: 'Listo',
                        text: response.mensaje
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('formAgregarEmpresa').reset(); // Resetear el formulario
                            $('#addEmpresaModal').modal('hide'); // Cerrar el modal
                            location.reload(); // Recargar la página
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error: ' + response.mensaje
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error en la solicitud'
                });
                console.error('Error en la solicitud:', error);
            });
    }

    // Función para convertir texto a mayúsculas 
    function convertirAMayusculas(input) {
        input.value = input.value.toUpperCase();
    }

    // Función para que solo se permitan letras en el campo de representante 
    function validarRepresentante(input) {
        var representante = input.value.trim();
        if (!/^[a-zA-Z\s]+$/.test(representante)) {
            input.setCustomValidity("El campo representante solo puede contener letras y espacios");
        } else {
            input.setCustomValidity("");
        }
    }

    // Agregar eventos de input para convertir a mayúsculas en tiempo real
    document.getElementById('empresaModal').addEventListener('input', function() {
        convertirAMayusculas(this);
    });

    document.getElementById('representanteModal').addEventListener('input', function() {
        convertirAMayusculas(this);
        validarRepresentante(this);
    });

       // Agregar eventos de input para convertir a mayúsculas en tiempo real
       document.getElementById('editEmpresaNombre').addEventListener('input', function() {
        convertirAMayusculas(this);
    });

    document.getElementById('editEmpresaRepresentante').addEventListener('input', function() {
        convertirAMayusculas(this);
        validarRepresentante(this);
    });







    // Función para cargar datos de empresa en el modal de edición
    function cargarDatosEmpresa(idEmpresa, nombreEmpresa, representante) {
        document.getElementById('editEmpresaId').value = idEmpresa;
        document.getElementById('editEmpresaNombre').value = nombreEmpresa;
        document.getElementById('editEmpresaRepresentante').value = representante;
    }

    // Función para editar una empresa
    function editarEmpresa(idEmpresa) {
        var empresa = document.getElementById('editEmpresaNombre').value;
        var representante = document.getElementById('editEmpresaRepresentante').value;
        var id = document.getElementById('editEmpresaId').value;

        var data = {
            id: id,
            empresa: empresa,
            representante: representante
        };

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
                Swal.fire({
                    icon: 'success',
                    title: 'Listo',
                    text: response.mensaje
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#editEmpresaModal').modal('hide'); // Cerrar modal de edición
                        location.reload(); // Recargar la página
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error: ' + response.mensaje
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error en la solicitud'
            });
            console.error('Error en la solicitud:', error);
        });
    }


    // Función para mostrar modal de edición al hacer clic en el botón Editar
    function mostrarModalEditar(idEmpresa, nombreEmpresa, representante) {
        cargarDatosEmpresa(idEmpresa, nombreEmpresa, representante);
        $('#editEmpresaModal').modal('show');
    }

    // Función para eliminar una empresa
    function eliminarEmpresa(idEmpresa) {
        Swal.fire({
            title: '¿Está seguro?',
            text: "Esta acción eliminará la empresa. ¿Desea continuar?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // solicitud de eliminación
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
                            Swal.fire({
                                icon: 'success',
                                title: 'Listo',
                                text: response.mensaje
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload(); // Recargar la página después de eliminar la empresa
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error: ' + response.mensaje
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error en la solicitud'
                        });
                        console.error('Error en la solicitud:', error);
                    });
            }
        });
    }
