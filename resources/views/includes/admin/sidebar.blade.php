<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="height: auto;">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset(Auth::user()->avatar) }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->first_name.' '.Auth::user()->last_name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form  -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /search form -->

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{{ $page == 'dashboard' ? 'active' : '' }}">
                <a href="{{ url('/admin/dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li><li class="{{ $page == 'email-list' ? 'active' : '' }}">
                <a href="{{ url('/admin/email-templates') }}">
                    <i class="fa fa-dashboard"></i> <span>Email Templates</span>
                </a>
            </li>
            <li class="treeview {{ $page == 'profile' ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span>Profile</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $child == 'profile_update' ? 'active' : '' }}"><a href="{{ url('/admin/profile') }}"><i class="fa fa-circle-o"></i> Edit Profile</a></li>
                    <li class="{{ $child == 'profile_reset_password' ? 'active' : '' }}"><a href="{{ url('/admin/password') }}"><i class="fa fa-circle-o"></i> Reset Password</a></li>
                </ul>
            </li>
            <li class="treeview {{ $page == 'profile' ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span>Ad Management</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $child == 'profile_update' ? 'active' : '' }}"><a href="{{ url('/admin/profile') }}"><i class="fa fa-circle-o"></i>Categories</a></li>
                    <li class="{{ $child == 'profile_reset_password' ? 'active' : '' }}"><a href="{{ url('/admin/password') }}"><i class="fa fa-circle-o"></i>Sub Categories</a></li>
                </ul>
            </li>
            <li class="{{ $page == 'security' ? 'active' : '' }}">
                <a href="{{ url('/admin/security/settings') }}">
                    <i class="fa fa-shield"></i> <span>Security Management</span>
                </a>
            </li>
            <li class="{{ $page == 'admin-list' ? 'active' : '' }}">
                <a href="{{ url('/admin/users/management') }}">
                    <i class="fa fa-users"></i> <span>Users Management</span>
                </a>
            </li>
            <li class="treeview {{ $page == 'pricing-list' ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-dollar"></i>
                    <span>Pricing Management</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $child == 'country' ? 'active' : '' }}"><a href="{{ url('/admin/countries/pricings') }}"><i class="fa fa-circle-o"></i> Country Pricings</a></li>
                    <li class="{{ $child == 'state' ? 'active' : '' }}"><a href="{{ url('/admin/states/pricings') }}"><i class="fa fa-circle-o"></i> State Pricings</a></li>
                    <li class="{{ $child == 'city' ? 'active' : '' }}"><a href="{{ url('/admin/cities/pricings') }}"><i class="fa fa-circle-o"></i> City Pricings</a></li>
                </ul>
            </li>

            <li class="{{ $page == 'category-list' ? 'active' : '' }}">
                <a href="{{ url('/admin/categories/management') }}">
                    <i class="fa fa-square"></i> <span>Categories Management</span>
                </a>
            </li>

            <li class="{{ $page == 'subcategory-list' ? 'active' : '' }}">
                <a href="{{ url('/admin/subcategories/management') }}">
                    <i class="fa fa-square-o"></i> <span>Subcategories Management</span>
                </a>
            </li>

            <li class="{{ $page == 'plan-list' ? 'active' : '' }}">
                <a href="{{ url('/admin/plans/management') }}">
                    <i class="fa fa-newspaper-o"></i> <span>Plans Management</span>
                </a>
            </li>
            <li class="{{ $page == 'faqs-list' ? 'active' : '' }}">
                <a href="{{ url('/admin/faqs/management') }}">
                    <i class="fa  fa-question-circle"></i> <span>FAQs Management</span>
                </a>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
