<div class="row">

    <div class="col-lg-12 col-md-12" id="cust_name_container">
        <div class="col-lg-6">
            <div class="form-group">
                <div class="input-group">
                    {{ Form::select('customerId', $selectCustomers, null,
                    ['class' => 'form-control selectpicker show-tick', 'id' => 'customer_name', 'placeholder' => 'Select Customer', 'data-live-search' => 'true']) }}
                    {{--<select id="customer_name" name="customer_id" class="form-control selectpicker show-tick" data-live-search="true">--}}
                        {{--<option selected disabled>Select customer</option>--}}
                        {{--@foreach($selectCustomers as $selectCustomer)--}}
                            {{--<option value="{{ $selectCustomer->id }}" data-subtext="{{ $selectCustomer->phone }}">--}}
                                {{--{{ $selectCustomer->name }}--}}
                            {{--</option>--}}
                        {{--@endforeach--}}
                    {{--</select>--}}
                    <span class="input-group-btn">
                        <button class="btn btn-info" type="button" data-toggle="modal" data-target="#modal_add_customer">
                            <i class="fa fa-plus-circle"></i>
                        </button>
                    </span>
                </div><!-- /input-group -->
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12">
        <div class="col-lg-7">
            <div class="form-group">
                {{ Form::label('question', 'Question', ['class' => 'control-label']) }}
                {{ Form::textarea('question', null,
                        ['class' => 'form-control', 'placeholder' => 'Enter customer\'s question']) }}
            </div>
        </div>
    </div>

    <div class="col-lg-11">
        <div class="col-lg-7">
            <div class="form-group">
                <label class="checkbox-inline">
                    <input name="is_need_call" type="checkbox" data-toggle="toggle" data-on="Yes" data-off="No"> Need Call ?
                </label>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="col-lg-11">
            <div class="form-group">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-plus"></i> Add Question
                </button>
            </div>
        </div>
    </div>
</div>