var stats = $('#stats').data('stats');
console.log(stats);
var chart = new Chart($('#stats'), {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        datasets: stats
    },

    // Configuration options go here
    options: {
        scales: {
            /*xAxes: [{
                type: 'time',
                time: {
                    unit: 'day'
                }
            }]*/
            xAxes: [{
                type: 'time',
                time: {
                    displayFormats: {
                        quarter: 'DD MM YYYY'
                    }
                }
            }]
        }
    }
});