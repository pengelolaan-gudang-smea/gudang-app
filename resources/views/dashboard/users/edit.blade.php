@extends('layouts.dashboard.dashboard')
@section('content')
<section class="section">
    <div class="row">
        <div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Edit User {{ $user->username }} </h5>

                    <!-- General Form Elements -->
                    <form action="{{ route('user.update', ['user' => $user->username]) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Username <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username', $user->username) }}">
                                @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail" class="col-sm-2 col-form-label">Email <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail" class="col-sm-2 col-form-label">Password <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Role <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-select" aria-label="Default select example" name="roles">
                                    <option selected disabled>Pilih role</option>
                                    @foreach ($roles as $item)
                                    <option value="{{ $item->id }}" {{ $user->roles->pluck('id')->contains($item->id) ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <small class="text-secondary"><span class="text-danger">* </span>Field wajid diisi</small>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-12 d-flex justify-content-end gap-2">
                                <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Edit User</button>
                            </div>
                        </div>

                    </form><!-- End General Form Elements -->

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
