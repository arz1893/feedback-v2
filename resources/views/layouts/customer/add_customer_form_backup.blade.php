<div style="margin-top: -3px;">
    <div class="row form-margin-bottom">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label for="name" class="control-label">
                Customer's name <span class="text-danger">*</span>
            </label>
        </div>
        <div class=" col-lg-7 col-md-7 col-sm-7 col-xs-8" v-bind:class="{'has-error': errors.has('name')}">
            <input type="text"
                   name="name"
                   id="name"
                   class="form-control"
                   placeholder="Enter customer's name"
                   v-model="customer.name"
                   v-validate="'required'">
            {{--{{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter customer\'s name', 'v-model' => 'customer.name']) }}--}}
            <span class="help-block text-red" v-show="errors.has('name')">
                @{{ errors.first('name') }}
            </span>
        </div>
    </div>

    <div class="row form-margin-bottom">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label for="gender" class="control-label">
                Gender <span class="text-danger">*</span>
            </label>
        </div>
        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-8">
            <label class="radio-inline">
                <input type="radio" name="gender" id="gender_male" value="1" v-model="customer.gender" v-validate="'required'"> Male
            </label>
            <label class="radio-inline">
                <input type="radio" name="gender" id="gender_female" value="0" v-model="customer.gender" v-validate="'required'"> Female
            </label>

            <span class="help-block text-red" v-show="errors.has('gender')">
                @{{ errors.first('gender') }}
            </span>
        </div>
    </div>

    <div class="row form-margin-bottom">
        <div class="form-group">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <label for="phone" class="control-label">
                    Customer's phone <span class="text-danger">*</span>
                </label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-8" v-bind:class="{'has-error': errors.has('phone')}">
                <input name="phone"
                       id="phone"
                       type="text"
                       class="form-control"
                       data-inputmask="'mask': ['9999-9999-9999', '+62 999 9999 9999']"
                       data-mask placeholder="Enter your phone address"
                       v-model="customer.phone"
                       v-validate="'required|numeric|min:10'">
                <span class="help-block text-red" v-show="errors.has('phone')">
                    @{{ errors.first('phone') }}
                </span>
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
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-8" v-bind:class="{'has-error': errors.has('phone')}">
                <input type="date"
                       name="birthdate"
                       class="form-control"
                       {{--data-large-mode="true"--}}
                       {{--data-large-default="true"--}}
                       {{--data-init-set="false"--}}
                       {{--data-modal="true"--}}
                       placeholder="Click here"
                       v-model="customer.birthdate"
                       v-validate="'required'">
                <span class="help-block text-red" v-show="errors.has('birthdate')">
                @{{ errors.first('birthdate') }}
            </span>
            </div>
        </div>
    </div>

    <div class="row form-margin-bottom">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label for="email" class="control-label">
                Email address
            </label>
        </div>
        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-8" v-bind:class="{'has-error': errors.has('email')}">
            <input type="email"
                   name="email"
                   id="email"
                   class="form-control"
                   placeholder="Enter customer's email"
                   v-model="customer.email"
                   v-validate="'email'">
            <span class="help-block text-red" v-show="errors.has('email')">
                @{{ errors.first('email') }}
            </span>
        </div>
    </div>

    <div class="form-group form-margin-bottom">
        {{ Form::label('address', 'Customer\'s address', ['class' => 'control-label']) }}
        {{ Form::textarea('address', null, ['class' => 'form-control', 'placeholder' => 'Enter customer\'s address', 'rows' => 2, 'v-model' => 'customer.address']) }}

    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            {{ Form::text('nation', null, ['class' => 'form-control', 'placeholder' => 'Nation', 'v-model' => 'customer.nation']) }}
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            {{ Form::text('city', null, ['class' => 'form-control', 'placeholder' => 'City', 'v-model' => 'customer.city']) }}
        </div>
    </div>

    <div class="form-group form-margin-bottom">
        {{ Form::label('memo', 'Memo', ['class' => 'control-label']) }}
        {{ Form::textarea('memo', null, ['class' => 'form-control', 'placeholder' => 'Enter memo if necessary', 'rows' => 2, 'v-model' => 'customer.memo']) }}
    </div>
</div>