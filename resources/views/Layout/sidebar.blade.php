        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Laporan Tabungan</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('riwayat_transaksi') }}">
                    <i class="fas fa-coins"></i>
                    <span>Transaksi</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('aksi_target') }}">
                    <i class="fas fa-bullseye"></i>
                    <span>Aksi Target</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users') }}">
                    <i class="fas fa-users"></i>
                    <span>Pengguna</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            <div class="sidebar-card d-none d-lg-flex">
                <p class="text-center mb-2">"Laporan tabungan adalah ringkasan aktivitas keuangan yang mencatat pendapatan, pengeluaran, dan saldo untuk mengelola dana dengan efisien."</p>
                <a class="btn btn-success btn-sm" href="https://incrustwerush.org/" target="_blank">incrustwerush.org</a>
            </div>

        </ul>
        <!-- End of Sidebar -->