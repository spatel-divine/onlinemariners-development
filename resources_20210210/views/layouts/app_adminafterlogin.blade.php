<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Basic Page Needs==================================================-->
    <title>Online Mariners | Homepage</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="public/adminassets/img/mariners-favicon.png" type="image/gif" sizes="16x16">    
    <!-- Js Jquery basic-->
    <script type="text/javascript" src="{{-- asset('public/adminassets/plugins/js/jquery.min.js') --}}"></script> 
    <!-- CSS==================================================-->
    <link rel="stylesheet" href="{{ asset('public/adminassets/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('public/adminassets/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('public/adminassets/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('public/adminassets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/adminassets/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('public/adminassets/dist/css/skins/_all-skins.min.css') }}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{ asset('public/adminassets/bower_components/morris.js/morris.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('public/adminassets/bower_components/jvectormap/jquery-jvectormap.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('public/adminassets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('public/adminassets/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('public/adminassets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <!-- Select 2 css -->
    <link rel="stylesheet" href="{{ asset('public/adminassets/bower_components/select2/dist/css/select2.min.css') }}">
    <script src="{{ asset('public/adminassets/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('public/adminassets/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Validate -->
    <script src="{{ asset('public/adminassets/dist/js/jquery.validate.min.js') }}"></script>
    <!-- Select 2 js-->
    <script type="text/javascript" src="{{ asset('public/adminassets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('public/adminassets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    
    <!--- Hearder -->
    <div class="wrapper">
        @include('includesadmin.header')

        @include('includesadmin.sidebar')

        @yield('content')

        @include('includesadmin.footer')
        <!-- Extra js -->
        @yield('custom_js')
    </div>

</body>
</html>