var date = new Date(),
    date1 = new Date(),
    date2 = new Date(),
    date3 = new Date(),
    date4 = new Date(),
    date5 = new Date(),
    date6 = new Date(),
    date7 = new Date();
date1.setDate(date.getDate() - 7);
date2.setDate(date.getDate() - 6);
date3.setDate(date.getDate() - 5);
date4.setDate(date.getDate() - 4);
date5.setDate(date.getDate() - 3);
date6.setDate(date.getDate() - 2);
date7.setDate(date.getDate() - 1);
var ctx = document.getElementById('serverusage-chart').getContext('2d');
var chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [date1.getDate() + '/' + date1.getMonth(), date2.getDate() + '/' + date2.getMonth(), date3.getDate() + '/' + date3.getMonth(),
        date4.getDate() + '/' + date4.getMonth(),
        date5.getDate() + '/' + date5.getMonth(), date6.getDate() + '/' + date6.getMonth(),
        date7.getDate() + '/' + date7.getMonth(), date.getDate() + '/' + date.getMonth()
        ],
        datasets: [{
            label: 'SCP-SL',
            data: [1, 2, 3, 4, 5, 6, 7, 8],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)'],
            borderColor: [
                'rgba(255, 99, 132, 1)'],
            borderWidth: 1
        }, {
            label: 'Minecraft',
            fill: true,
            backgroundColor: ['rgba(15, 255, 35, 0.2)'],
            borderColor: window.chartColors.green,
            borderWidth: 1,
            data: [8, 7, 6, 5, 4, 3, 2, 1],
        }]
    },
    plugins: {
        filler: {
            propagate: true
        },
        deferred: {
            xOffset: 150,   // defer until 150px of the canvas width are inside the viewport
            yOffset: '50%', // defer until 50% of the canvas height are inside the viewport
            delay: 500      // delay of 500 ms after the canvas is considered inside the viewport
        }
    },
    options: {
        animation: {
            tension: {
                duration: 2000,
                easing: 'easeInQuad',
                from: 10,
                to: 0,
                loop: false
            }
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});