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

    <div class="col-md-6 col-lg-offset-3">
        <div class="form-group">
            <div class="form-group">
                <label for="image_cover">Choose image</label>
                <input type="file" accept="image/*" class="form-control-file" name="image_cover" id="image_cover" aria-describedby="fileHelp">
                <small id="fileHelp" class="form-text text-muted">
                    Choose your service image / logo (*this is optional)
                </small>
            </div>
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