<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="/img/profile_small.jpg"/>
                             </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong
                                            class="font-bold">{{ Auth::user()->name }}</strong>
                             </span> <span class="text-muted text-xs block">Art Director <b
                                            class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="#">Profile</a></li>
                        <li><a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">Logout</a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>
                <div class="logo-element">
                    {{config('app.short_name')}}+
                </div>
            </li>

            <li>
                <a href="{{ route('dashboard') }}"><i class="fa fa-th-large"></i> <span
                            class="nav-label">Dashboard</span> </a>
            </li>
            <li>
                <a href="{{ route('placements') }}"><i class="fa fa-pie-chart"></i> <span
                            class="nav-label">Placements</span> </a>
            </li>
            <li>
                <a href="{{ route('hok') }}"><i class="fa fa-flask"></i> <span
                            class="nav-label">Halls Of Knowledge</span></a>
            </li>
            <li>
                <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Posts</span><span
                            class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="{{ route('posts') }}">All Posts</a></li>
                    <li><a href="{{ route('posts') }}?type=bachelore">Bachelore</a></li>
                    <li><a href="{{ route('posts') }}?type=master">Master</a></li>
                    <li><a href="{{ route('posts') }}?type=specialization">Specialization</a></li>
                </ul>
            </li>
        </ul>

    </div>
</nav>