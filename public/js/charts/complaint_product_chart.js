if($('#complaint_product_chart').length > 0) {
    let ctx = document.getElementById('complaint_product_chart');
    const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_product_report/get-monthly-complaint/' + new Date().getFullYear();
    let tenantId = $('#tenant_id').val();
    let complaintPerMonth = null;

    axios.post(url, {
        tenantId: tenantId
    })
    .then(response => {
        complaintPerMonth = response.data;
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
    })
    .catch(error => {
        console.log(error);
    });


    $('#select_year').on('change', function () {
        let data = $('#select_year').val();
        console.log(data);
    })
}