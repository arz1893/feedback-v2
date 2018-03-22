if($('#complaint_product_chart_all_yearly').length > 0) {

    $('#current_year').text($('#select_year').val());

    var ctx = document.getElementById("complaint_product_chart_all_yearly");
    var tenantId = $('#tenantId').val();
    var year = $('#select_year').val();
    var count = $('#show_data').val();
    const url = window.location.protocol + "//" + window.location.host + '/api/complaint_product_report/show-all-report/' + tenantId + '/yearly/' + year + '/show/' + count;

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
        window.myChart = myChart;
    }).catch(error => {
        console.log(error);
    });

    $('#select_year').change(function () {
        myChart.destroy();
        onChangeShowData();
    });

    $('#show_data').change(function () {
        myChart.destroy();
        onChangeShowData();
    });

    function onChangeShowData() {
        var ctx = document.getElementById("complaint_product_chart_all_yearly");
        var tenantId = $('#tenantId').val();
        var year = $('#select_year').val();
        var count = $('#show_data').val();
        $('#current_year').text($('#select_year').val());
        const url = window.location.protocol + "//" + window.location.host + '/api/complaint_product_report/show-all-report/' + tenantId + '/yearly/' + year + '/show/' + count;

        axios.get(url).then(response => {
            if(response.data.error === undefined) {
                $('#not_found').css('display', 'none');
                $('#complaint_product_chart_all_yearly').css('display', '');
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
                window.myChart = myChart;
            } else {
                $('#not_found').css('display', '');
                $('#complaint_product_chart_all_yearly').css('display', 'none');
            }
        }).catch(error => {
            console.log(error);
        });
    }
} else if($('#complaint_product_chart_all_monthly').length > 0) {
    $('#current_year').text($('#select_year').val());
    $('#current_month').text($('#select_month option:selected').text());

    var ctx = document.getElementById("complaint_product_chart_all_monthly");
    var tenantId = $('#tenantId').val();
    var year = $('#select_year').val();
    var month = $('#select_month').val();
    var count = $('#show_data').val();
    const url = window.location.protocol + "//" + window.location.host + '/api/complaint_product_report/show-all-report/' + tenantId + '/monthly/' + year + '/' + month + '/show/' + count;

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

        window.myChart = myChart;
    }).catch(error => {
        console.log(error);
    });

    $('#select_year').change(function () {
        myChart.destroy();
        $('#current_year').text($('#select_year').val());
        $('#current_month').text($('#select_month option:selected').text());
        onChangeData();
    });

    $('#select_month').change(function () {
        myChart.destroy();
        $('#current_year').text($('#select_year').val());
        $('#current_month').text($('#select_month option:selected').text());
        onChangeData();
    });

    $('#show_data').change(function () {
        myChart.destroy();
        $('#current_year').text($('#select_year').val());
        $('#current_month').text($('#select_month option:selected').text());
        onChangeData();
    });

    function onChangeData() {
        var ctx = document.getElementById("complaint_product_chart_all_monthly");
        var tenantId = $('#tenantId').val();
        var year = $('#select_year').val();
        var month = $('#select_month').val();
        var count = $('#show_data').val();
        const url = window.location.protocol + "//" + window.location.host + '/api/complaint_product_report/show-all-report/' + tenantId + '/monthly/' + year + '/' + month + '/show/' + count;

        axios.get(url).then(response => {
            if(response.data.error === undefined) {
                $('#not_found').css('display', 'none');
                $('#complaint_product_chart_all_monthly').css({'display': '', 'height': '55vh', 'width': '80vw'});
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
                window.myChart = myChart;
            } else {
                $('#not_found').css('display', '');
                $('#complaint_product_chart_all_monthly').css('display', 'none');
            }
        }).catch(error => {
            console.log(error);
        });
    }
}