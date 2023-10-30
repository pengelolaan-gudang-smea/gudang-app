@extends('layouts.dashboard.dashboard')
@section('content')
<section class="section">
    <div class="row">
        <div>
            <div class="card">
                <div class="card-body">
                    <p class="card-title">Form Pengajuan Barang</p>

                    <!-- General Form Elements -->
                    <form action="{{ route('pengajuan-barang.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="jurusan_id" value="{{ Auth::user()->jurusan_id }}">
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Nama <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="name" placeholder="Masukan nama barang" class="form-control @error('name') is-invalid @enderror" name="name" required>
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="harga" class="col-sm-2 col-form-label">Harga (satuan)<span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="number" id="harga" placeholder="Masukan harga barang/pcs" class="form-control @error('harga') is-invalid @enderror" name="harga" required>
                                @error('harga')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="satuan" class="col-sm-2 col-form-label">Kuantitas (Qty) <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="number" id="satuan" placeholder="Masukan kuantitas barang" class="form-control @error('satuan') is-invalid @enderror" name="satuan" required>
                                @error('satuan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="spek" class="col-sm-2 col-form-label">Spek <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <textarea type="text" id="spek" placeholder="Masukan spek teknis barang" class="form-control @error('spek') is-invalid @enderror" name="spek" required></textarea>
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
                                <a href="{{ route('pengajuan-barang.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Ajukan Barang</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
