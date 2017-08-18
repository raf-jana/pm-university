<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="{{ config('blog.meta.keywords') }}">
    <meta name="description" content="{{ config('blog.meta.description') }}">

    {{-- Encrypted CSRF token for Laravel, in order for Ajax requests to work --}}
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">

    <title>{{ fullTitle($post->title) }}</title>

    @yield('before_styles')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    @yield('styles')

    @yield('after_styles')

            <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<progress value="0" id="progressBar" class="flat">
    <div class="progress-container">
        <span class="progress-bar"></span>
    </div>
</progress>
<div id="app">
    <!--Header-->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/" title=""><img height="35"
                                                               src="{{ asset('images/site/logo-inner.png') }}"
                                                               alt="{{ config('app.name') }}"></a>
            </div>
        </div>
    </nav>
    <!--//Header-->

    <!--Inner Banner-->
    <section class="inner-banner">
        <div class="caption">
            <h1><span>{{$post->title}}</span></h1>

            <p><span>{!! $post->summary !!}</span>
            </p>
        </div>
    </section>
    <!--//Inner Banner-->

    <!--Articles-->
    <!--Category Tabs-->
    <tabs>
        <tab name="TOP 10" :selected="true">
        </tab>
        <tab name="LATEST">
        </tab>
        <tab name="VIDEOS">
        </tab>
        <tab name="BOOKS">
        </tab>
        <tab name="INTERVIEWS">
        </tab>
        <tab name="TOOLS">
        </tab>
    </tabs>
    <!--//Category Tabs-->
    <!--//Articles-->

    <!--Special Section-->
    <section class="special-section">
        <div class="container">
            <div class="special-article" id="special-article">
                <span style="display: none;">{{ $post->id }}</span>

                <h2>{{$post->note_title}}</h2>

                <p>{!! $post->note_description !!}</p>
            </div>
        </div>
    </section>
    <!--//Special Section-->

    <!--Next Previous Section-->
    <section class="next-previous-section">
        <div class="container">
            @if($nextPost)
                <div class="pull-left">
                    <a href="{{ url($nextPost->slug)}}"><i class="material-icons">&#xE314;</i>
                        {{ $nextPost->title }} </a>
                </div>
            @endif @if($previousPost)
                <div class="pull-right">
                    <a href="{{ url($previousPost->slug)}}">{{ $previousPost->title
						}} <i class="material-icons">&#xE315;</i>
                    </a>
                </div>
            @endif
        </div>
    </section>
    <!--//Next Previous Section-->

    <!--Footer-->
    @include("includes._footer")
            <!--//Footer-->

    @include('includes._copy_rights')
</div>
</div>

@yield('before_scripts')

@yield('scripts')
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script src="/js/jquery-scrolltofixed-min.js"></script>
<script src="{{ mix('/js/app.js') }}"></script>
<!-- page script -->
<script type="text/javascript">
    $(document).ready(function () {
        var getMax = function () {
            return $(document).height() - $(window).height();
        }

        var getValue = function () {
            return $(window).scrollTop();
        }

        if ('max' in document.createElement('progress')) {
            var progressBar = $('progress');

            progressBar.attr({max: getMax()});

            $(document).on('scroll', function () {
                progressBar.attr({value: getValue()});
            });

            $(window).resize(function () {
                progressBar.attr({max: getMax(), value: getValue()});
            });
        }
        else {
            var progressBar = $('.progress-bar'),
                    max = getMax(),
                    value, width;

            var getWidth = function () {
                // Calculate width in percentage
                value = getValue();
                width = (value / max) * 100;
                width = width + '%';
                return width;
            }

            var setWidth = function () {
                progressBar.css({width: getWidth()});
            }

            $(document).on('scroll', setWidth);
            $(window).on('resize', function () {
                max = getMax();
                setWidth();
            });
        }
    });
</script>
<!-- GA script -->
@include('includes._ga')
        <!-- //GA script -->

@yield('after_scripts')

        <!-- JavaScripts -->

</body>
</html>
