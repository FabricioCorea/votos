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
                        '<button class="btn btn-icon btn-edit" data-toggle="tooltip" title="Editar" onclick="openEditModal(' + empresa.id + ')">' +
                            '<i class="material-icons">edit</i>' +
                        '</button>' +
                        '<button class="btn btn-icon btn-delete" data-toggle="tooltip" title="Eliminar" onclick="deleteEmpresa(' + empresa.id + ')">' +
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