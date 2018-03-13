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
                nextPage: null
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
                    name: 'complaint_id',
                    value: $(event.currentTarget).data('id')
                }).appendTo('#form_delete_suggestion_product');
                $('#modal_remove_suggestion_product').modal('show');
            },
        }
    });

    function searchByDate(selected) {
        $('#btnClearSearch').removeClass('disabled');
        $('#btnClearSearch').attr('onclick', 'clearSearch()');
        suggestionProductList.searchStatus = 'Searching...';
        suggestionProductList.errorMessage = '';
        var date_start = $('#date_start').datepicker('getFormattedDate');
        var date_end = $('#date_end').datepicker('getFormattedDate');
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
                        suggestionProductList.paging.prev = (response.data.links.prev === null ? null:response.data.links.prev);
                        suggestionProductList.paging.next = (response.data.links.next === null ? null:response.data.links.next);
                        suggestionProductList.searchStatus = '';
                    } else {
                        suggestionProductList.errorMessage = 'no data found';
                        suggestionProductList.searchStatus = '';
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
        $('#btnClearSearch').addClass('disabled');
        $('#btnClearSearch').attr('onclick', '');
        suggestionProductList.searchStatus = 'Searching...';
        suggestionProductList.errorMessage = '';
        $('#date_start').val('');
        $('#date_end').val('');
        var tenantId = $('#tenantId').val();
        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/suggestion_product/' + tenantId + '/get-all-suggestion-product';
        function fireRequest() {
            axios.get(url).then(response => {
                suggestionProductList.suggestionProducts = response.data.data;
                suggestionProductList.searchStatus = '';
            }).catch(error => {
                console.log(error);
            });
        }

        var debounceFunction = _.debounce(fireRequest, 1000);
        debounceFunction();
    }
}