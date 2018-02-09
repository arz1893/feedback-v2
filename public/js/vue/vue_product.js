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

if($('#complaint_product_list_show').length > 0) {
    Vue.use(VeeValidate);

    var complaintProductListShow = new Vue({
        el: '#complaint_product_list_show',
        data: {
            showReply: false,
            replyTo: '',
            replyId: ''
        },
        methods: {
            showReplyBox: function (event) {
                this.showReply = !this.showReply
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

if($('#complaint_product_index').length > 0) {
    var complaintProductIndex = new Vue({
        el: '#complaint_product_index',
        created() {
            // this.getUser($('#tenantId').val());
        },
        data: {
            tenantId: $('#tenantId').val(),
            products: Array
        },
        methods: {
            getUser: function (id) {
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/product/' + this.tenantId + '/get-product-list';

                axios.get(url).then(response => {
                    this.products = response.data;
                    console.log(response.data);
                }).catch(error => {
                    console.log(Object.assign({}, error));
                });

                console.log(this.products);
            }
        }
    });
}