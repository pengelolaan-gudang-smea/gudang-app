<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="{{ request()->routeIs('dashboard') ? 'nav-link' : 'nav-link collapsed' }}"
                href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->


        @can('Edit akun')
            <li class="nav-item">
                <a class="{{ request()->routeIs('user.index') ? 'nav-link' : 'nav-link collapsed' }}"
                    href="{{ route('user.index') }}">
                    <i class="bi bi-people-fill"></i>
                    <span>User Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="{{ request()->routeIs('anggaran.index') ? 'nav-link' : 'nav-link collapsed' }}"
                    href="{{ route('anggaran.index') }}">
                    <i class="bi bi-coin"></i>
                    <span>Anggaran</span>
                </a>
            </li>
        @endcan
        @can('Mengajukan barang')
            <li class="nav-item">
                <a class="{{ request()->routeIs('pengajuan-barang.index') ? 'nav-link' : 'nav-link collapsed' }}"
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
            
        <li class="nav-item">
            <a class="{{ request()->routeIs('barang.index') ? 'nav-link' : 'nav-link collapsed' }}"
                href="{{ route('barang.index') }}">
                <i class="bi bi-box-seam-fill"></i>
                <span>Barang Diajukan</span>
            </a>
        </li>
        @endcan
        <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('user.index') }}">
                <i class="bi bi-question-circle"></i>
                <span>User</span>
            </a>
        </li><!-- End F.A.Q Page Nav -->


        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-register.html">
                <i class="bi bi-card-list"></i>
                <span>Register</span>
            </a>
        </li><!-- End Register Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-login.html">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Login</span>
            </a>
        </li><!-- End Login Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-error-404.html">
                <i class="bi bi-dash-circle"></i>
                <span>Error 404</span>
            </a>
        </li><!-- End Error 404 Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-blank.html">
                <i class="bi bi-file-earmark"></i>
                <span>Blank</span>
            </a>
        </li><!-- End Blank Page Nav -->

    </ul>

</aside><!-- End Sidebar-->
