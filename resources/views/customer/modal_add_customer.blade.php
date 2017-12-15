<!-- Modal -->
<div class="modal fade" id="modal_add_customer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-primary" id="myModalLabel">Add Customer</h4>
                <small class="text-danger">*note: field with (*) must be filled</small>
            </div>
            {{ Form::open(['action' => 'Customer\CustomerController@store', 'id' => 'form_add_customer']) }}
            <div class="modal-body modal-customer">
                @include('layouts.customer.add_customer_form')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add Customer</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
<!-- End Modal -->