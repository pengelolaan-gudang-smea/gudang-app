@extends('layouts.dashboard.dashboard')
@section('content')
<section class="section">
    {{-- Sweetalert --}}
    @if (session('success'))
    <x-sweetalert :message="session('success')" />
    @endif
    <div class="card">
        <div class="card-body">
            <div class="my-3 accordion" id="accordionFilter">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#filterAccordion" aria-expanded="true" aria-controls="filterAccordion">
                            <i class="bi bi-funnel-fill me-2"></i> <b>Filter</b>
                        </button>
                    </h2>
                    <div id="filterAccordion" class="accordion-collapse collapse" data-bs-parent="#accordionFilter">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <select class="form-control select2 fixed-width" name="jurusan" data-toggle="tooltip" title="Filter Jurusan">
                                        <option selected disabled>-- Pilih Jurusan --</option>
                                        <option value="all">All</option>
                                        @foreach (App\Models\Jurusan::get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control select2 fixed-width" name="tahun" data-toggle="tooltip" title="Filter Tahun" disabled>
                                        <option selected disabled>-- Pilih Tahun --</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-3 alert alert-primary d-flex align-items-center" role="alert">
                                <i class="flex-shrink-0 bi bi-info-circle-fill me-2"></i>
                                <small>
                                    Filter yang Anda terapkan akan memengaruhi data yang akan dicetak dalam format PDF dan Excel.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <button class="btn btm-sm btn-success export-excel" data-toggle="tooltip" title="Export ke Excel"><i class="bi bi-file-earmark-excel"></i> Excel</button>
            <button class="btn btm-sm btn-danger export-pdf" data-toggle="tooltip" title="Export ke PDF & Print"><i class="bi bi-filetype-pdf"></i> PDF</button>
            <div class="mt-3 table-responsive" id="viewTable">
                <table class="table mt-2 table-hover table-bordered" id="barangsTable">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Harga (Satuan)</th>
                            <th scope="col">Kuantitas (Qty)</th>
                            <th scope="col">Sub total</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td colspan="7" class="text-center">Tabel tidak memiliki data</td>
                    </tbody>
                </table>
                <div class="modal fade" id="detailBarangModal" tabindex="-1" aria-labelledby="detailBarangModalLabel" aria-hidden="true" data-bs-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="detailBarangModalLabel">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body-detail">
                                {{-- modal body goes here. --}}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Default Table Example -->
            <div class="modal fade" id="ModalPenolakan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Penolakan</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="penolakanForm" method="post">
                                @csrf
                                @method('PUT')
                                <div class="mb-3 form-floating">
                                    <textarea class="form-control" id="penolakan" placeholder="Masukan alasan penolakan..." style="height: 120px" name="penolakan"></textarea>
                                    <label for="penolakan">Alasan Penolakan :<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="submitPenolakan">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- modal persetujan --}}
            <div class="modal fade" id="ModalPersetujuan" tabindex="-1" aria-labelledby="persetujuanModal" aria-hidden="true" data-bs-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="persetujuanModal">Persetujuan</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="persetujuanForm" method="post">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="persetujuan" class="form-label">Jumlah Barang :<span class="text-danger">*</span></label>
                                    <input type="text" inputmode="numeric" id="persetujuan" placeholder="Masukan jumlah barang " class="form-control" name="persetujuan" required min="0">
                                    <div class="invalid-feedback">
                                        <!-- Error message will be injected here -->
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <select name="jenis_anggaran" id="jenis-anggaran-persetujuan" class="form-control select2">
                                        <option selected disabled>-- Pilih Jenis Anggaran --</option>
                                        @foreach ($anggaran as $item)
                                        <option value={{ $item->id }}>{{ $item->jenis_anggaran }} - {{ $item->tahun }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="submitPersetujuan">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- end modal persetujuan  --}}

            {{-- modal edit barang --}}
            <div class="modal fade" id="ModalEditBarang" tabindex="-1" aria-labelledby="editDataBarang" aria-hidden="true" data-bs-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editDataBarang">Edit jumlah barang yang di setujui</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="EditJumlahBarangForm" method="post">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="EditJumlahBarang" class="form-label">Jumlah Barang :<span class="text-danger">*</span></label>
                                    <input type="text" inputmode="numeric" id="EditJumlahBarang" placeholder="Masukan jumlah barang " class="form-control" name="jumlahBarang" required min="0">
                                    <div class="invalid-feedback">
                                        <!-- Error message will be injected here -->
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <select name="jenis_anggaran" id="jenis-anggaran-edit" class="form-control select2">
                                        @foreach ($anggaran as $item)
                                        <option value={{ $item->id }}>
                                            {{ $item->jenis_anggaran }} - {{ $item->tahun }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="submitEditjumlahBarang">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end modal edit barang  --}}
        </div>
    </div>
    </div>
