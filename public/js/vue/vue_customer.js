Vue.use(VeeValidate);

var modal_add_customer = new Vue({
    el: '#modal_add_customer',
    data: {
        customer: {
            name: '',
            gender: '',
            email: '',
            phone: '',
            birthdate: '',
            address: '',
            nation: '',
            city: '',
            memo: ''
        },
        CSRF_TOKEN: $('meta[name="csrf-token"]').attr('content')
    },
    methods: {

        submitCustomer: function () {
            this.$validator.validateAll().then((result) => {
                if (result) {
                    axios.post(window.location.protocol + "//" + window.location.host + "/" + 'customer',this.customer)
                        .then(response => {
                        console.log(response);
                })
                .catch(error => {
                        console.log(error);
                });
                    // eslint-disable-next-line
                }
            });
        }
    }
});