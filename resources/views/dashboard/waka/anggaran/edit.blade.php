@extends('layouts.dashboard.dashboard')
@section('content')
    <section class="section">
        <div class="row">
            <div>
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">Form Edit Anggaran</p>

                        <!-- General Form Elements -->
                        <form action="{{ route('anggaran.update',['anggaran'=>$anggaran->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <label for="anggaran" class="col-sm-2 col-form-label">Nominal Anggaran <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" id="anggaran"
                                        class="form-control @error('anggaran') is-invalid @enderror" name="anggaran" required value="{{ old('anggaran', number_format($anggaran->anggaran, 0, ',', '.')) }}">
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
                                                    <option value="APBD" {{ $anggaran->jenis_anggaran == 'APBD' ? 'selected' : '' }}>APBD</option>
                                                    <option value="BOS" {{ $anggaran->jenis_anggaran == 'BOS' ? 'selected' : '' }}>BOS</option>
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
                                    <button type="submit" class="btn btn-primary">Update Anggaran</button>
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
    </script>
@endsection
