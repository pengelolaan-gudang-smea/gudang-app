@extends('layouts.auth')
@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-4">

            <div class="justify-content-center mb-2 d-flex gap-5 align-items-center">
                <img src="{{ asset('assets/img/smk.png') }}" alt="Logo SMK N 1 Bantul" width="60">
                <span class="fs-4 fw-bold">Sistem Gudang</span>
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo Gudang" width="60">
            </div>
            <div class="card mb-3">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>

                    </div>
                @endif
                @if (session()->has('status'))
                    <div class="alert alert-success">
                        {{ session()->get('status') }}

                    </div>
                @endif
                <div class="card-body">

                    <div class="pt-4 pb-2">
                        <h5 class="card-title text-center pb-0 fs-4">Reset Password </h5>
                        <p class="text-center small">Masukan email untuk reset password</p>
                    </div>

                    <form class="row g-3 " action="{{ route('password.email') }}" method="POST">
                        @csrf

                        <div class="col-12">
                            <label for="youremail" class="form-label">Email</label>

                            <input type="email" name="email" class="form-control" id="youremail" required>

                        </div>

                        <div class="col-12">
                            <button class="btn btn-primary w-100" type="submit">Reset password</button>
                        </div>
                        <div class="col-12">
                            <p class="small mb-0">kembali ke halaman <a href="{{ route('login') }}">login</a>
                            </p>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>


    </div>
@endsection
