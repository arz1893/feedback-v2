function setCategoryType(selected) {
    var type = $(selected).data('type');

    if(type === 'root') {
        var master_product_id = $(selected).data('product_id');
        $('<input>').attr({
            type: 'hidden',
            name: 'category_type',
            value: 'root'
        }).appendTo('#form_add_category');
        $('<input>').attr({
            type: 'hidden',
            name: 'master_product_id',
            value: master_product_id
        }).appendTo('#form_add_category');
    } else if(type === 'sub') {
        var id = $(selected).data('id');
        $('<input>').attr({
            type: 'hidden',
            name: 'master_product_id',
            value: master_product_id
        }).appendTo('#form_add_category');
        $('<input>').attr({
            type: 'hidden',
            name: 'category_type',
            value: 'sub'
        }).appendTo('#form_add_category');
        $('<input>').attr({
            type: 'hidden',
            name: 'parent_id',
            value: id
        }).appendTo('#form_add_category');
    }
}

function setEditCategory(selected) {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var id = $(selected).data('id');

    $.ajax({
        method: 'POST',
        url: window.location.protocol + "//" + window.location.host + "/" + 'product_category/get-category',
        dataType: 'json',
        data: {id: id, _token: CSRF_TOKEN},
        success: function (response) {
            console.log(response);
            $('#btn_update_category').data('id', id);
            $('#txt_edit_category').val(response.name);
        }
    })
}

function updateCategory(selected) {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var id = $(selected).data('id');
    var txtCategoryName = $('#txt_edit_category').val();

    $.ajax({
        method: 'POST',
        url: window.location.protocol + "//" + window.location.host + "/" + 'product_category/update-category',
        dataType: 'json',
        data: {id: id, category_name: txtCategoryName,_token: CSRF_TOKEN},
        success: function (response) {
            location.reload();
        }
    });
}

function setDeleteCategory(selected) {
    var id = $(selected).data('id');
    $('#btn_delete_category').data('id', id);
}

function deleteCategory(selected) {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var id = $(selected).data('id');

    $.ajax({
        method: 'POST',
        url: window.location.protocol + "//" + window.location.host + "/" + 'product_category/delete-category',
        dataType: 'json',
        data: {id: id, _token: CSRF_TOKEN},
        success: function (response) {
            location.reload();
        }
    });
}

function expandTree(selected) {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var id = $(selected).data('id');

    var child_name = [];

    $.ajax({
        method: 'POST',
        url: window.location.protocol + "//" + window.location.host + "/" + 'product_category/get-childs',
        dataType: 'json',
        data: {id: id, _token: CSRF_TOKEN},
        success: function (response) {
            if(response !== null) {
                $(selected).attr('onclick', 'closeTree(this)');
                var list = $('li#' + id).append('<ul id=id></ul>').find('ul');
                $.each(response.childs, function (i) {
                    list.append(
                        '<li id="'+response.childs[i].id+'">'
                        + '<a href="#!" id="'+ response.childs[i].id +'" data-id="'+ response.childs[i].id +'" onclick="expandTree(this)">' +
                        '<i class="fa fa-angle-down"></i> &nbsp;' +
                        '</a>'
                        + '<a href="#">'+ response.childs[i].name + ' &nbsp; </a>'
                        + '<div class="dropdown" style="display: inline;">'
                        + '<a href="#" ' +
                        'id="category_action_'+ response.childs[i].id +'" ' +
                        'data-toggle="dropdown" ' +
                        'aria-haspopup="true" ' +
                        'aria-expanded="false">'
                        + '<i class="fa fa-plus" aria-hidden="true"></i>' +
                        '</a>' +
                        '<ul id="'+ response.childs[i].id +'" class="dropdown-menu" aria-labelledby="category_action_'+ response.childs[i].id +'">' +
                        '<li>' +
                        '<a class="dropdown-item" ' +
                        'href="#" ' +
                        'data-toggle="modal" ' +
                        'data-target="#modal_add_sub" ' +
                        'data-type="sub" ' +
                        'data-id="'+ response.childs[i].id +'" ' +
                        'onclick="setCategoryType(this)">' +
                        'Add Sub Category' +
                        '</a>' +
                        '</li>' +
                        '<li>' +
                        '<a class="dropdown-item" ' +
                        'href="#" ' +
                        'data-toggle="modal" ' +
                        'data-target="#modal_edit_category" ' +
                        'data-type="edit_category" ' +
                        'data-id="'+ response.childs[i].id +'" ' +
                        'onclick="setEditCategory(this)">' +
                        'Edit Category Name' +
                        '</a>' +
                        '</li>' +
                        '<li>' +
                        '<a class="dropdown-item" ' +
                        'href="#" ' +
                        'data-toggle="modal" ' +
                        'data-target="#modal_delete_category" ' +
                        'data-type="delete_category" ' +
                        'data-id="'+ response.childs[i].id +'" ' +
                        'onclick="setDeleteCategory(this)">' +
                        'Remove Category' +
                        '</a>' +
                        '</li>' +
                        '</ul>' +
                        '</div>' +
                        '</li>'
                    );
                });
            }
        }
    });
}

function closeTree(selected) {
    var id = $(selected).data('id');
    var selectedList = $('li#' + id).find('ul').remove();
    $(selected).attr('onclick', 'expandTree(this)');
}