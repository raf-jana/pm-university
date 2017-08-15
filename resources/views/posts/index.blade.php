<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Encrypted CSRF token for Laravel, in order for Ajax requests to work --}}
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">

    <title>@yield('title', config('app.name'))</title>

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
    <!--Banner-->
    <section class="main-banner">
        <div class="banner-logo">
            <img src="/images/site/logo.png" alt="{{ config('app.name') }}"/>
        </div>

        <div class="caption">
            <h1>
                <span>{{ config('app.name') }}</span>
            </h1>

            <p>
                <span>A free, game-changing online university for product managers!
                    Learn all aspects of Product Management from some of the leading
                    product managers of Silicon Valley. </span>
            </p>
        </div>

    </section>
    <!--//Banner-->
    <!--BACHELOUR'S DEGREE-->
    <section class="common-section">
        <div class="container">
            <h2>BACHELOR'S DEGREE</h2>

            <p>Learn the basics of Product Management. Topics range from how to
                be a product manager, working with teams as a PM to creating
                product roadmaps that lead to truly amazing products!</p>
            <ul class="pm-list">
                @foreach($bachelorePosts as $key => $post)
                    <li>
                        <a class="{{class_active_post($key)}}" href="{{$post->path()}}">
                            <div class="media">
                                <div class="media-left"><span class="pm-list-count">{{$key += 1}}.</span></div>
                                <div class="media-body">{{$post->title}}</div>
                                <div class="media-right"><span class="r-more">READ</span></div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
    <!--//BACHELOUR'S DEGREE-->
    <!--MASTER'S DEGREE-->
    <section class="common-section">
        <div class="container">
            <h2>MASTER'S DEGREE</h2>

            <p>Already a Product Manager or think you've got the skills to go after a Master's Degree in Product
                Management? Learn advanced topics in product management.</p>
            <ul class="pm-list">
                @foreach($masterPosts as $key => $post)
                    <li>
                        <a class="{{class_active_post($key)}}" href="{{$post->slug}}">
                            <div class="media">
                                <div class="media-left"><span class="pm-list-count">{{$key += 1}}.</span></div>
                                <div class="media-body">{{$post->title}}</div>
                                <div class="media-right"><span class="r-more">READ</span></div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
    <!--//MASTER'S DEGREE-->

    <!--SPECIALIZATION-->
    <section class="common-section">
        <div class="container">
            <h2>SPECIALIZATION</h2>

            <p>Dig deeper into the discipline of product management and dive into twenty advanced product management
                courses that truly put your skills to the test!</p>
            <ul class="specialisation-list">
                @foreach($specializationPosts as $key => $post)
                    <li>
                        <a class="{{class_active_post($key)}}" href="{{$post->slug}}">
                            <div>
                                <img src="{{$post->imageUrl()}}"
                                     alt="{{$post->title}}"
                                     class="s-list-icon"/>
                            </div>
                            <div class="s-list-name">{{$post->title}}</div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
    <!--//SPECIALIZATION-->

    <!--HALLS OF KNOWLEDGE-->
    <section class="common-section" style="background-color: #f2f2f2;">
        <div class="container">
            <h2>HALLS OF KNOWLEDGE</h2>

            <p>Learn about Product Management from thought leaders across the world by accessing these free courses,
                blogs, and podcasts focused on proven methods in product management.</p>

            <div class="knowledge">
                <div class="row">
                    @foreach($hoks as $hok)
                        <div class="col-md-4">
                            <a href="{{ $hok->link }}" target="_blank">
                                <div class="k-list-item">
                                    <div class="list-image">
                                        <img src="{{asset($hok->imageUrl())}}"/>
                                    </div>
                                    <div class="list-desc">
                                        <div class="list-desc-details">
                                            <p>{{$hok->title}}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!--//HALLS OF KNOWLEDGE-->

    <!--PLACEMENTS-->
    <section class="common-section">
        <div class="container">
            <h2>PLACEMENTS</h2>

            <p>Learn how to get interviews and land jobs as a first time Product Manager, create a winning resume
                and portfolio, and build your brand as a thought leader and successful product manager. Also take
                advantage of the benefits of PM University's career placement program by submitting your resume for
                PM University contributors to find a fit for you to begin your career as a Product Manager!</p>

            <div class="placement-list">
                @foreach($placements as $placement)
                    <div class="media">
                        <div class="pull-left">
                            <img src="{{asset($placement->imageUrl())}}"/>
                        </div>
                        <div class="media-body">
                            <h4 class="p-list-header">{{ $placement->title }}</h4>

                            <div class="p-list-desc">
                                {{ $placement->summary }}
                            </div>
                            <div class="p-list-link">
                                <a href="{{ $placement->link }}" target="_blank">Read more &raquo;</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--//PLACEMENTS-->

    <!--Footer-->
    @include('includes._footer')
            <!--//Footer-->

    @include('includes._copy_rights')
</div>

@yield('before_scripts')

@yield('scripts')
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script src="/js/jquery-scrolltofixed-min.js"></script>
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
