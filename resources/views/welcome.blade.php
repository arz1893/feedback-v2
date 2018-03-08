@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/landing-page/landing-page-style.css') }}" rel="stylesheet">
@endpush

@section('content')

    <div class="container" style="margin-top: 20px;">
        <div class="row intro">
            <div class="col-md-6 col-sm-8 intro-left">
                <div class="intro-left-content">
                    <img src="{{ asset('default-images/49.svg') }}" alt="Template Logo" width="300"> <br>
                    @auth
                        <a href="{{ url('/home') }}" class="btn btn-flat btn-primary">
                            <i class="fa fa-arrow-circle-right"></i> back to home
                        </a>
                    @endauth
                    <h1 class="text-info">Under construction</h1>
                    <p class="lead">We are working hard to bring to you our great project soon.</p>
                    <p>Coming soon/Under construction, I hope you will enjoy working with it. This a paragraph where some more info about your project could go. </p>
                    <p class="social">
                        <a href="#" class="facebook">
                            <i class="fa fa-facebook"></i>
                        </a>
                        <a href="#" class="gplus"><i class="fa fa-google-plus"></i></a>
                        <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
                        <a href="#" title="" class="instagram"><i class="fa fa-instagram"></i></a>
                        <a href="#" class="email"><i class="fa fa-envelope"> </i></a></p>
                        <p class="credit">&copy; {!! date('Y'); !!} Sunwell System
                </div>
            </div>
        </div>
    </div>
@endsection