<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Lockscreen</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome/font-awesome.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('css/ionicons/css/ionicons.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/admin-lte/AdminLTE.css') }}">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
    <div class="lockscreen-logo">
        <a href="../../index2.html"><b>Customer</b>Feedback</a>
    </div>
    <!-- User name -->
    <div class="lockscreen-name">Whoops!</div>


    <!-- /.lockscreen-item -->
    <div class="help-block text-center">
        Your invitation has expired, please contact your supervisor
    </div>
    <div class="text-center">
        <a href="{{ url('/') }}">Go to home page</a>
    </div>
    <div class="lockscreen-footer text-center">
        Copyright &copy; {{ date('Y') }} <b><a href="#!" class="text-black">Sunwell System</a></b><br>
        All rights reserved
    </div>
</div>
<!-- /.center -->

<!-- jQuery 3 -->
<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('js/bootstrap/bootstrap.js') }}"></script>
</body>
</html>
