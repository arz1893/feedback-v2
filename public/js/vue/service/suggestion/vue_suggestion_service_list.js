if($('#suggestion_service_list_container').length > 0) {
    var suggestionServiceList = new Vue({
        el: '#suggestion_service_list_container',
        created() {
            var tenantId = $('#tenantId').val();
            this.getAllSuggestionService(tenantId);
        },
        data: {
            suggestionServices: [],
            suggestionService: {
                systemId: '',
                customer_suggestion: '',
                customer: [],
                service: [],
                serviceCategory: [],
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
        methods: {
            getAllSuggestionService: function (tenantId) {
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/suggestion_service/' + tenantId + '/get-all-suggestion-service';
                var vm = this;
                
                axios.get(url).then(function (response) {
                    if(response.data.data.length > 0) {
                        vm.suggestionServices = response.data.data;
                        vm.makePagination(response.data);
                    } else {
                        vm.errorMessage = 'no data found';
                    }
                }).catch(error => {
                    console.log(error);
                })
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
                var suggestion_id = $(event.currentTarget).data('suggestion_service_id');
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/suggestion_service/' + suggestion_id + '/get-suggestion-service';

                axios.get(url).then(function (response) {
                    vm.suggestionService.systemId = response.data.data.systemId;
                    vm.suggestionService.customer_suggestion = response.data.data.customer_suggestion;
                    vm.suggestionService.customer = response.data.data.customer;
                    vm.suggestionService.service = response.data.data.service;
                    vm.suggestionService.serviceCategory = response.data.data.serviceCategory;
                    vm.suggestionService.tenantId = response.data.data.tenantId;
                    vm.suggestionService.created_by = response.data.data.created_by;
                    vm.suggestionService.created_at = response.data.data.created_at;
                    vm.suggestionService.attachment = response.data.data.attachment;
                })
                    .catch(error => {
                        alert('whoops! something wrong within the process');
                        console.log(error);
                    });

                $('#modal_suggestion_service_show').modal('show');
            },

            deleteSuggestionService: function (event) {
                $('<input>').attr({
                    type: 'hidden',
                    name: 'suggestion_id',
                    value: $(event.currentTarget).data('id')
                }).appendTo('#form_delete_suggestion_service');
                $('#modal_remove_suggestion_service').modal('show');
            },
        }
    });

    function searchByDate(selected) {
        $('#btnClearSearch').removeClass('disabled');
        $('#btnClearSearch').attr('onclick', 'clearSearch()');
        suggestionServiceList.searchStatus = 'Searching...';
        suggestionServiceList.errorMessage = '';
        var date_start = $('#date_start').datepicker('getFormattedDate');
        var date_end = $('#date_end').datepicker('getFormattedDate');
        var tenantId = $('#tenantId').val();
        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/suggestion_service/' + tenantId + '/filter-by-date/' + date_start + '/' + date_end;

        function filterComplaint() {
            axios.get(url).then(response => {
                if(response.data.data.length !== 0) {
                    suggestionServiceList.suggestionServices = response.data.data;
                    suggestionServiceList.paging.currentPage = response.data.meta.current_page;
                    suggestionServiceList.paging.endPage = response.data.meta.last_page;
                    suggestionServiceList.paging.prev = (response.data.links.prev === null ? null:response.data.links.prev);
                    suggestionServiceList.paging.next = (response.data.links.next === null ? null:response.data.links.next);
                    suggestionServiceList.searchStatus = '';
                } else {
                    suggestionServiceList.errorMessage = 'no data found';
                    suggestionServiceList.searchStatus = '';
                }
            }).catch(error => {
                console.log(error);
            });
        }

        var debounceFunction = _.debounce(filterComplaint, 1000);
        debounceFunction();
    }

    function clearSearch() {
        $('#btnClearSearch').addClass('disabled');
        $('#btnClearSearch').attr('onclick', '');
        suggestionServiceList.searchStatus = 'Searching...';
        suggestionServiceList.errorMessage = '';
        $('#date_start').val('');
        $('#date_end').val('');
        var tenantId = $('#tenantId').val();
        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/suggestion_service/' + tenantId + '/get-all-suggestion-service';
        function fireRequest() {
            axios.get(url).then(response => {
                suggestionServiceList.suggestionServices = response.data.data;
                suggestionServiceList.searchStatus = '';
            }).catch(error => {
                console.log(error);
            });
        }

        var debounceFunction = _.debounce(fireRequest, 1000);
        debounceFunction();
    }
}