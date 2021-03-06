<div class="form-group">
    {{ Form::label('customerId', 'Customer') }}
    <div class="input-group input-group-md">
        {{ Form::select('customerId', $selectCustomers, null, ['class' => 'form-control select2',
                                                               'placeholder' => 'Anonymous',
                                                               'style' => 'width: 100%;']) }}
        <span class="input-group-btn">
          <button type="button" class="btn btn-info btn-flat" id="btn_add_customer" data-toggle="modal" data-target="#modal_add_customer">
              <i class="fa fa-plus-circle"></i>
          </button>
        </span>
    </div>
</div>

<div class="form-group">
    {{ Form::label('customer_suggestion', 'Suggestion') }}
    {{ Form::textarea('customer_suggestion', null, ['class' => 'form-control', 'placeholder' => 'Please enter customer\'s suggestion', 'rows' => 6]) }}
</div>

<div class="row">
    <div class="col-lg-6">
        <button type="submit" class="btn btn-warning">
            {{ $submitButtonText }}
        </button>
    </div>
</div>