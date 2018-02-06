<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            {{ Form::label('name', 'Name') }}
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Tag Name']) }}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            {{ Form::label('defValue', 'Default Search') }}
            {{ Form::select('defValue', [0 => 'No', 1 => 'Yes'], 0, ['class' => 'form-control']) }}
        </div>
    </div>
</div>