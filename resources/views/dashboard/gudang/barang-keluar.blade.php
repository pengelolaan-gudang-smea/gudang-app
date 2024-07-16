@extends('layouts.dashboard.dashboard')
@section('content')
<section class="section">
    {{-- Sweetalert --}}

    <div class="card">
        <div class="card-body p-2">

            <!-- Default Table -->
            <div class="table-responsive">
                <table class="table mt-2" id="barangsTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Nama pengambil</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Tujuan</th>
                            <th scope="col">Tanggal </th>
                            <th scope="col">Qr Code</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->nama_barang }}</td>
                            <td>{{ $item->nama_pengambil }}</td>
                            <td>{{ $item->jumlah_pengambilan }}</td>
                            <td>{{ $item->tujuan }}</td>
                            <td>{{ Carbon\Carbon::parse($item->tgl_pengambilan)->translatedFormat('d F Y')}}</td>
                            <td>
                                <button type="button" class="btn qrKeluar" data-bs-toggle="modal" data-bs-target="#ModalQr" data-qr="{{ asset('storage/' . $item->qrCode) }}">
                                    <img src="{{ asset('storage/' . $item->qrCode) }}" alt="" width="50">
                                </button>

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

    <div class="modal fade" id="ModalQr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Qr Code</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="modalQrImage" src="" alt="QR Code" width="40%" class="mx-auto">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="printQrCode"><i class="bi bi-printer-fill"></i></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        let table = new DataTable('#barangsTable');
        $(document).ready(function () {
    $('#ModalQr').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);
        const qrCodeUrl = button.data('qr');
        $('#modalQrImage').attr('src', qrCodeUrl); 
    });
    $('#printQrCode').click(function() {
        const qrCodeSrc = $('#modalQrImage').attr('src');
        const printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>Print QR Code</title></head><body>');
        printWindow.document.write('<img src="' + qrCodeSrc + '" alt="QR Code" width="50%">');
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    });
});
    </script>
</section>
@endsection
