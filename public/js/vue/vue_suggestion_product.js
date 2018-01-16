var complaint_product = new Vue({
    el: '#vue_suggestion_product_container',
    data: {
        nodeTitle: '',
        productId: '',
        productCategoryId: '',
        show: true
    },
    methods: {
        append: function(title, productId, productCategoryId) {
            $('#btn_show_category_navigator').removeClass('hidden');
            $('#panel_add_suggestion_product').removeClass('hidden');
            $('#category_navigator').addClass('hidden');
            // this.show = false;
            this.nodeTitle = '<h3 class="text-orange"> Add suggestion to : '+ title +'</h3>';
            this.productId = '<input type="hidden" name="productId" value="' + productId +'">';
            this.productCategoryId = '<input type="hidden" name="productCategoryId" value="' + productCategoryId +'">';
        },

        showNavigator: function () {
            // this.show = true;
            $('#btn_show_category_navigator').addClass('hidden');
            $('#panel_add_suggestion_product').addClass('hidden');
            $('#category_navigator').removeClass('hidden');
        }
    }
});