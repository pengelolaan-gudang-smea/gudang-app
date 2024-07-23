@extends('layouts.dashboard.dashboard')
@section('content')
    <section class="section">
        <div class="row">
            <div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ubah hak akses {{ $user->username }}</h5>

                        <!-- General Form Elements -->
                        <form action="{{ route('user.akses', ['user' => $user->username]) }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="{{ $user->username }}" disabled>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Role</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" disabled value="{{ $role->name }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <legend class="col-form-label col-sm-2 pt-0">Hak akses</legend>
                                <div class="col-sm-10">
                                    @foreach ($hak as $akses)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                id="gridCheck{{ $akses->id }}" name="akses[]" value="{{ $akses->id }}"
                                                {{ in_array($akses->id, $user->permissions->pluck('id')->toArray()) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="gridCheck{{ $akses->id }}">
                                                {{ $akses->name }}
                                            </label>
                                        </div>
                                    @endforeach



                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-sm-12 d-flex justify-content-end gap-2">
                                    <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Simpan Hak Akses User</button>
                                </div>
                            </div>

                        </form><!-- End General Form Elements -->

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
