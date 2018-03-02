if($('#complaint_product_chart').length > 0) {
    let complaintProductChart = new Vue({
        el: '#complaint_product_chart',
        created: function () {
            const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_product_report/get-monthly-complaint/' + new Date().getFullYear();
            axios.post(url, {
                tenantId: $('#tenant_id').val()
            }).then(response => {
                chartData = response.data;
            }).catch(error => {

            })
        },
        data: {
            chartData: [],
            tenantId: '',
            selectedYear: ''
        },
        methods: {

        }
    });
}