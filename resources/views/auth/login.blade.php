@extends('layouts.auth')
@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
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
            <div class="card">
                <div class="card-header">
                    {{ $title }}
                </div>
                <div class="card-body">
                    <form action="{{ route('login.auth') }}" method="POST">
                        @csrf
                        <div class="form-group mt-3">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" placeholder="Masukan username"
                                name="username" value="{{ old('username') }}">
                        </div>
                        <div class="form-group mt-3">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Masukan password"
                                name="password">
                        </div>
                        <a href="{{ route('forgot.password') }}" class="my-3 d-block">Lupa password?</a>
                        <button type="submit" class="btn btn-primary d-block mx-auto">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
