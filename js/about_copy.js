$(document).ready(function(){
       
    CargarDatosGrafico();
 });


 function CargarDatosGrafico(){
$.ajax({
    url: 'http://localhost:82/votos/controller/about_copy.php',
    type: 'POST' 
}).done(function(resp){
    var titulo = [];
    var cantidad = [];

    var data = JSON.parse(resp);
    for(var i=0; i < data.length; i++){
        titulo.push(data[i][1]);
        cantidad.push(data[i][2]);
    }
    
     // Datos para el gráfico
     var datos = {
        labels: titulo,
        datasets: [{
            label: 'Colores favoritos',
            data: cantidad, // Datos de ejemplo para los porcentajes
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)'
            ],
            borderWidth: 1
        }]
    };

    // Configuración del gráfico
    var config = {
        type: 'pie',
        data: datos,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    // Crear el gráfico
    var myChart = new Chart(
        document.getElementById('grafico'),
        config
    );


})


 }