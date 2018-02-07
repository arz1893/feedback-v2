function checkTenantName(selected) {
    if($('#txt_tenant_email').val().length == 0) {
        $(selected).popover('show');
    } else {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var result = emailReg.test($('#txt_tenant_email').val());
        if(result === true) {
            $('#form-check-tenant').submit();
        } else {
            $(selected).popover('show');
        }
    }
}

function deleteItem(selected) {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var modal = $($(selected).data('modal'));
    var id = modal.data('id');

    if($(selected).data('type') === 'product') {
        $('<input>').attr({
            type: 'hidden',
            name: 'product_id',
            value: $(selected).data('id')
        }).appendTo('#form_delete_product');
        $('#modal_delete_product').modal('show');
    } else if($(selected).data('type') === 'service') {
        $('<input>').attr({
            type: 'hidden',
            name: 'service_id',
            value: $(selected).data('id')
        }).appendTo('#form_delete_service');
        $('#modal_delete_service').modal('show');
    } else if($(selected).data('type') === 'tag') {
        $('<input>').attr({
            type: 'hidden',
            name: 'tag_id',
            value: $(selected).data('id')
        }).appendTo('#form_delete_tag');
        $('#modal_delete_tag').modal('show');
    } else if($(selected).data('type') === 'faq_product') {
        $('<input>').attr({
            type: 'hidden',
            name: 'faq_product_id',
            value: $(selected).data('id')
        }).appendTo('#form_delete_faq_product');
        $('#modal_delete_product_faq').modal('show');
    } else if($(selected).data('type') === 'faq_service') {
        $('<input>').attr({
            type: 'hidden',
            name: 'faq_service_id',
            value: $(selected).data('id')
        }).appendTo('#form_delete_faq_service');
        $('#modal_delete_service_faq').modal('show');
    } else if($(selected).data('type') === 'question') {
        $('<input>').attr({
            type: 'hidden',
            name: 'question_id',
            value: $(selected).data('id')
        }).appendTo('#form_delete_question');
        $('#modal_delete_question').modal('show');
    } else if($(selected).data('type') === 'delete_complaint_product_attachment') {
        $('<input>').attr({
            type: 'hidden',
            name: 'complaint_product_id',
            value: $(selected).data('id')
        }).appendTo($('#form_delete_complaint_product_attachment'));
        $('#modal_remove_complaint_product_attachment').modal('show');
    } else if($(selected).data('type') === 'delete_complaint_service_attachment') {
        $('<input>').attr({
            type: 'hidden',
            name: 'complaint_service_id',
            value: $(selected).data('id')
        }).appendTo($('#form_delete_complaint_service_attachment'));
        $('#modal_remove_complaint_service_attachment').modal('show');
    } else if($(selected).data('type') === 'delete_answer') {
        $('<input>').attr({
            type: 'hidden',
            name: 'question_id',
            value: $(selected).data('id')
        }).appendTo('#form_delete_answer');
        $('#modal_delete_answer').modal('show');
    }
}

function deleteUser(selected) {
    $('#modal_delete_user_content').html('Are you sure want to delete <span class="text-blue">' + $(selected).data('user_email') + '</span> ?');

    $('<input>').attr({
        type: 'hidden',
        name: 'user_id',
        value: $(selected).data('user_id')
    }).appendTo('#form_delete_user');
}

function deleteComplaintProduct(selected) {
    $('<input>').attr({
        type: 'hidden',
        name: 'complaint_id',
        value: $(selected).data('id')
    }).appendTo('#form_delete_complaint_product');
    $('#modal_remove_complaint_product').modal('show');
}

function deleteComplaintService(selected) {
    $('<input>').attr({
        type: 'hidden',
        name: 'complaint_id',
        value: $(selected).data('id')
    }).appendTo('#form_delete_complaint_service');
    $('#modal_remove_complaint_service').modal('show');
}

function deleteSuggestionProduct(selected) {
    $('<input>').attr({
        type: 'hidden',
        name: 'suggestion_id',
        value: $(selected).data('id')
    }).appendTo('#form_delete_suggestion_product');
    $('#modal_remove_suggestion_product').modal('show');
}

function deleteSuggestionService(selected) {
    $('<input>').attr({
        type: 'hidden',
        name: 'suggestion_id',
        value: $(selected).data('id')
    }).appendTo('#form_delete_suggestion_service');
    $('#modal_remove_suggestion_service').modal('show');
}

function selectColor(selected) {
    var id = $(selected).data('id').toString();
    $('a.btn-select-color').each(function (index, element) {
        $(element).removeClass('is-selected-color');
    });
    $(selected).addClass('is-selected-color');
    $('input[name=bgColor]').removeAttr('checked');

    switch($(selected).data('id')) {
        case 777777: {
            $('#777777').attr('checked', 'checked');
            break;
        }
        case '7E8C8D': {
            $('#7E8C8D').attr('checked', 'checked');
            break;
        }
        case 'C6382E': {
            $('#C6382E').attr('checked', 'checked');
            break;
        }
        case 'D55005': {
            $('#D55005').attr('checked', 'checked');
            break;
        }
        case 'EF9E0E': {
            $('#EF9E0E').attr('checked', 'checked');
            break;
        }
        case '25AF62': {
            $('#25AF62').attr('checked', 'checked');
            break;
        }
        case '13A388': {
            $('#13A388').attr('checked', 'checked');
            break;
        }
        case '2482C0': {
            $('#2482C0').attr('checked', 'checked');
            break;
        }
        case '8D45AB': {
            $('#8D45AB').attr('checked', 'checked');
            break;
        }
        case '2E3E4E': {
            $('#2E3E4E').attr('checked', 'checked');
            break;
        }
    }
}