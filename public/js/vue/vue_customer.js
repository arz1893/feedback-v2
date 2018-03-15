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
        CSRF_TOKEN: $('meta[name="csrf-token"]').attr('content'),
        tenantId: $('#tenantId').val()
    },
    methods: {

        submitCustomer: function () {
            var vm = this;
            const url = window.location.protocol + "//" + window.location.host + '/api/customer/add-customer';
            this.$validator.validateAll().then((result) => {
                if (result) {
                    axios.post(url, {
                        tenantId: this.tenantId,
                        customer: this.customer
                    }).then(response => {
                        $('#customer_exist').css('display', 'none');
                        if(response.data.error === undefined) {
                            console.log(response.data.data);
                            var option = new Option(response.data.name + ' - ' + response.data.phone, response.data.systemId, false, false);
                            $('#customerId').append(option).trigger('change');
                            $('#customerId').val(response.data.systemId).trigger('change');

                            vm.customer.name = '';
                            vm.customer.gender = '';
                            vm.customer.phone = '';
                            vm.customer.birthdate = '';
                            vm.customer.email = '';
                            vm.customer.address = '';
                            vm.customer.nation = '';
                            vm.customer.city = '';
                            vm.customer.memo = '';

                            if(Root.is_anonymous != null) {
                                Root.is_anonymous = false;
                            }
                            if(Root.is_customer != null) {
                                Root.is_customer = true;
                            }
                            $('#modal_add_customer').modal('hide');
                            this.errors.clear();
                        } else {
                            console.log(response.data.error);
                            $('#customer_exist').removeAttr('style');
                        }
                    }) .catch(error => {
                        console.log(error);
                    });

                }
            });
        }
    }
});