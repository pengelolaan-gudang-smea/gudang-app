@extends('layouts.auth')
@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-4">
         
            <div class="text-center mb-2">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo Gudang" width="60">
                <span class="fs-4">Sistem Gudang</span>
            </div>
            <div class="card mb-3">
                @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}

                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}

                </div>
            @endif
                <div class="card-body">

                    <div class="pt-4 pb-2">
                        <h5 class="card-title text-center pb-0 fs-4">Login </h5>
                        <p class="text-center small">Masukan username & password untuk login</p>
                    </div>

                    <form class="row g-3 " action="{{ route('login.auth') }}" method="post">
                        @csrf

                        <div class="col-12">
                            <label for="yourUsername" class="form-label">Username</label>

                            <input type="text" name="username" class="form-control" id="yourUsername" required value="{{ old('username') }}">

                        </div>

                        <div class="col-12">
                            <label for="yourPassword" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="yourPassword" required>
                            <div class="invalid-feedback">Please enter your password!</div>
                        </div>


                        <div class="col-12">
                            <button class="btn btn-primary w-100" type="submit">Login</button>
                        </div>
                        <div class="col-12">
                            <p class="small mb-0">Lupa password? <a href="{{ route('forgot.password') }}">reset password</a>
                            </p>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
