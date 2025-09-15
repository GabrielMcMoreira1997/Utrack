<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @stack('styles')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                <!-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Home</a>
                </li> -->
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="{{ asset('pdf/LGPD_Orientacoes_UTrack.pdf') }}" target="_blank" class="nav-link">
                        <i class="fas fa-shield-alt"></i> LGPD
                    </a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link" style="color: #000;">
                            <i class="fas fa-sign-out-alt"></i> Sair
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link">
                <img src="{{ asset('images/logo-transparente.png') }}" alt="UTrack Logo" class="brand-image elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Utrack</span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                        <!-- DASHBOARD -->
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <!-- RELATORIOS -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    Relatórios
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('links.report') }}" class="nav-link">
                                        <i class="nav-icon fas fa-file-alt"></i>
                                        <p>Relatórios</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- CONFIGURAÇÕES -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    Configurações
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link">
                                        <i class="fas fa-users nav-icon"></i>
                                        <p>Usuários</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('tags.index') }}" class="nav-link">
                                        <i class="fas fa-tags nav-icon"></i>
                                        <p>Tags</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('roles.index') }}" class="nav-link">
                                        <i class="fas fa-user-shield nav-icon"></i>
                                        <p>Roles</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>
        <!-- /.sidebar -->

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="main-footer d-flex justify-content-between align-items-center">
            <strong>Copyright &copy; 2025</strong>
            <a href="{{ asset('pdf/LGPD_Orientacoes_UTrack.pdf') }}" target="_blank" class="text-sm text-muted">
                <i class="fas fa-shield-alt"></i> LGPD e Privacidade
            </a>
        </footer>

    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="{{ asset('vendor/adminlte/js/adminlte.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @vite(['resources/js/app.js'])

    @stack('scripts')

</body>

</html>
