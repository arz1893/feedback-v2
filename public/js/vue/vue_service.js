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
            function filterServices() {
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
            let debounceFunction = _.debounce(filterServices, 1000);
            debounceFunction();
        } else {
            const url = window.location.protocol + "//" + window.location.host + "/" + 'api/service/' + tenantId + '/get-service-list';
            serviceIndex.searchStatus = 'Loading...';
            function getServices() {
                axios.get(url).then(response => {
                    serviceIndex.services = response.data.data;
                    serviceIndex.searchStatus = '';
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

if($('#complaint_service_list_index').length > 0) {
    Vue.use(VeeValidate);
    let complaintServiceListIndex = new Vue({
        el: '#complaint_service_list_index',
        data: {
            complaintService: {
                systemId: '',
                customer_rating: '',
                customer_complaint: '',
                is_need_call: '',
                is_urgent: '',
                customer: [],
                service: [],
                serviceCategory: [],
                tenantId: '',
                is_answered: '',
                attachment: '',
                created_by: '',
                created_at: ''
            },
            complaintReplies: null,
            showReply: false,
            showDetail: false,
            searchStatus: ''
        },
        methods: {
            showComplaintDetail: function (event) {
                let vm = this;
                let complaint_id = $(event.currentTarget).data('complaint_id');
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_service/' + complaint_id + '/get-complaint-service';

                axios.get(url).then(function (response) {
                    vm.complaintService.systemId = response.data.data.systemId;
                    vm.complaintService.customer_rating = response.data.data.customer_rating;
                    vm.complaintService.customer_complaint = response.data.data.customer_complaint;
                    vm.complaintService.is_need_call = response.data.data.is_need_call;
                    vm.complaintService.is_urgent = response.data.data.is_urgent;
                    vm.complaintService.customer = response.data.data.customer;
                    vm.complaintService.service = response.data.data.service;
                    vm.complaintService.serviceCategory = response.data.data.service_category;
                    vm.complaintService.tenantId = response.data.data.tenant_id;
                    vm.complaintService.is_answered = response.data.data.is_answered;
                    vm.complaintService.attachment = response.data.data.attachment;
                    vm.complaintService.created_at = response.data.data.created_at;

                    if(response.data.data.customer !== null) {
                        vm.showAllComplaintReplies(response.data.data.systemId);
                    }
                })
                .catch(error => {
                    alert('something wrong within the process');
                    console.log(error);
                });
                $('#modal_complaint_service_show').modal('show');
            },

            showAllComplaintReplies: function (complaint_service_id) {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_service_reply/' + complaint_service_id + '/get-complaint-service-replies';
                this.searchStatus = 'Loading Data...';
                function getComplaintReplies() {
                    axios.get(url).then(function (response) {
                        if(response.data === '') {
                            vm.complaintReplies = null;
                            vm.searchStatus = '';
                        } else {
                            vm.complaintReplies = response.data;
                            vm.searchStatus = '';
                        }
                    })
                    .catch(error => {
                        alert('something wrong within the process');
                        console.log(error);
                    });
                }

                let debounceFunction = _.debounce(getComplaintReplies, 1000);
                debounceFunction();
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

if($('#suggestion_service_list_container').length > 0) {
    let suggestionServiceList = new Vue({
        el: '#suggestion_service_list_container',
        data: {
            suggestionService: {
                systemId: '',
                customer_suggestion: '',
                customer: [],
                service: [],
                serviceCategory: [],
                tenantId: '',
                created_by: '',
                created_at: '',
                attachment: ''
            },
            searchStatus: ''
        },
        methods: {
            showSuggestionDetail: function (event) {
                let vm = this;
                let suggestion_id = $(event.currentTarget).data('suggestion_service_id');
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/suggestion_service/' + suggestion_id + '/get-suggestion-service';

                axios.get(url).then(function (response) {
                    vm.suggestionService.systemId = response.data.data.systemId;
                    vm.suggestionService.customer_suggestion = response.data.data.customer_suggestion;
                    vm.suggestionService.customer = response.data.data.customer;
                    vm.suggestionService.service = response.data.data.service;
                    vm.suggestionService.serviceCategory = response.data.data.serviceCategory;
                    vm.suggestionService.tenantId = response.data.data.tenantId;
                    vm.suggestionService.created_by = response.data.data.created_by;
                    vm.suggestionService.created_at = response.data.data.created_at;
                    vm.suggestionService.attachment = response.data.data.attachment;
                })
                    .catch(error => {
                        alert('whoops! something wrong within the process');
                        console.log(error);
                    });

                $('#modal_suggestion_service_show').modal('show');
            }
        }
    });
}



