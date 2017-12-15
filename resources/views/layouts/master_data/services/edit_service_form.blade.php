<div class="">
    <div class="col-md-4 col-lg-offset-3">
        <div class="form-group">
            {{ Form::label('name', 'Name', ['class' => 'control-label']) }}
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter your service name']) }}
        </div>
    </div>

    <div class="col-md-6 col-lg-offset-3">
        <div class="form-group">
            {{ Form::label('description', 'Description', ['class' => 'control-label']) }}
            {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter your service description']) }}
        </div>
    </div>
</div>

<div class="">
    <div class="col-md-6 col-lg-offset-3">
        <div class="form-group">
            {{ Form::submit($submitButtonText, ['class' => 'btn btn-primary']) }}
        </div>
    </div>
</div>