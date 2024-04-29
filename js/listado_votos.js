
var ctx = document.getElementById('grafico').getContext('2d');
var grafico = new Chart(ctx, {
    type: 'pie',
    data: {
        labels:  json_encode($categorias) ,
        datasets: [{
            label: 'Cantidad',
            data:  json_encode($cantidades),
            backgroundColor: [
                'rgba(52, 73, 94)',
                'rgba(241, 189, 20)' 
            ],
            borderColor: [
                'rgba(178, 186, 187)',
                'rgba(253,247,232)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true, 
        maintainAspectRatio: false, 
        plugins: {
            tooltip: {
                enabled: true, 
                callbacks: {
                    label: function(context) {
                        var label = context.label || '';
                        var value = context.formattedValue || '';
                        return value + '%'; 
                    }
                }
            }
        }
    }
});
