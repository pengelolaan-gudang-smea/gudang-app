@extends('layouts.dashboard.dashboard')
@section('content')
    <section class="section">
        {{-- Sweetalert --}}
        @if (session('success'))
            <x-sweetalert :message="session('success')" />
        @endif
        <div class="card">
            <div class="card-body">
                <div class="gap-3 d-flex align-items-center">
                    <a href="{{ route('barang-gudang.create') }}" class="my-3 btn btn-primary "><i class="bi bi-box2-fill"></i>
                        Tambah Barang Gudang</a>
                    <button class="btn btn-md btn-success" data-bs-toggle="modal" data-bs-target="#modal-import-excel"><i class="bi bi-file-earmark-excel"></i> Import
                        Excel</button>
                </div>
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
                                    <td class="satuan">{{ $item->stock_akhir }}</td>
                                    <td class="keterangan">{!! $item->penerima ? '<i class="m-0 bi bi-check text-success fs-2"></i>' : '-' !!}</td>
                                    <td class="keterangan">
                                        <img src="{{ asset('storage/' . $item->qr_code) }}" alt="" width="50">
                                    </td>
                                    <td>
                                        <div class="gap-3 d-flex">
                                            @if ($item->satuan != 0)
                                                @if ($item->keterangan)
                                                    <div>
                                                        <button type="button"
                                                            class="bi bi-box-arrow-right fw-bold btn btn-sm bg-danger link-light"
                                                            data-bs-toggle="modal" data-bs-trigger="click"
                                                            data-bs-title="Pengambilan barang"
                                                            data-bs-target="#ModalPengambilan"
                                                            data-slug="{{ $item->slug }}" data-qty="{{ $item->satuan }}">
                                                        </button>

                                                    </div>
                                                @else
                                                    @if ($item->qr_code)
                                                        <div>
                                                            <button type="button"
                                                                class="bi bi-check fw-bold btn btn-sm bg-success link-light"
                                                                data-bs-toggle="modal" data-bs-target="#ModalKeterangan"
                                                                data-bs-trigger="click" data-bs-title="Checklist"
                                                                data-slug={{ $item->slug }}>
                                                            </button>
                                                        </div>
                                                        @if ($item->penerima)
                                                        <div>
                                                            <button type="button"
                                                                class="bi bi-box-arrow-right fw-bold btn btn-sm bg-danger link-light"
                                                                data-bs-toggle="modal" data-bs-target="#ModalPengambilan"
                                                                data-bs-trigger="click" data-bs-title="Pengambilan Barang"
                                                                data-slug={{ $item->slug }} data-qty = "{{ $item->stock }}">
                                                            </button>
                                                        </div>
                                                        @endif
                                                    @else
                                                        <div>
                                                            <button type="button"
                                                                class="bi bi-qr-code fw-bold btn btn-sm bg-success link-light qr-barang-btn"
                                                                data-bs-toggle="modal" data-bs-target="#ModalQr"
                                                                data-bs-trigger="click" data-bs-title="Generate QR Code"
                                                                data-slug={{ $item->slug }}>
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            @endif
                                            <div>
                                                <button type="button" data-barang="{{ $item->slug }}"
                                                    class="btn btn-sm bg-primary link-light detailBarangBtn"
                                                    data-bs-trigger="click" data-bs-title="Detail">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </div>

                                            <div>
                                                <button type="button"
                                                    class="btn btn-sm btn-danger link-light deleteBarangBtn"
                                                    data-bs-trigger="click" data-bs-title="Delete"
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

        <div class="modal fade" id="ModalKeterangan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            data-bs-backdrop="static">
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
                                    class="form-control @error('penerima') is-invalid @enderror" name="penerima"
                                    required>
                                @error('penerima')
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
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Pengambilan Barang</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="pengambilanForm" method="post">
                            @csrf
                            @method('PUT')
                            <label for="pengambilan" class=" col-form-label">Pengambilan Barang<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" id="nama_pengambil" placeholder="Masukan nama pengambil"
                                    class="form-control @error('nama_pengambil') is-invalid @enderror" name="nama_pengambil"
                                    required min="0">
                                <input type="text" id="tujuan" placeholder="Masukan tujuan barang"
                                    class="form-control @error('tujuan') is-invalid @enderror my-3" name="tujuan"
                                    required min="0">
                                <input type="number" id="pengambilan" placeholder="Masukan jumlah barang yang diambil"
                                    class="form-control @error('pengambilan') is-invalid @enderror" name="pengambilan"
                                    required min="0">
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

                            <div class="mb-3 row">
                                <label for="pengambilan" class="mb-3">Lokasi Barang<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" id="lokasi" placeholder="Masukan lokasi "
                                        class="form-control @error('lokasi') is-invalid @enderror" name="lokasi"
                                        required>
                                    @error('lokasi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <img src="" alt="" id="#qrcodebarang">
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
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

        <div class="modal fade" id="ModalQrSuccess" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true" data-bs-backdrop="static">
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
                        <a class="btn btn-primary" role="button" id="printQrButton"><i class="bi bi-printer-fill"></i>
                            Print</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-import-excel" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Import from XLSX, CSV.</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="gap-2 d-grid">
                            <button class="mb-3 btn btn-primary">
                                <i class="bi bi-file-earmark-spreadsheet"></i> Download File Format Excel
                            </button>
                        </div>
                        <hr>
                        <form action="{{ route('import.barang') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="import-excel" id="" class="form-control mb-3 @error('import-excel') is-invalid @enderror">
                            @error('import-excel')
                                <div class="mb-3 invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <button class="btn btn-primary">Import Excel</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <script>
            let table = new DataTable('#barangsTable');

            $(document).ready(function() {
                $('[data-bs-trigger="click"]').popover({
                    trigger: 'hover',
                });
                const qrCreated = {!! json_encode(request('qr_created')) !!};
                const qrCodePath = {!! json_encode(request('qr_code')) !!}

                if (qrCreated) {
                    $('#ModalQrSuccess').modal('show');
                    var qrCodeUrl = "{{ asset('storage/') }}" + '/' + qrCodePath;
                    $('#qrCodeImage').attr('src', qrCodeUrl);

                    $('#printQrButton').click(function(event) {
                        event.preventDefault();
                        printQr(qrCodeUrl);
                    });
                }

                function printQr(qrCodeUrl) {
                    var printWindow = window.open(qrCodeUrl, '_blank');

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
                                let qrCodePath = response.barang.qr_code;
                                $('#detailBarangModalLabel').text(
                                    `Detail Barang ${response.barang.name}`);
                                $('.showBarang').empty();
                                const Qr = $(
                                    `<img src="{{ asset('storage/${response.barang.qr_code}') }}" width="100">
                                    <button class="btn btn-sm bg-warning text-light" type="button" id="buttonPrintQr"><i class="bi bi-printer-fill"></i></button>`
                                );
                                const listGroup = $(`<ul class="list-group">
                                                    <li class="list-group-item"><small>Nama Barang :</small><br> ${response.barang.kode_barang}</li>
                                                    <li class="list-group-item"><small>Nama Barang :</small><br> ${response.barang.kode_rekening}</li>
                                                    <li class="list-group-item"><small>Nama Barang :</small><br> ${response.barang.name}</li>
                                                    <li class="list-group-item"><small>Spek Teknis :</small><br> ${response.barang.spek}</li>
                                                    <li class="list-group-item"><small>Diambil oleh :</small><br>${response.barang.penerima ? response.barang.penerima : '-'}</li>
                                                    <li class="list-group-item"><small>Kuantitas (Qty) :</small><br> ${response.barang.satuan}</li>
                                                    <li class="list-group-item"><small>Tanggal Masuk :</small><br> ${response.barang.tgl_masuk}</li>
                                                    <li class="list-group-item"><small>Kode Qr :</small><br></li>
                                                </ul>`);
                                listGroup.find('li:contains("Kode Qr :")').append(Qr);
                                $('.showBarang').append(listGroup);

                                // Tampilkan modal
                                $('#detailBarangModal').modal('show');
                                $('#buttonPrintQr').click(function() {
                                    if (qrCodePath) {
                                        const printWindow = window.open(
                                            "{{ asset('storage/') }}" + '/' +
                                            qrCodePath, '_blank');

                                        printWindow.onload = function() {
                                            printWindow.print();
                                        };
                                    } else {
                                        console.error('Path gambar QR tidak tersedia.');
                                    }
                                });
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
                    const qty = button.data('qty');
                    console.log(qty);
                    const form = $(this).find('form#pengambilanForm');
                    const actionUrl = `/dashboard/barang-gudang/${slug}`;
                    $('#pengambilan').attr('max', qty);

                    form.attr('action', actionUrl);

                    $('#pengambilan').on('input', function() {
                        const nilaiSatuan = parseFloat($(this).attr('max'));
                        const nilaiInput = parseFloat($(this).val());

                        if (nilaiInput > nilaiSatuan) {
                            $(this).val(nilaiSatuan);
                        }
                    });

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
