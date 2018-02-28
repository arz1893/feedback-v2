if($('#complaint_product_chart').length > 0) {
    let ctx = document.getElementById('complaint_product_chart');
    const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_product_report/get-all-statistic/' + new Date().getFullYear();
    let complaintPerMonth = [];
    axios.get(url).then(response => {
        complaintPerMonth = response.data;

        if(complaintPerMonth !== null) {
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
        } else {
            $('#no_data_found').removeClass('invisible');
            $('#no_data_found').text('There is no data found in this year');
        }
    })
    .catch(error => {
        console.log(error);
    });

    $('#select_year').on('change', function () {
        let data = $(".select2-year option:selected").text();
        console.log(data);
    })
}