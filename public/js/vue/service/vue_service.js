if($('#vue_service_container').length > 0) {
    var Root = new Vue({
        el: '#vue_service_container',
        data: {
            nodeTitle: '',
            serviceId: '',
            serviceCategoryId: '',
            show: true,
            ratingValue: '',
            is_anonymous: true,
            is_customer: true,
            showAttachment: false
        },
        created: function () {

        },
        methods: {
            append: function(title, serviceId, serviceCategoryId) {
                $('#btn_show_category_navigator').removeClass('hidden');
                $('#panel_service').removeClass('hidden');
                $('#category_navigator').addClass('hidden');
                // this.show = false;
                this.nodeTitle = title;
                this.serviceId = '<input type="hidden" name="serviceId" value="' + serviceId +'">';
                this.serviceCategoryId = '<input type="hidden" name="serviceCategoryId" value="' + serviceCategoryId +'">';
            },

            showNavigator: function () {
                // this.show = true;
                $('#btn_show_category_navigator').addClass('hidden');
                $('#panel_service').addClass('hidden');
                $('#category_navigator').removeClass('hidden');
            },

            customerRating: function (value, event) {
                // console.log(value);
                // console.log(event.currentTarget.id);
                $('i.smiley_rating').each(function (index, element) {
                    $(element).removeClass('is-selected');
                });
                $('#' + event.currentTarget.id).addClass('is-selected');
                switch (value) {
                    case 1 : {
                        $('input[name=customer_rating]').attr('checked',false);
                        $('#radio_very_dissatisfied').attr('checked', 'checked');
                        break;
                    }
                    case 2: {
                        $('input[name=customer_rating]').attr('checked',false);
                        $('#radio_dissatisfied').attr('checked', 'checked');
                        break;
                    }
                    case 3: {
                        $('input[name=customer_rating]').attr('checked',false);
                        $('#radio_neutral').attr('checked', 'checked');
                        break;
                    }
                    case 4: {
                        $('input[name=customer_rating]').attr('checked',false);
                        $('#radio_satisfied').attr('checked', 'checked');
                        break;
                    }
                    case 5: {
                        $('input[name=customer_rating]').attr('checked',false);
                        $('#radio_very_satisfied').attr('checked', 'checked');
                        break;
                    }
                }

            },

            onChangeCustomer: function (value) {
                if(value.length === 0) {
                    this.is_anonymous = true;
                    $('#is_need_call').prop('checked', false);
                } else {
                    this.is_anonymous = false;
                }
            },

            onChangeEditCustomer: function (event) {
                if(event.currentTarget.value !== '') {
                    this.is_anonymous = false;
                    this.is_customer = true;
                } else if (event.currentTarget.value === '') {
                    this.is_customer = false;
                    this.is_anonymous = true;
                    $('#is_need_call').prop('checked', false);
                }
            },

            previewImage: function (event) {
                var attachment = event.target;
                if(attachment.files && attachment.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#preview').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(attachment.files[0]);
                }
                this.showAttachment = true;
            },

            clearAttachment: function(event) {
                $('#preview').removeAttr('src');
                $('#attachment').val("");
                $('#image_cover').val("");
                this.showAttachment = false;
            }
        }
    });

    $('#customerId').on("change", function () {
        Root.onChangeCustomer($(this).val());
    });
}

