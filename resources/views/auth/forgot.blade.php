@extends('layouts.auth')
@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
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
            <div class="card">
                <div class="card-header">
                    Forgot Password
                </div>
                <div class="card-body">
                    <form action="{{ route('password.email') }} " method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email"
                                name="email">
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Reset Password</button>
                    </form>
                </div>
            </div>

        </div>


    </div>
@endsection
