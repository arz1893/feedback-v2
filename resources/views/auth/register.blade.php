@extends('layouts.app')

@section('content')
    <div class="container" style="padding-top: 30px;">
        <h1 class="text-secondary">Register Tenant</h1>
        <span class="text-secondary">*) field is required</span>
        <hr>
        <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}" id="form_register">
            {{ csrf_field() }}
            @include('layouts.auth.register.register_form')
        </form>
    </div>
@endsection
