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
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#filterAccordion" aria-expanded="true" aria-controls="filterAccordion">
                                <i class="bi bi-funnel-fill me-2"></i> <b>Filter</b>
                            </button>
                        </h2>
                        <div id="filterAccordion" class="accordion-collapse collapse show" data-bs-parent="#accordionFilter">
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
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                    <button class="btn btm-sm btn-success"><i class="bi bi-file-earmark-excel"></i> Excel</button>
                    <button class="btn btm-sm btn-danger"><i class="bi bi-filetype-pdf"></i> PDF</button>
                    <button class="btn btm-sm btn-info text-light"><i class="bi bi-printer"></i> Print</button>
                <div class="table-responsive mt-3" id="viewTable">
                    <table class="table table-hover table-bordered mt-2" id="barangsTable">
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
                    <div class="modal fade" id="detailBarangModal" tabindex="-1" aria-labelledby="detailBarangModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="detailBarangModalLabel">Modal title</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
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
                <div class="modal fade" id="ModalPenolakan" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true" data-bs-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Penolakan</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="penolakanForm" method="post">
                                    @csrf
                                    @method('PUT')
                                    <label for="penolakan" class="col-sm-2 col-form-label">Penolakan<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" id="penolakan"
                                            placeholder="Masukan alasan penolakan barang" class="form-control"
                                            name="penolakan" required>

                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="submitPenolakan">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- modal persetujan --}}
                <div class="modal fade" id="ModalPersetujuan" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true" data-bs-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Persetujuan</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="persetujuanForm" method="post">
                                    @csrf
                                    @method('PUT')
                                    <label for="penolakan" class="col-sm-2 col-form-label">Setuju<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-10 mb-3">
                                        <input type="number" id="persetujuan" placeholder="Masukan jumlah barang "
                                            class="form-control" name="persetujuan" required min="0">
                                            @error('persetujuan')
                                                <small>{{ $message }}</small>
                                            @enderror
                                    </div>
                                    <div class="col-sm-10">
                                        <select name="jenis_anggaran" id="" class="form-select">
                                            <option selected>-- jenis anggaran --</option>
                                            @foreach ($anggaran as $item)
                                                <option value="{{ $item->id }}">{{ $item->jenis_anggaran }} - {{ $item->tahun }}</option>
                                            @endforeach
                                        </select>
                                        @error('jenis_anggaran')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="submitPersetujuan">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- end modal persetujuan  --}}

                {{-- modal edit barang --}}
                <div class="modal fade" id="ModalEditBarang" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true" data-bs-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit jumlah barang yg di setujui</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="EditJumlahBarangForm" method="post">
                                    @csrf
                                    @method('PUT')
                                    <label for="EditJumlahBarang" class="col-sm-2 col-form-label">Jumlah Barang<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-10 mb-3">
                                        <input type="number" id="jumlahBarang" placeholder="Masukan jumlah barang "
                                            class="form-control" name="jumlahBarang" required min="0">
                                    </div>
                                    <div class="col-sm-10">
                                        <select name="jenis_anggaran" id="jenis-anggaran" class="form-select">
                                            <option selected>-- jenis anggaran --</option>
                                            @foreach ($anggaran as $item)
                                                <option value={{ $item->id }}>{{ $item->jenis_anggaran }} - {{ $item->tahun }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary"
                                    id="submitEditjmulahBarang">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- end modal persetujuan  --}}
            </div>
        </div>
        </div>
        {{-- <script>
            $(document).ready(function() {
                $('.detailBarangBtn').click(function() {
                    const barangId = $(this).data('barang');
                    $.ajax({
                        type: 'GET',
                        url: '/dashboard/barang-acc/' + barangId,
                        success: function(response) {
                            console.log(response.barang);
                            if (response.status == 'success') {
                                $('#detailBarangModalLabel').text(
                                    `Detail Barang ${response.barang.name}`);
                                $('.modal-body-detail').empty();
                                // Menggunakan formatRupiah untuk harga dan sub_total
                                const formattedHarga = formatRupiah(response.barang.harga);
                                const formattedSubTotal = formatRupiah(response.barang.sub_total);
                                const statusBadgeClass = getStatusBadgeClass(response.barang
                                .status);
                                let badgeElement = '';

                                if (response.barang.status === 'Disetujui') {
                                    badgeElement = $(
                                        `<span class="badge ${statusBadgeClass}">${response.barang.keterangan} barang disetujui</span>`
                                    );
                                } else {
                                    badgeElement = $(
                                        `<span class="badge ${statusBadgeClass}">${response.barang.keterangan}</span>`
                                    );
                                }
                                let JenisAnggaran = '';
                                let TujuanBarang = '';
                                if (response.barang.anggaran !== null && response.barang
                                    .tujuan !== null) {
                                    JenisAnggaran = response.barang.anggaran;
                                    TujuanBarang = response.barang.tujuan;
                                } else {
                                    JenisAnggaran = '-';
                                    TujuanBarang = '-';
                                }


                                const listGroup = $(`<ul class="list-group">
                                    <li class="list-group-item"><small>Nama Barang :</small><br> ${response.barang.name}</li>
                                                    <li class="list-group-item"><small>Waktu Pengajuan :</small><br> ${response.barang.created_at_formatted}</li>
                                                    <li class="list-group-item"><small>Bulan yang di inginkan  :</small><br> ${response.barang.expired_formatted}</li>
                                                    <li class="list-group-item"><small>Tujuan Barang  :</small><br> ${TujuanBarang}</li>
                                                    <li class="list-group-item"><small>Jenis Barang  :</small><br> ${response.barang.jenis_barang}</li>
                                                    <li class="list-group-item"><small>Spek Teknis :</small><br> ${response.barang.spek}</li>
                                                    <li class="list-group-item"><small>Harga Satuan :</small><br>Rp ${response.barang.harga}</li>
                                                    <li class="list-group-item"><small>Kuantitas (Qty) :</small><br> ${response.barang.stock}</li>
                                                    <li class="list-group-item"><small>Satuan  :</small><br> ${response.barang.satuan}</li>
                                                    <li class="list-group-item"><small>Status :</small><br></li>
                                                    <li class="list-group-item"><small>Jenis Anggaran :</small><br>${response.barang.anggaran.jenis_anggaran} - ${response.barang.anggaran.tahun} </li>
                                                </ul>`);

                                listGroup.find('li:contains("Status :")').append(badgeElement);
                                listGroup.find('li:contains("Harga Satuan :")').html(
                                    `<small>Harga Satuan :</small><br>${formattedHarga}`);
                                listGroup.find('li:contains("Sub Total :")').html(
                                    `<small>Sub Total :</small><br>${formattedSubTotal}`);

                                $('.modal-body-detail').append(listGroup);

                                $('#detailBarangModal').modal('show');
                            } else {
                                // Handle other cases
                            }

                            function formatRupiah(angka) {
                                return new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR'
                                }).format(angka);
                            }

                            function getStatusBadgeClass(status) {
                                if (status === 'Belum disetujui') {
                                    return 'bg-warning text-dark';
                                } else if (status === 'Disetujui') {
                                    return 'bg-success';
                                } else {
                                    return 'bg-danger';
                                }
                            }
                        },
                        error: function(e) {
                            console.error(e);
                        }
                    });
                });

                $('.penolakan').click(function() {
                    const slug = $(this).data('slug');
                    const form = $('#ModalPenolakan').find('form#penolakanForm');
                    const actionUrl = `/dashboard/barang-acc/${slug}`;

                    form.attr('action', actionUrl);
                    form.find('#penolakan').val(''); // Bersihkan nilai input sebelum menampilkan modal
                    $('#ModalPenolakan').modal('show');
                });

                $('#submitPenolakan').on('click', function() {
                    // Lakukan sesuatu jika tombol 'Simpan' diklik
                    $('#penolakanForm').submit(); // Submit form
                });
                // persetujuan
                $('.persetujuan').click(function() {
                    const slug = $(this).data('slug');
                    const satuan = $(this).data('satuan');
                    console.log(satuan);
                    const form = $("#ModalPersetujuan").find('form#persetujuanForm');
                    const action = `/dashboard/barang-acc/${slug}`;
                    form.attr('action', action);
                    $('#persetujuan').attr('max', satuan)
                    $('#persetujuan').on('input', function() {
                        let persetujuan = $('#persetujuan')
                        if (persetujuan.val() < 0) {
                            persetujuan.val('')
                        } else if (persetujuan.val() > satuan) {
                            persetujuan.val(satuan)
                        }
                    })
                    $('#ModalPersetujuan').modal('show')
                });
                $('#submitPersetujuan').on('click', function() {
                    $('#persetujuanForm').submit()
                })

                $('.EditJumlahBarang').click(function() {
                    const slug = $(this).data('slug');
                    const satuan = $(this).data('satuan');
                    const keterangan = $(this).data('keterangan');
                    const jenisAnggaran = $(this).data('jenisanggaran')
                    console.log(jenisAnggaran);
                    const form = $('#ModalEditBarang').find('form#EditJumlahBarangForm')
                    const action = `/dashboard/barang-accepted/${slug}`;
                    form.attr('action', action);
                    $('#jumlahBarang').attr('max', satuan);
                    $('#jumlahBarang').val(keterangan)
                    $('#jenis-anggaran option').removeAttr('selected');
                    $('#jenis-anggaran option[value="' + jenisAnggaran + '"]').attr('selected', 'selected');
                    $('#jumlahBarang').on('input', function() {
                        let jumlahBarang = $('#jumlahBarang');
                        if (jumlahBarang.val() < 0) {
                            jumlahBarang.val('')
                        } else if (jumlahBarang.val() > satuan) {
                            jumlahBarang.val(satuan)
                        }
                    });
                    $('#ModalEditBarang').modal('show')
                })
                $('#submitEditjmulahBarang').click(function() {
                    $('#EditJumlahBarangForm').submit()
                })
            });
        </script> --}}
    </section>
