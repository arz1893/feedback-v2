<!-- Modal -->
<div class="modal fade"
     id="modal_add_product_category"
     tabindex="-1"
     role="dialog"
     aria-labelledby="modal_title">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-primary" id="modal_title_product_category">Add Category</h3>
            </div>
            {{ Form::open(['action' => 'MasterData\ProductCategoryController@store', 'id' => 'form_add_product_category']) }}
            <div class="modal-body">
                <div class="form-group">
                    {{ Form::label('name', 'Name', ['class' => 'control-label', 'id' => 'lbl_add_product_category']) }}
                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter category name', 'id' => 'txt_add_product_category']) }}
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
     id="modal_edit_product_category"
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
            {{ Form::open(['action' => 'MasterData\ProductCategoryController@updateProductCategory', 'id' => 'form_edit_product_category']) }}
            <div class="modal-body">
                {{ Form::label('name', 'Enter Category Name', ['class' => 'control-label', 'id' => 'lbl_edit_product_category']) }}
                {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Category Name', 'id' => 'txt_edit_product_category']) }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button data-id=""
                        id="btn_update_category"
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
     id="modal_delete_product_category"
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
            {{ Form::open(['action' => 'MasterData\ProductCategoryController@deleteProductCategory', 'id' => 'form_delete_product_category']) }}
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