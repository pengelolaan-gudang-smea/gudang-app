@extends('layouts.dashboard.dashboard')
@section('content')
<section class="section">
    <div class="row">
        <div>
            <div class="card">
                <div class="card-body">
                    <p class="card-title">Form Penambahan Barang Gudang</p>

                    <!-- General Form Elements -->
                    <form action="{{ route('barang-gudang.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Nama <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="name" placeholder="Masukan nama barang"
                                    class=" form-control @error('name') is-invalid @enderror" name="name" required value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="stock" class="col-sm-2 col-form-label">Kuantitas (Qty) <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="number" id="stock" placeholder="Masukan kuantitas barang"
                                    class="form-control @error('stock') is-invalid @enderror" name="stock" required value="{{ old('stock') }}">
                                @error('stock')
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
                                <input type="text" id="satuan" placeholder="Masukan satuan barang"
                                    class=" form-control @error('satuan') is-invalid @enderror" name="satuan" required value="{{ old('satuan') }}">
                                @error('satuan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                         <div class="row mb-3">
                            <label for="tahun" class="col-sm-2 col-form-label">Tahun <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="tahun" placeholder="Masukan tahun barang"
                                    class=" form-control @error('tahun') is-invalid @enderror" name="tahun" required value="{{ old('tahun') }}">
                                @error('tahun')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="satuan" class="col-sm-2 col-form-label">Tanggal Faktur <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="date" id="tgl_faktur"
                                    class="form-control @error('tgl_faktur') is-invalid @enderror" name="tgl_faktur" required value="{{ old('tgl_faktur') }}">
                                @error('tgl_faktur')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Jenis" class="col-sm-2 col-form-label">Jenis Barang <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-select" aria-label="Default select example" id="jenis-barang"
                                    name="jenis_barang">
                                    <option selected disabled>-- Pilih jenis barang --</option>
                                    <option value="Aset" data-jenis-barang="Aset">Aset</option>
                                    <option value="Persediaan"data-jenis-barang="Persediaan">Persediaan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="Jenis" class="col-sm-2 col-form-label">Jenis Anggaran <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-select" aria-label="Default select example" id="jenis-barang"
                                    name="jenis_anggaran_id">
                                    <option selected disabled>-- Pilih jenis anggaran --</option>
                                    @foreach ($jenis_anggaran as $jenis )
                                    <option value="{{ $jenis->id }}" >{{ $jenis->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="lokasi" class="col-sm-2 col-form-label">Lokasi <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="lokasi" placeholder="Masukan lokasi barang"
                                    class=" form-control @error('lokasi') is-invalid @enderror" name="lokasi" required value="{{ old('lokasi') }}">
                                @error('lokasi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="penerima" class="col-sm-2 col-form-label">Penerima <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="penerima" placeholder="Masukan penerima barang"
                                    class=" form-control @error('penerima') is-invalid @enderror" name="penerima" required value="{{ old('penerima') }}">
                                @error('penerima')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="satuan" class="col-sm-2 col-form-label">Tanggal Masuk <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="date" id="tgl_masuk"
                                    class="form-control @error('tgl_masuk') is-invalid @enderror" name="tgl_masuk" required value="{{ old('tgl_masuk') }}">
                                @error('tgl_masuk')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3 d-none" id="tujuan-barang">
                            <label for="tujuan" class="col-sm-2 col-form-label">Tujuan <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="tujuan" placeholder="Masukan tujuan barang"
                                    class="form-control @error('tujuan') is-invalid @enderror" name="tujuan" value="{{ old('tujuan') }}">
                                @error('tujuan')
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
                                <textarea type="text" id="spek" placeholder="Masukan spek teknis barang"
                                    class="form-control @error('spek') is-invalid @enderror" name="spek" required>{{ old('spek') }}</textarea>
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
                                <button id='ajukan-barang' type="submit" class="btn btn-primary">Ajukan
                                    Barang</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        $('#jenis-barang').change(function() {
                const jenisBarang = $(this).find(':selected')
                const jenisBarangVal =jenisBarang.data('jenis-barang')
                if (jenisBarangVal === 'Aset') {
                    $('#tujuan-barang').removeClass('d-none');
                }else{
                    $('#tujuan-barang').addClass('d-none');
                }
            })
    });
</script>
@endsection
