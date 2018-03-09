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
                        // console.log(response);
                        // console.log(response.data.systemId, response.data.name, response.data.phone);
                        var option = new Option(response.data.name + ' - ' + response.data.phone, response.data.systemId, false, false);
                        $('#customerId').append(option ).trigger('change');

                        if(Root.is_anonymous != null) {
                            Root.is_anonymous = false;
                        }
                        if(Root.is_customer != null) {
                            Root.is_customer = true;
                        }
                        $('#modal_add_customer').modal('hide');
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