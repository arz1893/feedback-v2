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
            },

            submitFormAttachment: function (event) {
                $('#form_change_attachment').submit();
            }
        }
    });

    $('#customerId').on("change", function () {
        Root.onChangeCustomer($(this).val());
    });
}

if($('#complaint_product_list_index').length > 0) {
    Vue.use(VeeValidate);

    let complaintProductListIndex = new Vue({
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
            complaintReplies: {
                systemId: '',
                reply_content: '',
                created_by: []
            },
            showReply: false,
            replyTo: '',
            replyId: '',
            showDetail: false
        },
        watch: {
            complaintProduct: function () {
                console.log(this.complaintProduct.product.img);
            }
        },
        methods: {
            showComplaintDetail: function (event) {
                let vm = this;
                let complaint_id = $(event.currentTarget).data('complaint_id');
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
                    vm.complaintReplies = response.data.data.complaint_replies;
                    vm.complaintProduct.tenantId = response.data.data.tenantId;
                    vm.complaintProduct.is_answered = response.data.data.is_answered;
                    vm.complaintProduct.attachment = response.data.data.attachment;
                    vm.complaintProduct.created_by = response.data.data.created_by;
                    vm.complaintProduct.created_at = response.data.data.created_at;
                })
                .catch(error => {
                    alert('something wrong within the process');
                    console.log(error);
                });
                this.showDetail = true;
                $('#modal_complaint_product_show').modal('show');
            },
            
            showComplaintReplies: function (event) {
                let vm = this;
                let complaint_product_id = this.complaintProduct.systemId;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/complaint_product_reply/' + complaint_product_id + '/get-complaint-product-replies';

                axios.get(url).then(function (response) {
                    vm.complaintReplies.systemId = response.data.data.systemId;
                    vm.reply_content = response.data.data.reply_content;
                    vm.reply_content = response.data.data.created_by;
                })
                .catch(error => {
                    alert('something wrong within the process');
                    console.log(error);
                });
            },

            showReplyBox: function (event) {
                this.showReply = !this.showReply;
                this.replyTo = $('#reply_to').html();
            },
            submitReply: function (event) {
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
                        $('#form_complaint_product_reply').submit();
                    }
                })
                .catch(error => {
                        console.log(error);
                });
            },

            deleteReply: function (event) {
                console.log(event.currentTarget.getAttribute('data-id'));
                this.replyId = '<input type="hidden" name="id" value="' + event.currentTarget.getAttribute('data-id') + '">';
                $('#modal_remove_complaint_product_reply').modal('show');
            }
        }
    });
}

if($('#product_index').length > 0) {

    let productIndex = new Vue({
        el: '#product_index',
        created() {
            let tenantId = $('#tenantId').val();
            this.getProducts(tenantId);
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
        },
        watch: {

        },
        computed: {
            filteredProducts: function () {
                return this.products.filter((product) => {
                    return product.name.toLowerCase().match(this.searchString.toLowerCase());
                });
            }
        },
        methods: {
            getProducts: function (id) {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/product/' + id + '/get-product-list';
                axios.get(url).then(response => {
                    this.products = response.data.data;
                    vm.makePagination(response.data);
                }).catch(error => {
                    console.log('something wrong within the process');
                    console.log(Object.assign({}, error));
                });
            },
            
            makePagination: function (data) {
                let vm = this;
                vm.pagination.current_page = data.meta.current_page;
                vm.pagination.first_page_link = data.links.first;
                vm.pagination.last_page_link = data.links.last;
                vm.pagination.next_page_link = data.links.next;
                vm.pagination.prev_page_link = data.links.prev;
                vm.pagination.total_page = data.meta.last_page;
                vm.pagination.path = data.meta.path;
            },
            
            nextPage: function (url) {
                let vm = this;
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

                let debounceFunction = _.debounce(fireRequest, 1000);
                debounceFunction(vm);
            }
        }
    });
    
    $('#select_tags').on('change', function () {
        let tagIds = $(this).val();
        let tenantId = $('#tenantId').val();
        if(tagIds.length > 0) {
            const url = window.location.protocol + "//" + window.location.host + "/" + 'api/product/' + tenantId + '/filter-product-list';
            productIndex.searchStatus = 'Searching...';
            function filterProducts() {

                axios.post(url, {
                    tags: tagIds
                })
                .then(function (response) {
                    productIndex.products = response.data.data;
                    productIndex.searchStatus = '';
                })
                .catch(error => {
                    console.log(Object.assign({}, error));
                });
            }
            //debounce buat trigger function setelah 0.5 detik
            let debounceFunction = _.debounce(filterProducts, 1000);
            debounceFunction();
        } else {
            const url = window.location.protocol + "//" + window.location.host + "/" + 'api/product/' + tenantId + '/get-product-list';
            productIndex.searchStatus = 'Loading...';
            function getProducts() {
                axios.get(url).then(response => {
                    productIndex.products = response.data.data;
                    productIndex.searchStatus = '';
                }).catch(error => {
                    console.log(Object.assign({}, error));
                });
            }
            //debounce buat trigger function setelah 0.5 detik
            let debounceFunction = _.debounce(getProducts, 1000);
            debounceFunction();
        }
    });
}