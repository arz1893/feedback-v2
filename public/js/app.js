$(document).ready(function () {

    $('#table_product').DataTable({
        responsive: true,
        bLengthChange: false,
        iDisplayLength: 10,
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
        iDisplayLength: 10,
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
        iDisplayLength: 10
    });

    $('#table_question').DataTable({
        responsive:true,
        bLengthChange: false,
        iDisplayLength: 10,
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
        iDisplayLength: 10
    });

    $('#table_customer').DataTable({
        responsive: true,
        scrollX: true,
        bLengthChange: false,
        iDisplayLength: 10
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

    $('.select2-year').select2({
        theme: 'bootstrap',
        placeholder: "Choose..."
    });

    $('.select2-tag').select2({
        placeholder: 'Select Tag',
        theme: 'bootstrap'
    });

    // $('.select2-customer').select2({
    //     placeholder: 'Choose customer...',
    //     theme: 'bootstrap'
    // });

    $('.select2-on-edit-customer').select2({
        theme: 'bootstrap'
    });

    $('.select2-product').select2({
        placeholder: 'Choose product...',
        theme: 'bootstrap'
    });

    $('.select2-service').select2({
        placeholder: 'Choose service...',
        theme: 'bootstrap'
    });

    $('.select2-customer').select2({
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

    $('#modal_edit_customer').modal({
        show: false,
        backdrop: 'static'
    });

    $('#modal_category').modal({
        show: false,
        backdrop: 'static'
    });

    $('#lightgallery').lightGallery();

    $('.datepicker').datepicker({
        format: 'dd-M-yyyy',
        todayBtn: true,
        todayHighlight: true
    });
});