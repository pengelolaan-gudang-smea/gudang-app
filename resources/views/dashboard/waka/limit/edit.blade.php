@extends('layouts.dashboard.dashboard')
@section('content')
<section class="section">
    <div class="row">
        <div>
            <div class="card">
                <div class="card-body">
                    <p class="card-title">Form Edit Limit Anggaran</p>

                    <!-- General Form Elements -->
                    <form action="{{ route('limit-anggaran.update',['limit'=>$limit->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3 row">
                            <label for="jenis-anggaran" class="col-sm-2 col-form-label">Anggaran <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-select select2" aria-label="Default select example" id="jenis-anggaran" name="anggaran_id">
                                    <option disabled>-- Pilih anggaran --</option>
                                    @foreach ($anggaran as $item)
                                    <option value="{{ $item->id }}" {{ ($item->id == old('anggaran_id',$limit->anggaran->id)) ? 'selected' : '' }}>{{ 'Rp ' . number_format($item->anggaran, 0, ',', '.') }} - {{ $item->tahun }}</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="anggaran" class="col-sm-2 col-form-label">Nominal Limit Anggaran <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="anggaran" class="form-control @error('anggaran') is-invalid @enderror" name="limit" required value="{{ old('limit',$limit->limit) }}">
                                @error('anggaran')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="jurusan" class="col-sm-2 col-form-label">Jurusan <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-select select2" aria-label="Default select example" id="jurusan" name="jurusan_id">
                                    <option disabled>-- Pilih jurusan --</option>
                                    @foreach ($jurusan as $item)
                                    <option value="{{ $item->id }}" {{ ($item->id == old('jurusan_id',$limit->jurusan->id)) ? 'selected' : ''}}>{{ $item->name}}</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>



                        <div class="mb-3 row">
                            <small class="text-secondary"><span class="text-danger">* </span>Field wajid diisi</small>
                        </div>

                        <div class="mb-3 row">
                            <div class="gap-2 col-sm-12 d-flex justify-content-end">
                                <a href="{{ route('limit-anggaran.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
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

        $('#jenis-anggaran').select2({
            theme: "bootstrap-5",
        });

        $('#jurusan').select2({
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
