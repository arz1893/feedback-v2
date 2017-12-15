var complaint_service = new Vue({
    el: '#vue_complaint_service_container',
    data: {
        nodeTitle: '',
        serviceId: '',
        serviceCategoryId: '',
        show: true
    },
    methods: {
        append: function (title, serviceId, serviceCategoryId) {
            $('#btn_show_category_navigator').removeClass('hidden');
            $('#panel_add_complaint').removeClass('hidden');
            $('#category_navigator').addClass('hidden');

            this.nodeTitle = '<span class="text-red"> Add complaint to </span> : ' + title;
            this.serviceId = '<input type="hidden" name="serviceId" value="' + serviceId +'">';
            this.serviceCategoryId = '<input type="hidden" name="serviceCategoryId" value="' + serviceCategoryId +'">';
        },

        showNavigator: function () {
            $('#btn_show_category_navigator').addClass('hidden');
            $('#panel_add_complaint').addClass('hidden');
            $('#category_navigator').removeClass('hidden');
        }
    }
});