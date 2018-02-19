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

if($('#complaint_service_list_show').length > 0) {
    Vue.use(VeeValidate);
    var complaintServiceListContainer = new Vue({
        el:'#complaint_service_list_show',
        data: {
            showReply: false,
            replyTo: '',
            replyId: ''
        },
        methods: {
            showReplyBox: function (event) {
                this.showReply = !this.showReply
                this.replyTo = $('#reply_to').html();
            },
            submitReply: function (event) {
                const dict = {
                    custom: {
                        reply_content: {
                            required: 'please enter reply content' // messages can be strings as well.
                        }
                    }
                };
                this.$validator.localize('en', dict);
                this.$validator.validateAll().then((result) => {
                    if(result) {
                        $('#form_complaint_service_reply').submit();
                    }
                })
                .catch(error => {
                        console.log(error);
                });
            },
            
            deleteReply: function (event) {
                console.log(event.currentTarget.getAttribute('data-id'));
                this.replyId = '<input type="hidden" name="id" value="' + event.currentTarget.getAttribute('data-id') + '">';
                $('#modal_remove_complaint_service_reply').modal('show');
            }
        }
    });
}

if($('#service_index').length > 0) {
    let serviceIndex = new Vue({
        el: '#service_index',
        created() {
            let tenantId = $('#tenantId').val();
            this.getServices(tenantId);
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
            searchStatus: ''
        },
        computed: {
            filteredServices: function () {
                return this.services.filter((service) => {
                    return service.name.toLowerCase().match(this.searchString.toLowerCase());
                });
            }  
        },
        methods: {
            getServices: function () {
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/service/' + this.tenantId + '/get-service-list';

                axios.get(url).then(response => {
                    this.services = response.data.data;
                    this.makePagination(response.data);
                }).catch(error => {
                    console.log('something wrong within the process');
                });
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

    $('#select_tags').on('change', function () {
        let tagIds = $(this).val();
        let tenantId = $('#tenantId').val();
        if(tagIds.length > 0) {
            const url = window.location.protocol + "//" + window.location.host + "/" + 'api/service/' + tenantId + '/filter-service-list';
            serviceIndex.searchStatus = 'Searching...';
            function filterProducts() {
                axios.post(url, {
                    tags: tagIds
                })
                    .then(function (response) {
                        serviceIndex.services = response.data.data;
                        serviceIndex.searchStatus = '';
                    })
                    .catch(error => {
                        console.log(Object.assign({}, error));
                    });
            }
            //debounce buat trigger function setelah 1 detik
            let debounceFunction = _.debounce(filterProducts, 1000);
            debounceFunction();
        } else {
            const url = window.location.protocol + "//" + window.location.host + "/" + 'api/service/' + tenantId + '/get-service-list';
            serviceIndex.searchStatus = 'Loading...';
            function getProducts() {
                axios.get(url).then(response => {
                    serviceIndex.services = response.data.data;
                    serviceIndex.searchStatus = '';
                }).catch(error => {
                    console.log(Object.assign({}, error));
                });
            }
            //debounce buat trigger function setelah 1 detik
            let debounceFunction = _.debounce(getProducts, 1000);
            debounceFunction();
        }
    });
}

