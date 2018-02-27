if($('#complaint_product_chart').length > 0) {
    let ctx = document.getElementById('complaint_product_chart');
    const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_product_report/get-all-statistic';
    let complaintPerMonth = [];
    axios.get(url).then(response => {
        complaintPerMonth = response.data;

        let myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July", "Augustus", "September", "October", "November", "December"],
                datasets: [{
                    label: 'Complaint',
                    data: complaintPerMonth,
                    backgroundColor: 'maroon',
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
    })
    .catch(error => {
        console.log(error);
    });

}