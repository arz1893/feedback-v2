var complaint_product = new Vue({
    el: '#vue_suggestion_service_container',
    data: {
        nodeTitle: '',
        serviceId: '',
        serviceCategoryId: '',
        show: true
    },
    methods: {
        append: function(title, serviceId, serviceCategoryId) {
            $('#btn_show_category_navigator').removeClass('hidden');
            $('#panel_add_suggestion_service').removeClass('hidden');
            $('#category_navigator').addClass('hidden');
            // this.show = false;
            this.nodeTitle = '<span class="text-orange"> Add suggestion to </span> : ' + title;
            this.serviceId = '<input type="hidden" name="serviceId" value="' + serviceId +'">';
            this.serviceCategoryId = '<input type="hidden" name="serviceCategoryId" value="' + serviceCategoryId +'">';
        },

        showNavigator: function () {
            // this.show = true;
            $('#btn_show_category_navigator').addClass('hidden');
            $('#panel_add_suggestion_service').addClass('hidden');
            $('#category_navigator').removeClass('hidden');
        }
    }
});