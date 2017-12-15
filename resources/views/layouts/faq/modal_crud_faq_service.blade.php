<!-- Modal -->
<div class="modal fade"
     id="modal_add_service_faq"
     tabindex="-1"
     role="dialog"
     aria-labelledby="myModalLabel"
     data-type="product_faq"
     data-id="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-blue" id="myModalLabel">
                    Add FAQ to Service
                </h4>
            </div>
            {{ Form::open(['action' => 'Faq\FaqServiceController@store', 'id' => 'form_add_faq_service']) }}
            {{ Form::hidden('serviceId', $service->systemId) }}
            <div class="modal-body">
                <div class="form-group">
                    {{ Form::label('question', 'Question', ['class' => 'control-label']) }}
                    {{ Form::text('question', null, ['class' => 'form-control', 'placeholder' => 'Enter your FAQ question']) }}
                </div>
                <div class="form-group">
                    {{ Form::label('answer', 'Answer', ['class' => 'control-label']) }}
                    {{ Form::textarea('answer', null, ['class' => 'form-control', 'placeholder' => 'Enter your answer to current question']) }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit"
                        class="btn btn-primary"> Add FAQ
                </button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Modal -->
<div class="modal fade"
     id="modal_delete_service_faq"
     tabindex="-1"
     role="dialog"
     aria-labelledby="myModalLabel"
     data-type="product_faq"
     data-id="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-orange" id="myModalLabel">
                    Warning <i class="fa fa-exclamation-triangle"></i>
                </h4>
            </div>
            {{ Form::open(['action' => 'Faq\FaqServiceController@deleteFaqService', 'id' => 'form_delete_faq_service']) }}
            <div class="modal-body">
                Are you sure want to delete this FAQ ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary"> Delete
                </button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
<!-- End Modal -->