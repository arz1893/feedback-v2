<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="col-lg-11 col-md-11">
            <div class="form-group">
                {{ Form::label('txt_company_name', 'Your Company Name *') }}
                {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'txt_company_name', 'placeholder' => 'Enter Company Name']) }}
            </div>
            {{--<div class="form-group">--}}
            {{--{{ Form::label('select_category', 'Business Type *') }}--}}
            {{--{{ Form::select('category_id', $categories, null, [--}}
            {{--'class' => 'form-control',--}}
            {{--'id' => 'select_category',--}}
            {{--'placeholder' => 'Choose Your Business Type',--}}
            {{--'aria-describedby' => 'categoryHelp'--}}
            {{--]) }}--}}
            {{--<small id="categoryHelp" class="form-text text-muted">In what category your business is running ?</small>--}}
            {{--</div>--}}
            <div class="form-group">
                {{ Form::label('txt_email', 'Email Address *') }}
                {{ Form::email('email', null, ['class' => 'form-control', 'id' => 'txt_email', 'placeholder' => 'Enter email']) }}
            </div>
            <div class="form-group">
                {{ Form::label('txt_password', 'Password *') }}
                {{ Form::password('password', ['class' => 'form-control', 'id' => 'txt_password', 'placeholder' => 'Enter Password']) }}
            </div>
            <div class="form-group">
                {{ Form::label('txt_repeat_password', 'Repeat Password *') }}
                {{ Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'txt_repeat_password', 'placeholder' => 'Enter Your Password Again']) }}
            </div>
            <div class="form-group">
                {{ Form::label('select_country', 'Country *') }}
                {{ Form::select('country_id', $countries, null, ['class' => 'form-control', 'placeholder' => 'Choose your country']) }}
                {{--<select class="form-control" id="select_country" name="country">--}}
                {{--<option selected disabled value="">Choose Your Country</option>--}}
                {{--@foreach($countries as $country)--}}
                {{--<option value="{{ $country->country }}">{{ $country->country }}</option>--}}
                {{--@endforeach--}}
                {{--</select>--}}
            </div>

        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="col-md-11 col-md-11">
            <div class="form-group">
                {{ Form::label('address', 'Company Address') }}
                {{ Form::textarea('address', null, ['class' => 'form-control', 'placeholder' => 'Enter Your Company Address', 'rows' => 5]) }}
            </div>
            <div class="form-group">
                {{ Form::label('txt_description', 'Description') }}
                {{ Form::textarea('description', null, ['class' => 'form-control', 'id' => 'txt_description', 'placeholder' => 'Describe your business', 'rows' => 8]) }}
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    Register <i class="fa fa-user-plus"></i>
                </button>
            </div>
        </div>
    </div>
</div>