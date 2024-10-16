@extends('layouts.dashboard.dashboard')
@section('content')
    <section class="section">
        <div class="row">
            <div>
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">Form Tambah Anggaran</p>

                        <!-- General Form Elements -->
                        <form action="{{ route('limit-anggaran.store') }}" method="POST">
                            @csrf

                            <div class="mb-3 row">
                                <label for="jenis-anggaran" class="col-sm-2 col-form-label">Anggaran <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <select class="form-select select2" aria-label="Default select example" id="jenis-anggaran"
                                        name="anggaran_id">
                                        <option selected disabled>-- Pilih anggaran --</option>
                                        @foreach ($anggaran as $item)
                                            <option value="{{ $item->id }}">
                                                {{ 'Rp ' . number_format($item->anggaran, 0, ',', '.') }} -
                                                {{ $item->tahun }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="anggaran" class="col-sm-2 col-form-label">Nominal Limit Anggaran <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" id="anggaran"
                                        class="form-control @error('anggaran') is-invalid @enderror" name="limit" required
                                        min="0">
                                    @error('anggaran')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="text-danger" id="error-limit">

                                    </small>
                                </div>

                            </div>

                            <div class="mb-3 row">
                                <label for="jenis-jurusan" class="col-sm-2 col-form-label">Jurusan <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <select class="form-select select2" aria-label="Default select example" id="jenis-jurusan"
                                        name="jurusan_id">
                                        <option selected disabled>-- Pilih jurusan --</option>
                                        @foreach ($jurusan as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
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
                                    <button type="submit" class="btn btn-primary" id="simpan-limit">Simpan</button>
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
            $('#anggaran').on('input', function() {
                let anggaran = $('#anggaran').val();
                $('#anggaran').val(formatRupiahInput(anggaran));
            });

            $('#jenis-anggaran').on('change', function() {
                const selectedAnggaranId = $('#jenis-anggaran').val();

                $.ajax({
                    url: `/dashboard/waka/check-anggaran/${selectedAnggaranId}`,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let anggaran = $('#anggaran').val()
                        handleData(data);
                    },
                    error: function(error) {
                        console.error('There has been a problem with your fetch operation:',
                            error);
                    }
                });
            });

            function handleData(data) {
                if (data.status === 'limit reach') {
                    $('#error-limit').text('Limit telah tercapai.');
                    $('#anggaran').prop('disabled', true);
                    $('#simpan-limit').prop('disabled', true);
                } else {
                    $('#error-limit').text('');
                    $('#simpan-limit').prop('disabled', false);
                    anggaranValue = parseFloat(data);
                    calculateTotal();
                }
            }




            $('#anggaran').on('input', function() {
                let inputValue = $(this).val().replace(/[^\d,]/g, "");
                inputValue = inputValue.replace(".", "");
                limitValue = parseFloat(inputValue) || 0;

                if (limitValue < 0) {
                    limitValue = 0;
                }

                calculateTotal();
            });
        });

        function calculateTotal() {
            if (!isNaN(limitValue) && !isNaN(anggaranValue)) {

                const total = anggaranValue - limitValue;
                if (total < 0) {
                    $('#error-limit').text('Nominal limit melebihi anggaran yang dipilih.');
                    $('#simpan-limit').prop('disabled', true);
                } else {
                    $('#error-limit').text('');
                    $('#simpan-limit').prop('disabled', false);
                }
            }
        }
    </script>
@endsection
