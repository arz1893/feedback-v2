if($('#complaint_service_chart_all_year').length > 0) {
    const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_service_report/get-all-year-complaint/';
    var ctx = document.getElementById('complaint_service_chart_all_year');
    var tenantId = $('#tenant_id').val();

    axios.post(url, {
        tenantId: tenantId
    }).then(response => {
        if(response.data !== '') {
            var complaintServiceChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: response.data[0],
                    datasets: [{
                        label: 'Complaint',
                        data: response.data[1],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)'
                        ],
                        borderWidth: 1,
                    }],
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
        } else {
            $('#complaint_service_chart').css('display', '');
            $('#no_data_found').css('display', 'none');
        }
    }).catch(error => {
        alert(error);
    });
}

if($('#complaint_service_chart_yearly').length > 0) {
    const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_service_report/get-yearly-complaint/' + new Date().getFullYear();
    var ctx = document.getElementById('complaint_service_chart_yearly');
    var tenantId = $('#tenant_id').val();

    axios.post(url, {
        tenantId: tenantId
    }).then(response => {
        if(response.data !== '') {
            var complaintServiceChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                    datasets: [{
                        label: 'Complaint',
                        data: response.data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)'
                        ],
                        borderWidth: 1,
                        fill: false
                    }],
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
        } else {
            $('#complaint_service_chart').css('display', '');
            $('#no_data_found').css('display', 'none');
        }
    }).catch(error => {
        alert(error);
    });


    $('#select_year').on('change', function () {
        var selected_value = $('#select_year').val();
        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_service_report/get-yearly-complaint/' + selected_value;
        var tenantId = $('#tenant_id').val();

        axios.post(url, {
            tenantId: tenantId
        }).then(response => {
            var complaintPerMonth = response.data;
            if(complaintPerMonth !== '') {
                var complaintServiceChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                        datasets: [{
                            label: 'Complaint',
                            data: complaintPerMonth,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)'
                            ],
                            borderWidth: 1,
                            fill: false
                        }],
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
                $('#complaint_service_chart').css('display', '');
                $('#no_data_found').css('display', 'none');
            } else {
                $('#complaint_service_chart').css('display', 'none');
                $('#no_data_found').css('display', '');
            }
        }).catch(error => {
            alert(error);
        });
    });
}