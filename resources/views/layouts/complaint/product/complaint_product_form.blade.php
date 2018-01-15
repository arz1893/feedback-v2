<div class="form-group">
    {{ Form::label('customerId', 'Customer') }}
    <div class="input-group input-group-md">
        {{ Form::select('customerId', $selectCustomers, null, ['class' => 'selectpicker', 'placeholder' => 'Anonymous', 'data-live-search' => 'true']) }}
        <span class="input-group-btn">
          <button type="button" class="btn btn-info btn-flat" id="btn_add_customer" data-toggle="modal" data-target="#modal_add_customer">
              <i class="fa fa-plus-circle"></i>
          </button>
        </span>
    </div>
</div>

<div class="form-group">
    {{ Form::label('', 'Customer Satisfaction') }} <br>
    <a class="" href="#very_bad" >
        <i id="very_bad" class="smiley_rating material-icons text-red" style="font-size: 4em;" v-on:click="customerRating(1, $event)">sentiment_very_dissatisfied</i>
    </a>
    <a class="" href="#bad">
        <i id="bad" class="smiley_rating material-icons text-orange" style="font-size: 4em;" v-on:click="customerRating(2, $event)">sentiment_dissatisfied</i>
    </a>
    <a class="" href="#normal">
        <i id="normal" class="smiley_rating material-icons text-muted" style="font-size: 4em;" v-on:click="customerRating(3, $event)">sentiment_neutral</i>
    </a>
    <a class="" href="#satisfied">
        <i id="satisfied" class="smiley_rating material-icons text-aqua" style="font-size: 4em;" v-on:click="customerRating(4, $event)">sentiment_satisfied</i>
    </a>
    <a class="" href="#very_satisfied">
        <i id="very_satisfied" class="smiley_rating material-icons text-green" style="font-size: 4em;" v-on:click="customerRating(5, $event)">sentiment_very_satisfied</i>
    </a>

    <div v-html="ratingValue"></div>
</div>
<div class="form-group">
    {{ Form::label('customer_complaint', 'Complaint') }}
    {{ Form::textarea('customer_complaint', null, ['class' => 'form-control', 'placeholder' => 'Please enter customer\'s complaint', 'rows' => 6]) }}
</div>
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
        <div class="form-group">
            <label>
                {{ Form::hidden('is_need_call', 0) }}
                {{ Form::checkbox('is_need_call', 1) }}
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