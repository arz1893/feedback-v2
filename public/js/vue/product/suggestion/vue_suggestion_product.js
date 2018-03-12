if($('#suggestion_product_list_container').length > 0) {
    var suggestionProductList = new Vue({
        el: '#suggestion_product_list_container',
        data: {
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
            searchStatus: ''
        },
        methods: {
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
            }
        }
    });
}