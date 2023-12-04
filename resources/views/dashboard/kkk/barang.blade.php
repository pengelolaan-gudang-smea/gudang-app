@extends('layouts.dashboard.dashboard')
@section('content')
<section class="section">
    {{-- Sweetalert --}}
    @if (session('success'))
    <x-sweetalert :message="session('success')" />
    @endif
    <div class="card">
        <div class="card-body">
            <a href="{{ route('pengajuan-barang.create') }}" class="btn btn-primary my-3 {{ ($grand_total >= $limit) ? 'disabled': ''}}"> <i class="bi bi-box2-fill"></i>
                Ajukan
                barang</a>
                @if ($grand_total == $limit)
                <small class="text-danger">Limit telah tercapai</small>
                @endif
            <!-- Default Table -->
            <div class="table-responsive">
                <table class="table mt-2" id="barangsTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Harga (Satuan)</th>
                            <th scope="col">Kuantitas (Qty)</th>
                            <th scope="col">Status</th>
                            <th scope="col">Sub Total</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->name }}</td>
                            <td class="harga">{{ 'Rp ' . number_format($item->harga, 0, ',', '.') }}</td>
                            <td class="satuan">{{ $item->satuan }}</td>
                            <td>
                                @if($item->status == 'Disetujui')
                                    <span class="badge bg-success">{{ $item->status }}</span>
                                @elseif($item->status == 'Ditolak')
                                    <span class="badge bg-danger">{{ $item->status }}</span>
                                @elseif($item->status == 'Belum disetujui')
                                    <span class="badge bg-warning text-white">{{ $item->status }}</span>
                                @endif
                            </td>

                            <td class="sub-total">{{ 'Rp ' . number_format($item->sub_total, 0, ',', '.') }}</td>
                            <td>
                                <div class="d-flex gap-3">
                                    <div>
                                        <button type="button" data-barang="{{ $item->slug }}" class="btn btn-sm bg-primary link-light detailBarangBtn" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <div>
                                        <a href="{{ route('pengajuan-barang.edit', ['barang' => $item->slug]) }}" class="btn btn-sm bg-warning link-light" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-sm btn-danger link-light deleteBarangBtn" data-barang="{{ $item->name }}" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-title="Hapus">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                        <form action="{{ route('pengajuan-barang.destroy', ['barang' => $item->slug]) }}"
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
                <p class="fw-bold mb-0">Total Keseluruhan : Rp {{ number_format($grand_total, 0, ',', '.') }},00 dari Rp {{number_format($limit, 0, ',','.')  }},00</p>
                <p>Sisa Anggaran : Rp {{ number_format($sisa, 0, ',','.') }},00</p>
            </div>
            <!-- End Default Table Example -->
        </div>
    </div>
    </div>
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
    <script>
        let table = new DataTable('#barangsTable');
        $('[data-bs-toggle="popover"]').popover();
        $(document).ready(function() {
            $('.detailBarangBtn').click(function() {
                const barangId = $(this).data('barang');
                $.ajax({
                    type: 'GET'
                    , url: '/dashboard/pengajuan-barang/' + barangId
                    , success: function(response) {
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
                            } else if (status === 'Ditolak') {
                                return 'bg-danger';
                            }
                        }

                    }
                , });
            });

            $('.deleteBarangBtn').click(function() {
                const barang = $(this).data('barang');
                console.log(barang);
                Swal.fire({
                    title: 'Anda yakin?'
                    , text: "Anda tidak bisa mengembalikan data ini!"
                    , icon: 'warning'
                    , showCancelButton: true
                    , confirmButtonColor: '#3085d6'
                    , cancelButtonColor: '#d33'
                    , confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const deleteBarangForm = $(`.deleteBarangForm[data-barang="${barang}"]`);
                        deleteBarangForm.submit();
                    }
                });
            });
        });

        const harga = document.querySelectorAll('.harga');
        const sub_total = document.querySelectorAll('.sub-total');

    </script>
</section>
@endsection
