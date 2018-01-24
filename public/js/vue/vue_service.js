var Root = new Vue({
    el: '#vue_service_container',
    data: {
        nodeTitle: '',
        serviceId: '',
        serviceCategoryId: '',
        show: true,
        ratingValue: '',
        is_anonymous: true,
        is_customer: true
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

            this.ratingValue = '<input type="hidden" name="customer_rating" value="'+ value +'">';

        },

        onChangeCustomer: function (event) {
            if(event.currentTarget.value !== '') {
                this.is_anonymous = false;
            } else if (event.currentTarget.value === '') {
                this.is_anonymous = true;
                $('#is_need_call').prop('checked', false);
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
        }

    }
});

var complaintServiceListContainer = new Vue({
    el:'#complaint_service_list_show',
    data: {
        showReply: false,
        replyTo: ''
    },
    methods: {
        showReplyBox: function (event) {
            this.showReply = !this.showReply
            this.replyTo = $('#reply_to').html();
        }
    }
});