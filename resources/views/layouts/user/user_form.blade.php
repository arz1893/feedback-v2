<div class="row">
    <div class="col-lg-6">
        <div class="form-group error">
            {{ Form::label('name', 'Name') }}
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-address-card" aria-hidden="true"></i>
                </div>
                {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter user\'s name']) }}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="form-group error">
            {{ Form::label('email', 'Email Address') }}
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-envelope"></i>
                </div>
                {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter user\'s email address']) }}
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="form-group error">
            <label for="phone">Phone Number</label>

            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-phone"></i>
                </div>
                <input name="phone" id="phone" type="text" class="form-control"
                       data-inputmask="'mask': ['9999-9999-9999', '+62 999 9999 9999']" data-mask placeholder="Enter user's phone address">
            </div>
            <!-- /.input group -->
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            {{ Form::label('usergroupId', 'User Group') }}
            {{ Form::select('usergroupId', $userGroups, null, ['class' => 'form-control', 'placeholder' => 'Select Role']) }}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            <button type="submit" class="btn btn-success">
                <i class="fa fa-user-plus"></i> Add User
            </button>
        </div>
    </div>
</div>