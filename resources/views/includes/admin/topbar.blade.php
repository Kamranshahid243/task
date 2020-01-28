<header class="main-header">

    <!-- Logo -->
    <a href="{{ url('/admin/dashboard') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>A</b>DB</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">Dashboard</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->

                @include('includes.admin.notifications')

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset(Auth::user()->avatar) }}" class="user-image" alt="Avatar">
                        <span class="hidden-xs">{{ Auth::user()->first_name.' '.Auth::user()->last_name }}</span>
                    </a>
                    <ul class="dropdown-menu">

                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ asset(Auth::user()->avatar) }}" class="img-circle" alt="Avatar">

                            <p>
                                {{ Auth::user()->first_name.' '.Auth::user()->last_name }} - {{ Auth::user()->type == 'superadmin' ? 'Super Admin' : 'Admin' }}
                                <small>Member since {{ Auth::user()->created_at->toFormattedDateString() }}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ url('/admin/profile') }}" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Sign out</a>
                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                @csrf
                                </form>
                            </div>
                        </li>

                    </ul>
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </li>
            </ul>
        </div>

    </nav>
</header>
