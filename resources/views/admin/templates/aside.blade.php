<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="info" style="position: static; text-align: center">
                <p><i class="fa fa-user-circle"></i> {{ \Auth::user()->name }}</p>
                <!-- Status -->
                {{-- <a href="#"><i class="fa fa-circle text-success"></i> {{ \Auth::user()->email }}</a> --}}
            </div>
        </div>

        <!-- search form (Optional) -->
        {{-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i
                            class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form> --}}
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            {{-- <li class="header">HEADER</li> --}}
            <!-- Optionally, you can add icons to the links -->
            <li class="{{ (request()->is('dashboard*')) ? 'active' : '' }}"><a href="{{ route('dashboard') }}"><i class="fa fa-map"></i> <span>Peta</span></a></li>
            {{-- <li><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li> --}}
            <li class="treeview {{ ((request()->is('lokasi*')) || (request()->is('alumni*'))) ? 'active' : '' }}">
                <a href="#"><i class="fa fa-list"></i> <span>Master Data</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ (request()->is('lokasi*')) ? 'active' : '' }}"><a href="{{ route('lokasi.index') }}"><i class="fa fa-map-marker"></i> Lokasi</a></li>
                    <li class="{{ (request()->is('alumni*')) ? 'active' : '' }}"><a href="{{ route('alumni.index') }}"><i class="fa fa-users"></i> Alumni</a></li>
                </ul>
            </li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
