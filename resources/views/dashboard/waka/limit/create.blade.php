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
                            <label for="Jenis" class="col-sm-2 col-form-label">Anggaran <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-select" aria-label="Default select example" id="jenis-anggaran" name="anggaran_id">
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
                            <label for="anggaran" class="col-sm-2 col-form-label">Nominal Limit Anggaran <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="anggaran" class="form-control @error('anggaran') is-invalid @enderror" name="limit" required min="0" >
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
                            <label for="Jenis" class="col-sm-2 col-form-label">Jurusan <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-select" aria-label="Default select example" id="jenis" name="jurusan_id">
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
        $('#anggaran').keyup(function() {
            let anggaran = $('#anggaran').val();
            $('#anggaran').val(formatRupiahInput(anggaran));
        });

        $('#jenis-anggaran').select2({
            theme: "bootstrap-5",
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

    const anggaranSelect = document.querySelector('#jenis-anggaran');
    const limitInput = document.querySelector('#anggaran');
    let anggaranValue = 0; // Simpan nilai anggaran yang diambil dari server
    let limitValue = 0; // Simpan nilai input dari pengguna
    const simpanButton = document.getElementById('simpan-limit');

    limitInput.addEventListener('input', function(event) {
        // Ambil nilai input dan hapus karakter selain digit dan koma
        let inputValue = event.target.value.replace(/[^\d,]/g, "");
        // Ubah koma menjadi titik untuk mendapatkan nilai float
        inputValue = inputValue.replace(".", "");
        limitValue = parseFloat(inputValue) || 0;

        if (limitValue < 0) {
            limitValue = 0;
        }

        calculateTotal();
    });

    anggaranSelect.addEventListener('change', function(event) {
        const selectedAnggaranId = event.target.value;

        fetch(`/dashboard/waka/check-anggaran/${selectedAnggaranId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'limit reach') {
                    const errorFeedback = document.querySelector('#error-limit');
                    errorFeedback.textContent = 'Limit telah tercapai.';
                    limitInput.disabled = true;
                    simpanButton.disabled = true;
                } else {
                    const errorFeedback = document.querySelector('#error-limit');
                    errorFeedback.textContent = '';
                    simpanButton.disabled = false;
                    anggaranValue = parseFloat(data);
                    calculateTotal();
                }
            })
            .catch(error => {
                console.error('There has been a problem with your fetch operation:', error);
            });
    });


    function calculateTotal() {
        if (!isNaN(limitValue) && !isNaN(anggaranValue)) {
            const total = anggaranValue - limitValue;
            console.log(total);
            if (total < 0) {
                const errorFeedback = document.querySelector('#error-limit');
                errorFeedback.textContent = 'Nominal limit melebihi anggaran yang dipilih.';
                simpanButton.disabled = true;
            } else {
                const errorFeedback = document.querySelector('#error-limit');
                errorFeedback.textContent = '';
                simpanButton.disabled = false;
            }
        }
    }

</script>
@endsection
