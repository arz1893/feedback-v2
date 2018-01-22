$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $('#complaint_product_tree').fancytree({
        extensions: ['glyph','wide','edit'],
        glyph: {
            preset: 'bootstrap',
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
});

function setComplaintTarget(selected) {
    var node = $('#complaint_product_tree').fancytree('getActiveNode');
    var product_id = $('#product_id').val();
    if(node === null) {
        alert('please select category first');
    } else {
        $('#product_category_name').html(node.title);
        $('<input>').attr({
            type: 'hidden',
            name: 'product_category_id',
            value: node.key
        }).appendTo('#form_add_complaint_product');
        $('<input>').attr({
            type: 'hidden',
            name: 'product_id',
            value: product_id
        }).appendTo('#form_add_complaint_product');
        $('#modal_add_complaint_product').modal('show');
    }
}