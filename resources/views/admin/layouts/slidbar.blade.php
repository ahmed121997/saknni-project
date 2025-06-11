<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{URL::to('/')}}" target="_blank">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Saknni</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{route('admin.dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Pages Collapse Menu -->


     <!-- Users item  -->

    <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('admin.filemanager.index')}}">
            <i class="fas fa-folder fa-2x text-gray"></i>
            <span>File Manager</span>
        </a>

        <a class="nav-link collapsed" href="{{route('admin.user')}}">
            <i class="fas fa-user fa-2x text-gray"></i>
            <span>Users</span>
        </a>
        <!-- properties item  -->
        <a class="nav-link collapsed" href="{{route('admin.property')}}">
            <i class="fas fa-home fa-2x text-gray"></i>
            <span>Properties</span>
        </a>

        <a class="nav-link collapsed" href="{{route('admin.logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt fa-2x text-gray" ></i>
            <span>Logout</span>
        </a>

        <form id="logout-form" method="POST" action="{{ route('admin.logout') }}"  style="display: none;">
            @csrf
        </form>
         <!-- logout item  -->
    </li>



    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
           aria-expanded="{{ is_active_routes(['admin.type-properties.index', 'admin.list-views.index', 'admin.type-finishes.index'], 'true', 'false') }}"
           aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Utilities</span>
        </a>
        <div id="collapseUtilities" class="collapse {{ is_active_routes(['admin.type-properties.index', 'admin.list-views.index', 'admin.type-finishes.index'], 'show') }}"
             aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ is_active_routes(['admin.type-properties.index'])}}" href="{{ route('admin.type-properties.index') }}">Type Properties</a>
                <a class="collapse-item {{ is_active_routes(['admin.list-views.index']) }}" href="{{ route('admin.list-views.index') }}">List Views</a>
                <a class="collapse-item {{ is_active_routes(['admin.type-finishes.index']) }}" href="{{ route('admin.type-finishes.index') }}">Type Finishes</a>
            </div>
        </div>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline mt-3">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
