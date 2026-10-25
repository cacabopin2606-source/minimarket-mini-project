<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Minimarket')</title>

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    @yield('css')
</head>

<body id="page-top">

<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center"
           href="{{ route('dashboard') }}">

            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-store"></i>
            </div>

            <div class="sidebar-brand-text mx-3">
                Minimarket
            </div>

        </a>

        <hr class="sidebar-divider my-0">

        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            Menu
        </div>

        <!-- Products -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('products.index') }}">
                <i class="fas fa-fw fa-box"></i>
                <span>Products</span>
            </a>
        </li>

        <!-- Kasir -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('cashier.index') }}">
                <i class="fas fa-fw fa-cash-register"></i>
                <span>Kasir</span>
            </a>
        </li>

        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggle -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End Sidebar -->


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <ul class="navbar-nav ml-auto">

                    <!-- User -->
                    <li class="nav-item dropdown no-arrow">

                        <a class="nav-link dropdown-toggle"
                           href="#"
                           id="userDropdown"
                           data-toggle="dropdown">

                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                {{ auth()->user()->name }}
                            </span>

                            <i class="fas fa-user-circle fa-2x"></i>

                        </a>

                        <div class="dropdown-menu dropdown-menu-right shadow">

                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}">

                                @csrf

                                <button type="submit" class="dropdown-item">

                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>

                                    Logout

                                </button>

                            </form>

                        </div>

                    </li>

                </ul>

            </nav>
            <!-- End Topbar -->


            <!-- Page Content -->
            <div class="container-fluid">

                @yield('content')

            </div>

        </div>

    </div>

</div>


<!-- JavaScript -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>

@yield('js')

</body>

</html>