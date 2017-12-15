$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $('#complaint_service_tree').fancytree({
        extensions: ['glyph','wide','edit'],
        glyph: {
            preset: 'material',
            map: {}
        },
        source: $.ajax({
            method: 'POST',
            url: window.location.protocol + "//" + window.location.host + "/" + 'service_category/get-trees',
            dataType: 'json',
            data: {master_service_id: $('#master_service_id').val(), _token: CSRF_TOKEN},
            success: function (response) {
                return response;
            }
        }),

        lazyload: function (event, data) {
            var node = data.node;
            data.result = {
                method: 'POST',
                url: window.location.protocol + "//" + window.location.host + "/" + 'service_category/get-childs',
                data: {mode: 'children', parent_id: node.key, _token: CSRF_TOKEN},
                cache: false
            };
        }
    });
});