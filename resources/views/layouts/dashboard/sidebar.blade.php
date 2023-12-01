<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-heading">Dashboard</li>
        <li class="nav-item">
            <a class="{{ request()->routeIs('dashboard') ? 'nav-link' : 'nav-link collapsed' }}"
                href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->


        @can('Edit akun')
        <li class="nav-heading">Kelola User</li>
            <li class="nav-item">
                <a class="{{ request()->routeIs('user*') ? 'nav-link' : 'nav-link collapsed' }}"
                    href="{{ route('user.index') }}">
                    <i class="bi bi-people-fill"></i>
                    <span>User Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="{{ request()->routeIs('rekap.login') ? 'nav-link' : 'nav-link collapsed' }}"
                    href="{{ route('rekap.login') }}">
                    <i class="bx bxs-user-account"></i>
                    <span>Rekap Login User</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="{{ request()->routeIs('rekap.activity') ? 'nav-link' : 'nav-link collapsed' }}"
                    href="{{ route('rekap.activity') }}">
                    <i class="bi bi-activity"></i>
                    <span>Rekap Aktivitas user</span>
                </a>
            </li>

        <li class="nav-heading">Kelola Anggaran</li>
            <li class="nav-item">
                <a class="{{ request()->routeIs('anggaran*') ? 'nav-link' : 'nav-link collapsed' }}"
                    href="{{ route('anggaran.index') }}">
                    <i class="bi bi-coin"></i>
                    <span>Anggaran</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="{{ request()->routeIs('limit-anggaran*') ? 'nav-link' : 'nav-link collapsed' }}"
                    href="{{ route('limit-anggaran.index') }}">
                    <i class="bi bi-exclamation-circle"></i>
                    <span>Limit Anggaran</span>
                </a>
            </li>
        @endcan
        @can('Mengajukan barang')
        <li class="nav-heading">Kelola Barang</li>
            <li class="nav-item">
                <a class="{{ request()->routeIs('pengajuan-barang*') ? 'nav-link' : 'nav-link collapsed' }}"
                    href="{{ route('pengajuan-barang.index') }}">
                    <i class="bi bi-box-seam-fill"></i>
                    <span>Pengajuan Barang</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="{{ request()->routeIs('barang.setuju') ? 'nav-link' : 'nav-link collapsed' }}"
                    href="{{ route('barang.setuju') }}">
                    <i class="bi bi-check2-circle"></i>
                    <span>Barang Disetujui</span>
                </a>
            </li>
        @endcan
        @can('Edit barang')
        <li class="nav-heading">Kelola Barang</li>
        <li class="nav-item">
            <a class="{{ request()->routeIs('barang-acc.index') ? 'nav-link' : 'nav-link collapsed' }}"
                href="{{ route('barang-acc.index') }}">
                <i class="bi bi-box-seam-fill"></i>
                <span>Barang Diajukan</span>
            </a>
        </li>
        @endcan
        @can('Barang gudang')
        <li class="nav-heading">Kelola Barang</li>
        <li class="nav-item">
            <a class="{{ request()->routeIs('barang-gudang.*') ? 'nav-link' : 'nav-link collapsed' }}"
                href="{{ route('barang-gudang.index') }}">
                <i class="bi bi-box-seam-fill"></i>
                <span>Barang Gudang</span>
            </a>
        </li>

        @endcan
        <li class="nav-heading">Lainnya</li>

        <li class="nav-item">
            <a class="{{ request()->routeIs('dashboard.profile') ? 'nav-link' : 'nav-link collapsed' }}" href="{{ route('dashboard.profile',['user'=>Auth::user()->username]) }}">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li><!-- End Profile Page Nav -->

       
    </ul>

</aside><!-- End Sidebar-->
