@extends('layouts.dashboard.dashboard')
@section('content')
    <section class="section">
        <div class="row">
            <div>
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">Form Edit Barang Pengajuan</p>

                        <!-- General Form Elements -->
                        <form action="{{ route('barang-acc.update', ['acc' => $barang->slug]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <label for="name" class="col-sm-2 col-form-label">Nama <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" id="name"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name', $barang->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="harga" class="col-sm-2 col-form-label">Harga (satuan)<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="number" id="harga"
                                        class="form-control @error('harga') is-invalid @enderror" name="harga"
                                        value="{{ old('harga', $barang->harga) }}" required>
                                    @error('harga')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="satuan" class="col-sm-2 col-form-label">Satuan <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" id="satuan"
                                        class="form-control @error('satuan') is-invalid @enderror" name="satuan"
                                        value="{{ old('satuan', $barang->satuan) }}" required>
                                    @error('satuan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="spek" class="col-sm-2 col-form-label">Spek <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <textarea type="text" id="spek" class="form-control @error('spek') is-invalid @enderror" name="spek"
                                        required>{{ old('spek', $barang->spek) }} </textarea>
                                    @error('spek')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <small class="text-secondary"><span class="text-danger">* </span>Field wajid diisi</small>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-12 d-flex justify-content-end gap-2">
                                    <a href="{{ route('barang-acc.index') }}" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-primary">AJukan Barang</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
