<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <!-- Dashboard Section -->
        <li class="nav-heading">Dashboard</li>
        <li class="nav-item">
            <a class="{{ request()->routeIs('dashboard') ? 'nav-link' : 'nav-link collapsed' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <!-- Kelola User Section -->
        @can('Edit akun')
        <li class="nav-heading">Kelola User</li>
        <li class="nav-item">
            <a class="{{ request()->routeIs('rekap.login') ? 'nav-link' : 'nav-link collapsed' }}" href="{{ route('rekap.login') }}">
                <i class="bx bxs-user-account"></i>
                <span>Rekap Login User</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="{{ request()->routeIs('rekap.activity') ? 'nav-link' : 'nav-link collapsed' }}" href="{{ route('rekap.activity') }}">
                <i class="bi bi-activity"></i>
                <span>Rekap Aktivitas User</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="{{ request()->routeIs('user*') ? 'nav-link' : 'nav-link collapsed' }}" href="{{ route('user.index') }}">
                <i class="bi bi-people-fill"></i>
                <span>Manajemen User</span>
            </a>
        </li>
        @endcan

        <!-- Kelola Barang Section -->
        @can('Mengajukan barang')
        <li class="nav-heading">Kelola Barang</li>
        <li class="nav-item">
            <a class="{{ request()->routeIs('pengajuan-barang*') ? 'nav-link' : 'nav-link collapsed' }}" href="{{ route('pengajuan-barang.index') }}">
                <i class="bi bi-box-seam-fill"></i>
                <span>Pengajuan Barang</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="{{ request()->routeIs('barang.setuju') ? 'nav-link' : 'nav-link collapsed' }}" href="{{ route('barang.setuju') }}">
                <i class="bi bi-check2-circle"></i>
                <span>Barang Disetujui</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('barang.masuk') }}" class="{{ request()->routeIs('barang.masuk') ? 'nav-link' : 'nav-link collapsed' }}">
                <i class="bi bi-box-arrow-right"></i>
                <span>Barang Masuk</span>
            </a>
        </li>
        @endcan

        <!-- Kelola Anggaran Section -->
        @can('Menyetujui barang')
        <li class="nav-heading">Kelola Anggaran</li>
        <li class="nav-item">
            <a class="{{ request()->routeIs('anggaran*') ? 'nav-link' : 'nav-link collapsed' }}" href="{{ route('anggaran.index') }}">
                <i class="bi bi-coin"></i>
                <span>Anggaran</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="{{ request()->routeIs('limit-anggaran*') ? 'nav-link' : 'nav-link collapsed' }}" href="{{ route('limit-anggaran.index') }}">
                <i class="bi bi-exclamation-circle"></i>
                <span>Limit Anggaran</span>
            </a>
        </li>

        <!-- Kelola Barang Section for Admin -->
        <li class="nav-heading">Kelola Barang</li>
        <li class="nav-item">
            <a class="{{ request()->routeIs('barang-acc.index') ? 'nav-link' : 'nav-link collapsed' }}" href="{{ route('barang-acc.index') }}">
                <i class="bi bi-box-seam-fill"></i>
                <span>Barang Diajukan</span>
            </a>
        </li>

        <!-- Data Master Section -->
        <li class="nav-heading">Data Master</li>
        <li class="nav-item">
            <a class="{{ request()->routeIs('data-master.jurusan.*') ? 'nav-link' : 'nav-link collapsed' }}" href="{{ route('data-master.jurusan.index') }}">
                <i class="bi bi-list-stars"></i>
                <span>Master Jurusan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="{{ request()->routeIs('data-master.jenis-anggaran.*') ? 'nav-link' : 'nav-link collapsed' }}" href="{{ route('data-master.jenis-anggaran.index') }}">
                <i class="bi bi-list-stars"></i>
                <span>Master Jenis Anggaran</span>
            </a>
        </li>
        @endcan

        <!-- Kelola Barang Gudang Section -->
        @can('Barang gudang')
        <li class="nav-heading">Kelola Barang</li>
        <li class="nav-item">
            <a class="{{ request()->routeIs('barang-gudang.*') ? 'nav-link' : 'nav-link collapsed' }}" href="{{ route('barang-gudang.index') }}">
                <i class="bi bi-box-seam-fill"></i>
                <span>Barang Gudang</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="{{ request()->routeIs('barang.keluar') ? 'nav-link' : 'nav-link collapsed' }}" href="{{ route('barang.keluar') }}">
                <i class="bi bi-box-seam-fill"></i>
                <span>Barang Keluar</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="{{ request()->routeIs('laporan.gudang') ? 'nav-link' : 'nav-link collapsed' }}" href="{{ route('laporan.gudang') }}">
                <i class="bi bi-pie-chart-fill"></i>
                <span>Laporan Persediaan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="{{ request()->routeIs('laporan.jurusan') ? 'nav-link' : 'nav-link collapsed' }}" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-pie-chart-fill"></i>
                <span>Laporan Aset</span>
            </a>
            <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('laporan.aset') }}">
                        <i class="bi bi-circle"></i><span>Jurusan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('laporan.lab') }}">
                        <i class="bi bi-circle"></i><span>Lab / Ruang</span>
                    </a>
                </li>
            </ul>
        </li>
        @endcan

        <!-- Lainnya Section -->
        <li class="nav-heading">Lainnya</li>
        <li class="nav-item">
            <a class="{{ request()->routeIs('dashboard.profile') ? 'nav-link' : 'nav-link collapsed' }}" href="{{ route('dashboard.profile',['user'=>Auth::user()->username]) }}">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li><!-- End Profile Page Nav -->

    </ul>
</aside><!-- End Sidebar-->
