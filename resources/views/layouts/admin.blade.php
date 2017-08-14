<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">
    <title>{{ fullTitle() }}</title>
    @include('admin.includes._styles')
            <!-- Scripts -->
    <script>
        window.Language = '{{ app()->getLocale() }}';
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <!-- // Scripts -->
</head>
<body>
<div id="wrapper">
    @include('admin.includes._sidebar')
    <div id="page-wrapper" class="gray-bg">
        @include('admin.includes._static_top')
        {{--@include('admin.includes._breadcrumbs')--}}
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
            @yield('content')
        </div>
        @include('admin.includes._footer')
    </div>
</div>
<!-- Scripts -->
<!-- Mainly scripts -->
<script src="/js/admin/jquery-3.1.1.min.js"></script>
<script src="/js/admin/bootstrap.min.js"></script>
<script src="/js/admin/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="/js/admin/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="/js/admin/inspinia.js"></script>
<script src="/js/admin/plugins/pace/pace.min.js"></script>
@yield('scripts')
</body>
</html>