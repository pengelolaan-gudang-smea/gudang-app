@extends('layouts.dashboard.dashboard')
@section('content')
    <section class="section">
        <div class="row">
            <div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tambah User </h5>

                        <!-- General Form Elements -->
                        <form action="{{ route('user.store') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="username">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="email">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Role</label>
                                <div class="col-sm-10">
                                    <select class="form-select" aria-label="Default select example" name="role">
                                        <option selected>Pilih role</option>
                                        @foreach ($roles as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <legend class="col-form-label col-sm-2 pt-0">Hak akses</legend>
                                <div class="col-sm-10">
                                    @foreach ($hak as $akses)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gridCheck1" name="akses[]"
                                                value="{{ $akses->id }}">
                                            <label class="form-check-label" for="gridCheck1">
                                                {{ $akses->name }}
                                            </label>
                                        </div>
                                    @endforeach


                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary mx-auto d-block">Tambah User</button>
                                    <a href="{{ route('user.index') }}">kembali</a>
                                </div>

                            </div>

                        </form><!-- End General Form Elements -->

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
