@extends('layouts.dashboard.dashboard')
@section('content')
<section class="section">
    {{-- Sweetalert --}}
    @if (session('success'))
    <x-sweetalert :message="session('success')" />
    @endif
    <div class="card">
        <div class="card-body">
            <div class="accordion my-3" id="accordionFilter">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#filterTanggalAccordion" aria-expanded="true" aria-controls="filterTanggalAccordion">
                            <i class="bi bi-funnel-fill me-2"></i> <b>Filter</b>
                        </button>
                    </h2>
                    <div id="filterTanggalAccordion" class="accordion-collapse collapse show" data-bs-parent="#accordionFilter">
                        <div class="accordion-body">
                            <form method="GET" id="formFilter">
                                <div class="d-flex justify-content-center mb-2">
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group">
                                                <span class="input-group-text" id="filterDateInput"><i class="bi bi-calendar-range-fill"></i></span>
                                                <input type="text" name="filter_date" class="form-control" placeholder="Filter Tanggal" autocomplete="off" aria-describedby="filterDateInput" data-toggle="tooltip" title="Filter Tanggal">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="input-group">
                                                <span class="input-group-text" id="filterStatusInput"><i class="bi bi-activity"></i></span>
                                                <select name="filter_status" id="filter_status" class="form-control" data-toggle="tooltip" title="Filter Status">
                                                    <option value="all" >Semua</option>
                                                    <option value="Disetujui">Disetujui</option>
                                                    <option value="Belum disetujui">Belum Disetujui</option>
                                                    <option value="Ditolak">Ditolak</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary"><i class="bi bi-funnel"></i> Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('pengajuan-barang.create') }}" class="btn btn-primary my-3 {{ ($grand_total >= $limit) ? 'disabled': ''}}"> <i class="bi bi-box2-fill"></i>
                Ajukan
                barang</a>
                @if ($grand_total == $limit)
                    <small class="text-danger">Limit telah tercapai</small>
                @endif

                <button class="btn btn-success"><i class="bi bi-file-earmark-arrow-up"></i> Import</button>
            <div class="table-responsive">
                <table class="table table-hover table-bordered mt-2" id="barangsTable">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Waktu Pengajuan</th>
                            <th scope="col">Harga (Satuan)</th>
                            <th scope="col">Kuantitas (Qty)</th>
                            <th scope="col">Status</th>
                            <th scope="col">Sub Total</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td colspan="7" class="text-center">Tabel tidak memiliki data</td>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6" class="text-right"></th>
                            <th colspan="2" class="text-right"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    </div>
    <div class="modal fade" id="detailBarangModal" tabindex="-1" aria-labelledby="detailBarangModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="detailBarangModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
    <script>
    let barangsTable
    let startDate = ''
    let endDate = ''
    $(document).ready(function() {
        let total = "{{ number_format($grand_total, 0, ',', '.') }}";
        let limit = "{{ number_format($limit, 0, ',', '.') }}";
        let sisa = "{{ number_format($sisa, 0, ',', '.') }}";

        $('input[name="filter_date"]').on('apply.daterangepicker', function(ev, picker) {
            startDate = picker.startDate.format('YYYY-MM-DD');
            endDate = picker.endDate.format('YYYY-MM-DD');
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });

        $('input[name="filter_date"]').on('cancel.daterangepicker', function(ev, picker) {
            startDate = '';
            endDate = '';
            $(this).val('');
        });

        $('form#formFilter').on('submit', function(e) {
            e.preventDefault();
            loadData();
        });

        $(function() {
            loadData();
        });

        function loadData() {
            if (barangsTable !== undefined) {
                barangsTable.destroy();
                barangsTable.clear().draw();
            }

            let status = $('select[name="filter_status"]').val();

            barangsTable = $('#barangsTable').DataTable({
                responsive: true,
                searching: true,
                autoWidth: false,
                ordering: true,
                processing: true,
                serverSide: true,
                aLengthMenu: [
                    [5, 10, 25, 50, 100, 250, 500, -1],
                    [5, 10, 25, 50, 100, 250, 500, "All"]
                ],
                pageLength: 10,
                ajax: {
                    url: "{{ route('pengajuan-barang.data') }}",
                    method: "GET",
                    data: {
                        startDate: startDate ? startDate : null,
                        endDate: endDate ? endDate : null,
                        status: status ? status : null
                    }
                },
                drawCallback: function(settings) {
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

                    $('table#barangsTable tr').on('click', '#hapus', function(e) {
                        e.preventDefault();
                        let data = barangsTable.row($(this).parents('tr')).data();
                        let url = $(this).data('url');
                        destroy(data, url);
                    });
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', width: '1%', orderable: true, searchable: true },
                    { data: 'name', name: 'name', orderable: false },
                    { data: 'created_at', name: 'created_at', orderable: false },
                    { data: 'harga', name: 'harga', orderable: false },
                    { data: 'stock', name: 'stock', orderable: false },
                    { data: 'status', name: 'status', orderable: false },
                    { data: 'sub_total', name: 'sub_total', orderable: false },
                    { data: 'action', name: 'action', orderable: false },
                ],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();

                    $(api.column(5).footer()).css({
                        'text-align': 'right',
                        'padding-right': '10px'
                    }).html(
                        '<strong>Total Keseluruhan :</strong>' +
                        '<br/>Total Anggaran :' +
                        '<br/>Sisa Anggaran :'
                    );

                    $(api.column(6).footer()).html(
                        'Rp ' + total + ',00' +
                        '<br/> Rp ' + limit + ',00' +
                        '<br/> Rp ' + sisa + ',00'
                    );
                }
            });

            barangsTable.on('draw', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });
        }

        show = function(data, url) {
            if (data) {
                $('#detailBarangModalLabel').text(`Detail Barang ${data.name}`);
                $('.modal-body').empty();

                let expiredDate = new Date(data.expired);
                let formattedExpiredDate = expiredDate.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });

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
                            <td>${data.status}</td>
                        </tr>
                        <tr>
                            <th>Sub Total</th>
                            <td>${data.sub_total}</td>
                        </tr>
                    </table>`;

                $('.modal-body').append(tableContent);
                $('#detailBarangModal').modal('show');
            }
        }

        edit = function(data, url) {
            window.location.href = url
        }

        destroy = function(data, url) {
            Swal.fire({
                title: 'Apakah anda yakin?'
                , text: "Ingin menghapus data ini?"
                , icon: 'warning'
                , showCancelButton: true
                , confirmButtonColor: '#0D6EFD'
                , cancelButtonColor: '#DC3545'
                , confirmButtonText: 'Ya!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url
                        , data: {
                            _token: "{{ csrf_token() }}"
                            , _method: "delete"
                        }
                        , type: 'POST'
                        , success: function(res) {
                            if (res.status == 'success') {
                                Swal.fire({
                                    icon: 'success'
                                    , title: 'Berhasil'
                                    , text: res.msg
                                    , showConfirmButton: false
                                    , timer: 1500
                                })
                            }
                            barangsTable.ajax.reload(null, false)
                        }
                        , error: function(err) {
                            Swal.fire({
                                    icon: 'error'
                                    , title: 'Gagal'
                                    , text: err
                                    , showConfirmButton: false
                                    , timer: 1500
                                })
                        }
                    })
                }
            })
        }
    });
    </script>
@endsection
