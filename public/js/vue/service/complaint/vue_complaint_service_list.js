if($('#complaint_service_list_index').length > 0) {
    Vue.use(VeeValidate);
    let complaintServiceListIndex = new Vue({
        el: '#complaint_service_list_index',
        created() {
            var tenantId = $('#tenantId').val();
            this.getAllComplaintServices(tenantId);
        },
        data: {
            complaintServices: [],
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
            paging: {
                currentPage: '',
                endPage: '',
                prevPage: null,
                nextPage: null,
                path: ''
            },
            reply_content: '',
            complaintReplies: null,
            showReply: false,
            showDetail: false,
            searchStatus: '',
            errorMessage: ''
        },
        methods: {
            getAllComplaintServices: function (tenantId) {
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_service/' + tenantId + '/get-all-complaint-service';
                var vm = this;
                axios.get(url).then(response => {
                    if(response.data.data.length > 0) {
                        vm.complaintServices = response.data.data;
                        vm.makePagination(response.data);
                    } else {
                        vm.errorMessage = 'no data found';
                    }
                }).catch(error => {
                    console.log(error);
                });
            },

            makePagination: function (data) {
                var vm = this;
                vm.paging.currentPage = data.meta.current_page;
                vm.paging.endPage = data.meta.last_page;
                vm.paging.prevPage = (data.links.prev === null ? null:data.links.prev);
                vm.paging.nextPage = (data.links.next === null ? null:data.links.next);
            },
            
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
                let vm = this;
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
                        let complaint_service_id = $('#complaintServiceId').val();
                        let customerId = (($('#customerId').length > 0) ? $('#customerId').val():null);
                        let reply_content = vm.reply_content;
                        let creatorId = $('#creatorId').val();
                        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_service_reply/' + complaint_service_id + '/post-reply';

                        axios.post(url, {
                            complaintServiceId: complaint_service_id,
                            reply_content: reply_content,
                            customerId: customerId,
                            creatorId: creatorId
                        })
                            .then(response => {
                                if(response.data.status === true) {
                                    vm.showAllComplaintReplies(complaint_service_id);
                                }
                            })
                            .catch(error => {
                                alert('whoops! there something wrong within the process');
                                console.log(error);
                            });
                        vm.reply_content = '';
                        $('#reply_content').val('');
                        $('#collapseReply').collapse('hide');
                    }
                })
                    .catch(error => {
                        console.log(error);
                    });
            },

            deleteComplaintService: function (event) {
                $('<input>').attr({
                    type: 'hidden',
                    name: 'complaint_id',
                    value: $(event.currentTarget).data('id')
                }).appendTo('#form_delete_complaint_service');
                $('#modal_remove_complaint_service').modal('show');
            },

            deleteReply: function (event) {
                let vm = this;
                let complaintServiceId = vm.complaintService.systemId;
                let replyId = event.currentTarget.getAttribute('data-id');
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_service_reply/delete-reply';

                axios.post(url, {
                    replyId: replyId
                })
                .then(response => {
                    if(response.data.status === true) {
                        vm.showAllComplaintReplies(complaintServiceId);
                    }
                })
                .catch(error => {

                });
            },

            changePage: function (url) {
                var vm = this;
                vm.searchStatus = 'Loading...';
                function fireRequest(vm) {
                    axios.get(url).then(response => {
                        vm.complaintServices = response.data.data;
                        vm.makePagination(response.data);
                        vm.searchStatus = '';
                    }).catch(error => {
                        console.log('something wrong within the process');
                        console.log(Object.assign({}, error));
                    });
                }

                var debounceFunction = _.debounce(fireRequest, 1000);
                debounceFunction(vm);
            }
        }
    });

    $('#date_start').change(function () {
        if($('#date_start').val() !== '' && $('#date_end').val() !== '') {
            $('#btnSearchByDate').removeClass('disabled');
            $('#btnSearchByDate').attr('onclick', 'searchByDate(this)');
        } else {
            $('#btnSearchByDate').addClass('disabled');
            $('#btnSearchByDate').attr('onclick', '');
        }
    });

    $('#date_end').change(function () {
        if($('#date_end').val() !== '' && $('#date_start').val() !== '') {
            $('#btnSearchByDate').removeClass('disabled');
            $('#btnSearchByDate').attr('onclick', 'searchByDate(this)');
        } else {
            $('#btnSearchByDate').addClass('disabled');
            $('#btnSearchByDate').attr('onclick', '');
        }
    });

    $('#service_name').change(function () {
        $('#btnSearchService').removeClass('disabled');
        $('#btnSearchService').attr('onclick', 'searchByService()');
    });

    function searchByDate(selected) {
        $('#btnClearSearch').removeClass('disabled');
        $('#btnClearSearch').attr('onclick', 'clearSearch()');
        complaintServiceListIndex.searchStatus = 'Searching...';
        complaintServiceListIndex.errorMessage = '';
        var date_start = $('#date_start').val();
        var date_end = $('#date_end').val();
        var tenantId = $('#tenantId').val();
        console.log(date_start, date_end);
        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_service/' + tenantId + '/filter-by-date/' + date_start + '/' + date_end;

        function filterComplaint() {
            axios.get(url).then(response => {
                if(response.data.data.length > 0) {
                    complaintServiceListIndex.complaintServices = response.data.data;
                    complaintServiceListIndex.paging.currentPage = response.data.meta.current_page;
                    complaintServiceListIndex.paging.endPage = response.data.meta.last_page;
                    complaintServiceListIndex.paging.prev = (response.data.links.prev === null ? null:response.data.links.prev);
                    complaintServiceListIndex.paging.next = (response.data.links.next === null ? null:response.data.links.next);
                    complaintServiceListIndex.paging.path = response.data.meta.path;
                    complaintServiceListIndex.searchStatus = '';
                } else {
                    complaintServiceListIndex.errorMessage = 'no data found';
                    complaintServiceListIndex.searchStatus = '';
                }
            }).catch(error => {
                console.log(error);
            });
        }

        var debounceFunction = _.debounce(filterComplaint, 1000);
        debounceFunction();
    }

    function clearSearch() {
        $('#btnSearchByDate').addClass('disabled');
        $('#btnSearchByDate').attr('onclick', '');
        $('#btnSearchService').addClass('disabled');
        $('#btnSearchService').attr('onclick', '');
        complaintServiceListIndex.searchStatus = 'Searching...';
        complaintServiceListIndex.errorMessage = '';
        $('#date_start').val('');
        $('#date_end').val('');
        $('#service_name').val('').trigger('change.select2');
        var tenantId = $('#tenantId').val();
        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_service/' + tenantId + '/get-all-complaint-service';
        function fireRequest() {
            axios.get(url).then(response => {
                complaintServiceListIndex.complaintServices = response.data.data;
                complaintServiceListIndex.paging.currentPage = response.data.meta.current_page;
                complaintServiceListIndex.paging.endPage = response.data.meta.last_page;
                complaintServiceListIndex.paging.prev = (response.data.links.prev === null ? null:response.data.links.prev);
                complaintServiceListIndex.paging.next = (response.data.links.next === null ? null:response.data.links.next);
                complaintServiceListIndex.paging.path = response.data.meta.path;
                complaintServiceListIndex.searchStatus = '';
            }).catch(error => {
                console.log(error);
            });
        }

        var debounceFunction = _.debounce(fireRequest, 1000);
        debounceFunction();
    }

    function searchByCustomer() {
        var customerId = $('#customer_name').select2('data')[0].id;
        var tenantId = $('#tenantId').val();
        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_service/' + tenantId + '/filter-by-customer/' + customerId;
        complaintServiceListIndex.searchStatus = 'Searching...';
        complaintServiceListIndex.errorMessage = '';

        function fireRequest() {
            axios.get(url).then(response => {
                if(response.data.data.length > 0) {
                    complaintServiceListIndex.complaintServices = response.data.data;
                    complaintServiceListIndex.paging.currentPage = response.data.meta.current_page;
                    complaintServiceListIndex.paging.endPage = response.data.meta.last_page;
                    complaintServiceListIndex.paging.prev = (response.data.links.prev === null ? null:response.data.links.prev);
                    complaintServiceListIndex.paging.next = (response.data.links.next === null ? null:response.data.links.next);
                    complaintServiceListIndex.searchStatus = '';
                } else {
                    complaintServiceListIndex.errorMessage = 'no data found';
                    complaintServiceListIndex.searchStatus = '';
                }
            }).catch(error => {
                console.log(error);
            });
        }

        var debounceFunction = _.debounce(fireRequest, 1000);
        debounceFunction();
    }

    function searchByService() {
        var serviceId = $('#service_name').select2('data')[0].id;
        var tenantId = $('#tenantId').val();
        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_service/' + tenantId + '/filter-by-service/' + serviceId;
        console.log(serviceId, tenantId);
        complaintServiceListIndex.searchStatus = 'Searching...';
        complaintServiceListIndex.errorMessage = '';

        function fireRequest() {
            axios.get(url).then(response => {
                if(response.data.data.length > 0) {
                    complaintServiceListIndex.complaintServices = response.data.data;
                    complaintServiceListIndex.paging.currentPage = response.data.meta.current_page;
                    complaintServiceListIndex.paging.endPage = response.data.meta.last_page;
                    complaintServiceListIndex.paging.prev = (response.data.links.prev === null ? null:response.data.links.prev);
                    complaintServiceListIndex.paging.next = (response.data.links.next === null ? null:response.data.links.next);
                    complaintServiceListIndex.paging.path = response.data.meta.path;
                    complaintServiceListIndex.searchStatus = '';
                } else {
                    complaintServiceListIndex.errorMessage = 'no data found';
                    complaintServiceListIndex.searchStatus = '';
                }
            }).catch(error => {
                console.log(error);
            });
        }

        var debounceFunction = _.debounce(fireRequest, 1000);
        debounceFunction();
    }

    $('#modal_complaint_service_show').on('hidden.bs.modal', function (e) {
        $('#collapseReply').collapse('hide');
        $('#reply_content').val('');
        complaintServiceListIndex.reply_content = '';
        complaintServiceListIndex.complaintReplies = null;
        $('#collapseAllReplies').collapse('hide');
    })
}