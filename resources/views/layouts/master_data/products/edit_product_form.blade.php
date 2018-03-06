<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="form-group">
            {{ Form::label('name', 'Product Name') }}
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter your product name']) }}
        </div>
        <div class="form-group">
            {{ Form::label('description', 'Description') }}
            {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter your product description']) }}
        </div>
        <div class="form-group">
            {{ Form::label('tags', 'Select tag') }}
            {{ Form::select('tags[]', $selectTags, null, ['class' => 'form-control select2-tag', 'multiple' => true, 'data-placeholder' => 'Select Tag...', 'style' => 'width:100%']) }}
        </div>
        <div class="form-group">
            {{ Form::submit('Update Product', ['class' => 'btn btn-primary form-control']) }}
        </div>
    </div>
</div>