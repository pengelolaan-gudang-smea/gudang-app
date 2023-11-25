 @extends('layouts.auth')
 @section('content')
 <div class="row justify-content-center mt-5">
    <div class="col-md-4">

        <div class="text-center mb-2">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo Gudang" width="60">
            <span class="fs-4">Sistem Gudang</span>
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
                    <p class="text-center small">Masukan password baru</p>
                </div>

                <form class="row g-3 " action="{{ route('password.update') }}" method="POST">
                    @csrf

                    <input type="hidden" name="token" value="{{ request()->token }}">
                    <input type="hidden" name="email" value="{{ request()->email }}">
                    <div class="col-12">
                        <label for="new_password" class="form-label">Password </label>

                        <input type="password" name="password" class="form-control" id="new_password" required>

                    </div>
                    <div class="col-12">
                        <label for="new_password_confirmation" class="form-label">Konfirmasi Password </label>

                        <input type="password" name="password_confirmation" class="form-control" id="new_password_confirmation" required>

                    </div>

                    <div class="col-12">
                        <button class="btn btn-primary w-100" type="submit">Ubah Password</button>
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
 @endsection
