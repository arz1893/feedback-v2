<!-- Modal -->
<div class="modal fade"
     id="modal_add_service_category"
     tabindex="-1"
     role="dialog"
     aria-labelledby="modal_service">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-primary" id="modal_title_service_category">Add Category</h3>
            </div>
            {{ Form::open(['action' => 'MasterData\ServiceCategoryController@store', 'id' => 'form_add_service_category']) }}
            <div class="modal-body">
                <div class="form-group">
                    {{ Form::label('name', 'Name', ['class' => 'control-label', 'id' => 'lbl_add_service_category']) }}
                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter category name', 'id' => 'txt_add_service_category']) }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add Category</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Modal -->
<div class="modal fade"
     id="modal_edit_service_category"
     tabindex="-1"
     role="dialog"
     aria-labelledby="modal_edit_label"
     aria-hidden="true"
     data-id=""
     data-type="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_edit_label">Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['action' => 'MasterData\ServiceCategoryController@renameServiceCategory', 'id' => 'form_edit_service_category']) }}
            <div class="modal-body">
                {{ Form::label('name', 'Enter Category Name', ['class' => 'control-label', 'id' => 'lbl_edit_service_category']) }}
                {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Category Name', 'id' => 'txt_edit_service_category']) }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button data-id=""
                        id="btn_service_category"
                        type="submit"
                        class="btn btn-primary">
                    Update Category
                </button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Modal -->
<div class="modal fade"
     id="modal_delete_service_category"
     tabindex="-1"
     role="dialog"
     aria-labelledby="modal_delete_label"
     aria-hidden="true"
     data-id=""
     data-type="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_delete_label">Delete Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['action' => 'MasterData\ServiceCategoryController@deleteServiceCategory', 'id' => 'form_delete_service_category']) }}
            <div class="modal-body">
                Are you sure want to delete this category ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button data-id=""
                        id="btn_delete_category"
                        type="submit"
                        class="btn btn-danger">
                    Delete
                </button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
<!-- End Modal -->