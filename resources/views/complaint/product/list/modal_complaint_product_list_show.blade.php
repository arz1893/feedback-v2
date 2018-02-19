<div id="modal_complaint_product_show" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-danger">Complaint Detail</h4>
            </div>
            <div class="modal-body">
                <div class="media">
                    <div class="media-left">
                        <a href="#">
                            <img class="media-object" src="{{ asset($complaintProduct->product->img) }}" width="125px">
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading text-danger">
                            {{ $complaintProduct->product->name }} ( {{ $complaintProduct->product_category->name }} )
                            <span class="mailbox-read-time pull-right visible-lg visible-md">{{ $complaintProduct->created_at->format('d F Y, H:iA') }}</span>
                            <span class="mailbox-read-time visible-sm visible-xs">{{ $complaintProduct->created_at->format('d F Y, H:iA') }}</span>
                        </h4>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->