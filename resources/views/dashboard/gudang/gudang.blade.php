@extends('layouts.dashboard.dashboard')
@section('content')
    <section class="section">
        {{-- Sweetalert --}}
        @if (session('success'))
            <x-sweetalert :message="session('success')" />
        @endif
        <div class="card">
            <div class="card-body">
                <a href="{{ route('barang-gudang.create') }}" class="btn btn-primary my-3 "><i class="bi bi-box2-fill"></i>
                    Tambah Barang Gudang</a>
                <!-- Default Table -->
                <div class="table-responsive">
                    <table class="table mt-2" id="barangsTable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Kuantitas (Qty)</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Qr Code</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barang as $item)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $item->name }}</td>
                                    <td class="satuan">{{ $item->satuan }}</td>
                                    <td class="keterangan">{!! $item->keterangan ? '<i class="bi bi-check text-success fs-2"></i>' : '-' !!}</td>
                                    <td class="keterangan"><img src="{{ asset('storage/' . $item->qr_code) }}"
                                            alt="" width="50"></td>
                                    <td>
                                        <div class="d-flex gap-3">
                                            @if ($item->satuan != 0)
                                                @if ($item->keterangan)
                                                    <div>
                                                        <button type="button"
                                                            class="bi bi bi-box-arrow-right fw-bold btn btn-sm bg-danger link-light"
                                                            data-bs-toggle="modal" data-bs-target="#ModalPengambilan"
                                                            data-slug={{ $item->slug }}>
                                                        </button>
                                                    </div>
                                                    <div>
                                                        <button type="button"
                                                            class="bi bi bi bi-qr-code fw-bold btn btn-sm bg-success link-light qr-barang-btn"
                                                            data-bs-toggle="modal" data-bs-target="#ModalQr"
                                                            data-slug={{ $item->slug }}>
                                                        </button>
                                                    </div>
                                                @else
                                                    <div>
                                                        <button type="button"
                                                            class="bi bi-check fw-bold btn btn-sm bg-success link-light"
                                                            data-bs-toggle="modal" data-bs-target="#ModalKeterangan"
                                                            data-slug={{ $item->slug }}>
                                                        </button>
                                                    </div>
                                                @endif
                                            @endif

                                            <div>
                                                <button type="button" data-barang="{{ $item->slug }}"
                                                    class="btn btn-sm bg-primary link-light detailBarangBtn">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </div>
                                            <div>
                                                <a href="{{ route('barang-gudang.edit', ['gudang' => $item->slug]) }}"
                                                    class="btn btn-sm bg-warning link-light">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            </div>
                                            <div>
                                                <button type="button"
                                                    class="btn btn-sm btn-danger link-light deleteBarangBtn"
                                                    data-barang="{{ $item->name }}">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                                <form
                                                    action="{{ route('barang-gudang.destroy', ['gudang' => $item->slug]) }}"
                                                    method="post" hidden class="deleteBarangForm"
                                                    data-barang="{{ $item->name }}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
                <!-- End Default Table Example -->
            </div>
        </div>
        </div>

        <div class="modal fade" id="ModalKeterangan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Keterangan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="keteranganForm" method="post">
                            @csrf
                            @method('PUT')
                            <label for="penerima" class="col-sm-2 col-form-label">Penerima<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="penerima" placeholder="Masukan penerima barang"
                                    class="form-control @error('keterangan') is-invalid @enderror" name="keterangan"
                                    required>
                                @error('keterangan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="submitKeterangan">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="ModalPengambilan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Keterangan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="pengambilanForm" method="post">
                            @csrf
                            @method('PUT')
                            <label for="pengambilan" class="col-sm-2 col-form-label">Pengambilan Barang<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="number" id="pengambilan" placeholder="Masukan jumlah barang "
                                    class="form-control @error('pengambilan') is-invalid @enderror" name="pengambilan"
                                    required>
                                @error('pengambilan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="submitPengambilan">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="ModalQr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Generate Qr</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="Qr" method="post">
                            @csrf
                            <input type="hidden" name="barang" value="" id="barang-modal">

                            <div class="row mb-3">
                                <label for="pengambilan" class="col-sm-2 col-form-label">Lokasi Barang<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" id="pengambilan" placeholder="Masukan lokasi "
                                        class="form-control @error('pengambilan') is-invalid @enderror" name="lokasi"
                                        required>
                                    @error('pengambilan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="Jenis" class="col-sm-2 col-form-label">Anggaran <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <select class="form-select" aria-label="Default select example" id="jenis-anggaran"
                                        name="anggaran">
                                        <option selected disabled>Pilih anggaran</option>
                                        @foreach ($anggaran as $item)
                                            <option value="{{ $item->jenis }} - {{ $item->tahun }}">
                                                {{ $item->jenis }} -
                                                {{ $item->tahun }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <img src="" alt="" id="#qrcodebarang">
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        {{-- <span type="button" class="btn btn-success" id="qrGenerate">Generate</span> --}}
                        <button type="button" class="btn btn-primary" id="simpanQr">Generate </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="detailBarangModal" tabindex="-1" aria-labelledby="detailBarangModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="detailBarangModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body showBarang">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="ModalQrSuccess" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">QR Code</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex justify-content-center">
                        <img src="" alt="QR Code" id="qrCodeImage" class="img-fluid">
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-primary" role="button" id="printQrButton"><i class="fa-solid fa-print"></i> Print</a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            let table = new DataTable('#barangsTable');

            $(document).ready(function() {
                const qrCreated = {!! json_encode(request('qr_created')) !!};
                const qrCodePath = {!! json_encode(request('qr_code')) !!}

                if (qrCreated) {
                    $('#ModalQrSuccess').modal('show');
                    var qrCodeUrl = "{{ asset('storage/') }}" + '/' + qrCodePath;
                    $('#qrCodeImage').attr('src', qrCodeUrl);

                    // Menambahkan event listener untuk memanggil fungsi printQr saat tombol "Print" ditekan
                    $('#printQrButton').click(function(event) {
                        event.preventDefault();
                        printQr(qrCodeUrl);
                    });
                }

                function printQr(qrCodeUrl) {
                    var printWindow = window.open(qrCodeUrl, '_blank');

                    // Menunggu gambar selesai dimuat sebelum mencetak
                    printWindow.onload = function() {
                        printWindow.print();
                    };
                }

                $('.detailBarangBtn').click(function() {
                    const barangSlug = $(this).data('barang');
                    $.ajax({
                        type: 'GET',
                        url: '/dashboard/barang-gudang/' + barangSlug,
                        success: function(response) {
                            if (response.status == 'success') {
                                $('#detailBarangModalLabel').text(
                                    `Detail Barang ${response.barang.name}`);
                                $('.showBarang').empty();
                                const Qr = $(
                                    `<img src="{{ asset('storage/${response.barang.qr_code}') }}" width="100">`
                                );
                                const listGroup = $(`<ul class="list-group">
                                                    <li class="list-group-item"><small>Nama Barang :</small><br> ${response.barang.name}</li>
                                                    <li class="list-group-item"><small>Spek Teknis :</small><br> ${response.barang.spek}</li>
                                                    <li class="list-group-item"><small>Diambil oleh :</small><br>${response.barang.keterangan ? response.barang.keterangan : '-'}</li>
                                                    <li class="list-group-item"><small>Kuantitas (Qty) :</small><br> ${response.barang.satuan}</li>
                                                    <li class="list-group-item"><small>Kode Qr :</small><br></li>
                                                </ul>`);
                                listGroup.find('li:contains("Kode Qr :")').append(Qr);
                                $('.showBarang').append(listGroup);

                                // Tampilkan modal
                                $('#detailBarangModal').modal('show');
                            } else {
                                // Handle other cases
                            }


                        },
                    });
                });

                $('.deleteBarangBtn').click(function() {
                    const barang = $(this).data('barang');
                    console.log(barang);
                    Swal.fire({
                        title: 'Anda yakin?',
                        text: "Anda tidak bisa mengembalikan data ini!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const deleteBarangForm = $(`.deleteBarangForm[data-barang="${barang}"]`);
                            deleteBarangForm.submit();
                        }
                    });
                });

                $('#ModalKeterangan').on('show.bs.modal', function(event) {
                    const button = $(event.relatedTarget);
                    const slug = button.data('slug');
                    const form = $(this).find('form#keteranganForm');
                    const actionUrl = `/dashboard/barang-gudang/${slug}`;
                    form.attr('action', actionUrl);
                });

                $('#submitKeterangan').on('click', function() {
                    // Lakukan sesuatu jika tombol 'Simpan' diklik
                    $('#keteranganForm').submit(); // Submit form
                });

                $('#ModalPengambilan').on('show.bs.modal', function(event) {
                    const button = $(event.relatedTarget);
                    const slug = button.data('slug');
                    const form = $(this).find('form#pengambilanForm');
                    const actionUrl = `/dashboard/barang-gudang/${slug}`;

                    form.attr('action', actionUrl);
                });

                $('#submitPengambilan').on('click', function() {
                    $('#pengambilanForm').submit();
                });

                $('#ModalQr').on('show.bs.modal', function(event) {
                    const button = $(event.relatedTarget);
                    const slug = button.data('slug');
                    console.log(slug);
                    const barang = $('#barang-modal').val(slug)
                    const form = $(this).find('form#Qr');
                    const actionUrl = `/dashboard/barang-gudang/${slug}/qrcode`;

                    form.attr('action', actionUrl);
                    $('#qrGenerate').data('slug', slug);
                });
                $('#simpanQr').on('click', function() {
                    $('#Qr').submit();
                });
            });

            const harga = document.querySelectorAll('.harga');
            const sub_total = document.querySelectorAll('.sub-total');
        </script>
    </section>
@endsection
