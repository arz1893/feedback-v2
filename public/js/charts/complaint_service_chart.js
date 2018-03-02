if($('#complaint_service_chart').length > 0) {
    let ctx = document.getElementById('complaint_service_chart');
    const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_service_report/get-monthly-complaint/' + new Date().getFullYear();
    let complaintPerMonth = [];
    let tenantId = $('#tenant_id').val();

    axios.post(url, {
        tenantId: tenantId
    }).then(response => {
        complaintPerMonth = response.data;

        if(complaintPerMonth !== '') {
            let config = {
                type: 'line',
                data: {
                    labels: ["January", "February", "March", "April", "May", "June", "July", "Augustus", "September", "October", "November", "December"],
                    datasets: [{
                        label: 'Complaint',
                        data: complaintPerMonth,
                        backgroundColor: 'red',
                        borderColor: 'maroon',
                        fill: false
                    }]
                },
                options: {
                    events: ['click'],
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            };

            let complaintChart = new Chart(ctx, config);
        } else {
            $('#no_data_found').removeClass('invisible');
        }

    })
    .catch(error => {
        console.log(error);
    });

}