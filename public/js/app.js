$(document).ready(function () {

    $('#table_product').DataTable({
        responsive: true,
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 2 },
            {
                targets: [3],
                render: function ( data, type, row ) {
                    return data.length > 10 ?
                        data.substr( 0, 50 ) +'…' :
                        data;
                }
            }
        ]
    });

    $('#table_service').DataTable({
        responsive: true,
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 2 },
            {
                targets: [3],
                render: function ( data, type, row ) {
                    return data.length > 10 ?
                        data.substr( 0, 50 ) +'…' :
                        data;
                }
            }
        ]
    });

    $('#table_tags').DataTable({
        responsive: true
    });

    $('#table_question').DataTable({
        responsive:true,
        columnDefs: [ {
            targets: [1],
            render: function ( data, type, row ) {
                return data.length > 100 ?
                    data.substr( 0, 150 ) +'…' :
                    data;
            }
        } ]
    });

    $('#table_user').DataTable({
        responsive: true,
        scrollX: true
    });

    $('#table_complaint_product').DataTable({
        responsive: true,
        columnDefs: [
            {
                "width": "25%",
                "targets": 1,
                "render": function(data, type, row) {
                    return data.length > 100 ?
                        data.substr( 0, 150 ) +'…' :
                        data;
                }
            },
            { "width": "5%", "targets": 5 },
            { "width": "8%", "targets": 6 },
            { "width": "8%", "targets": 7 }
        ]
    });

    $('#table_complaint_service').DataTable({
        responsive: true,
        columnDefs: [
            {
                "width": "25%",
                "targets": 1,
                "render": function(data, type, row) {
                    return data.length > 100 ?
                        data.substr( 0, 200 ) +'…' :
                        data;
                }
            },
            { "width": "5%", "targets": 5 },
            { "width": "8%", "targets": 6 },
            { "width": "8%", "targets": 7 }
        ]
    });

    $('#table_suggestion_product').DataTable({
        responsive: true,
        columnDefs: [
            {
                "width": "25%",
                "targets": 1,
                "render": function(data, type, row) {
                    return data.length > 100 ?
                        data.substr( 0, 200 ) +'…' :
                        data;
                }
            }
        ]
    });

    $('#table_suggestion_service').DataTable({
        responsive: true,
        columnDefs: [
            {
                "width": "25%",
                "targets": 1,
                "render": function(data, type, row) {
                    return data.length > 100 ?
                        data.substr( 0, 200 ) +'…' :
                        data;
                }
            }
        ]
    });

    $('#product_picture').on('change', function (e) {
        e.preventDefault();
        $('#form_change_picture').submit();
    });

    $('#toggle_anonymous').change(function () {
        if($(this).prop('checked') === true) {
            $('#cust_name_container').removeAttr('style');
            // $('#toggle_anonymous_text').html('Enter or select user');
        } else {
            $('#cust_name_container').css('display', 'none');
            // $('#toggle_anonymous_text').html('Anonymous user');
        }
    });

    // $('#tree_view').treed({openedClass:'glyphicon-chevron-right', closedClass:'glyphicon-chevron-down'});
    $('.select2-tag').select2({
        placeholder: 'Select Tag',
        theme: 'bootstrap'
    });

    $('.select2-customer').select2({
        theme: 'bootstrap'
    });

    $('.select2-on-edit-customer').select2({
        theme: 'bootstrap'
    });

    $('#birthdate').dateDropper({});
    $('#modal_add_customer').modal({
        show: false,
        backdrop: 'static'
    });

    // $('input').iCheck({
    //     checkboxClass: 'icheckbox_square-blue',
    //     radioClass: 'iradio_square-blue'
    // });

    // $('input[type="file"]').prettyFile();

    $('#lightgallery').lightGallery();
});