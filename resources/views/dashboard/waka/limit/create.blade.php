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
                                        <option selected disabled>Pilih anggaran</option>
                                        @foreach ($anggaran as $item)
                                            <option value="{{ $item->id }}">
                                                {{ 'Rp. ' . number_format($item->anggaran, 0, ',', '.') }} -
                                                {{ $item->tahun }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="anggaran" class="col-sm-2 col-form-label">Nominal Limit Anggaran <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="number" id="anggaran"
                                        class="form-control @error('anggaran') is-invalid @enderror" name="limit" required
                                        min="0">
                                    @error('anggaran')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="text-danger" id="error-limit">

                                    </div>
                                </div>

                            </div>

                            <div class="row mb-3">
                                <label for="Jenis" class="col-sm-2 col-form-label">Jurusan <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <select class="form-select" aria-label="Default select example" id="jenis"
                                        name="jurusan_id">
                                        <option selected disabled>Pilih jurusan</option>
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
                                    <button type="submit" class="btn btn-primary" id="simpan-limit">Simpan limit
                                        Anggaran</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const anggaranSelect = document.querySelector('#jenis-anggaran');
        const limitInput = document.querySelector('#anggaran');
        let anggaranValue = 0; // Simpan nilai anggaran yang diambil dari server
        let limitValue = 0; // Simpan nilai input dari pengguna
        const simpanButton = document.getElementById('simpan-limit');

        limitInput.addEventListener('input', function(event) {
            if (event.target.value < 0) {
                event.target.value = 0; // Jika nilai negatif dimasukkan, ubah nilainya menjadi 0
            }
            limitValue = parseInt(event.target.value); // Simpan nilai input saat pengguna mengetikkan nominal
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
                    anggaranValue = parseFloat(data); // Simpan nilai anggaran dari respons
                    calculateTotal();
                })
                .catch(error => {
                    console.error('There has been a problem with your fetch operation:', error);
                });
        });


        function calculateTotal() {
            if (!isNaN(limitValue) && !isNaN(anggaranValue)) {
                const total = anggaranValue - limitValue; // Hitung total
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