@endsection
@section('script')
    <script>
    let barangsTable
    $(document).ready(function() {
        $(function() {
            loadData();
            filter();
        });

        function loadData() {
            let jurusanId = $('select[name=jurusan]').val();
            let tahun = $('select[name=tahun]').val();

            if (barangsTable !== undefined) {
                barangsTable.destroy();
                barangsTable.clear().draw();
            }

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
                    url: "{{ route('barang-acc.data') }}",
                    method: "GET",
                    data: {
                        jurusan: jurusanId,
                        tahun: tahun,
                    },
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
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', width: '1%', class: 'fixed-side text-center', orderable: true, searchable: true },
                    { data: 'name', name: 'name', orderable: false },
                    { data: 'harga', name: 'harga', orderable: false },
                    { data: 'stock', name: 'stock', orderable: false },
                    { data: 'sub_total', name: 'sub_total', orderable: false },
                    { data: 'status', name: 'status', orderable: false },
                    { data: 'action', name: 'action', orderable: false },
                ],
            });

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
                        url: "{{ route('filter-jurusan') }}",
                        method: "GET",
                        data: { jurusan_id: jurusanId },
                        success: function(data) {
                            if (data.length > 0) {
                                selectTahun.prop('disabled', false);
                                selectTahun.empty();
                                selectTahun.append('<option selected disabled>-- Pilih Tahun --</option>');
                                selectTahun.append('<option value="all">All</option>');
                                $.each(data, function(key, value) {
                                    selectTahun.append('<option value="'+ value +'">'+ value +'</option>');
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

        show = function(data, url) {
            console.log(data);

            if (data) {
                $('#detailBarangModalLabel').text(`Detail Barang ${data.name}`);
                $('.modal-body-detail').empty();

                let expiredDate = new Date(data.expired);
                let formattedExpiredDate = expiredDate.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
                let jenisAnggaran = data.anggaran ? data.anggaran.jenis_anggaran + ' - ' + data.anggaran.tahun : '<small class="text-secondary">Jenis anggaran belum dialokasikan</small>';

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
                            <td>${data.keterangan_with_badge}</td>
                        </tr>
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
