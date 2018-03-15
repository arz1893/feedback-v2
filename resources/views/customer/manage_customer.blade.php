<!-- Modal -->
<div class="modal fade" id="modal_add_customer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {{ Form::hidden('tenantId', Auth::user()->tenantId, ['id' => 'tenantId']) }}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-primary" id="myModalLabel">Add Customer</h4>
                <small class="text-danger">*note: field with (*) must be filled</small>
            </div>
            <div class="alert alert-danger alert-dismissible" role="alert" id="customer_exist" style="display: none;">
                <strong>Alert!</strong> Customer with the entered phone number already exist, please check the customer list
            </div>
            <form @submit.prevent="submitCustomer">
                <div class="modal-body modal-customer">
                    @include('layouts.customer.add_customer_form')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal -->