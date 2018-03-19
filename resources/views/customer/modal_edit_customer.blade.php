<!-- Modal -->
<div class="modal fade" id="modal_edit_customer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-warning" id="myModalLabel">Edit Customer</h4>
            </div>
            <form role="form" @submit.prevent="updateCustomer">
                <div class="modal-body">
                    <div class="container-fluid">
                        @include('layouts.customer.add_customer_form')
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update changes</button>
                </div>
            </form>
        </div>
    </div>
</div>