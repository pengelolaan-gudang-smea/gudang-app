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

                            <div class="row mb-3">
                                <label for="Jenis" class="col-sm-2 col-form-label">Anggaran <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <select class="form-select" aria-label="Default select example" id="jenis-anggaran"
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

                            <div class="row mb-3">
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

                            <div class="row mb-3">
                                <label for="Jenis" class="col-sm-2 col-form-label">Jurusan <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <select class="form-select" aria-label="Default select example" id="jenis-jurusan"
                                        name="jurusan_id">
                                        <option selected disabled>-- Pilih jurusan --</option>
                                        @foreach ($jurusan as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>



                            <div class="row mb-3">
                                <small class="text-secondary"><span class="text-danger">* </span>Field wajid diisi</small>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-12 d-flex justify-content-end gap-2">
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

            // $('#jenis').select2({
            //     theme: "bootstrap-5",
            // });
            
            $('#jenis-anggaran').on('change', function() {
                const selectedAnggaranId = $('#jenis-anggaran').val();

                $.ajax({

                    url = `/dashboard/waka/check-anggaran/${selectedAnggaranId}`,
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

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? rupiah : 0;
        }
    </script>
@endsection
