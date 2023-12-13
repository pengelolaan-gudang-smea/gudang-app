@extends('layouts.dashboard.dashboard')
@section('content')
<section class="section">
    {{-- Sweetalert --}}
    @if (session('success'))
    <x-sweetalert :message="session('success')" />
    @endif
    <div class="card">
        <div class="card-body">
            <div class="row d-flex justify-content-between mt-5 mb-3">
                <div class="col-md-6">
                    <div class="form-group row d-flex align-items-center">
                        <label class="col-2">Jurusan</label>
                        <label class="col-1 text-right">:</label>
                        <div class="col-md-6">
                            <select class="form-control" name="jurusan">
                                <option selected disabled>-- Pilih Jurusan --</option>
                                @foreach (App\Models\Jurusan::get() as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row d-flex align-items-center justify-content-end">
                        <label class="col-2">Tahun</label>
                        <label class="col-1 ">:</label>
                        <div class="col-md-6">
                            <select class="form-control" name="tahun" disabled>
                                <option selected disabled>-Pilih Tahun-</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive" id="viewTable">
                <table class="table mt-2" id="barangsTable">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Harga (Satuan)</th>
                            <th scope="col">Kuantitas (Qty)</th>
                            <th scope="col">Sub total</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->name }}</td>
                            <td>{{ 'Rp ' . number_format($item->harga, 0, ',', '.') }}</td>
                            <td>{{ $item->satuan }}</td>
                            <td class="sub-total">{{ 'Rp ' . number_format($item->sub_total, 0, ',', '.') }}</td>

                            <td>
                                @if($item->status == 'Disetujui')
                                <span class="badge bg-success">{{ $item->status }}</span>
                                @elseif($item->status != 'Disetujui' && $item->status != 'Belum disetujui' )
                                <span class="badge bg-danger">Ditolak</span>
                                @elseif($item->status == 'Belum disetujui')
                                <span class="badge bg-warning text-white">{{ $item->status }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-3">
                                    <div>
                                        <button type="button" data-barang="{{ $item->slug }}" class="btn btn-sm bg-primary link-light detailBarangBtn" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    @if($item->status != 'Disetujui')
                                    <div>
                                        <form action="{{ route('barang-acc.update', ['acc' => $item->slug]) }}" method="POST">
                                            @method('PUT')
                                            @csrf
                                            <input type="hidden" name="status" value="Disetujui">
                                            <button class="bi bi-check fw-bold btn btn-sm bg-success link-light" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-title="Setujui"></button>
                                        </form>
                                    </div>
                                    @endif
                                    
                                    @if($item->status == 'Disetujui' || $item->status == 'Belum disetujui' )
                                    <div>
                                            <button class="bi bi-x fw-bold btn btn-sm bg-danger link-light penolakan" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-title="Tolak" data-bs-target="#ModalPenolakan" data-slug="{{ $item->slug }}"></button>
                                    </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="modal fade" id="detailBarangModal" tabindex="-1" aria-labelledby="detailBarangModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
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
            </div>
            <!-- End Default Table Example -->
            <div class="modal fade" id="ModalPenolakan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Status</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="penolakanForm" method="post">
                                @csrf
                                @method('PUT')
                                <label for="penolakan" class="col-sm-2 col-form-label">Penolakan<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" id="penolakan" placeholder="Masukan alasan penolakan barang"
                                        class="form-control" name="status"
                                        required>
                                   
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="submitPenolakan">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        $(document).ready(function() {
            $('[data-bs-toggle="popover"]').popover();
            $('select[name=jurusan]').select2({
                theme: "bootstrap-5"
            })
            $('select[name=jurusan]').change(function() {
                let jurusan = $(this).val();
                $.ajax({
                    url: '{{ route('filter-jurusan') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        jurusan: jurusan
                    },
                    success: function(data) {
                        const filterTahun = $('select[name=tahun]');
                        filterTahun.html('');
                        if (data.length > 0) {
                            var options = '';
                            options += '<option selected disabled>-- Pilih Tahun --</option>';
                            $.each(data, function(index, tahun) {
                                options += '<option value="' + tahun + '">' + tahun + '</option>';
                            });
                            filterTahun.append(options);
                            filterTahun.attr('disabled', false);
                            filterTahun.select2({
                                theme: "bootstrap-5"
                            });
                            filterTahun.change(function() {
                                const selectedTahun = filterTahun.val();
                                updateTabel(jurusan, selectedTahun);
                            });
                        }
                    }
                });
            });

            $('.detailBarangBtn').click(function() {
                const barangId = $(this).data('barang');
                $.ajax({
                    type: 'GET',
                    url: '/dashboard/barang-acc/' + barangId,
                    success: function(response) {
                        if (response.status == 'success') {
                            $('#detailBarangModalLabel').text(`Detail Barang ${response.barang.name}`);
                            $('.modal-body').empty();
                            // Menggunakan formatRupiah untuk harga dan sub_total
                            const formattedHarga = formatRupiah(response.barang.harga);
                            const formattedSubTotal = formatRupiah(response.barang.sub_total);
                            const statusBadgeClass = getStatusBadgeClass(response.barang.status);

                            const badgeElement = $(`<span class="badge ${statusBadgeClass}">${response.barang.status}</span>`);

                            const listGroup = $(`<ul class="list-group">
                                                    <li class="list-group-item"><small>Nama Barang :</small><br> ${response.barang.name}</li>
                                                    <li class="list-group-item"><small>Waktu Pengajuan :</small><br> ${response.barang.created_at_formatted}</li>
                                                    <li class="list-group-item"><small>Spek Teknis :</small><br> ${response.barang.spek}</li>
                                                    <li class="list-group-item"><small>Harga Satuan :</small><br>Rp ${response.barang.harga}</li>
                                                    <li class="list-group-item"><small>Kuantitas (Qty) :</small><br> ${response.barang.satuan}</li>
                                                    <li class="list-group-item"><small>Status :</small><br></li>
                                                    <li class="list-group-item"><small>Sub Total :</small><br>Rp ${response.barang.sub_total}</li>
                                                </ul>`);

                            listGroup.find('li:contains("Status :")').append(badgeElement);
                            listGroup.find('li:contains("Harga Satuan :")').html(`<small>Harga Satuan :</small><br>${formattedHarga}`);
                            listGroup.find('li:contains("Sub Total :")').html(`<small>Sub Total :</small><br>${formattedSubTotal}`);

                            $('.modal-body').append(listGroup);

                            $('#detailBarangModal').modal('show');
                        } else {
                            // Handle other cases
                        }

                        function formatRupiah(angka) {
                            return new Intl.NumberFormat('id-ID', {
                                style: 'currency'
                                , currency: 'IDR'
                            }).format(angka);
                        }

                        function getStatusBadgeClass(status) {
                            if (status === 'Belum disetujui') {
                                return 'bg-warning text-dark';
                            } else if (status === 'Disetujui') {
                                return 'bg-success';
                            } else   {
                                return 'bg-danger';
                            }
                        }
                    },
                    error: function(e) {
                        console.error(e);
                    }
                });
            });

            $('.penolakan').click(function(){
            const slug = $(this).data('slug');
            const form = $('#ModalPenolakan').find('form#penolakanForm');
            const actionUrl = `/dashboard/barang-acc/${slug}`;

            form.attr('action', actionUrl);
            form.find('#penolakan').val(''); // Bersihkan nilai input sebelum menampilkan modal
            $('#ModalPenolakan').modal('show');
        });

            // $('#ModalPenolakan').on('show.bs.modal', function(event) {
            //         const button = $(event.relatedTarget);
            //         const slug = button.data('slug');
            //         const form = $(this).find('form#penolakanForm');
            //         const actionUrl = `/dashboard/barang-acc/${slug}`;
            //         form.attr('action', actionUrl);
            //         console.log(form);
            //     });

                $('#submitPenolakan').on('click', function() {
                    // Lakukan sesuatu jika tombol 'Simpan' diklik
                    $('#penolakanForm').submit(); // Submit form
                });

            function updateTabel(jurusan, selectedTahun) {
                $("#viewTable").html(``)
                $("#viewTable").html(`<table class="table mt-2" id="barangsTable">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">#</th>
                                                    <th scope="col">Nama</th>
                                                    <th scope="col">Harga (Satuan)</th>
                                                    <th scope="col">Kuantitas (Qty)</th>
                                                    <th scope="col">Sub total</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            </table>`);
                $('#barangsTable').DataTable({
                    processing: true
                    , serverSide: true
                    , responsive: true
                    , pageLength: 25
                    , "paging": true
                    , "order": [
                        [0, "asc"]
                    ]
                    , ajax: {
                        "url": "{{ route('filter-barang') }}"
                        , "type": "POST"
                        , "data": {
                            "_token": "{{ csrf_token() }}"
                            , "jurusan": jurusan
                            , "tahun": selectedTahun
                        }
                    , }
                    , columns: [{
                            data: 'DT_RowIndex'
                            , orderable: false
                            , searchable: false
                            , width: "8%"
                            , className: "text-center"
                        }
                        , {
                            data: 'nama'
                            , className: "text-center"
                        }
                        , {
                            data: 'harga'
                            , className: "text-center"
                        }
                        , {
                            data: 'satuan'
                            , className: "text-center"
                        }
                        , {
                            data: 'sub_total'
                            , className: "text-center"
                        },
                        {
                            data: 'status',
                            className: "text-center",
                            render: function (data, type, row) {
                                // Implementasi badge sesuai dengan nilai status
                                let badgeClass = '';
                                if (data === 'Disetujui') {
                                    badgeClass = 'badge text-success';
                                } else if (data === 'Ditolak') {
                                    badgeClass = 'badge text-danger';
                                } else {
                                    badgeClass = 'badge text-warning';
                                }
                                return '<span class="' + badgeClass + '">' + data + '</span>';
                            }
                        },
                        {
                            data: 'action',
                            render: function (data, type, row) {
                                let slug = row.action;
                                let buttons = '<div class="d-flex gap-3">';
                                buttons += '<div>';
                                buttons += '<form action="{{ route('barang-acc.update', '') }}/' + slug + '" method="POST">';
                                buttons += '@method("PUT")';
                                buttons += '@csrf';
                                buttons += '<input type="hidden" name="status" value="Disetujui">';
                                buttons += '<button class="bi bi-check fw-bold btn btn-sm bg-success link-light" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-title="Setujui"></button>';
                                buttons += '</form>';
                                buttons += '</div>';
                                buttons += '<div>';
                                buttons += '<form action="{{ route('barang-acc.update', '') }}/' + slug + '" method="POST">';
                                buttons += '@csrf';
                                buttons += '@method("PUT")';
                                buttons += '<input type="hidden" name="status" value="Ditolak">';
                                buttons += '<button class="bi bi-x fw-bold btn btn-sm bg-danger link-light" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-title="Tolak"></button>';
                                buttons += '</form>';
                                buttons += '</div>';
                                buttons += '</div>';

                                return buttons;
                            }
                        }
                    ]
                    , "language": {
                        "paginate": {
                            "previous": 'Previous'
                            , "next": 'Next'
                        }
                    }
                });
            }

            let table = new DataTable('#barangsTable');
        });

    </script>
</section>
@endsection
