@extends('layouts.dashboard.dashboard')
@section('content')
<section class="section">
    <div class="row">
        <div>
            <div class="card">
                <div class="card-body">
                    <p class="card-title">Form Edit Barang Pengajuan</p>

                    <!-- General Form Elements -->
                    <form action="{{ route('pengajuan-barang.update', ['barang' => $barang->slug]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3 row">
                            <label for="kode_barang" class="col-sm-2 col-form-label">Kode Barang <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="kode_barang" placeholder="Masukan kode barang" class=" form-control @error('kode_barang') is-invalid @enderror" name="kode_barang" required value="{{ old('kode_barang', $barang->kode_barang) }}">
                                @error('kode_barang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="kode_rekening" class="col-sm-2 col-form-label">Kode Rekening <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="kode_rekening" placeholder="Masukan kode barang" class=" form-control @error('kode_rekening') is-invalid @enderror" name="kode_rekening" required value="{{ old('kode_rekening', $barang->kode_rekening) }}">
                                @error('kode_rekening')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="name" class="col-sm-2 col-form-label">Nama <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $barang->name) }}" required>
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="harga" class="col-sm-2 col-form-label">Harga <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="harga" placeholder="Masukan harga barang/pcs" class="form-control @error('harga') is-invalid @enderror" name="harga" required value="{{ old('harga',$barang->harga) }}">
                                @error('harga')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                                <small class="text-danger d-none" id="info-limit-1">Anggaran kurang</small>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="stock" class="col-sm-2 col-form-label">Kuantitas (Qty) <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="number" id="stock" placeholder="Masukan kuantitas barang" class="form-control @error('stock') is-invalid @enderror" name="stock" required value="{{ old('stock',$barang->stock) }}">
                                @error('stock')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                                <small class="text-danger d-none" id="info-limit-2">Anggaran kurang</small>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="satuan" class="col-sm-2 col-form-label">Satuan <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="satuan" class="form-select @error('satuan') is-invalid @enderror select2" aria-label="Default select example" id="satuan" required>
                                    <option selected disabled>-- Pilih satuan --</option>
                                    <option value="Buah" {{ $barang->satuan == 'Buah' ? 'selected' : '' }}>Buah</option>
                                    <option value="Pcs" {{ $barang->satuan == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                                    <option value="Dus" {{ $barang->satuan == 'Dus' ? 'selected' : '' }}>Dus</option>
                                    <option value="Box" {{ $barang->satuan == 'Box' ? 'selected' : '' }}>Box</option>
                                    <option value="Lusin" {{ $barang->satuan == 'Lusin' ? 'selected' : '' }}>Lusin</option>
                                    <option value="Gram" {{ $barang->satuan == 'Gram' ? 'selected' : '' }}>Gram</option>
                                    <option value="Kg" {{ $barang->satuan == 'Kg' ? 'selected' : '' }}>Kilogram</option>
                                    <option value="Liter" {{ $barang->satuan == 'Liter' ? 'selected' : '' }}>Liter</option>
                                    <option value="Meter" {{ $barang->satuan == 'Meter' ? 'selected' : '' }}>Meter</option>
                                    <option value="Cm" {{ $barang->satuan == 'Cm' ? 'selected' : '' }}>Centimeter</option>
                                    <option value="Inch" {{ $barang->satuan == 'Inch' ? 'selected' : '' }}>Inch</option>
                                </select>
                                @error('satuan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="satuan" class="col-sm-2 col-form-label">Bulan yang di inginkan  <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="month" id="expired"  class="form-control @error('expired') is-invalid @enderror" name="expired" required value="{{ old('expired',date('Y-m', strtotime($barang->expired))) }}">
                                @error('expired')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="Jenis" class="col-sm-2 col-form-label">Jenis Barang <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-select" aria-label="Default select example" id="jenis-barang" name="jenis_barang_id">
                                    <option selected disabled>-- Pilih jenis barang --</option>
                                    <option value="Aset" {{ ($barang->jenis_barang == 'Aset') ? 'selected' : ''}}>Aset</option>
                                    <option value="Persediaan" {{ ($barang->jenis_barang == 'Persediaan') ? 'selected' : ''}}>Persediaan</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row" id="tujuan-barang">
                            <label for="tujuan" class="col-sm-2 col-form-label">Tujuan  <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="tujuan" placeholder="Masukan tujuan barang" class="form-control @error('tujuan') is-invalid @enderror" name="tujuan" required value="{{ old('tujuan',$barang->tujuan) }}">
                                @error('tujuan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="spek" class="col-sm-2 col-form-label">Spek <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <textarea type="text" id="spek" class="form-control @error('spek') is-invalid @enderror" name="spek" required>{{ old('spek', $barang->spek) }} </textarea>
                                @error('spek')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <small class="text-secondary"><span class="text-danger">* </span>Field wajid diisi</small>
                        </div>

                        <div class="mb-3 row">
                            <div class="gap-2 col-sm-12 d-flex justify-content-end">
                                <a href="{{ route('pengajuan-barang.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary" id="ajukan-barang">Ajukan Barang</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        const debounce = (func, delay) => {
            let debounceTimer;
            return function() {
                const context = this;
                const args = arguments;
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => func.apply(context, args), delay);
            };
        };

        const toggleTujuanBarang = () => {
            const jenisBarangVal = $('#jenis-barang').find(':selected').data('tujuan');
            if (jenisBarangVal === 'Barang Aset') {
                $('#tujuan-barang').removeClass('d-none');
            } else {
                $('#tujuan-barang').addClass('d-none');
            }
        };

        const handleHargaInput = () => {
            let harga = $('#harga').val();
            $('#harga').val(formatRupiahInput(harga));

            const price = parseInt(harga.replace(/\./g, ""));
            const limit = {{ $sisa }};
            const btn = $('#ajukan-barang');
            const info1 = $('#info-limit-1');
            const info2 = $('#info-limit-2');
            const satuanInput = $('#stock');

            const toggleButtonAndInfo = (condition, btn, info) => {
                if (condition) {
                    btn.addClass('disabled');
                    info.removeClass('d-none');
                } else {
                    btn.removeClass('disabled');
                    info.addClass('d-none');
                }
            };

            toggleButtonAndInfo(price > limit, btn, info1);

            satuanInput.off('input').on('input', function() {
                const total = $(this).val() * price;
                toggleButtonAndInfo(total > limit, btn, info2);
            });
        };

        $('#jenis-barang').change(toggleTujuanBarang);
        $('#harga').keyup(debounce(handleHargaInput, 100));
    });
    </script>
@endsection
