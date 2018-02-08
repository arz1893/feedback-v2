<div class="">
    <div class="col-md-8 col-lg-offset-2">
        <div class="form-group">
            {{ Form::label('name', 'Name', ['class' => 'control-label']) }}
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter your service name']) }}
        </div>
    </div>

    <div class="col-md-8 col-lg-offset-2">
        <div class="form-group">
            {{ Form::label('description', 'Description', ['class' => 'control-label']) }}
            {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter your service description']) }}
        </div>
    </div>

    <div class="col-md-8 col-lg-offset-2">
        <div class="form-group">
            {{ Form::label('tags', 'Select tag') }}
            {{ Form::select('tags[]', $selectTags, null, ['class' => 'form-control select2-tag', 'multiple' => true, 'data-placeholder' => 'Select Tag...']) }}
        </div>
    </div>
</div>

<div class="">
    <div class="col-md-8 col-lg-offset-2">
        <div class="form-group">
            {{ Form::submit($submitButtonText, ['class' => 'btn btn-primary']) }}
        </div>
    </div>
</div>