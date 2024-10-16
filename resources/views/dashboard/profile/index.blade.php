@extends('layouts.dashboard.dashboard')
@section('content')
    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">
                @if (session('success'))
                    <x-sweetalert :message="session('success')" />
                @endif

                <div class="card">
                    <div class="pt-4 card-body profile-card">
                        <h2>{{ Auth::user()->name }}</h2>
                        <small>Anda login sebagai</small>
                        @if (Auth::user()->hasRole('KKK'))
                        <p class="mb-1 fw-bold">{{ Auth::user()->roles->pluck('name')->implode(', ') }} - {{ Auth::user()->jurusan->name }}</p>
                        @else
                        <p class="mb-1">{{ Auth::user()->roles->pluck('name')->implode(', ') }}</p>
                        @endif
                        <hr>
                        Hak akses Anda :
                        <ul>
                            @foreach (Auth::user()->permissions as $permission)
                                <li>{{ $permission->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card">
                    <div class="pt-3 card-body">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item">
                                <button class="nav-link @if (session('tab') == 'profile_overview' || !session('tab')) active @endif" data-bs-toggle="tab"
                                    data-bs-target="#profile-overview">Overview</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link @if (session('tab') == 'profile_edit') active @endif" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                    Profile</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link @if (session('tab') == 'profile_change_password') active @endif" data-bs-toggle="tab"
                                    data-bs-target="#profile-change-password">Change Password</button>
                            </li>
                        </ul>
                        <div class="pt-2 tab-content">
                            <div class="tab-pane fade @if (session('tab') == 'profile_overview' || !session('tab')) show active @endif" id="profile-overview">
                                <h5 class="card-title">Profile Details</h5>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Name</div>
                                    <div class="col-lg-9 col-md-8">{{ Auth::user()->name }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Username</div>
                                    <div class="col-lg-9 col-md-8">{{ Auth::user()->username }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">{{ Auth::user()->email }}</div>
                                </div>
                            </div>

                            <div class="tab-pane fade @if (session('tab') == 'profile_edit') show active @endif profile-edit pt-3" id="profile-edit">
                                <!-- Profile Edit Form -->
                                <form action="{{ route('profile.update', ['user' => Auth::user()->username]) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3 row">
                                        <label for="name" class="col-md-4 col-lg-3 col-form-label">Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="name" type="text" class="form-control" id="name"
                                                value="{{ Auth::user()->name }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="username" class="col-md-4 col-lg-3 col-form-label">Username</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="username" type="text" class="form-control" id="username"
                                                value="{{ Auth::user()->username }}">
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="company" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="email" type="email" class="form-control" id="company"
                                                value="{{ Auth::user()->email }}">
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Simpan</button>
                                    </div>
                                </form><!-- End Profile Edit Form -->
                            </div>

                            <div class="tab-pane fade @if (session('tab') == 'profile_change_password') show active @endif pt-3" id="profile-change-password">
                                <!-- Change Password Form -->
                                <form action="{{ route('profile.updatePass', ['user' => Auth::user()->username]) }}" method="post">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3 row">
                                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Password Lama</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="current_password" type="password" class="form-control"
                                                id="currentPassword">
                                                @error('current_password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Password Baru</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="new_password" type="password" class="form-control"
                                                id="new_password">
                                                @error('new_password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Konfirmasi Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="new_password_confirmation" type="password" class="form-control"
                                                id="renewPassword">
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary"><i class="bi bi-key"></i> Ubah Password</button>
                                    </div>
                                </form><!-- End Change Password Form -->
                            </div>
                        </div><!-- End Bordered Tabs -->
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
