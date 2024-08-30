<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo Gudang" width="32">
            <span class="d-none d-lg-block">Sistem Gudang</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">


            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    @if (!auth()->user()->jurusan_id && auth()->user()->hasPermissionTo('Mengajukan barang'))
                    <i class="bi bi-exclamation-circle text-danger"></i>
                    @endif
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->username }}</span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ Auth::user()->name }}</h6>
                        <p class="mb-0">{{ Auth::user()->getRoleNames()->implode(', ') }}</p>
                        @if(Auth::user()->getRoleNames()->implode(', ') == 'KKK')
                        <p class="mb-3">{{ Auth::user()->jurusan->name }}</p>
                        @endif
                        @if (!auth()->user()->jurusan_id && auth()->user()->hasPermissionTo('Mengajukan barang'))
                            <p class="badge bg-danger">Tidak ada jurusan yang di miliki</p>
                        @endif
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="dropdown-header">
                       {{ Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center"
                            href="{{ route('dashboard.profile', ['user' => Auth::user()->username]) }}">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item d-flex align-items-center">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </button>
                        </form>

                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->
