$(document).ready(function () {

    $('#table_product').DataTable({
        responsive: true,
        bLengthChange: false,
        iDisplayLength: 20,
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 2 },
            { "width": "5%", "targets": 0 },
            { "width": "8%", "targets": 1 },
            { "width": "40%", "targets": 3 },
            { "width": "15%", "targets": 4 },

        ]
    });

    $('#table_service').DataTable({
        responsive: true,
        bLengthChange: false,
        iDisplayLength: 20,
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
        responsive: true,
        bLengthChange: false,
        iDisplayLength: 20
    });

    $('#table_question').DataTable({
        responsive:true,
        bLengthChange: false,
        iDisplayLength: 20,
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
        scrollX: true,
        bLengthChange: false,
        iDisplayLength: 20
    });

    $('#table_complaint_product').DataTable({
        responsive: true,
        bLengthChange: false,
        iDisplayLength: 20,
        columnDefs: [
            { "width": "5%", "targets": 0 },
            { "width": "10%","targets": 1 },
            { "width": "8%", "targets": 5 },
            { "width": "8%", "targets": 6 },
            { "width": "9%", "targets": 7 }
        ]
    });

    $('#table_complaint_service').DataTable({
        responsive: true,
        bLengthChange: false,
        iDisplayLength: 20,
        columnDefs: [
            { "width": "5%", "targets": 0 },
            {
                "width": "10%",
                "targets": 1,
                "render": function(data, type, row) {
                    return data.length > 100 ?
                        data.substr( 0, 200 ) +'…' :
                        data;
                }
            },
            { "width": "8%", "targets": 5 },
            { "width": "8%", "targets": 6 },
            { "width": "9%", "targets": 7 }
        ]
    });

    $('#table_suggestion_product').DataTable({
        responsive: true,
        bLengthChange: false,
        iDisplayLength: 20,
        columnDefs: [
            { "width": "10%", "targets": 1 }
        ]
    });

    $('#table_suggestion_service').DataTable({
        responsive: true,
        bLengthChange: false,
        iDisplayLength: 20,
        columnDefs: [
            {
                "width": "10%",
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


    $('.select2').select2({
        theme: 'bootstrap'
    });

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

    $('#select_tags').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        placeholder: 'Select Tag',
        width: '100%'
    });

    $('#modal_add_customer').modal({
        show: false,
        backdrop: 'static'
    });

    $('#lightgallery').lightGallery();
});