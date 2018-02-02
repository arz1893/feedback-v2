/**
 * Created by arnadi on 9/20/17.
 */
$(document).ready(function () {

    $('#form_login').validate({
        errorClass: "my-error-class",
        validClass: "my-valid-class",
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 4
            }
        },
        messages: {
            email: {
                required: "Please enter your email address",
                email: "email format is not valid"
            },
            password: {
                required: "Please enter your password",
                minlength: jQuery.validator.format("At least {0} characters required!")
            }
        },

        submitHandler: function (form) {
            form.submit();
        }
    });

    $('#form_register').validate({
        errorClass: "my-error-class",
        validClass: "my-valid-class",
        rules: {
            name: 'required',
            category_id: 'required',
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 4
            },
            password_confirmation: {
                required: true,
                minlength: 4,
                equalTo: '#txt_password'
            },
            country: 'required'
        },
        messages: {
            name: 'please enter your business / company name',
            email: {
                required: 'please enter your email',
                email: 'email format is invalid'
            },
            category_id: 'please select your business type',
            password: {
                required: 'please enter your password',
                minlength: jQuery.validator.format("At least {0} characters required!")
            },
            password_confirmation: {
                required: 'please re enter your password',
                minlength: jQuery.validator.format("At least {0} characters required!"),
                equalTo: 'your password didn\'t match'
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $('#form_add_product').validate({
        errorClass: "my-error-class",
        validClass: "my-valid-class",

        rules: {
            name: 'required',
            description: 'required',
            metric: {
                required: true
            },
            price: {
                required: true,
                number: true,
                min: 0
            },
            image_cover: {
                required: true
            }
        },
        messages: {
            name: 'please enter your product name',
            description: 'please enter your product description',
            metric: {
                required: 'please choose product\'s metric unit'
            },
            price: {
                required: 'please inster product\'s price',
                number: 'price must be numeric',
                min: 'price must be positive number'
            },
            image_cover: {
                required: 'please insert your product picture'
            }
        }
    });

    $('#product_picture').on('change', function () {
        $(this).validate({
            errorClass: "my-error-class",
            validClass: "my-valid-class",

            onkeyup: true,

            rules: {
                required: true,
                extension: 'jpg|jpeg|png|bmp|svg|gif'
            },
            messages: {
                required: 'please insert product picture',
                extension: 'file must be an image'
            }
        });
    });

    $('#form_edit_product').validate({
        errorClass: "my-error-class",
        validClass: "my-valid-class",

        rules: {
            name: 'required',
            description: 'required',
            metric: {
                required: true
            },
            price: {
                required: true,
                number: true,
                min: 0
            }
        },
        messages: {
            name: 'please enter your product name',
            description: 'please enter your product description',
            metric: {
                required: 'please choose product\'s metric unit'
            },
            price: {
                required: 'please inster product\'s price',
                number: 'price must be numeric',
                min: 'price must be positive number'
            }
        }
    });

    $('#form_add_service').validate({
        errorClass: "my-error-class",
        validClass: "my-valid-class",

        rules: {
            name: 'required',
            description: 'required'
        },
        messages: {
            name: 'please enter your service name',
            description: 'please enter your service description'
        }
    });

    $('#form_add_faq_product').validate({
        errorClass: "my-error-class",
        validClass: "my-valid-class",

        rules: {
            question: 'required',
            answer: 'required'
        },
        messages: {
            question: 'please enter your FAQ question',
            answer: 'please enter your answer to current question'
        },

        submitHandler: function (form) {
            form.submit();
        }
    });

    $('#sub_product_form').validate({
        errorClass: "my-error-class",
        validClass: "my-valid-class",

        rules: {
            name: 'required'
        },
        messages: {
            name: 'please enter your sub product name'
        },

        submitHandler: function (form) {
            form.submit();
        }
    });

    $('#form_add_customer').validate({
        errorClass: "my-error-class",
        validClass: "my-valid-class",

        rules: {
            name: 'required',
            gender: 'required',
            phone: {
                required: true,
                minlength: 9
            },
            birthdate: 'required',
            email: 'email'
        },
        messages: {
            name: 'please enter customer\'s name',
            gender: 'gender not yet selected',
            phone: {
                required: 'please enter customer\'s phone number',
                minlength: 'at least 10 digits of number are required'
            },
            birthdate: 'please enter customer\'s birthdate'
        },
        errorPlacement: function(error, element)
        {
            if ( element.is(":radio") )
            {
                error.appendTo( element.parents('.error') );
            }
            else
            { // This is the default behavior
                error.insertAfter( element );
            }
        },
        submitHandler: function (form) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            console.log(form.data);
            // form.submit();
        }
    });

    $('#form_add_product_category').validate({
        errorClass: "my-error-class",
        validClass: "my-valid-class",

        rules: {
            txt_add_product_category: 'required'
        },
        messages: {
            txt_add_product_category: 'please enter category name'
        },

        submitHandler: function (form) {
            form.submit();
        }
    });

    $('#form_edit_product_category').validate({
        errorClass: "my-error-class",
        validClass: "my-valid-class",

        rules: {
            txt_edit_product_category: 'required'
        },
        messages: {
            txt_edit_product_category: 'please enter category name'
        },

        submitHandler: function (form) {
            form.submit();
        }
    });

    $('#form_add_user').validate({
        errorClass: "my-error-class",
        validClass: "my-valid-class",

        rules: {
            name: 'required',
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 4
            },
            password_confirmation: {
                equalTo: '#password'
            },
            phone: 'required',
            usergroupId: 'required'
        },
        messages: {
            name: 'please enter user\'s name',
            email: {
                required: 'please enter email address',
                email: 'email format is invalid'
            },
            password: {
                required: 'please enter user\'s password',
                minlength: jQuery.validator.format("please, at least {0} characters are necessary")
            },
            password_confirmation: {
                equalTo: 'your password didn\'t match'
            },
            phone: 'please enter user\'s phone number',
            usergroupId: 'please select user type'
        },

        errorPlacement: function(error, element)
        {
            if ( element.is(":text") )
            {
                error.appendTo( element.parents('.error') );
            }
            else
            { // This is the default behavior
                error.insertAfter( element );
            }
        },

        submitHandler: function (form) {
            form.submit();
        }
    });

    $('#form_edit_user').validate({
        errorClass: "my-error-class",
        validClass: "my-valid-class",

        rules: {
            name: 'required',
            user_type_id: 'required'
        },
        messages: {
            name: 'please enter user\'s name',
            user_type_id: 'please select user type'
        },

        submitHandler: function (form) {
            form.submit();
        }
    });

    $('#form_add_complaint_product').validate({
        errorClass: "my-error-class",
        validClass: "my-valid-class",

        rules: {
            customer_rating: 'required',
            customer_complaint: 'required'
        },
        messages: {
            customer_rating: 'please select rating',
            customer_complaint: 'please enter customer\'s complaint'
        },

        errorPlacement: function(error, element)
        {
            if ( element.is(":radio") )
            {
                error.appendTo( element.parents('.error') );
            }
            else
            { // This is the default behavior
                error.insertAfter( element );
            }
        },

        submitHandler: function (form) {
            form.submit();
        }
    });

    $('#form_edit_complaint_product').validate({
        errorClass: "my-error-class",
        validClass: "my-valid-class",

        rules: {
            customer_rating: 'required',
            customer_complaint: 'required',
            attachment: {
                accept: 'image/*'
            }
        },
        messages: {
            customer_rating: 'please select rating',
            customer_complaint: 'please enter customer\'s complaint'
        },

        errorPlacement: function(error, element)
        {
            if ( element.is(":radio") )
            {
                error.appendTo( element.parents('.error') );
            }
            else
            { // This is the default behavior
                error.insertAfter( element );
            }
        },

        submitHandler: function (form) {
            form.submit();
        }
    });

    $('#form_add_complaint_service').validate({
        errorClass: "my-error-class",
        validClass: "my-valid-class",

        rules: {
            customer_rating: 'required',
            customer_complaint: 'required'
        },
        messages: {
            customer_rating: 'please select rating',
            customer_complaint: 'please enter customer\'s complaint'
        },

        errorPlacement: function(error, element)
        {
            if ( element.is(":radio") )
            {
                error.appendTo( element.parents('.error') );
            }
            else
            { // This is the default behavior
                error.insertAfter( element );
            }
        },

        submitHandler: function (form) {
            form.submit();
        }
    });

    $('#form_edit_complaint_service').validate({
        errorClass: "my-error-class",
        validClass: "my-valid-class",

        rules: {
            customer_rating: 'required',
            customer_complaint: 'required'
        },
        messages: {
            customer_rating: 'please select rating',
            customer_complaint: 'please enter customer\'s complaint'
        },

        errorPlacement: function(error, element)
        {
            if ( element.is(":radio") )
            {
                error.appendTo( element.parents('.error') );
            }
            else
            { // This is the default behavior
                error.insertAfter( element );
            }
        },

        submitHandler: function (form) {
            form.submit();
        }
    });

    $('#form_add_suggestion_product').validate({
        errorClass: "my-error-class",
        validClass: "my-valid-class",

        rules: {
            customer_suggestion: 'required'
        },
        messages: {
            customer_suggestion: 'please enter customer\'s suggestion'
        },

        submitHandler: function (form) {
            console.log("submitted");
            form.submit();
        }
    });

    $('#form_add_suggestion_service').validate({
        errorClass: "my-error-class",
        validClass: "my-valid-class",

        rules: {
            customer_suggestion: 'required'
        },
        messages: {
            customer_suggestion: 'please enter customer\'s suggestion'
        },

        submitHandler: function (form) {
            console.log("submitted");
            form.submit();
        }
    });

    $('#form_account_setup').validate({
        errorClass: "my-error-class",
        validClass: "my-valid-class",

        rules: {
            phone: {
                required: true,
                minlength: 11
            },
            password: {
                required: true,
                minlength: 6
            },
            password_confirmation: {
                required: true,
                equalTo: '#txt_password'
            }
        },
        messages: {
            phone: {
                required: 'please enter your phone number',
                minlength: 'your phone number is invalid'
            },
            password: {
                required: 'please enter your password',
                minlength: 'at least 6 character are required'
            },
            password_confirmation: {
                equalTo: 'your password didn\'t match'
            }
        },

        errorPlacement: function(error, element)
        {
            if ( element.is(":text") || element.is(":password") )
            {
                error.appendTo( element.parents('.error') );
            }
            else
            { // This is the default behavior
                error.insertAfter( element );
            }
        },

        submitHandler: function (form) {
            form.submit();
        }
    });
});