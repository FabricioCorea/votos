
// Obtener las empresas mediante una solicitud AJAX
var xhr = new XMLHttpRequest();
xhr.open('GET', '../controller/empresas2.php', true);
xhr.onload = function() {
    if (xhr.status >= 200 && xhr.status < 300) {
        var empresas = JSON.parse(xhr.responseText);
        var listaEmpresas = document.getElementById('listaEmpresas');
        empresas.forEach(function(empresa) {
            var row = document.createElement('tr');
            row.innerHTML = '<td>' + empresa.id + '</td>' +
                            '<td>' + empresa.empresa + '</td>' +
                            '<td>' + empresa.representante + '</td>'; // Ajusta según la estructura de tus datos
            listaEmpresas.appendChild(row);
        });
    } else {
        console.error('Error al obtener las empresas');
    }
};
xhr.send();
