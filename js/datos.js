var urlVotos = 'http://localhost/votos/controller/datos.php?opc=GetVotos';
    var urlListaEmpresas = 'http://localhost/votos/controller/datos.php?opc=GetVotos';
    $(document).ready(function(){
       
        CargarListaEmpresas();
     });

    

    function cargarEmpresas() {
        $.ajax({
            url: urlVotos,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var empresas = response;
                var secuencia = 1;

                // Limpiar la tabla antes de agregar nuevos datos
                $('#dataEmpresas').empty();

                // Recorrer los datos y construir las filas de la tabla
                empresas.forEach(function(empresa) {
                    var fila = '<tr>' +
                        '<td>' + secuencia + '</td>' +
                        '<td>' + empresa.empresa + '</td>' +
                        '<td>' + empresa.representante + '</td>' +
                        '<td>' + empresa.presente + '</td>' +
                        '<td>' + empresa.representado + '</td>' +
                        '<td>' + empresa.voto + '</td>' +
                        '</tr>';
                    
                    $('#dataEmpresas').append(fila);
                    secuencia++;
                });
            },
            error: function(xhr, status, error) {
                // Manejar errores de la solicitud AJAX
                console.error(error);
                Swal.fire('Error', 'Hubo un error al cargar los datos de las empresas', 'error');
            }
        });
    }



function CargarListaEmpresas() {
  $.ajax({
    url: urlListaEmpresas,
    type: "GET",
    datatype: "JSON",
    success: function(response){
      var MisItems = response;
      var opciones =
        '<option value="">' + "Seleccione una empresa" + "</option>";
      
      for(i=0; i<MisItems.length; i++){ //Muestra Id y nombre
           opciones +='<option value="' +
            MisItems[i].id +
            '">' +
            MisItems[i].id +
            " - " +
            MisItems[i].empresa +
            " - " +
            MisItems[i].representante +
            "</option>";
        }
      $("#Select_empresa").html(opciones);
      $("#Select_empresa").select2({
        language: {
          noResults: function () {
            return "Sin Resultados <a href='http://localhost/votos/Formularios/login.php' class='btn btn-success'>Agregar Nuevo Proveedor</a>";
          },
        },
        escapeMarkup: function (markup) {
          return markup;
        },
      });
    },
  });
}