<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-danger elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link d-flex justify-content-center">
        <img src="{{ asset('assets/logos/logo-full.png') }}" alt="MSU-IIT Map Logo" style="width: 60%;">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/images/users/user-default.jpg') }}" class="img-circle elevation-2" alt="Admin Profile Photo">
            </div>
            <div class="info">
                <a href="{{ route('dashboard') }}" class="d-block">Default Admin</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">MAP ELEMENTS</li>
                <li class="nav-item {{ Route::currentRouteName() == 'buildings.index' || Route::currentRouteName() == 'buildings.add' || Route::currentRouteName() == 'buildings.types' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::currentRouteName() == 'buildings' || Route::currentRouteName() == 'buildings_add' ? 'active' : '' }} d-flex justify-center-start align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building nav-item mr-2" viewBox="0 0 16 16">
                            <path d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z" />
                            <path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3z" />
                        </svg>
                        <p>
                            Buildings
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('buildings.add') }}" class="nav-link {{ Route::currentRouteName() == 'buildings.add' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Building</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('buildings.index') }}" class="nav-link {{ Route::currentRouteName() == 'buildings.index' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Buildings</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('buildings.types') }}" class="nav-link {{ Route::currentRouteName() == 'buildings.types' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Building Types</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ Route::currentRouteName() == 'paths.index' || Route::currentRouteName() == 'paths.add' || Route::currentRouteName() == 'paths.edit' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link d-flex justify-center-start align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building nav-item mr-2" viewBox="0 0 16 16">
                            <path d="M5 8.5A2.5 2.5 0 0 1 7.5 6H9V4.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L9.41 8.658A.25.25 0 0 1 9 8.466V7H7.5A1.5 1.5 0 0 0 6 8.5V11H5z" />
                            <path fill-rule="evenodd" d="M6.95.435c.58-.58 1.52-.58 2.1 0l6.515 6.516c.58.58.58 1.519 0 2.098L9.05 15.565c-.58.58-1.519.58-2.098 0L.435 9.05a1.48 1.48 0 0 1 0-2.098zm1.4.7a.495.495 0 0 0-.7 0L1.134 7.65a.495.495 0 0 0 0 .7l6.516 6.516a.495.495 0 0 0 .7 0l6.516-6.516a.495.495 0 0 0 0-.7L8.35 1.134Z" />
                        </svg>
                        <p>
                            Paths
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('paths.add') }}" class="nav-link {{ Route::currentRouteName() == 'paths.add' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Paths</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('paths.edit') }}" class="nav-link {{ Route::currentRouteName() == 'paths.edit' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Path Editor</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('paths.index') }}" class="nav-link {{ Route::currentRouteName() == 'paths.index' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Paths</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header mt-4">NAVIGATION</li>
                <li class="nav-item {{ Route::currentRouteName() == 'procedures.index' || Route::currentRouteName() == 'procedures.add' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link d-flex justify-center-start align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building nav-item mr-2" viewBox="0 0 16 16">
                            <path d="M7 7V1.414a1 1 0 0 1 2 0V2h5a1 1 0 0 1 .8.4l.975 1.3a.5.5 0 0 1 0 .6L14.8 5.6a1 1 0 0 1-.8.4H9v10H7v-5H2a1 1 0 0 1-.8-.4L.225 9.3a.5.5 0 0 1 0-.6L1.2 7.4A1 1 0 0 1 2 7zm1 3V8H2l-.75 1L2 10zm0-5h6l.75-1L14 3H8z" />
                        </svg>
                        <p>
                            Procedures
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('procedures.add') }}" class="nav-link {{ Route::currentRouteName() == 'procedures.add' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Procedures</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('procedures.index') }}" class="nav-link {{ Route::currentRouteName() == 'procedures.index' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Procedures</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ Route::currentRouteName() == 'events.index' || Route::currentRouteName() == 'events.add' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link d-flex justify-center-start align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building nav-item mr-2" viewBox="0 0 16 16">
                            <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z" />
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z" />
                            <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5z" />
                        </svg>
                        <p>
                            Events
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('events.add') }}" class="nav-link {{ Route::currentRouteName() == 'events.add' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Event</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('events.index') }}" class="nav-link {{ Route::currentRouteName() == 'events.index' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Events</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header mt-4">USERS</li>
                <li class="nav-item">
                    <a href="#" class="nav-link d-flex justify-center-start align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building nav-item mr-2" viewBox="0 0 16 16">
                            <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m.256 7a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1zm3.63-4.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0" />
                        </svg>
                        <p>
                            Administrators
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('buildings.add') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Admins</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link d-flex justify-center-start align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building nav-item mr-2" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                        </svg>
                        <p>
                            Users
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('buildings.add') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Users</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <div class="d-flex flex-column justify-content-center align-items-center mt-2 mb-2">
        <a href="{{ route('dashboard') }}" class="btn btn-primary my-1 btn-sm rounded-lg text-light" style="width: 80%;">Dashboard</a>
        <a href="" class="btn btn-primary my-1 btn-sm rounded-lg text-light" style="width: 80%;">Settings</a>
        <a href="" class="btn btn-danger my-1 btn-sm rounded-lg text-light" style="width: 80%;">Logout</a>
    </div>
</aside>
<!-- /.control-sidebar -->