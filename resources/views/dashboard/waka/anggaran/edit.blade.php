@extends('layouts.dashboard.dashboard')
@section('content')
    <section class="section">
        <div class="row">
            <div>
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">Form Tambah Anggaran</p>

                        <!-- General Form Elements -->
                        <form action="{{ route('anggaran.update',['anggaran'=>$anggaran->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <label for="anggaran" class="col-sm-2 col-form-label">Nominal Anggaran <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" id="anggaran"
                                        class="form-control @error('anggaran') is-invalid @enderror" name="anggaran" required value="{{ old('anggaran',$anggaran->anggaran) }}">
                                    @error('anggaran')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="Jenis" class="col-sm-2 col-form-label">Jenis <span
                                        class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <select class="form-select" aria-label="Default select example" id="jenis"
                                                name="jenis">
                                                <option selected disabled>-- Pilih jenis anggaran --</option>
                                                    <option value="BOS" {{ $anggaran->jenis == 'BOS' ? 'selected' : '' }}>BOS</option>
                                                    <option value="BOSDA" {{ $anggaran->jenis == 'BOSDA' ? 'selected' : '' }}>BOSDA</option>
                                            </select>
                                        </div>
                            </div>
                            <div class="row mb-3">
                                <label for="tahun" class="col-sm-2 col-form-label">Tahun <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="tahun" id="tahun"
                                        class="form-control @error('tahun') is-invalid @enderror" name="tahun" required value="{{ old('tahun',$anggaran->tahun) }}">
                                    @error('tahun')
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
                                    <a href="{{ route('anggaran.index') }}" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Tambah Anggaran</button>
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
            $('#anggaran').keyup(function() {
                let anggaran = $('#anggaran').val();
                $('#anggaran').val(formatRupiahInput(anggaran));
            });

            $('#jenis').select2({
                theme: "bootstrap-5",
            });
        });

        function formatRupiahInput(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, "").toString()
                , split = number_string.split(",")
                , sisa = split[0].length % 3
                , rupiah = split[0].substr(0, sisa)
                , ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? rupiah : 0;
        }
    </script>
@endsection
