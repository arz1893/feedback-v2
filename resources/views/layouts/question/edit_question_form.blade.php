<div class="row margin-bottom">
    <div class="form-group">
        <div class="col-lg-3 col-md-12 col-xs-4">
            {{ Form::label('customer_name', 'Customer :') }}
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="input-group input-group-md">
                {{ Form::select('customerId', $selectCustomers, null, ['class' => 'form-control select2',
                                                                       'placeholder' => 'Anonymous', 'style' => 'width:100%']) }}
                <span class="input-group-btn">
                  <button type="button" class="btn btn-info btn-flat" id="btn_add_customer" data-toggle="modal" data-target="#modal_add_customer">
                      <i class="fa fa-plus-circle"></i>
                  </button>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="row margin-bottom">
    <div class="form-group">
        <div class="col-lg-3">
            {{ Form::label('question', 'Customer\'s Question :') }}
        </div>
        <div class="col-lg-5 col-md-8">
            {{ Form::textarea('question', null, ['class' => 'form-control', 'placeholder' => 'Enter customer\'s question' ,'rows' => 3]) }}
        </div>
    </div>
</div>

<div class="row margin-bottom">
    <div class="form-group">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4">
            {{ Form::label('is_need_call', 'Need Call ? :') }}
        </div>
        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-8">
            <label>
                {{ Form::hidden('is_need_call', 0) }}
                {{ Form::checkbox('is_need_call', 1) }}
                {{--<input type="checkbox" class="icheck-input" name="is_need_call" id="is_need_call" value="1">--}}
            </label>
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-8">
            {{ Form::submit('Save Changes', ['class' => 'btn btn-primary']) }}
        </div>
    </div>
</div>