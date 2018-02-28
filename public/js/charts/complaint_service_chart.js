if($('#complaint_service_chart').length > 0) {
    let ctx = document.getElementById('complaint_service_chart');
    const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_service_report/get-all-statistic/' + new Date().getFullYear();
    let complaintPerMonth = [];
    let tenantId = $('#tenant_id').val();
    axios.post(url, {
        tenantId: tenantId
    }).then(response => {
        complaintPerMonth = response.data;

        let myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July", "Augustus", "September", "October", "November", "December"],
                datasets: [{
                    label: 'Complaint',
                    data: complaintPerMonth,
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
    })
        .catch(error => {
            console.log(error);
        });

}