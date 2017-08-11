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

    <link rel="stylesheet" href="{{ mix('css/home.css') }}">

    <!-- Scripts -->
    <script>
        window.Language = '{{ config('app.locale') }}';
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    @yield('styles')
</head>
<body>
<div id="app">
    @include('particals.navbar')
    <div class="main">
        @yield('content')
    </div>
    @include('particals.footer')
</div>
<!-- Scripts -->
<script src="{{ mix('js/home.js') }}"></script>
@yield('scripts')
<script>
    $(function () {
        $("[data-toggle='tooltip']").tooltip();
    });
</script>
</body>
</html>