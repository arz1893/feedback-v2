if($('#suggestion_product_list_container').length > 0) {
    var suggestionProductList = new Vue({
        el: '#suggestion_product_list_container',
        data: {
            suggestionProducts: [],
            suggestionProduct: {
                systemId: '',
                customer_suggestion: '',
                customer: [],
                product: [],
                productCategory: [],
                tenantId: '',
                created_by: '',
                created_at: '',
                attachment: ''
            },
            paging: {
                currentPage: '',
                endPage: '',
                prevPage: null,
                nextPage: null,
                path: ''
            },
            searchStatus: '',
            errorMessage: ''
        },
        created() {
            var vm = this;
            var tenantId = $('#tenantId').val();
            vm.getAllSuggestionProduct(tenantId);
        },
        methods: {
            getAllSuggestionProduct: function (tenantId) {
                var vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/suggestion_product/' + tenantId + '/get-all-suggestion-product';
                axios.get(url).then(response => {
                    if(response.data.data.length > 0) {
                        vm.suggestionProducts = response.data.data;
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
                vm.paging.path = data.meta.path;
            },

            showSuggestionDetail: function (event) {
                var vm = this;
                var suggestion_id = $(event.currentTarget).data('suggestion_product_id');
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/suggestion_product/' + suggestion_id + '/get-suggestion-product';

                axios.get(url).then(function (response) {
                    vm.suggestionProduct.systemId = response.data.data.systemId;
                    vm.suggestionProduct.customer_suggestion = response.data.data.customer_suggestion;
                    vm.suggestionProduct.customer = response.data.data.customer;
                    vm.suggestionProduct.product = response.data.data.product;
                    vm.suggestionProduct.productCategory = response.data.data.productCategory;
                    vm.suggestionProduct.tenantId = response.data.data.tenantId;
                    vm.suggestionProduct.created_by = response.data.data.created_by;
                    vm.suggestionProduct.created_at = response.data.data.created_at;
                    vm.suggestionProduct.attachment = response.data.data.attachment;
                })
                    .catch(error => {
                        alert('whoops! something wrong within the process');
                        console.log(error);
                    });

                $('#modal_suggestion_product_show').modal('show');
            },

            deleteSuggestionProduct: function (event) {
                $('<input>').attr({
                    type: 'hidden',
                    name: 'suggestion_id',
                    value: $(event.currentTarget).data('id')
                }).appendTo('#form_delete_suggestion_product');
                $('#modal_remove_suggestion_product').modal('show');
            },

            changePage: function (url) {
                var vm = this;
                vm.searchStatus = 'Loading...';
                function fireRequest(vm) {
                    axios.get(url).then(response => {
                        vm.suggestionProducts = response.data.data;
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

    $('#product_name').change(function () {
        $('#btnSearchProduct').removeClass('disabled');
        $('#btnSearchProduct').attr('onclick', 'searchByProduct()');
    });

    function searchByDate(selected) {
        suggestionProductList.searchStatus = 'Searching...';
        suggestionProductList.errorMessage = '';
        var date_start = $('#date_start').val();
        var date_end = $('#date_end').val();
        var tenantId = $('#tenantId').val();
        console.log(date_start, date_end, tenantId);
        if(date_start !== '' && date_end !== '') {
            const url = window.location.protocol + "//" + window.location.host + "/" + 'api/suggestion_product/' + tenantId + '/filter-by-date/' + date_start + '/' + date_end;

            function filterComplaint() {
                axios.get(url).then(response => {
                    if(response.data.data.length !== 0) {
                        suggestionProductList.suggestionProducts = response.data.data;
                        suggestionProductList.paging.currentPage = response.data.meta.current_page;
                        suggestionProductList.paging.endPage = response.data.meta.last_page;
                        suggestionProductList.paging.prevPage = (response.data.links.prev === null ? null:response.data.links.prev);
                        suggestionProductList.paging.nextPage = (response.data.links.next === null ? null:response.data.links.next);
                        suggestionProductList.paging.path = response.data.meta.path;
                        suggestionProductList.searchStatus = '';
                    } else {
                        suggestionProductList.errorMessage = 'no data found';
                        suggestionProductList.searchStatus = '';
                        suggestionProductList.paging.currentPage = '';
                        suggestionProductList.paging.endPage = '';
                        suggestionProductList.paging.prevPage = '';
                        suggestionProductList.paging.nextPage = '';
                        suggestionProductList.paging.path = '';
                    }
                }).catch(error => {
                    console.log(error);
                });
            }

            var debounceFunction = _.debounce(filterComplaint, 1000);
            debounceFunction();
        } else {
            $('#date_start').addClass('has-error');
            $('#date_end').addClass('has-error');
            suggestionProductList.searchStatus = '';
        }
    }

    function clearSearch() {
        $('#btnSearchByDate').addClass('disabled');
        $('#btnSearchByDate').attr('onclick', '');
        $('#btnSearchProduct').addClass('disabled');
        $('#btnSearchProduct').attr('onclick', '');
        suggestionProductList.searchStatus = 'Searching...';
        suggestionProductList.errorMessage = '';
        $('#date_start').val('');
        $('#date_end').val('');
        $('#product_name').val('').trigger('change.select2');
        var tenantId = $('#tenantId').val();
        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/suggestion_product/' + tenantId + '/get-all-suggestion-product';
        function fireRequest() {
            axios.get(url).then(response => {
                suggestionProductList.searchStatus = '';
                if(response.data.data.length > 0) {
                    suggestionProductList.suggestionProducts = response.data.data;
                    suggestionProductList.paging.currentPage = response.data.meta.current_page;
                    suggestionProductList.paging.endPage = response.data.meta.last_page;
                    suggestionProductList.paging.prevPage = (response.data.links.prev === null ? null:response.data.links.prev);
                    suggestionProductList.paging.nextPage = (response.data.links.next === null ? null:response.data.links.next);
                    suggestionProductList.paging.path = response.data.meta.path;
                } else  {
                    suggestionProductList.errorMessage = 'no data found';
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
        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/suggestion_product/' + tenantId + '/filter-by-customer/' + customerId;
        suggestionProductList.searchStatus = 'Searching...';
        suggestionProductList.errorMessage = '';

        function fireRequest() {
            axios.get(url).then(response => {
                if(response.data.data.length > 0) {
                    suggestionProductList.suggestionProducts = response.data.data;
                    suggestionProductList.paging.currentPage = response.data.meta.current_page;
                    suggestionProductList.paging.endPage = response.data.meta.last_page;
                    suggestionProductList.paging.prevPage = (response.data.links.prev === null ? null:response.data.links.prev);
                    suggestionProductList.paging.nextPage = (response.data.links.next === null ? null:response.data.links.next);
                    suggestionProductList.searchStatus = '';
                } else {
                    suggestionProductList.errorMessage = 'no data found';
                    suggestionProductList.searchStatus = '';
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
        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/suggestion_product/' + tenantId + '/filter-by-product/' + productId;
        suggestionProductList.searchStatus = 'Searching...';
        suggestionProductList.errorMessage = '';

        function fireRequest() {
            axios.get(url).then(response => {
                if(response.data.data.length > 0) {
                    suggestionProductList.suggestionProducts = response.data.data;
                    suggestionProductList.paging.currentPage = response.data.meta.current_page;
                    suggestionProductList.paging.endPage = response.data.meta.last_page;
                    suggestionProductList.paging.prevPage = (response.data.links.prev === null ? null:response.data.links.prev);
                    suggestionProductList.paging.nextPage = (response.data.links.next === null ? null:response.data.links.next);
                    suggestionProductList.paging.path = response.data.meta.path;
                    suggestionProductList.searchStatus = '';
                } else {
                    suggestionProductList.errorMessage = 'no data found';
                    suggestionProductList.searchStatus = '';
                    suggestionProductList.paging.currentPage = '';
                    suggestionProductList.paging.endPage = '';
                    suggestionProductList.paging.prevPage = '';
                    suggestionProductList.paging.nextPage = '';
                    suggestionProductList.paging.path = '';
                }
            }).catch(error => {
                console.log(error);
            });
        }

        var debounceFunction = _.debounce(fireRequest, 1000);
        debounceFunction();
    }
}