if($('#service_index').length > 0) {
    let serviceIndex = new Vue({
        el: '#service_index',
        created() {
            let tenantId = $('#tenantId').val();
            let tags = $('#select_tags').val();
            this.getServices(tenantId, tags);
        },
        data: {
            tenantId : $('#tenantId').val(),
            tags: [],
            services: [],
            pagination: {
                current_page: '',
                first_page_link: '',
                last_page_link: '',
                next_page_link: '',
                prev_page_link: '',
                total_page: '',
                path: '',
            },
            searchString: '',
            searchStatus: '',
            errorMessage: ''
        },
        computed: {
            filteredServices: function () {
                let vm = this;
                let result = this.services.filter((service) => {
                    return service.name.toLowerCase().match(this.searchString.toLowerCase());
                });

                if(result.length === 0) {
                    vm.errorMessage = 'no data found';
                } else {
                    vm.errorMessage = '';
                    return result;
                }
            }  
        },
        methods: {
            getServices: function (id, tags) {
                let vm = this;
                if(tags.length === 0) {
                    const url = window.location.protocol + "//" + window.location.host + "/" + 'api/service/' + id + '/get-service-list';

                    axios.get(url).then(response => {
                        if(response.data.data.length === 0) {
                            vm.services = response.data.data;
                            vm.errorMessage = 'no data found';
                        } else {
                            vm.services = response.data.data;
                            vm.errorMessage = '';
                            vm.makePagination(response.data);
                        }
                    }).catch(error => {
                        console.log('something wrong within the process');
                    });
                } else {
                    const url = window.location.protocol + "//" + window.location.host + "/" + 'api/service/' + id + '/filter-service-list/' + tags;
                    axios.get(url)
                    .then(function (response) {
                        if(response.data.data.length === 0) {
                            vm.services = response.data.data;
                            vm.errorMessage = 'no data found';
                        } else {
                            vm.errorMessage = '';
                            vm.services = response.data.data;
                            vm.makePagination(response.data);
                        }
                    })
                    .catch(error => {
                        console.log(Object.assign({}, error));
                    });
                }

            },

            makePagination: function (data) {
                let vm = this;
                vm.pagination.current_page = data.meta.current_page;
                vm.pagination.first_page_link = data.links.first;
                vm.pagination.last_page_link = data.links.last;
                vm.pagination.next_page_link = data.links.next;
                vm.pagination.prev_page_link = data.links.prev;
                vm.pagination.total_page = data.meta.last_page;
                vm.pagination.path = data.meta.path;
            },

            nextPage: function (url) {
                let vm = this;
                vm.searchStatus = 'Loading...';
                function fireRequest(vm) {
                    axios.get(url).then(response => {
                        vm.services = response.data.data;
                        vm.makePagination(response.data);
                        vm.searchStatus = '';
                    }).catch(error => {
                        console.log('something wrong within the process');
                        console.log(Object.assign({}, error));
                    });
                }

                let debounceFunction = _.debounce(fireRequest, 1000);
                debounceFunction(vm);
            }
        }
    });

    function filterByName() {
        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/service/' + serviceIndex.tenantId + '/filter-by-name/' + serviceIndex.searchString;
        serviceIndex.searchStatus = 'Searching...';
        serviceIndex.errorMessage = '';
        if(serviceIndex.searchString !== '') {
            function fireRequest() {
                axios.get(url).then(response => {
                    if(response.data.data.length === 0) {
                        serviceIndex.errorMessage = 'no data found';
                        serviceIndex.searchStatus = '';
                        serviceIndex.services = response.data.data;
                    } else {
                        serviceIndex.services = response.data.data;
                        serviceIndex.makePagination(response.data);
                        serviceIndex.searchStatus = '';
                    }
                }).catch(error => {
                    console.log(error);
                });
            }

            var debounceFunction = _.debounce(fireRequest, 1000);
            debounceFunction();
        } else {
            var tagIds = $('#select_tags').val();
            var tenantId = $('#tenantId').val();
            if (tagIds.length > 0) {
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/service/' + tenantId + '/filter-service-list/' + tagIds;
                serviceIndex.searchStatus = 'Searching...';
                function filterServices() {

                    axios.get(url)
                        .then(function (response) {
                            if(response.data.data.length === 0) {
                                serviceIndex.services = response.data.data;
                                serviceIndex.errorMessage = 'no data found';
                                serviceIndex.searchStatus = '';
                            } else {
                                serviceIndex.services = response.data.data;
                                serviceIndex.makePagination(response.data);
                                serviceIndex.errorMessage = '';
                                serviceIndex.searchStatus = '';
                            }
                        })
                        .catch(error => {
                            console.log(Object.assign({}, error));
                        });
                }
                //debounce buat trigger function setelah 0.5 detik
                var debounceFunction = _.debounce(filterServices, 1000);
                debounceFunction();
            } else {
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/service/' + tenantId + '/get-service-list';
                serviceIndex.searchStatus = 'Loading...';
                function getServices() {
                    axios.get(url).then(response => {
                        if(response.data.data.length === 0) {
                            serviceIndex.services = response.data.data;
                            serviceIndex.errorMessage = 'no data found';
                        } else {
                            serviceIndex.services = response.data.data;
                            serviceIndex.makePagination(response.data);
                            serviceIndex.errorMessage = '';
                            serviceIndex.searchStatus = '';
                        }
                    }).catch(error => {
                        console.log(Object.assign({}, error));
                    });
                }
                //debounce buat trigger function setelah 0.5 detik
                var debounceFunction = _.debounce(getServices, 1000);
                debounceFunction();
            }
        }
    }

    $('#select_tags').on('change', function () {
        let tagIds = $(this).val();
        let tenantId = $('#tenantId').val();
        if(tagIds.length > 0) {
            const url = window.location.protocol + "//" + window.location.host + "/" + 'api/service/' + tenantId + '/filter-service-list/' + tagIds;
            serviceIndex.searchStatus = 'Searching...';
            serviceIndex.errorMessage = '';
            serviceIndex.searchString = '';
            function filterServices() {
                axios.get(url)
                .then(function (response) {
                    if(response.data.data.length === 0) {
                        serviceIndex.errorMessage = 'no data found';
                        serviceIndex.services = response.data.data;
                        serviceIndex.searchStatus = '';
                    } else {
                        serviceIndex.errorMessage = '';
                        serviceIndex.searchStatus = '';
                        serviceIndex.services = response.data.data;
                        serviceIndex.makePagination(response.data);
                    }
                })
                .catch(error => {
                    console.log(Object.assign({}, error));
                });
            }
            //debounce buat trigger function setelah 1 detik
            let debounceFunction = _.debounce(filterServices, 1000);
            debounceFunction();
        } else {
            const url = window.location.protocol + "//" + window.location.host + "/" + 'api/service/' + tenantId + '/get-service-list';
            serviceIndex.searchStatus = 'Loading...';
            serviceIndex.errorMessage = '';
            serviceIndex.searchString = '';
            function getServices() {
                axios.get(url).then(response => {
                    if(response.data.data.length === 0) {
                        serviceIndex.errorMessage = 'no data found';
                        serviceIndex.searchStatus = '';
                    } else {
                        serviceIndex.errorMessage = '';
                        serviceIndex.searchStatus = '';
                        serviceIndex.services = response.data.data;
                    }
                }).catch(error => {
                    console.log(Object.assign({}, error));
                });
            }
            //debounce buat trigger function setelah 1 detik
            let debounceFunction = _.debounce(getServices, 1000);
            debounceFunction();
        }
    });
}



