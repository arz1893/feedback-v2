if($('#vue_product_container').length > 0) {
    var Root = new Vue({
        el: '#vue_product_container',
        data: {
            nodeTitle: '',
            productId: '',
            productCategoryId: '',
            show: true,
            ratingValue: '',
            is_anonymous: true,
            is_customer: true,
            showAttachment: false
        },
        created: function () {

        },
        methods: {
            append: function(title, productId, productCategoryId) {
                $('#btn_show_category_navigator').removeClass('hidden');
                $('#panel_product').removeClass('hidden');
                $('#category_navigator').addClass('hidden');
                // this.show = false;
                this.nodeTitle = title;
                this.productId = '<input type="hidden" name="productId" value="' + productId +'">';
                this.productCategoryId = '<input type="hidden" name="productCategoryId" value="' + productCategoryId +'">';
            },

            showNavigator: function () {
                // this.show = true;
                $('#btn_show_category_navigator').addClass('hidden');
                $('#panel_product').addClass('hidden');
                $('#category_navigator').removeClass('hidden');
            },

            customerRating: function (value, event) {
                // console.log(value);
                // console.log(event.currentTarget.id);
                $('i.smiley_rating').each(function (index, element) {
                    $(element).removeClass('is-selected');
                });
                $('#' + event.currentTarget.id).addClass('is-selected');
                switch (value) {
                    case 1 : {
                        $('input[name=customer_rating]').attr('checked',false);
                        $('#radio_very_dissatisfied').attr('checked', 'checked');
                        break;
                    }
                    case 2: {
                        $('input[name=customer_rating]').attr('checked',false);
                        $('#radio_dissatisfied').attr('checked', 'checked');
                        break;
                    }
                    case 3: {
                        $('input[name=customer_rating]').attr('checked',false);
                        $('#radio_neutral').attr('checked', 'checked');
                        break;
                    }
                    case 4: {
                        $('input[name=customer_rating]').attr('checked',false);
                        $('#radio_satisfied').attr('checked', 'checked');
                        break;
                    }
                    case 5: {
                        $('input[name=customer_rating]').attr('checked',false);
                        $('#radio_very_satisfied').attr('checked', 'checked');
                        break;
                    }
                }

            },

            onChangeCustomer: function (value) {
                if(value.length === 0) {
                    this.is_customer = false;
                    this.is_anonymous = true;
                    $('#is_need_call').prop('checked', false);
                } else {
                    this.is_anonymous = false;
                    this.is_customer = true;
                }
            },

            // onChangeEditCustomer: function (event) {
            //     if(event.currentTarget.value !== '') {
            //         this.is_anonymous = false;
            //         this.is_customer = true;
            //     } else if (event.currentTarget.value === '') {
            //         this.is_customer = false;
            //         this.is_anonymous = true;
            //         $('#is_need_call').prop('checked', false);
            //     }
            // },
            
            previewImage: function (event) {
                var uploadedImage = event.target;
                if(uploadedImage.files && uploadedImage.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#preview').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(uploadedImage.files[0]);
                }
                this.showAttachment = true;
            },

            clearAttachment: function(event) {
                $('#preview').removeAttr('src');
                $('#attachment').val("");
                $('#image_cover').val("");
                this.showAttachment = false;
            }
        }
    });

    $('#customerId').on("change", function () {
        Root.onChangeCustomer($(this).val());
    });
}

