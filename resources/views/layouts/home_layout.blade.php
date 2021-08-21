<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Login - Sippy Beans</title>
    <link rel="apple-touch-icon" href="{{ asset('assets/app-assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}">
    <!--Common CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/components.css')}}">
    <!--end-dashboard-->
    <!--Common CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/pages/data-list-view.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/pages/app-user.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-responsive-style.css')}}">
    <!-- END: Common CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/dist/assets/css/main.min.css')}}">
</head>
<!-- END: Head-->
<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
    <!-- BEGIN: Header-->
    <!-- END: Header-->
    <!-- BEGIN: Main Menu-->
    <!-- END: Main Menu-->
    <!-- BEGIN: Content-->
    @yield('content')
</body>
<!-- END: Body-->

</html>