</section>
@endsection
@section('script')
<script>
    let barangsTable
    $(document).ready(function() {
        $(function() {
            loadData();
            filter();
            exportPdf();
            exportExcel();
        });

        function loadData() {
            let jurusanId = $('select[name=jurusan]').val();
            let tahun = $('select[name=tahun]').val();

            if (barangsTable !== undefined) {
                barangsTable.destroy();
                barangsTable.clear().draw();
            }

            barangsTable = $('#barangsTable').DataTable({
                responsive: true
                , searching: true
                , autoWidth: false
                , ordering: true
                , processing: true
                , serverSide: true
                , aLengthMenu: [
                    [5, 10, 25, 50, 100, 250, 500, -1]
                    , [5, 10, 25, 50, 100, 250, 500, "All"]
                ]
                , pageLength: 10
                , ajax: {
                    url: "{{ route('barang-acc.data') }}"
                    , method: "GET"
                    , data: {
                        jurusan: jurusanId
                        , tahun: tahun
                    , }
                , }
                , drawCallback: function(settings) {
                    $('table#barangsTable tr').on('click', '#detail', function(e) {
                        e.preventDefault();
                        let url = $(this).data('url');
                        let data = barangsTable.row($(this).parents('tr')).data();
                        show(data, url);
                    });

                    $('table#barangsTable tr').on('click', '#ubah', function(e) {
                        e.preventDefault();
                        let url = $(this).data('url');
                        let data = barangsTable.row($(this).parents('tr')).data();
                        edit(data, url);
                    });

                    $('table#barangsTable tr').on('click', '#acc', function(e) {
                        e.preventDefault();
                        let url = $(this).data('url');
                        let data = barangsTable.row($(this).parents('tr')).data();
                        acc(data, url);
                    });

                    $('table#barangsTable tr').on('click', '#reject', function(e) {
                        e.preventDefault();
                        let url = $(this).data('url');
                        let data = barangsTable.row($(this).parents('tr')).data();
                        reject(data, url);
                    });
                }
                , columns: [{
                        data: 'DT_RowIndex'
                        , name: 'DT_RowIndex'
                        , width: '1%'
                        , class: 'fixed-side text-center'
                        , orderable: true
                        , searchable: true
                    }
                    , {
                        data: 'name'
                        , name: 'name'
                        , orderable: false
                    }
                    , {
                        data: 'harga'
                        , name: 'harga'
                        , orderable: false
                    }
                    , {
                        data: 'stock'
                        , name: 'stock'
                        , orderable: false
                    }
                    , {
                        data: 'sub_total'
                        , name: 'sub_total'
                        , orderable: false
                    }
                    , {
                        data: 'status'
                        , name: 'status'
                        , orderable: false
                    }
                    , {
                        data: 'action'
                        , name: 'action'
                        , orderable: false
                    }
                , ]
            , });

            barangsTable.on('draw', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });
        }

        function filter() {
            let selectJurusan = $('select[name=jurusan]');
            let selectTahun = $('select[name=tahun]');

            selectJurusan.on('change', function() {
                let jurusanId = $(this).val();
                if (jurusanId !== 'all') {
                    $.ajax({
                        url: "{{ route('filter-jurusan') }}"
                        , method: "GET"
                        , data: {
                            jurusan_id: jurusanId
                        }
                        , success: function(data) {
                            if (data.length > 0) {
                                selectTahun.prop('disabled', false);
                                selectTahun.empty();
                                selectTahun.append('<option selected disabled>-- Pilih Tahun --</option>');
                                selectTahun.append('<option value="all">All</option>');
                                $.each(data, function(key, value) {
                                    selectTahun.append('<option value="' + value + '">' + value + '</option>');
                                });
                            } else {
                                selectTahun.prop('disabled', true);
                                selectTahun.empty();
                                selectTahun.append('<option selected disabled>-- Pilih Tahun --</option>');
                            }
                        }
                    });
                } else {
                    selectTahun.prop('disabled', true);
                    selectTahun.empty();
                    selectTahun.append('<option selected disabled>-- Pilih Tahun --</option>');
                }
                loadData();
            });

            selectTahun.on('change', function() {
                loadData();
            });
        }

        function exportPdf() {
            $('.export-pdf').on('click', function(e) {
                e.preventDefault();

                let jurusanId = $('select[name=jurusan]').val();
                let tahun = $('select[name=tahun]').val();

                window.open("{{ route('export.anggaran.export-pdf') }}?jurusan=" + jurusanId + "&tahun=" + tahun, '_blank');
            });
        }

        function exportExcel() {
            $('.export-excel').on('click', function(e) {
                e.preventDefault();

                let jurusanId = $('select[name=jurusan]').val();
                let tahun = $('select[name=tahun]').val();

                window.open("{{ route('export.anggaran.export-excel') }}?jurusan=" + jurusanId + "&tahun=" + tahun, '_blank');
            });
        }

        show = function(data, url) {

            if (data) {
                $('#detailBarangModalLabel').text(`Detail Barang ${data.name}`);
                $('.modal-body-detail').empty();

                let formattedExpiredDate = new Date(data.expired).toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });

                // kondisi anggaran
                let jenisAnggaran = data.anggaran
                    ? `${data.anggaran.jenis_anggaran} - ${data.anggaran.tahun}`
                    : '<small class="text-secondary">Jenis anggaran belum dialokasikan</small>';

                // susun tabel
                let tableContent = `
                    <table class="table table-bordered">
                        <tr>
                            <th>Kode</th>
                            <td>${data.no_inventaris}</td>
                        </tr>
                        <tr>
                            <th>Barang</th>
                            <td>${data.name}</td>
                        </tr>
                        <tr>
                            <th>Waktu Pengajuan</th>
                            <td>${data.created_at}</td>
                        </tr>
                        <tr>
                            <th>Bulan yang diinginkan</th>
                            <td>${formattedExpiredDate}</td>
                        </tr>
                        <tr>
                            <th>Tujuan Barang</th>
                            <td>${data.tujuan}</td>
                        </tr>
                        <tr>
                            <th>Jenis Barang</th>
                            <td>${data.jenis_barang}</td>
                        </tr>
                        <tr>
                            <th>Spek Teknis</th>
                            <td>${data.spek}</td>
                        </tr>
                        <tr>
                            <th>Harga Satuan</th>
                            <td>${data.harga}</td>
                        </tr>
                        <tr>
                            <th>Kuantitas (Qty)</th>
                            <td>${data.stock}</td>
                        </tr>
                        <tr>
                            <th>Satuan</th>
                            <td>${data.satuan}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>${data.original_status === 'Ditolak' ? data.status : data.keterangan_with_badge}</td>
                        </tr>
                        ${data.original_status === 'Ditolak' ? `
                        <tr>
                            <th>Keterangan</th>
                            <td>${data.keterangan}</td>
                        </tr>` : ''}
                        <tr>
                            <th>Sub Total</th>
                            <td>${data.sub_total}</td>
                        </tr>
                        <tr>
                            <th>Jenis Anggaran</th>
                            <td>${jenisAnggaran}</td>
                        </tr>
                    </table>`;

                $('.modal-body-detail').append(tableContent);

                // showing modal
                $('#detailBarangModal').modal('show');
            }
        }

        edit = function(data, url) {
            let stock = data.stock;
            let keterangan = data.keterangan;
            let jenisAnggaran = data.jenis_anggaran;

            $('#EditJumlahBarang').attr('max', stock);
            $('#EditJumlahBarang').val(keterangan);
            $('#jenis_anggaran option').removeAttr('selected');
            $('#jenis_anggaran option[value="' + jenisAnggaran + '"]').attr('selected', 'selected');

            $('#EditJumlahBarang').on('input', function() {
                let jumlahBarang = $(this).val();
                let errorText = $(this).siblings('.invalid-feedback');
                $(this).removeClass('is-invalid');
                $('#submitEditjumlahBarang').prop('disabled', false);

                jumlahBarang = jumlahBarang.replace(/[^0-9]/g, '');
                $(this).val(jumlahBarang);

                if (jumlahBarang > stock) {
                    $(this).addClass('is-invalid');
                    errorText.html('Jumlah barang tidak boleh lebih dari <b>' + stock + '.</b>');
                    $('#submitEditjumlahBarang').prop('disabled', true);
                } else if (jumlahBarang < 0) {
                    $(this).addClass('is-invalid');
                    errorText.text('Jumlah barang tidak boleh kurang dari 0.');
                }
            });

            $('#EditJumlahBarangForm').off('submit').on('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Loading',
                    text: 'Sedang memproses data...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });

                let jumlahBarang = $('#EditJumlahBarang').val();
                let jenisAnggaran = $('#jenis-anggaran-edit').val();

                $('#ModalEditBarang').modal('hide');

                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: {
                        _token: "{{ csrf_token() }}",
                        jumlah: jumlahBarang,
                        jenis_anggaran: jenisAnggaran
                    },
                    success: function(res) {
                        if (res.status == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: res.msg,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                        barangsTable.ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Gagal mengubah data!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            });

            $('#ModalEditBarang').modal('show');
        }

        acc = function(data, url) {
            let stock = data.stock;
            let keterangan = data.keterangan;
            let jenisAnggaran = data.jenis_anggaran;

            $('#jenis-anggaran option').removeAttr('selected');
            $('#jenis-anggaran option[value="' + jenisAnggaran + '"]').attr('selected', 'selected');

            $('#persetujuan').on('input', function() {
                let jumlahBarang = $(this).val();
                let errorText = $(this).siblings('.invalid-feedback');
                $(this).removeClass('is-invalid');
                $('#submitPersetujuan').prop('disabled', false);

                jumlahBarang = jumlahBarang.replace(/[^0-9]/g, '');
                $(this).val(jumlahBarang);

                if (jumlahBarang > stock) {
                    $(this).addClass('is-invalid');
                    errorText.html('Jumlah barang tidak boleh lebih dari <b>' + stock + '.</b>');
                    $('#submitPersetujuan').prop('disabled', true);
                } else if (jumlahBarang < 0) {
                    $(this).addClass('is-invalid');
                    errorText.text('Jumlah barang tidak boleh kurang dari 0.');
                }
            });

            $('#persetujuanForm').off('submit').on('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Loading',
                    text: 'Sedang memproses data...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });

                let jumlahBarang = $('#persetujuan').val();
                let jenisAnggaran = $('#jenis-anggaran-persetujuan').val();

                $('#ModalPersetujuan').modal('hide');

                $.ajax({
                    url: url,
                    type: "PUT",
                    data: {
                        _token: "{{ csrf_token() }}",
                        persetujuan: jumlahBarang,
                        jenis_anggaran: jenisAnggaran
                    },
                    success: function(res) {
                        if (res.status == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: res.msg,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                        barangsTable.ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            });

            $('#ModalPersetujuan').modal('show');
        }

        reject = function(data, url) {
            $('#ModalPenolakan').modal('show');

            $('#penolakanForm').off('submit').on('submit', function(e) {
                e.preventDefault();

                let penolakan = $('#penolakan').val().trim();

                if (penolakan === '') {
                    $('#penolakan').addClass('is-invalid');
                    if (!$('.invalid-feedback').length) {
                        $('#penolakan').after('<div class="invalid-feedback">Alasan penolakan wajib diisi.</div>');
                    }
                    return;
                } else {
                    $('#penolakan').removeClass('is-invalid');
                    $('.invalid-feedback').remove();
                }


                Swal.fire({
                    title: 'Loading',
                    text: 'Sedang memproses data...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });

                $('#ModalPenolakan').modal('hide');

                $.ajax({
                    url: url,
                    type: "PUT",
                    data: {
                        _token: "{{ csrf_token() }}",
                        penolakan: penolakan
                    },
                    success: function(res) {
                        if (res.status == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: res.msg,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                        barangsTable.ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                })
            });
        }
    });

</script>
@endsection
