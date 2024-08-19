@extends('layouts.auth')
@section('css')
<style>
    .logo img {
        user-drag: none;
        -webkit-user-drag: none;
        user-select: none;
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
</style>
@endsection
@section('content')
<section class="vh-100">
    <div class="container-fluid h-100">
        <div class="row h-100">
            <!-- Left Side: Form -->
            <div class="col-md-5 d-flex flex-column align-items-center justify-content-center">
                <!-- Top Left: Logos -->
                <div class="w-100 text-center mb-4">
                    <div class="d-flex justify-content-center align-items-center logo">
                        <img src="{{ asset('assets/img/smk.png') }}" alt="Logo SMK" width="60" class="mr-3">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo Gudang" width="60">
                    </div>
                    <p class="mt-2">Selamat datang di <b>Gudang App Skansaba</b></p>
                </div>
                <!-- Form Container -->
                <div class="form-container w-75 p-4 bg-white rounded shadow">
                    <h3 class="text-center mb-4 fw-bold">Login</h3>
                    @if (session()->has('error'))
                    <div class="alert alert-danger d-flex align-items-center">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <div>
                            {{ session()->get('error') }}
                        </div>
                    </div>
                    @endif
                    <form class="row g-3" action="{{ route('login.auth') }}" method="post">
                        @csrf
                        <div class="col-12">
                            <label for="yourUsername" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" id="yourUsername" required value="{{ old('username') }}">
                        </div>
                        <div class="col-12">
                            <label for="yourPassword" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="yourPassword" required>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100" type="submit">Login</button>
                        </div>
                    </form>
                </div>
                <p class="absolute bottom-0"><a href="https://skansaba.dev" target="_blank">Skansaba.dev</a> © {{ date('Y') }}</p>
            </div>

            <!-- Right Side: Image Background -->
            <div class="col-md-7 d-none d-md-block p-0">
                <div class="image h-100 w-100" style="
                        background-image: url('{{ asset('assets/img/cover_landing_page.jpg') }}');
                        background-size: cover;
                        background-position: center;
                        filter: grayscale(50%) brightness(0.5);
                        border-radius: 30px 0 0 30px;">
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
