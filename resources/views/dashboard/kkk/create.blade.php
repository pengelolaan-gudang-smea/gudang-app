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
                                <label for="harga" class="col-sm-2 col-form-label">Harga <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" id="harga" placeholder="Masukan harga barang/pcs"
                                        class="form-control @error('harga') is-invalid @enderror" name="harga" required value="{{ old('harga') }}">
                                    @error('harga')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="text-danger d-none" id="info-limit-1">Anggaran kurang</small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="stock" class="col-sm-2 col-form-label">Kuantitas (Qty) <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="number" id="stock" placeholder="Masukan kuantitas barang"
                                        class="form-control @error('stock') is-invalid @enderror" name="stock" required value="{{ old('name') }}">
                                    @error('stock')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="text-danger d-none" id="info-limit-2">Anggaran kurang</small>
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
                                <label for="satuan" class="col-sm-2 col-form-label">Bulan yang di inginkan <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="month" id="expired"
                                        class="form-control @error('expired') is-invalid @enderror" name="expired" required value="{{ old('expired') }}">
                                    @error('expired')
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
        $(document).ready(function() {
            let debounceTimer;
            $('#jenis-barang').change(function() {
                const jenisBarang = $(this).find(':selected')
                const jenisBarangVal =jenisBarang.data('jenis-barang')
                if (jenisBarangVal === 'Aset') {
                    $('#tujuan-barang').removeClass('d-none');
                }else{
                    $('#tujuan-barang').addClass('d-none');
                }
            })

            $('#harga').keyup(function() {
                clearTimeout(debounceTimer);

                // Tunggu sebentar sebelum memproses input
                debounceTimer = setTimeout(function() {
                    let harga = $('#harga').val();
                    $('#harga').val(formatRupiahInput(harga));

                    const price = harga.replace(/\./g,""); // Hilangkan titik untuk memproses sebagai angka
                    const priceFormatted = parseInt(price);

                    const btn = document.querySelector('#ajukan-barang');
                    const info1 = document.querySelector('#info-limit-1');
                    const info2 = document.querySelector('#info-limit-2');
                    const satuanInput = document.querySelector('#stock');

                    const limit = {{ $sisa }};

                    if (priceFormatted > limit) {
                        btn.classList.add('disabled');
                        info1.classList.remove('d-none');
                    } else {
                        btn.classList.remove('disabled');
                        info1.classList.add('d-none');
                    }

                    satuanInput.addEventListener('input', function() {
                        satuan = satuanInput.value * priceFormatted;

                        if (satuan > limit) {
                            btn.classList.add('disabled');
                            info2.classList.remove('d-none');
                        } else {
                            btn.classList.remove('disabled');
                            info2.classList.add('d-none');
                        }
                    });
                }, 300); // Tunggu 300ms sebelum memproses input
            });
        });

        function formatRupiahInput(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] !== undefined ? rupiah + "," + split[1] : rupiah;
            return prefix === undefined ? rupiah : rupiah ? rupiah : 0;
        }
    </script>
@endsection
