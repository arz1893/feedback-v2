<div class="form-group">
    {{ Form::label('customerId', 'Customer') }}
    <div class="input-group input-group-md">
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

<div class="form-group error">
    {{ Form::radio('customer_rating', 1, false, ['id' => 'radio_very_dissatisfied', 'class' => 'invisible']) }}
    {{ Form::radio('customer_rating', 2, false, ['id' => 'radio_dissatisfied', 'class' => 'invisible']) }}
    {{ Form::radio('customer_rating', 3, false, ['id' => 'radio_neutral', 'class' => 'invisible']) }}
    {{ Form::radio('customer_rating', 4, false, ['id' => 'radio_satisfied', 'class' => 'invisible']) }}
    {{ Form::radio('customer_rating', 5, false, ['id' => 'radio_very_satisfied', 'class' => 'invisible']) }}
    <br>

    {{ Form::label('', 'Customer Satisfaction') }} <br>
    <a class="" href="#!">
        <i id="very_bad"
           class="smiley_rating material-icons text-maroon"
           style="font-size: 3.5em;"
           v-on:click="customerRating(1, $event)"
           data-value="1">
            sentiment_very_dissatisfied
        </i>
    </a>
    <a class="" href="#!">
        <i id="bad"
           class="smiley_rating material-icons text-red"
           style="font-size: 3.5em;"
           v-on:click="customerRating(2, $event)"
           data-value="2">
            sentiment_dissatisfied
        </i>
    </a>
    <a class="" href="#!">
        <i id="normal"
           class="smiley_rating material-icons text-yellow"
           style="font-size: 3.5em;"
           v-on:click="customerRating(3, $event)"
           data-value="3">
            sentiment_neutral
        </i>
    </a>
    <a class="" href="#!">
        <i id="satisfied"
           class="smiley_rating material-icons text-olive"
           style="font-size: 3.5em;"
           v-on:click="customerRating(4, $event)"
           data-value="4">
            sentiment_satisfied
        </i>
    </a>
    <a class="" href="#!">
        <i id="very_satisfied"
           class="smiley_rating material-icons text-green"
           style="font-size: 3.5em;"
           v-on:click="customerRating(5, $event)"
           data-value="5">
            sentiment_very_satisfied
        </i>
    </a>
    <br>
</div>

<div class="form-group">
    {{ Form::label('customer_complaint', 'Complaint') }}
    {{ Form::textarea('customer_complaint', null, ['class' => 'form-control', 'placeholder' => 'Please enter customer\'s complaint', 'rows' => 6]) }}
</div>

<div class="form-group">
    {{ Form::label('attachment', 'Attach a File') }}
    {{ Form::file('attachment', ['class' => 'form-control-file', 'accept' => 'image/*']) }}
</div>

<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
        <div class="form-group">
            <label>
                {{ Form::hidden('is_need_call', 0) }}
                {{ Form::checkbox('is_need_call', 1, false, ['id' => 'is_need_call', ':disabled' => 'is_anonymous == true']) }}
                {{--<input type="checkbox" class="icheck-input" name="is_need_call" id="is_need_call" value="1">--}}
                Need Call ?
            </label>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
        <div class="form-group">
            <label>
                {{ Form::hidden('is_urgent', 0) }}
                {{ Form::checkbox('is_urgent', 1) }}
                {{--<input type="checkbox" class="icheck-input" name="is_urgent" id="is_urgent" value="1">--}}
                Is Urgent ?
            </label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <button type="submit" class="btn btn-danger">
            {{ $submitButtonText }}
        </button>
    </div>
</div>