if($('#product_index').length > 0) {

    var productIndex = new Vue({
        el: '#product_index',
        created() {
            var tenantId = $('#tenantId').val();
            var tags = $('#select_tags').val();
            this.getProducts(tenantId, tags);
            // this.getTags(tenantId);
        },
        data: {
            tenantId: $('#tenantId').val(),
            products: [],
            pagination: {
                current_page: '',
                first_page_link: '',
                last_page_link: '',
                next_page_link: '',
                prev_page_link: '',
                total_page: '',
                path: '',
            },
            searchString: '',
            searchStatus: '',
            errorMessage: ''
        },
        watch: {

        },
        computed: {
            filteredProducts: function () {
                var vm = this;
                var result =  this.products.filter(product => {
                    return product.name.toLowerCase().match(this.searchString.toLowerCase());
                });
                if(result.length === 0) {
                    vm.errorMessage = 'no data found';
                } else {
                    vm.errorMessage = '';
                    return result;
                }
            }
        },
        methods: {
            getProducts: function (id, tags) {
                var vm = this;
                if(tags.length === 0) {
                    const url = window.location.protocol + "//" + window.location.host + "/" + 'api/product/' + id + '/get-product-list';
                    axios.get(url).then(response => {
                        if(response.data.data.length === 0) {
                            vm.products = response.data.data;
                            vm.errorMessage = 'no data found';
                        } else {
                            vm.products = response.data.data;
                            vm.errorMessage = '';
                            vm.makePagination(response.data);
                        }
                    }).catch(error => {
                        console.log('something wrong within the process');
                        console.log(Object.assign({}, error));
                    });
                } else {
                    const url = window.location.protocol + "//" + window.location.host + "/" + 'api/product/' + id + '/filter-product-list/' + tags;
                    axios.get(url)
                    .then(function (response) {
                        if(response.data.data.length === 0) {
                            vm.products = response.data.data;
                            vm.errorMessage = 'no data found';
                        } else {
                            vm.errorMessage = '';
                            vm.products = response.data.data;
                            vm.makePagination(response.data);
                        }
                    })
                    .catch(error => {
                        console.log(Object.assign({}, error));
                    });
                }
            },
            
            makePagination: function (data) {
                var vm = this;
                vm.pagination.current_page = data.meta.current_page;
                vm.pagination.first_page_link = data.links.first;
                vm.pagination.last_page_link = data.links.last;
                vm.pagination.next_page_link = data.links.next;
                vm.pagination.prev_page_link = data.links.prev;
                vm.pagination.total_page = data.meta.last_page;
                vm.pagination.path = data.meta.path;
            },
            
            nextPage: function (url) {
                var vm = this;
                vm.searchStatus = 'Loading...';
                function fireRequest(vm) {
                    axios.get(url).then(response => {
                        vm.products = response.data.data;
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

    function filterByName() {
        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/product/' + productIndex.tenantId + '/filter-by-name/' + productIndex.searchString;
        productIndex.searchStatus = 'Searching...';
        productIndex.errorMessage = '';
        if(productIndex.searchString !== '') {
            function fireRequest() {
                axios.get(url).then(response => {
                    if(response.data.data.length === 0) {
                        productIndex.errorMessage = 'no data found';
                        productIndex.searchStatus = '';
                        productIndex.products = response.data.data;
                    } else {
                        productIndex.products = response.data.data;
                        productIndex.makePagination(response.data);
                        productIndex.searchStatus = '';
                    }
                }).catch(error => {
                    console.log(error);
                });
            }

            var debounceFunction = _.debounce(fireRequest, 1000);
            debounceFunction();
        } else {
            var tagIds = $('#select_tags').val();
            var tenantId = $('#tenantId').val();
            if (tagIds.length > 0) {
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/product/' + tenantId + '/filter-product-list/' + tagIds;
                productIndex.searchStatus = 'Searching...';
                function filterProducts() {

                    axios.get(url)
                        .then(function (response) {
                            if(response.data.data.length === 0) {
                                productIndex.products = response.data.data;
                                productIndex.errorMessage = 'no data found';
                                productIndex.searchStatus = '';
                            } else {
                                productIndex.products = response.data.data;
                                productIndex.makePagination(response.data);
                                productIndex.errorMessage = '';
                                productIndex.searchStatus = '';
                            }
                        })
                        .catch(error => {
                            console.log(Object.assign({}, error));
                        });
                }
                //debounce buat trigger function setelah 0.5 detik
                var debounceFunction = _.debounce(filterProducts, 1000);
                debounceFunction();
            } else {
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/product/' + tenantId + '/get-product-list';
                productIndex.searchStatus = 'Loading...';
                function getProducts() {
                    axios.get(url).then(response => {
                        if(response.data.data.length === 0) {
                            productIndex.products = response.data.data;
                            productIndex.errorMessage = 'no data found';
                        } else {
                            productIndex.products = response.data.data;
                            productIndex.makePagination(response.data);
                            productIndex.errorMessage = '';
                            productIndex.searchStatus = '';
                        }
                    }).catch(error => {
                        console.log(Object.assign({}, error));
                    });
                }
                //debounce buat trigger function setelah 0.5 detik
                var debounceFunction = _.debounce(getProducts, 1000);
                debounceFunction();
            }
        }
    }
    
    $('#select_tags').on('change', function () {
        var tagIds = $(this).val();
        var tenantId = $('#tenantId').val();
        if(tagIds.length > 0) {
            const url = window.location.protocol + "//" + window.location.host + "/" + 'api/product/' + tenantId + '/filter-product-list/' + tagIds;
            productIndex.searchStatus = 'Searching...';
            productIndex.searchString = '';
            function filterProducts() {

                axios.get(url)
                .then(function (response) {
                    if(response.data.data.length === 0) {
                        productIndex.products = response.data.data;
                        productIndex.errorMessage = 'no data found';
                        productIndex.searchStatus = '';
                    } else {
                        productIndex.products = response.data.data;
                        productIndex.makePagination(response.data);
                        productIndex.errorMessage = '';
                        productIndex.searchStatus = '';
                    }
                })
                .catch(error => {
                    console.log(Object.assign({}, error));
                });
            }
            //debounce buat trigger function setelah 0.5 detik
            var debounceFunction = _.debounce(filterProducts, 1000);
            debounceFunction();
        } else {
            const url = window.location.protocol + "//" + window.location.host + "/" + 'api/product/' + tenantId + '/get-product-list';
            productIndex.searchStatus = 'Loading...';
            productIndex.searchString = '';
            function getProducts() {
                axios.get(url).then(response => {
                    if(response.data.data.length === 0) {
                        productIndex.products = response.data.data;
                        productIndex.errorMessage = 'no data found';
                    } else {
                        productIndex.products = response.data.data;
                        productIndex.makePagination(response.data);
                        productIndex.errorMessage = '';
                        productIndex.searchStatus = '';
                    }
                }).catch(error => {
                    console.log(Object.assign({}, error));
                });
            }
            //debounce buat trigger function setelah 0.5 detik
            var debounceFunction = _.debounce(getProducts, 1000);
            debounceFunction();
        }
    });
}