@extends('layouts.dashboard.dashboard')
@section('content')
<section class="section">
    <div class="row">
        <div>
            <div class="card">
                <div class="card-body">
                    <p class="card-title">Form Tambah Anggaran</p>

                    <!-- General Form Elements -->
                    <form action="{{ route('anggaran.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <label for="anggaran" class="col-sm-2 col-form-label">Nominal Anggaran <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="anggaran" class="form-control @error('anggaran') is-invalid @enderror" name="anggaran" required placeholder="Masukkan nominal anggaran...">
                                @error('anggaran')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="Jenis" class="col-sm-2 col-form-label">Jenis <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-select" aria-label="JenisAnggaran" id="jenis" name="jenis_anggaran">
                                    <option selected disabled>-- Pilih jenis anggaran --</option>
                                        @foreach ($jenis_anggaran as $ja)
                                            <option value="{{ $ja->name }}" data-tahun="{{ $ja->tahun }}">{{ $ja->name }} - {{ $ja->tahun }}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="tahun" class="col-sm-2 col-form-label">Tahun <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="number" id="tahun" class="form-control @error('tahun') is-invalid @enderror" name="tahun" required min="1999" placeholder="Pilih jenis anggaran terlebih dahulu..." readonly style="cursor:not-allowed;">
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
            theme: "bootstrap-5"
        });

        $('select[name=jenis_anggaran]').change(function() {
            let jenisAnggaran = this.value;
            let tahun = $(this).find(':selected').data('tahun');
            $('#tahun').val(tahun);
        });
    });
</script>
@endsection
