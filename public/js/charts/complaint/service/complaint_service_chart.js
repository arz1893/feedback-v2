if($('#complaint_service_chart_all_yearly').length > 0) {

    $('#current_year').text($('#select_year').val());

    var ctx = document.getElementById("complaint_service_chart_all_yearly");
    var tenantId = $('#tenantId').val();
    var year = $('#select_year').val();
    const url = window.location.protocol + "//" + window.location.host + '/api/complaint_service_report/show-all-report/' + tenantId + '/yearly/' + year;

    axios.get(url).then(response => {
        console.log(response.data.data);
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
        var ctx = document.getElementById("complaint_service_chart_all_yearly");
        var tenantId = $('#tenantId').val();
        var year = $(this).val();
        $('#current_year').text($(this).val());
        const url = window.location.protocol + "//" + window.location.host + '/api/complaint_service_report/show-all-report/' + tenantId + '/yearly/' + year;

        axios.get(url).then(response => {
            if(response.data.error === undefined) {
                $('#not_found').css('display', 'none');
                $('#complaint_service_chart_all_yearly').css('display', '');
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
                $('#complaint_service_chart_all_yearly').css('display', 'none');
            }
        }).catch(error => {
            console.log(error);
        });
    });
} else if($('#complaint_service_chart_all_monthly').length > 0) {
    $('#current_year').text($('#select_year').val());
    $('#current_month').text($('#select_month option:selected').text());

    var ctx = document.getElementById("complaint_service_chart_all_monthly");
    var tenantId = $('#tenantId').val();
    var year = $('#select_year').val();
    var month = $('#select_month').val();
    const url = window.location.protocol + "//" + window.location.host + '/api/complaint_service_report/show-all-report/' + tenantId + '/monthly/' + year + '/' + month;

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
        $('#current_year').text($('#select_year').val());
        $('#current_month').text($('#select_month option:selected').text());
        onChangeDate();
    });

    $('#select_month').change(function () {
        $('#current_year').text($('#select_year').val());
        $('#current_month').text($('#select_month option:selected').text());
        onChangeDate();
    });

    function onChangeDate() {
        var ctx = document.getElementById("complaint_service_chart_all_monthly");
        var tenantId = $('#tenantId').val();
        var year = $('#select_year').val();
        var month = $('#select_month').val();
        const url = window.location.protocol + "//" + window.location.host + '/api/complaint_service_report/show-all-report/' + tenantId + '/monthly/' + year + '/' + month;

        axios.get(url).then(response => {
            if(response.data.error === undefined) {
                $('#not_found').css('display', 'none');
                $('#complaint_service_chart_all_monthly').css('display', '');
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
                $('#complaint_service_chart_all_monthly').css('display', 'none');
            }
        }).catch(error => {
            console.log(error);
        });
    }
}