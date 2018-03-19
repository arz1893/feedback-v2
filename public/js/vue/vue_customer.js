if($('#modal_add_customer').length > 0) {
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
}

if($('#modal_edit_customer').length > 0) {
    Vue.use(VeeValidate);
    
    var modal_edit_customer = new Vue({
        el: '#modal_edit_customer',
        data: {
            customer: {
                systemId: '',
                name: '',
                address: '',
                city: '',
                nation: '',
                email: '',
                gender: '',
                phone: '',
                birthdate: '',
                memo: '',
                tenantId: '',
                created_at: ''
            }
        },
        methods: {
            updateCustomer: function () {
                var vm = this;
                const url = window.location.protocol + "//" + window.location.host + '/api/customer/update-customer';
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post(url, {
                            customer: this.customer
                        }).then(response => {
                            if(response.data.message === 'success') {
                                $('#modal_edit_customer').modal('hide');
                                $('#alert_customer_success').css('display', '');
                                location.reload();
                            } else {
                                alert('whoops! there is something wrong within the process');
                            }
                        }).catch(error => {
                            console.log(error);
                        });
                    }
                });
            }
        }
    });
    
    function showCustomer(selected) {
        var customerId = $(selected).data('id');
        const url = window.location.protocol + "//" + window.location.host + '/api/customer/get-customer';
        $('#alert_customer_success').css('display', 'none');

        axios.post(url, {
            customerId: customerId
        }).then(response => {
            modal_edit_customer.customer.systemId = response.data.data.systemId,
            modal_edit_customer.customer.name = response.data.data.name,
            modal_edit_customer.customer.address = response.data.data.address,
            modal_edit_customer.customer.city = response.data.data.city,
            modal_edit_customer.customer.email = response.data.data.email,
            modal_edit_customer.customer.gender = response.data.data.gender,
            modal_edit_customer.customer.phone = response.data.data.phone,
            modal_edit_customer.customer.birthdate = response.data.data.birthdate,
            modal_edit_customer.customer.memo = response.data.data.memo,
            modal_edit_customer.customer.tenantId = response.data.data.tenantId,
            modal_edit_customer.customer.created_at = response.data.data.created_at
        }).catch(error => {
            console.log(error);
        });
    }
}