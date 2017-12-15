@extends('layouts.app')

@section('content')
    @include('layouts.errors.error_list')

    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Customer</b>Feedback</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Sign in to <u class="text-info">{{ $tenant->name }}</u></p>

            <form role="form" method="POST" action="{{ route('login') }}" id="form_login">
                {{ csrf_field() }}

                <div class="form-group has-feedback">
                    <label for="txt_email">Email</label>
                    <input type="email" name="email" id="txt_email" value="{{ old('email') }}" class="form-control" placeholder="Enter your email">
                </div>
                <div class="form-group has-feedback">
                    <label for="txt_password">Password</label>
                    <input type="password" name="password" id="txt_password" class="form-control" placeholder="Enter your password">
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <a href="{{ route('register') }}" class="text-center">Register a new membership</a>
                        <a href="#" class="text-center">Forgot password ?</a>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

@endsection
