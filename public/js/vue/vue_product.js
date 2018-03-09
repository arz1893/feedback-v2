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
                        console.log(response.data);
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

if($('#complaint_product_list_index').length > 0) {
    Vue.use(VeeValidate);

    var complaintProductListIndex = new Vue({
        el: '#complaint_product_list_index',
        data: {
            complaintProduct: {
                systemId: '',
                customer_rating: '',
                customer_complaint: '',
                is_need_call: '',
                is_urgent: '',
                customer: [],
                product: [],
                productCategory: [],
                tenantId: '',
                is_answered: '',
                attachment: '',
                created_by: '',
                created_at: ''
            },
            complaintReplies: null,
            showReply: false,
            showDetail: false,
            searchStatus: '',
            reply_content: '',
            showConfirmDelete: false
        },
        watch: {
            complaintProduct: function () {
                console.log(this.complaintProduct.product.img);
            }
        },
        methods: {
            showComplaintDetail: function (event) {
                var vm = this;
                var complaint_id = $(event.currentTarget).data('complaint_id');
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_product/' + complaint_id + '/get-complaint-product';

                axios.get(url).then(function (response) {
                    vm.complaintProduct.systemId = response.data.data.systemId;
                    vm.complaintProduct.customer_rating = response.data.data.customer_rating;
                    vm.complaintProduct.customer_complaint = response.data.data.customer_complaint;
                    vm.complaintProduct.is_need_call = response.data.data.is_need_call;
                    vm.complaintProduct.is_urgent = response.data.data.is_urgent;
                    vm.complaintProduct.customer = response.data.data.customer;
                    vm.complaintProduct.product = response.data.data.product;
                    vm.complaintProduct.productCategory = response.data.data.product_category;
                    vm.complaintProduct.tenantId = response.data.data.tenant_id;
                    vm.complaintProduct.is_answered = response.data.data.is_answered;
                    vm.complaintProduct.attachment = response.data.data.attachment;
                    vm.complaintProduct.created_by = response.data.data.created_by;
                    vm.complaintProduct.created_at = response.data.data.created_at;

                    if(response.data.data.customer !== null) {
                        vm.showAllComplaintReplies(response.data.data.systemId);
                    }
                })
                .catch(error => {
                    alert('something wrong within the process');
                    console.log(error);
                });
                $('#modal_complaint_product_show').modal('show');
            },
            
            showAllComplaintReplies: function (complaint_product_id) {
                var vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_product_reply/' + complaint_product_id + '/get-complaint-product-replies';
                this.searchStatus = 'Loading Data...';
                function getComplaintReplies() {
                    axios.get(url).then(function (response) {
                        if(response.data === '') {
                            vm.complaintReplies = null;
                            vm.searchStatus = '';
                        } else {
                            vm.complaintReplies = response.data;
                            vm.searchStatus = '';
                        }
                    })
                    .catch(error => {
                        alert('something wrong within the process');
                        console.log(error);
                    });
                }

                var debounceFunction = _.debounce(getComplaintReplies, 1000);
                debounceFunction();
            },

            showReplyBox: function (event) {
                this.showReply = !this.showReply;
                this.replyTo = $('#reply_to').html();
            },
            submitReply: function (event) {
                var vm = this;
                const dict = {
                    custom: {
                        reply_content: {
                            required: 'please enter reply content' // messages can be strings as well.
                        }
                    }
                };
                this.$validator.localize('en', dict);
                this.$validator.validateAll().then((result) => {
                    if(result) {
                        var complaintProductId  = $('#complaintProductId').val();
                        var customerId = (($('#customerId').length > 0) ? $('#customerId').val():null);
                        var reply_content = vm.reply_content;
                        var creatorId = $('#creatorId').val();
                        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_product_reply/' + complaintProductId + '/post-reply';

                        axios.post(url, {
                            complaintProductId: complaintProductId,
                            customerId: customerId,
                            reply_content: reply_content,
                            creatorId: creatorId
                        }).then(function (response) {
                            if(response.data.status === true) {
                                vm.showAllComplaintReplies(complaintProductId);
                            }
                        })
                        .catch(error => {
                            alert('whoops! there something wrong within the process');
                            console.log(error);
                        });
                        $('#collapseReply').collapse('hide');
                        $('#reply_content').val('');
                        vm.reply_content = '';
                    }
                })
                .catch(error => {
                    console.log(error);
                });
            },

            deleteReply: function (event) {
                var vm = this;
                var complaintProductId = vm.complaintProduct.systemId;
                var replyId = event.currentTarget.getAttribute('data-id');
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_product_reply/delete-reply';

                axios.post(url, {
                    replyId: replyId
                })
                .then(response => {
                    if(response.data.status === true) {
                        vm.showAllComplaintReplies(complaintProductId);
                    }
                })
                .catch(error => {
                    alert('whoops! there is something wrong within the process');
                    console.log(error)
                });
            }
        }
    });

    $('#modal_complaint_product_show').on('hidden.bs.modal', function (e) {
        $('#collapseReply').collapse('hide');
        $('#reply_content').val('');
        complaintProductListIndex.reply_content = '';
        complaintProductListIndex.complaintReplies = null;
        $('#collapseAllReplies').collapse('hide');
    });
}

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