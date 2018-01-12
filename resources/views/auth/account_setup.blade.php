@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('js/input-mask/jquery.inputmask.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/input-mask/jquery.inputmask.extensions.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/input-mask/jquery.inputmask.date.extensions.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $('[data-mask]').inputmask();
        $('.select2').select2();
    </script>
@endpush

@section('content')
    <div class="container" style="margin-top: 4%">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">Account Setup</div>

                    <div class="panel-body">
                        {{--<form class="form-horizontal" method="POST" action="{{ route('password.request') }}">--}}
                        {!! Form::open(['action' => ['Auth\RegisterController@registerViaEmail', $invitation->systemId],'id' => 'form_account_setup']) !!}

                        {{ Form::hidden('email', $invitation->email) }}
                        {{ Form::hidden('name', $invitation->name) }}
                        {{ Form::hidden('tenantId', $invitation->tenantId) }}
                        {{ Form::hidden('usergroupId', $invitation->usergroupId) }}

                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} error">
                                    <label for="email" class="control-label">E-Mail Address</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-envelope-o"></i>
                                        </div>
                                        <input id="email" type="email" class="form-control" name="email" value="{{ $invitation->email or old('email') }}" disabled>
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="help-block text-red">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }} error">
                                    <label for="phone" class="control-label">Phone Number</label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-phone"></i>
                                        </div>
                                        <input name="phone" id="phone" type="text" class="form-control"
                                               data-inputmask="'mask': ['9999-9999-9999', '+62 999 9999 9999']" data-mask placeholder="Enter your phone address">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }} error">
                                    <label for="password" class="control-label">New Password</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-unlock-alt"></i>
                                        </div>
                                        <input id="txt_password" type="password" class="form-control" name="password" required placeholder="Enter your password">
                                    </div>
                                    <p class="help-block">*min. 6 character</p>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }} error">
                                    <label for="password-confirm" class="control-label">Confirm New Password</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-repeat"></i>
                                        </div>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Repeat password">
                                    </div>
                                </div>
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary">
                                        Activate Account <i class="fa fa-user-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection