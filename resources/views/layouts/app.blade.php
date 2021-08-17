<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>{{ $page_title ?? 'Dashboard' }} - {{ config('app.name') }}</title>

    <link rel="apple-touch-icon" href="{{ asset('assets/app-assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/app-assets/vendors/css/extensions/tether-theme-arrows.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/semantic.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/app-assets/vendors/css/extensions/tether.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/app-assets/vendors/css/extensions/shepherd-theme-default.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-timepicker.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/app-assets/css/plugins/extensions/drag-and-drop.css') }}">
    {{-- <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/app-assets/vendors/css/file-uploaders/dropzone.min.css') }}"> --}}

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/pages/data-list-view.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/pages/app-user.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-responsive-style.css') }}">

    @if (request()->is('admin'))
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/app-assets/vendors/css/charts/apexcharts.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/app-assets/css/pages/dashboard-analytics.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/pages/card-analytics.css') }}">
    @endif

    @if (request()->path('admin.users*'))
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/pages/users.css') }}">
    @endif

    <link rel="stylesheet" href="{{ asset('vendors/css/extensions/sweetalert2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/css/extensions/toastr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/app-assets/css/plugins/extensions/toastr.css') }}" />
</head>

<body class="vertical-layout vertical-menu-modern 2-columns navbar-floating footer-static" data-open="click"
    data-menu="vertical-menu-modern" data-col="2-columns">
    <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
                    <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                        <ul class="nav navbar-nav">
                            <li class="nav-item mobile-menu d-xl-none mr-auto"><a
                                    class="nav-link nav-menu-main menu-toggle hidden-xs" href="#">
                                    <i class="ficon feather icon-menu"></i>
                                </a></li>
                        </ul>
                        <ul class="nav navbar-nav bookmark-icons">
                            <li class="nav-item d-none d-lg-block">
                                <a class="nav-link" href="{{ url('admin/orders') }}">
                                    <i class="ficon feather icon-file-text"></i>
                                </a>
                            </li>
                            <li class="nav-item d-none d-lg-block">
                                <a class="nav-link" href="{{ url('admin/promo-offers') }}">
                                    <img src="{{ asset('assets/images/promo.svg') }}">
                                </a>
                            </li>
                            <li class="nav-item d-none d-lg-block">
                                <a class="nav-link" href="{{ url('admin/users') }}">
                                    <i class="ficon feather icon-user"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-user nav-item">
                            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <div class="user-nav d-sm-flex d-none">
                                    <span class="user-name text-bold-600">
                                        {{ auth()->user()->name ?? '' }}
                                    </span>
                                    <span class="user-status">SIPPY Beans LTD | Admin</span>
                                </div>
                                <span>
                                    <img class="round" src="{{ asset(auth()->user()->profile_image ?? 'assets/images/avatar-s-11.jpg') }}" alt="avatar"
                                        height="40" width="40">
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ url('admin/users') }}">
                                    <i class="feather icon-user"></i>
                                    Edit Profile
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="feather icon-power"></i> Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row justify-content-center">
                <li class="nav-item">
                    <a class="navbar-brand" href="#">
                        <img src="{{ asset('assets/images/sippy-logo-full.png') }}">
                    </a>
                </li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item {{ request()->is('admin') ? 'active' : '' }}">
                    <a href="{{ url('admin') }}">
                        <i class="feather icon-grid"></i>
                        <span class="menu-title" data-i18n="Dashboard">Dashboard</span>
                    </a>
                </li>
                <li class=" navigation-header">
                    <span>OPERATIONS</span>
                </li>
                <li class="{{ request()->is('admin/users*') ? 'active' : '' }} nav-item">
                    <a href="{{ url('admin/users') }}">
                        <i class="feather icon-user"></i>
                        <span class="menu-title" data-i18n="Email">Users</span>
                    </a>
                </li>
                <li class="{{ request()->is('admin/orders*') ? 'active' : '' }} nav-item">
                    <a href="{{ url('admin/orders') }}">
                        <img src="{{ asset('assets/images/service-request.svg') }}" class="mr-1">
                        <span class="menu-title" data-i18n="Chat">Sales Orders</span>
                        {{-- <span class="badge badge badge-pill float-right mr-2">10</span> --}}
                    </a>
                </li>
                <li class="navigation-header">
                    <span>MANAGEMENT</span>
                </li>
                <li
                    class="{{ request()->is('admin/products*') || request()->is('admin/equipments*') || request()->is('admin/subscription*') ? 'active' : '' }} nav-item">
                    <a href="#">
                        <i class="feather icon-box"></i>
                        <span class="menu-title" data-i18n="Products">Products</span>
                    </a>
                    <ul class="menu-content">
                        <li class="{{ request()->is('admin/products*') ? 'active' : '' }}"><a
                                href="{{ url('admin/products') }}">
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Feather">Beans</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('admin/equipments*') ? 'active' : '' }}">
                            <a href="{{ url('admin/equipments') }}">
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Font Awesome">Equipment</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('admin/subscription*') ? 'active' : '' }}"><a
                                href="{{ url('admin/subscription') }}">
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Font Awesome">Subscription</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ request()->is('admin/categories*') ? 'active' : '' }} nav-item">
                    <a href="{{ url('admin/categories') }}">
                        <i class="feather icon-layers"></i>
                        <span class="menu-title" data-i18n="Calender">Categories</span>
                    </a>
                </li>
                <li class="{{ request()->is('admin/attributes*') ? 'active' : '' }} nav-item">
                    <a href="{{ url('admin/attributes') }}">
                        <img src="{{ asset('assets/images/noun-tag-3407019.svg') }}" class="mr-1">
                        <span class="menu-title" data-i18n="Ecommerce">Attributes</span>
                    </a>
                </li>
                <li class="navigation-header">
                    <span>MARKETING</span>
                <li class="{{ request()->is('admin/banners*') ? 'active' : '' }} nav-item">
                    <a href="{{ url('admin/banners') }}">
                        <img src="{{ asset('assets/images/banners.svg') }}" class="mr-1">
                        <span class="menu-title" data-i18n="User">Banners</span>
                    </a>
                </li>
                <li class="{{ request()->is('admin/promo-offers*') ? 'active' : '' }} nav-item">
                    <a href="{{ url('admin/promo-offers') }}">
                        <img src="{{ asset('assets/images/promo.svg') }}" class="mr-1">
                        <span class="menu-title" data-i18n="User">Promo/Offers</span>
                    </a>
                </li>
                <li class="{{ request()->is('admin/match-makers*') ? 'active' : '' }} nav-item">
                    <a href="{{ url('admin/match-makers') }}">
                        <img src="{{ asset('assets/images/matchmaker-icon.svg') }}" class="mr-1">
                        <span class="menu-title" data-i18n="User">Matchmaker</span>
                    </a>
                </li>
                <li class=" navigation-header">
                    <span>ADMIN</span>
                </li>
                <li class="{{ request()->is('admin/delivery-areas') ? 'active' : '' }} nav-item">
                    <a href="{{ url('admin/delivery-areas') }}">
                        <img src="{{ asset('assets/images/service-areas.svg') }}" class="mr-1">
                        <span class="menu-title" data-i18n="Data List">Delivery Areas</span>
                    </a>
                </li>
                <li class="{{ request()->is('admin/tax-charges') ? 'active' : '' }} nav-item">
                    <a href="{{ url('admin/tax-charges') }}">
                        <img src="{{ asset('assets/images/taxes-charges.svg') }}" class="mr-1">
                        <span class="menu-title" data-i18n="Data List">Taxes & Charges</span>
                    </a>
                </li>
                <li class="{{ request()->is('admin/service-policies') ? 'active' : '' }} nav-item">
                    <a href="{{ url('admin/service-policies') }}">
                        <img src="{{ asset('assets/images/service-policies.svg') }}" class="mr-1">
                        <span class="menu-title" data-i18n="Data List">Service Policies</span>
                    </a>
                </li>
                <li class=" navigation-header">
                    <span>SETTINGS</span>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <img src="{{ asset('assets/images/noun-sign-out-1157133.svg') }}" class="mr-1">
                        <span class="menu-title" data-i18n="Content">Log Out</span>
                    </a>
                </li>
                <li class=" navigation-header"></li>
            </ul>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">{{ $page_title ?? '' }}</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ url('admin') }}">
                                            <i class="feather icon-home"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ $page_title ?? '' }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @yield('content')
        </div>
    </div>
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <footer class="footer footer-static footer-light">
    </footer>

    <script src="{{ asset('assets/app-assets/vendors/js/vendors.min.js') }}"></script>
    @if (request()->path() == 'admin')
        <script src="{{ asset('assets/app-assets/vendors/js/charts/apexcharts.min.js') }}"></script>
        <script src="{{ asset('assets/app-assets/js/scripts/pages/dashboard-analytics.js') }}"></script>
    @endif
    <script src="{{ asset('assets/app-assets/vendors/js/extensions/tether.min.js') }}"></script>
    <script src="{{ asset('assets/app-assets/vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/app-assets/vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/app-assets/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/app-assets/vendors/js/extensions/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('assets/app-assets/js/scripts/datatables/datatable.js') }}"></script>
    <script src="{{ asset('assets/app-assets/js/scripts/pages/faq-kb.js') }}"></script>
    <script src="{{ asset('assets/app-assets/js/scripts/pages/user-profile.js') }}"></script>
    <script src="{{ asset('assets/app-assets/vendors/js/tables/datatable/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js') }}"></script>
    <script src="{{ asset('assets/app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('assets/app-assets/js/core/app.js') }}"></script>
    <script src="{{ asset('assets/app-assets/js/scripts/components.js') }}"></script>
    <script src="{{ asset('assets/js/semantic.min.js') }}"></script>
    <script src="{{ asset('assets/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/app-assets/js/scripts/forms/select/form-select2.js') }}"></script>
    <script src="{{ asset('assets/app-assets/vendors/js/extensions/dragula.min.js') }}"></script>
    <script src="{{ asset('assets/app-assets/js/scripts/extensions/drag-drop.js') }}"></script>
    {{-- <script src="{{ asset('assets/app-assets/vendors/js/extensions/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/app-assets/js/scripts/extensions/dropzone.js') }}"></script> --}}
    <script src="{{ asset('assets/app-assets/vendors/js/extensions/shepherd.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset('assets/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>

    <script src="{{ asset('vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('vendors/js/extensions/toastr.min.js') }}"></script>

    <script type="text/javascript">
        var $primary = '#7367F0';
        var $danger = '#EA5455';
        var $warning = '#FF9F43';
        var $info = '#0DCCE1';
        var $green = '#2dcd7a';
        var $pink = '#ea5455';

        var $primary_light = '#8F80F9';
        var $warning_light = '#FFC085';
        var $danger_light = '#f29292';
        var $info_light = '#1edec5';
        var $strok_color = '#b9c3cd';
        var $label_color = '#e7eef7';
        var $white = '#fff';

        let BASE_URL = '{{ url("admin") }}/';
        let ASSET_URL = '{{ asset("/") }}';
        let toastrOptions = {
            "closeButton": true,
            "progressBar": true,
            "showMethod": "slideDown",
            "hideMethod": "slideUp",
            "timeOut": 2000
        };
    </script>

    @if(session()->has('success'))
    <script type="text/javascript">
        toastr.success('{{ session()->get("success") }}', 'Success', toastrOptions);
    </script>
    @endif
    @if(session()->has('error'))
    <script type="text/javascript">
        toastr.error('{{ session()->get("error") }}', 'Error', toastrOptions);
    </script>
    @endif

    @yield('scripts')
</body>

</html>
