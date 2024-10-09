@extends('layouts.dashboard.dashboard')
@section('content')
<section class="section">
    <div class="row">
        <div>
            <div class="card">
                <div class="card-body">
                    <p class="card-title">Form Tambah User</p>

                    <!-- General Form Elements -->
                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Nama lengkap <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" required>
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="username" class="col-sm-2 col-form-label">Username <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="username" class="form-control @error('username') is-invalid @enderror" name="username" required>
                                @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-sm-2 col-form-label">Email <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" required>
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password" class="col-sm-2 col-form-label">Password <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="role">Role <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-select" aria-label="Default select example" id="role" name="role">
                                    <option selected disabled>-- Pilih role --</option>
                                    @foreach ($roles as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3" id="jurusanInput">
                            <label class="col-sm-2 col-form-label" for="jurusan_id">Jurusan <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-select" aria-label="Default select example" id="jurusan_id" name="jurusan_id">
                                    <option selected disabled>-- Pilih jurusan --</option>
                                    @foreach ($jurusan as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <legend class="col-form-label col-sm-2 pt-0">Hak akses <span class="text-danger">*</span>
                            </legend>
                            <div class="col-sm-10">
                                @foreach ($hak as $akses)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gridCheck{{ $akses->id }}" name="akses[]" value="{{ $akses->id }}">
                                    <label class="form-check-label" for="gridCheck{{ $akses->id }}">
                                        {{ $akses->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row mb-3">
                            <small class="text-secondary"><span class="text-danger">* </span>Field wajid diisi</small>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-12 d-flex justify-content-end gap-2">
                                <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Tambah User</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            toggleJurusanInput();

            $('#role').select2({
                theme: "bootstrap-5"
            });

            $('#role').on('change', toggleJurusanInput);

            function toggleJurusanInput() {
                const roleSelect = $('#role');
                const jurusanInput = $('#jurusanInput');

                if (roleSelect.val() === '3' || roleSelect.val() === '5') {
                    jurusanInput.show();
                    $('#jurusan_id').select2({
                        theme: "bootstrap-5"
                    })
                } else {
                    jurusanInput.hide();
                }
            }
        })

    </script>
</section>
@endsection
