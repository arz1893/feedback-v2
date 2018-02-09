var ctx = document.getElementById('complaint_product_chart');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["January", "February", "March", "April", "May", "June", "July", "Augustus", "September", "October", "November", "December"],
        datasets: [{
            label: 'Complaint per Month',
            data: [12, 19, 3, 5, 2, 3, 4, 6, 8, 11, 12, 13],
            backgroundColor: 'orange',
            borderColor: 'rgba(255,99,132,1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        },
        elements: {
            line: {
                tension: 0 // disables bezier curves
            }
        }
    }
});