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
                nextPage: null,
                path: ''
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
                vm.paging.path = data.meta.path;
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

            changePage: function (url) {
                var vm = this;
                vm.searchStatus = 'Loading...';
                function fireRequest(vm) {
                    axios.get(url).then(response => {
                        vm.suggestionServices = response.data.data;
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

    $('#service_name').change(function () {
        $('#btnSearchService').removeClass('disabled');
        $('#btnSearchService').attr('onclick', 'searchByService()');
    });

    function searchByDate(selected) {
        suggestionServiceList.searchStatus = 'Searching...';
        suggestionServiceList.errorMessage = '';
        var date_start = $('#date_start').val();
        var date_end = $('#date_end').val();
        var tenantId = $('#tenantId').val();
        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/suggestion_service/' + tenantId + '/filter-by-date/' + date_start + '/' + date_end;

        function filterComplaint() {
            axios.get(url).then(response => {
                if(response.data.data.length > 0) {
                    suggestionServiceList.suggestionServices = response.data.data;
                    suggestionServiceList.paging.currentPage = response.data.meta.current_page;
                    suggestionServiceList.paging.endPage = response.data.meta.last_page;
                    suggestionServiceList.paging.prevPage = (response.data.links.prev === null ? null:response.data.links.prev);
                    suggestionServiceList.paging.nextPage = (response.data.links.next === null ? null:response.data.links.next);
                    suggestionServiceList.paging.path = response.data.meta.path;
                    suggestionServiceList.searchStatus = '';
                } else {
                    suggestionServiceList.errorMessage = 'no data found';
                    suggestionServiceList.searchStatus = '';
                    suggestionServiceList.paging.currentPage = '';
                    suggestionServiceList.paging.endPage = null;
                    suggestionServiceList.paging.prevPage = null;
                    suggestionServiceList.paging.nextPage = null;
                    suggestionServiceList.paging.path = '';
                }
            }).catch(error => {
                console.log(error);
            });
        }

        var debounceFunction = _.debounce(filterComplaint, 1000);
        debounceFunction();
    }

    function clearSearch() {
        $('#btnSearchService').addClass('disabled');
        $('#btnSearchService').attr('onclick', '');
        suggestionServiceList.searchStatus = 'Searching...';
        suggestionServiceList.errorMessage = '';
        $('#date_start').val('');
        $('#date_end').val('');
        $('#service_name').val('').trigger('change.select2');
        $('.datepicker').datepicker('update', moment(new Date()).format('dd-M-yyyy'));
        var tenantId = $('#tenantId').val();
        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/suggestion_service/' + tenantId + '/get-all-suggestion-service';
        function fireRequest() {
            axios.get(url).then(response => {
                suggestionServiceList.searchStatus = '';
                if(response.data.data.length > 0) {
                    suggestionServiceList.suggestionServices = response.data.data;
                    suggestionServiceList.paging.currentPage = response.data.meta.current_page;
                    suggestionServiceList.paging.endPage = response.data.meta.last_page;
                    suggestionServiceList.paging.prevPage = (response.data.links.prev === null ? null:response.data.links.prev);
                    suggestionServiceList.paging.nextPage = (response.data.links.next === null ? null:response.data.links.next);
                    suggestionServiceList.paging.path = response.data.meta.path;
                } else {
                    suggestionServiceList.errorMessage = 'no data found';
                    suggestionServiceList.searchStatus = '';
                    suggestionServiceList.paging.currentPage = '';
                    suggestionServiceList.paging.endPage = null;
                    suggestionServiceList.paging.prevPage = null;
                    suggestionServiceList.paging.nextPage = null;
                    suggestionServiceList.paging.path = '';
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
        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/suggestion_service/' + tenantId + '/filter-by-customer/' + customerId;
        suggestionServiceList.searchStatus = 'Searching...';
        suggestionServiceList.errorMessage = '';

        function fireRequest() {
            axios.get(url).then(response => {
                if(response.data.data.length > 0) {
                    suggestionServiceList.suggestionServices = response.data.data;
                    suggestionServiceList.paging.currentPage = response.data.meta.current_page;
                    suggestionServiceList.paging.endPage = response.data.meta.last_page;
                    suggestionServiceList.paging.prevPage = (response.data.links.prev === null ? null:response.data.links.prev);
                    suggestionServiceList.paging.nextPage = (response.data.links.next === null ? null:response.data.links.next);
                    suggestionServiceList.searchStatus = '';
                } else {
                    suggestionServiceList.errorMessage = 'no data found';
                    suggestionServiceList.searchStatus = '';
                }
            }).catch(error => {
                console.log(error);
            });
        }

        var debounceFunction = _.debounce(fireRequest, 1000);
        debounceFunction();
    }

    function searchByService() {
        var serviceId = $('#service_name').select2('data')[0].id;
        var tenantId = $('#tenantId').val();
        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/suggestion_service/' + tenantId + '/filter-by-service/' + serviceId;
        suggestionServiceList.searchStatus = 'Searching...';
        suggestionServiceList.errorMessage = '';

        function fireRequest() {
            axios.get(url).then(response => {
                if(response.data.data.length > 0) {
                    suggestionServiceList.suggestionServices = response.data.data;
                    suggestionServiceList.paging.currentPage = response.data.meta.current_page;
                    suggestionServiceList.paging.endPage = response.data.meta.last_page;
                    suggestionServiceList.paging.prevPage = (response.data.links.prev === null ? null:response.data.links.prev);
                    suggestionServiceList.paging.nextPage = (response.data.links.next === null ? null:response.data.links.next);
                    suggestionServiceList.paging.path = response.data.meta.path;
                    suggestionServiceList.searchStatus = '';
                } else {
                    suggestionServiceList.errorMessage = 'no data found';
                    suggestionServiceList.searchStatus = '';
                    suggestionServiceList.paging.currentPage = '';
                    suggestionServiceList.paging.endPage = null;
                    suggestionServiceList.paging.prevPage = null;
                    suggestionServiceList.paging.nextPage = null;
                    suggestionServiceList.paging.path = '';
                }
            }).catch(error => {
                console.log(error);
            });
        }

        var debounceFunction = _.debounce(fireRequest, 1000);
        debounceFunction();
    }
}