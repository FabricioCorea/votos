
    var urlListaEmpresas = 'http://localhost/votos/controller/datos.php?opc=GetVotos';
    $(document).ready(function(){
       
        CargarListaEmpresas();
     });



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