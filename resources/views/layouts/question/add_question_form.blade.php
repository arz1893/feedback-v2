<div class="form-group">
    {{ Form::label('customerId', 'Customer') }}
    <div class="input-group">
        {{ Form::select('customerId', $selectCustomers, null, ['class' => 'form-control selectpicker',
                                                               'placeholder' => 'Anonymous',
                                                               'data-live-search' => 'true',
                                                               'v-on:change' => 'onChangeCustomer($event)']) }}
        <span class="input-group-btn">
          <button type="button" class="btn btn-info btn-flat" id="btn_add_customer" data-toggle="modal" data-target="#modal_add_customer">
              <i class="fa fa-plus-circle"></i>
          </button>
        </span>
    </div>
</div>

<div class="form-group">
    {{ Form::label('question', 'Question') }}
    {{ Form::textarea('question', null, ['class' => 'form-control', 'rows' => 6]) }}
</div>

<div class="form-group">
    <button type="submit" class="btn btn-success">
        Add Question
    </button>
</div>

