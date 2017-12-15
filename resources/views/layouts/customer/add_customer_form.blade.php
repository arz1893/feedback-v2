<div style="margin-top: -3px;">
    <div class="row form-margin-bottom">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label for="name" class="control-label">
                Customer's name <span class="text-danger">*</span>
            </label>
        </div>
        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-8">
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter customer\'s name']) }}
        </div>
    </div>

    <div class="row form-margin-bottom">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label for="gender" class="control-label">
                Gender <span class="text-danger">*</span>
            </label>
        </div>
        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-8 error">
            <label class="radio-inline">
                <input type="radio" name="gender" id="gender_male" value="1"> Male
            </label>
            <label class="radio-inline">
                <input type="radio" name="gender" id="gender_female" value="0"> Female
            </label>
        </div>
    </div>

    <div class="row form-margin-bottom">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label for="email" class="control-label">
                Email address <span class="text-danger">*</span>
            </label>
        </div>
        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-8 error">
            {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Enter customer\'s email']) }}
        </div>
    </div>

    <div class="row form-margin-bottom">
        <div class="form-group">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <label for="phone" class="control-label">
                    Customer's phone <span class="text-danger">*</span>
                </label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-8">
                {{ Form::input('number', 'phone', null, ['class' => 'form-control', 'placeholder' => 'Customer\'s phone number']) }}
            </div>
        </div>
    </div>

    <div class="row form-margin-bottom">
        <div class="form-group">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <label for="birthdate" class="control-label">
                    Birthdate <span class="text-danger">*</span>
                </label>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-8">
                <input type="text"
                       name="birthdate"
                       id="birthdate"
                       class="form-control"
                       data-large-mode="true"
                       data-large-default="true"
                       data-init-set="false"
                       data-modal="true"
                       placeholder="Click here">
            </div>
        </div>
    </div>

    <div class="form-group form-margin-bottom">
        {{ Form::label('address', 'Customer\'s address', ['class' => 'control-label']) }}
        {{ Form::textarea('address', null, ['class' => 'form-control', 'placeholder' => 'Enter customer\'s address', 'rows' => 2]) }}

    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            {{ Form::text('nation', null, ['class' => 'form-control', 'placeholder' => 'Nation']) }}
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            {{ Form::text('city', null, ['class' => 'form-control', 'placeholder' => 'City']) }}
        </div>
    </div>

    <div class="form-group form-margin-bottom">
        {{ Form::label('memo', 'Memo', ['class' => 'control-label']) }}
        {{ Form::textarea('memo', null, ['class' => 'form-control', 'placeholder' => 'Enter memo if necessary', 'rows' => 2]) }}
    </div>
</div>