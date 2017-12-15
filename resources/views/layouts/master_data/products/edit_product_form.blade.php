<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="form-group">
            {{ Form::label('name', 'Product Name') }}
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter your product name']) }}
        </div>
        <div class="form-group">
            {{ Form::label('description', 'Description') }}
            {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter your product description']) }}
        </div>
        <div class="form-group">
            {{ Form::label('metric', 'Product\'s metric') }}
            {{ Form::select('metric', [
                    'Pcs' => 'Pcs',
                    'Kg' => 'Kg',
                    'Meter' => 'Meter'
            ], null, ['class' => 'form-control', 'placeholder' => 'Select metric']) }}
        </div>
        <div class="form-group">
            {{ Form::label('price', 'Product\'s price') }}
            {{ Form::input('number', 'price', null, ['class' => 'form-control', 'placeholder' => 'Enter product\'s price', 'step' => 'any']) }}
        </div>
        <div class="form-group">
            {{ Form::submit('Update Product', ['class' => 'btn btn-primary form-control']) }}
        </div>
    </div>
</div>