if($('#complaint_product_list_index').length > 0) {
    Vue.use(VeeValidate);

    var complaintProductListIndex = new Vue({
        el: '#complaint_product_list_index',
        data: {
            complaintProducts: [],
            complaintProduct: {
                systemId: '',
                customer_rating: '',
                customer_complaint: '',
                is_need_call: '',
                is_urgent: '',
                customer: [],
                product: [],
                productCategory: [],
                tenantId: '',
                is_answered: '',
                attachment: '',
                created_by: '',
                created_at: ''
            },
            complaintReplies: null,
            showReply: false,
            showDetail: false,
            searchStatus: '',
            reply_content: '',
            showConfirmDelete: false,
            paging: {
                currentPage: '',
                endPage: '',
                prevPage: null,
                nextPage: null
            },
            errorMessage: '',
            errorInputMessage: '',
            is_searched: false
        },
        created() {
            var tenantId = $('#tenantId').val();
            this.getComplaintProducts(tenantId);
        },

        methods: {
            getComplaintProducts: function (tenantId) {
                var vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_product/' + tenantId + '/get-all-complaint-product';
                axios.get(url).then(response => {
                    if(response.data.data.length > 0) {
                        vm.complaintProducts = response.data.data;
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
                var vm = this;
                var complaint_id = $(event.currentTarget).data('complaint_id');
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_product/' + complaint_id + '/get-complaint-product';

                axios.get(url).then(function (response) {
                    vm.complaintProduct.systemId = response.data.data.systemId;
                    vm.complaintProduct.customer_rating = response.data.data.customer_rating;
                    vm.complaintProduct.customer_complaint = response.data.data.customer_complaint;
                    vm.complaintProduct.is_need_call = response.data.data.is_need_call;
                    vm.complaintProduct.is_urgent = response.data.data.is_urgent;
                    vm.complaintProduct.customer = response.data.data.customer;
                    vm.complaintProduct.product = response.data.data.product;
                    vm.complaintProduct.productCategory = response.data.data.product_category;
                    vm.complaintProduct.tenantId = response.data.data.tenant_id;
                    vm.complaintProduct.is_answered = response.data.data.is_answered;
                    vm.complaintProduct.attachment = response.data.data.attachment;
                    vm.complaintProduct.created_by = response.data.data.created_by;
                    vm.complaintProduct.created_at = response.data.data.created_at;

                    if(response.data.data.customer !== null) {
                        vm.showAllComplaintReplies(response.data.data.systemId);
                    }
                })
                    .catch(error => {
                        alert('something wrong within the process');
                        console.log(error);
                    });
                $('#modal_complaint_product_show').modal('show');
            },

            showAllComplaintReplies: function (complaint_product_id) {
                var vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_product_reply/' + complaint_product_id + '/get-complaint-product-replies';
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

                var debounceFunction = _.debounce(getComplaintReplies, 1000);
                debounceFunction();
            },

            showReplyBox: function (event) {
                this.showReply = !this.showReply;
                this.replyTo = $('#reply_to').html();
            },
            submitReply: function (event) {
                var vm = this;
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
                        var complaintProductId  = $('#complaintProductId').val();
                        var customerId = (($('#customerId').length > 0) ? $('#customerId').val():null);
                        var reply_content = vm.reply_content;
                        var creatorId = $('#creatorId').val();
                        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_product_reply/' + complaintProductId + '/post-reply';

                        axios.post(url, {
                            complaintProductId: complaintProductId,
                            customerId: customerId,
                            reply_content: reply_content,
                            creatorId: creatorId
                        }).then(function (response) {
                            if(response.data.status === true) {
                                vm.showAllComplaintReplies(complaintProductId);
                            }
                        })
                            .catch(error => {
                                alert('whoops! there something wrong within the process');
                                console.log(error);
                            });
                        $('#collapseReply').collapse('hide');
                        $('#reply_content').val('');
                        vm.reply_content = '';
                    }
                })
                    .catch(error => {
                        console.log(error);
                    });
            },
            
            deleteComplaintProduct: function (event) {
                $('<input>').attr({
                    type: 'hidden',
                    name: 'complaint_id',
                    value: $(event.currentTarget).data('id')
                }).appendTo('#form_delete_complaint_product');
                $('#modal_remove_complaint_product').modal('show');
            },

            deleteReply: function (event) {
                var vm = this;
                var complaintProductId = vm.complaintProduct.systemId;
                var replyId = event.currentTarget.getAttribute('data-id');
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_product_reply/delete-reply';

                axios.post(url, {
                    replyId: replyId
                })
                    .then(response => {
                        if(response.data.status === true) {
                            vm.showAllComplaintReplies(complaintProductId);
                        }
                    })
                    .catch(error => {
                        alert('whoops! there is something wrong within the process');
                        console.log(error)
                    });
            }
        }
    });

    $('#modal_complaint_product_show').on('hidden.bs.modal', function (e) {
        $('#collapseReply').collapse('hide');
        $('#reply_content').val('');
        complaintProductListIndex.reply_content = '';
        complaintProductListIndex.complaintReplies = null;
        $('#collapseAllReplies').collapse('hide');
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

    $('#product_name').change(function () {
        $('#btnSearchProduct').removeClass('disabled');
        $('#btnSearchProduct').attr('onclick', 'searchByProduct()');
    });

    function searchByDate(selected) {
        complaintProductListIndex.searchStatus = 'Searching...';
        complaintProductListIndex.errorMessage = '';
        var date_start = $('#date_start').datepicker('getFormattedDate');
        var date_end = $('#date_end').datepicker('getFormattedDate');
        var tenantId = $('#tenantId').val();
        console.log(date_start, date_end, tenantId);
        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_product/' + tenantId + '/filter-by-date/' + date_start + '/' + date_end;

        function filterComplaint() {
            axios.get(url).then(response => {
                if(response.data.data.length !== 0) {
                    complaintProductListIndex.complaintProducts = response.data.data;
                    complaintProductListIndex.paging.currentPage = response.data.meta.current_page;
                    complaintProductListIndex.paging.endPage = response.data.meta.last_page;
                    complaintProductListIndex.paging.prev = (response.data.links.prev === null ? null:response.data.links.prev);
                    complaintProductListIndex.paging.next = (response.data.links.next === null ? null:response.data.links.next);
                    complaintProductListIndex.searchStatus = '';
                } else {
                    complaintProductListIndex.errorMessage = 'no data found';
                    complaintProductListIndex.searchStatus = '';
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
        $('#btnSearchProduct').addClass('disabled');
        $('#btnSearchProduct').attr('onclick', '');
        complaintProductListIndex.searchStatus = 'Loading...';
        complaintProductListIndex.errorMessage = '';
        $('#date_start').val('');
        $('#date_end').val('');
        $('#product_name').val('').trigger('change.select2');
        var tenantId = $('#tenantId').val();
        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_product/' + tenantId + '/get-all-complaint-product';
        function fireRequest() {
            axios.get(url).then(response => {
                complaintProductListIndex.searchStatus = '';
                if(response.data.data.length > 0) {
                    complaintProductListIndex.complaintProducts = response.data.data;
                    complaintProductListIndex.paging.currentPage = response.data.meta.current_page;
                    complaintProductListIndex.paging.endPage = response.data.meta.last_page;
                    complaintProductListIndex.paging.prev = (response.data.links.prev === null ? null:response.data.links.prev);
                    complaintProductListIndex.paging.next = (response.data.links.next === null ? null:response.data.links.next);
                    complaintProductListIndex.searchStatus = '';
                } else {
                    complaintProductListIndex.errorMessage = 'no data found';
                }
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
        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_product/' + tenantId + '/filter-by-customer/' + customerId;
        complaintProductListIndex.searchStatus = 'Searching...';
        complaintProductListIndex.errorMessage = '';

        function fireRequest() {
            axios.get(url).then(response => {
                if(response.data.data.length > 0) {
                    complaintProductListIndex.complaintProducts = response.data.data;
                    complaintProductListIndex.paging.currentPage = response.data.meta.current_page;
                    complaintProductListIndex.paging.endPage = response.data.meta.last_page;
                    complaintProductListIndex.paging.prev = (response.data.links.prev === null ? null:response.data.links.prev);
                    complaintProductListIndex.paging.next = (response.data.links.next === null ? null:response.data.links.next);
                    complaintProductListIndex.searchStatus = '';
                } else {
                    complaintProductListIndex.errorMessage = 'no data found';
                    complaintProductListIndex.searchStatus = '';
                }
            }).catch(error => {
                console.log(error);
            });
        }

        var debounceFunction = _.debounce(fireRequest, 1000);
        debounceFunction();
    }

    function searchByProduct() {
        var productId = $('#product_name').select2('data')[0].id;
        var tenantId = $('#tenantId').val();
        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_product/' + tenantId + '/filter-by-product/' + productId;
        complaintProductListIndex.searchStatus = 'Searching...';
        complaintProductListIndex.errorMessage = '';

        function fireRequest() {
            axios.get(url).then(response => {
                if(response.data.data.length > 0) {
                    complaintProductListIndex.complaintProducts = response.data.data;
                    complaintProductListIndex.paging.currentPage = response.data.meta.current_page;
                    complaintProductListIndex.paging.endPage = response.data.meta.last_page;
                    complaintProductListIndex.paging.prev = (response.data.links.prev === null ? null:response.data.links.prev);
                    complaintProductListIndex.paging.next = (response.data.links.next === null ? null:response.data.links.next);
                    complaintProductListIndex.searchStatus = '';
                } else {
                    complaintProductListIndex.errorMessage = 'no data found';
                    complaintProductListIndex.searchStatus = '';
                }
            }).catch(error => {
                console.log(error);
            });
        }

        var debounceFunction = _.debounce(fireRequest, 1000);
        debounceFunction();
    }
}