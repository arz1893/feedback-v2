<div class="row margin-bottom">
    <div class="form-group">
        <div class="col-lg-3 col-md-3 col-xs-4">
            {{ Form::label('customer_name', 'Customer :') }}
        </div>
        <div class="col-lg-3">
            {{ Form::select('customerId', $selectCustomers, null, ['class' => 'form-control selectpicker show-tick', 'id' => 'customer_name', 'placeholder' => 'Select Customer', 'data-live-search' => true]) }}
        </div>
    </div>
</div>

<div class="row margin-bottom">
    <div class="form-group">
        <div class="col-lg-3">
            {{ Form::label('question', 'Customer\'s Question :') }}
        </div>
        <div class="col-lg-7">
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
                Need Call ?
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