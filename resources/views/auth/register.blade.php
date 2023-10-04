@extends('layouts.auth')
@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    {{ $title }}
                </div>
                <div class="card-body">
                    <form action="{{ route('register.store') }}" method="POST">
                        @csrf
                        <div class="form-group mt-3">
                            <label for="fullname">Username</label>
                            <input type="text" class="form-control  @error('username') is-invalid @enderror"
                                id="fullname" placeholder="Masukan username" name="username" value="{{ old('username') }}">
                            @error('username')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control  @error('email')is-invalid @enderror" id="email"
                                placeholder="Masukan email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Masukan password"
                                name="password">
                            @error('password')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="password_confirm">Confirm password</label>
                            <input type="password" class="form-control" id="password_confirm" placeholder="Confirm password"
                                name="password_confirmation">
                            @error('password_confirmation')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary my-3 mx-auto d-block">Register</button>
                        <p class="text-center ">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
