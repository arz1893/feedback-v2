if($('#complaint_product_chart_all').length > 0) {
    var ctx = document.getElementById("complaint_product_chart_all");
    var tenantId = $('#tenantId').val();
    var year = $('#select_year').val();
    const url = window.location.protocol + "//" + window.location.host + '/api/complaint_product_report/show-all-report/' + tenantId + '/yearly/' + year;

    axios.get(url).then(response => {
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: response.data.labels,
                datasets: [{
                    label: 'Complaint',
                    data: response.data.data,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255,99,132,1)',
                    borderWidth: 1,
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true,
                            fontSize: 10
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            maxRotation: 90,
                            fontSize: 10
                        }
                    }]
                }
            }
        });
    }).catch(error => {
        console.log(error);
    });

    $('#select_year').change(function () {
        var ctx = document.getElementById("complaint_product_chart_all");
        var tenantId = $('#tenantId').val();
        var year = $(this).val();
        console.log(year);
        const url = window.location.protocol + "//" + window.location.host + '/api/complaint_product_report/show-all-report/' + tenantId + '/yearly/' + year;

        axios.get(url).then(response => {
            if(response.data.error === undefined) {
                $('#not_found').css('display', 'none');
                $('#complaint_product_chart_all').css('display', '');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: response.data.labels,
                        datasets: [{
                            label: 'Complaint',
                            data: response.data.data,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255,99,132,1)',
                            borderWidth: 1,
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true,
                                    fontSize: 10
                                }
                            }],
                            xAxes: [{
                                ticks: {
                                    maxRotation: 90,
                                    fontSize: 10
                                }
                            }]
                        }
                    }
                });
            } else {
                $('#not_found').css('display', '');
                $('#complaint_product_chart_all').css('display', 'none');
            }
        }).catch(error => {
            console.log(error);
        });
    });
}