var complaint_product = new Vue({
    el: '#vue_complaint_product_container',
    data: {
        nodeTitle: '',
        productId: '',
        productCategoryId: '',
        show: true,
        ratingValue: '',
        is_anonymous: true,
        is_customer: true
    },
    created: function () {

    },
    methods: {
        append: function(title, productId, productCategoryId) {
            $('#btn_show_category_navigator').removeClass('hidden');
            $('#panel_add_complaint').removeClass('hidden');
            $('#category_navigator').addClass('hidden');
            // this.show = false;
            this.nodeTitle = '<h4>Add Complaint to : ' + title + '</h4>';
            this.productId = '<input type="hidden" name="productId" value="' + productId +'">';
            this.productCategoryId = '<input type="hidden" name="productCategoryId" value="' + productCategoryId +'">';
        },

        showNavigator: function () {
            // this.show = true;
            $('#btn_show_category_navigator').addClass('hidden');
            $('#panel_add_complaint').addClass('hidden');
            $('#category_navigator').removeClass('hidden');
        },
        
        customerRating: function (value, event) {
            // console.log(value);
            // console.log(event.currentTarget.id);

            $('i.smiley_rating').each(function (index, element) {
                $(element).removeClass('is-selected');
            });

            $('#' + event.currentTarget.id).addClass('is-selected');

            this.ratingValue = '<input type="hidden" name="customer_rating" value="'+ value +'">';

        },

        onChangeAddComplaintProduct: function (event) {
            if(event.currentTarget.value !== '') {
                this.is_anonymous = false;
            } else if (event.currentTarget.value === '') {
                this.is_anonymous = true;
                $('#is_need_call').prop('checked', false);
            }
        },

        onChangeEditComplaintProduct: function (event) {
            if(event.currentTarget.value !== '') {
                this.is_anonymous = false;
                this.is_customer = true;
            } else if (event.currentTarget.value === '') {
                this.is_customer = false;
                this.is_anonymous = true;
                $('#is_need_call').prop('checked', false);
            }
        }

    }
});