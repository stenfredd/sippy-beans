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
      <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,900" rel="stylesheet">

      <!--Common CSS-->
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/vendors/css/vendors.min.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/vendors/css/extensions/tether-theme-arrows.css')}}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/semantic.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/vendors/css/extensions/tether.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/vendors/css/extensions/shepherd-theme-default.css')}}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/vendors/css/vendors.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/bootstrap.css')}}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/bootstrap-extended.css')}}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/colors.css')}}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/components.css')}}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/core/colors/palette-gradient.css')}}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-datepicker.css')}}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-timepicker.css')}}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/css/plugins/extensions/drag-and-drop.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/vendors/css/file-uploaders/dropzone.min.css')}}">
      <!-- END: Common CSS-->


      <!--auth-login-->
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/pages/authentication.css')}}">
      <!--end auth-login-->

      <!--dashboard-->
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/vendors/css/charts/apexcharts.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/pages/dashboard-analytics.css')}}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/pages/card-analytics.css')}}">
      <!--end-dashboard-->

      <!--users-->
       <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/pages/users.css')}}">
      <!--end-users-->

      <!--service-policies-->
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/vendors/css/editors/quill/katex.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/vendors/css/editors/quill/monokai-sublime.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/vendors/css/editors/quill/quill.snow.css')}}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/vendors/css/editors/quill/quill.bubble.css')}}">
      <!--end-service-policies-->

      <!--Common CSS-->
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/pages/data-list-view.css')}}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/app-assets/css/pages/app-user.css')}}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css')}}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-style.css')}}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-responsive-style.css')}}">
      <!-- END: Common CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/dist/assets/css/auth-reg.min.css')}}">
    </head>
   <!-- END: Head-->
   <!-- BEGIN: Body-->
   <body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
      <!-- BEGIN: Header-->

      <!-- END: Header-->
      <!-- BEGIN: Main Menu-->

      <!-- END: Main Menu-->
      <!-- BEGIN: Content-->

      <div class="app-content content ml-0">

       <div class="content-wrapper px-0 py-0 my-0">
            @yield('content')
         </div>
      </div>
      <div class="sidenav-overlay"></div>
      <div class="drag-target"></div>
      <!-- BEGIN: Footer-->
      <script src="{{ asset('assets/app-assets/vendors/js/vendors.min.js')}}"></script>
      <script src="{{ asset('assets/app-assets/vendors/js/charts/apexcharts.min.js')}}"></script>
      <script src="{{ asset('assets/app-assets/vendors/js/extensions/tether.min.js')}}"></script>
      <script src="{{ asset('assets/app-assets/vendors/js/tables/datatable/pdfmake.min.js')}}"></script>
      <script src="{{ asset('assets/app-assets/vendors/js/tables/datatable/vfs_fonts.js')}}"></script>
      <script src="{{ asset('assets/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
      <script src="{{ asset('assets/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js')}}"></script>
      <script src="{{ asset('assets/app-assets/vendors/js/tables/datatable/buttons.html5.min.js')}}"></script>
      <script src="{{ asset('assets/app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js')}}"></script>
      <script src="{{ asset('assets/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>
      <script src="{{ asset('assets/app-assets/vendors/js/extensions/jquery.steps.min.js')}}"></script>
      <script src="{{ asset('assets/app-assets/js/scripts/pages/dashboard-analytics.js')}}"></script>
      <script src="{{ asset('assets/app-assets/js/scripts/datatables/datatable.js')}}"></script>
      <script src="{{ asset('assets/app-assets/js/scripts/pages/faq-kb.js')}}"></script>
      <script src="{{ asset('assets/app-assets/js/scripts/pages/user-profile.js')}}"></script>
      <script src="{{ asset('assets/app-assets/vendors/js/tables/datatable/dataTables.select.min.js')}}"></script>
      <script src="{{ asset('assets/app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
      <script src="{{ asset('assets/app-assets/js/core/app-menu.js')}}"></script>
      <script src="{{ asset('assets/app-assets/js/core/app.js')}}"></script>
      <script src="{{ asset('assets/app-assets/js/scripts/components.js')}}"></script>
      <script src="{{ asset('assets/js/semantic.min.js')}}"></script>
      <script src="{{ asset('assets/app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
      <script src="{{ asset('assets/app-assets/js/scripts/forms/select/form-select2.js')}}"></script>
      <script src="{{ asset('assets/app-assets/vendors/js/extensions/dragula.min.js')}}"></script>
      <script src="{{ asset('assets/app-assets/js/scripts/extensions/drag-drop.js')}}"></script>
      <script src="{{ asset('assets/app-assets/vendors/js/extensions/dropzone.min.js')}}"></script>
      <script src="{{ asset('assets/app-assets/js/scripts/extensions/dropzone.js')}}"></script>
      <script src="{{ asset('assets/app-assets/vendors/js/extensions/shepherd.min.js')}}"></script>
      <script src="{{ asset('assets/js/bootstrap-timepicker.min.js')}}"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" ></script>
      <script src="{{ asset('assets/js/bootstrap-datepicker.js')}}"></script>
      <script src="{{ asset('assets/app-assets/vendors/js/editors/quill/quill.min.js')}}"></script>
      <script src="{{ asset('assets/js/scripts.js')}}"></script>

      <!----------service-policies---------->
      <script src="{{ asset('assets/js/service-policies.js')}}"></script>
      <script src="{{ asset('assets/dist/assets/js/auth-reg.min.js')}}"></script>
      <!----------end service-policies---------->
   </body>
   <!-- END: Body-->
</html>
