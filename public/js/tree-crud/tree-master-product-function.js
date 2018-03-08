$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $('#product_category_tree').fancytree({
        extensions: ['glyph','wide','edit'],
        glyph: {
            preset: 'material',
            map: {}
        },
        source: $.ajax({
            method: 'POST',
            url: window.location.protocol + "//" + window.location.host + "/" + 'product_category/get-trees',
            dataType: 'json',
            data: {product_id: $('#product_id').val(), _token: CSRF_TOKEN},
            success: function (response) {
                return response;
            }
        }),

        edit: {
            triggerStart: ["f2", "dblclick", "shift+click", "mac+enter"],

            close: function(event, data){
                var nodeKey = data.node.key;
                if(nodeKey !== null) {
                    if(nodeKey.indexOf('_') !== -1) {
                        $.ajax({
                            method: 'POST',
                            url: window.location.protocol + "//" + window.location.host + "/" + 'product_category/add-child-node',
                            dataType: 'json',
                            data: {parent_id: data.node.parent.key, name: data.node.title, _token: CSRF_TOKEN},
                            success: function (response) {
                                data.node.key = response;
                            }
                        });
                    } else if(nodeKey.indexOf('_') === -1) {
                        $.ajax({
                            method: 'POST',
                            url: window.location.protocol + "//" + window.location.host + "/" + 'product_category/rename-node',
                            dataType: 'json',
                            data: {node_key: data.node.key, name: data.node.title, _token: CSRF_TOKEN},
                            success: function (response) {

                            }
                        });
                    }
                }
                // console.log(data.node);
            }
        },

        lazyload: function (event, data) {
           var node = data.node;
           data.result = {
                method: 'POST',
                url: window.location.protocol + "//" + window.location.host + "/" + 'product_category/get-childs',
                data: {mode: 'children', parent_id: node.key, _token: CSRF_TOKEN},
                cache: false
           };
        }
    });

    $.contextMenu({
        selector: "#product_category_tree span.fancytree-title",
        items: {
            "add_sub": {name: "Add sub", icon: "add"},
            "rename": {name: "Rename", icon: "edit"},
            "sep1": "----",
            "delete": {name: "Delete", icon: "delete"}
            // "more": {name: "More", items: {
            //     "sub1": {name: "Sub 1"},
            //     "sub1": {name: "Sub 2"}
            // }}
        },
        callback: function(itemKey, opt) {
            var node = $.ui.fancytree.getNode(opt.$trigger);
            if(itemKey === 'add_sub') {
                node.editCreateNode('child', {
                    title: '',
                    folder: true,
                    lazy: true
                });
            } else if(itemKey === 'delete') {
                var confirm = window.confirm('Are you sure want to delete this category ?');
                if(confirm === true) {
                    $.ajax({
                        method: 'POST',
                        url: window.location.protocol + "//" + window.location.host + "/" + 'product_category/delete-node',
                        dataType: 'json',
                        data: {node_id: node.key, _token: CSRF_TOKEN},
                        success: function (response) {
                            if(response.status === 'success') {
                                node.remove();
                            }
                        }
                    });
                }
            } else if(itemKey === 'rename') {
                node.editStart();
            }
        }
    });
});

function setProductCategoryType(selected) {
    var type = $(selected).data('type');
    var product_id = $('#product_id').val();

    if(type === 'root') {
        $('#modal_title_product_category').html('Add Category');
        $('<input>').attr({
            type: 'hidden',
            name: 'category_type',
            value: 'root'
        }).appendTo('#form_add_product_category');
        $('<input>').attr({
            type: 'hidden',
            name: 'product_id',
            value: product_id
        }).appendTo('#form_add_product_category');
    } else if(type === 'sub') {
        var activeNode = $('#product_category_tree').fancytree('getActiveNode');
        if(activeNode === null) {
            alert('please select category first');
        } else {
            $('#modal_title_product_category').html('Add Sub Category');
            var parent_id = activeNode.key;
            $('<input>').attr({
                type: 'hidden',
                name: 'product_id',
                value: product_id
            }).appendTo('#form_add_product_category');
            $('<input>').attr({
                type: 'hidden',
                name: 'category_type',
                value: 'sub'
            }).appendTo('#form_add_product_category');
            $('<input>').attr({
                type: 'hidden',
                name: 'parent_id',
                value: parent_id
            }).appendTo('#form_add_product_category');
            $('#modal_add_product_category').modal('show');
        }
    } else if(type === 'edit') {
        var activeNode = $('#product_category_tree').fancytree('getActiveNode');
        if(activeNode === null) {
            alert('please select category first');
        } else {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                method: 'POST',
                url: window.location.protocol + "//" + window.location.host + "/" + 'product_category/get-category',
                dataType: 'json',
                data: {node_id: activeNode.key, _token: CSRF_TOKEN},
                success: function (category) {
                    $('#txt_edit_product_category').val(category.name);
                }
            });

            var node_key = activeNode.key;
            $('<input>').attr({
                type: 'hidden',
                name: 'node_key',
                value: node_key
            }).appendTo('#form_edit_product_category');
            $('<input>').attr({
                type: 'hidden',
                name: 'category_type',
                value: 'edit'
            }).appendTo('#form_edit_product_category');
            $('#modal_edit_product_category').modal('show');
        }
    } else if(type === 'delete') {
        var activeNode = $('#product_category_tree').fancytree('getActiveNode');
        if(activeNode === null) {
            alert('please select category first');
        } else {
            var node_key = activeNode.key;
            $('<input>').attr({
                type: 'hidden',
                name: 'node_key',
                value: node_key
            }).appendTo('#form_delete_product_category');
            $('<input>').attr({
                type: 'hidden',
                name: 'product_id',
                value: product_id
            }).appendTo('#form_delete_product_category');
            $('<input>').attr({
                type: 'hidden',
                name: 'category_type',
                value: 'delete'
            }).appendTo('#form_delete_product_category');
            $('#modal_delete_product_category').modal('show');
        }
    }
}