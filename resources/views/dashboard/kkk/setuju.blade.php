@extends('layouts.dashboard.dashboard')
@section('content')
<section class="section">
    {{-- Sweetalert --}}
    @if (session('success'))
    <x-sweetalert :message="session('success')" />
    @endif
    <div class="card">
        <div class="card-body">

            <!-- Default Table -->
            <div class="table-responsive my-3">
                <table class="table mt-2" id="barangsTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Harga (Satuan)</th>
                            <th scope="col">Satuan (Qty)</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->name }}</td>
                            <td>{{ 'Rp ' . number_format($item->harga, 0, ',', '.') }}</td>
                            <td>{{ $item->satuan }}</td>
                            <td>
                                @if($item->status == 'Disetujui')
                                <span class="badge bg-success">{{ $item->status }}</span>
                                @elseif($item->status == 'Ditolak')
                                <span class="badge bg-danger">{{ $item->status }}</span>
                                @elseif($item->status == 'Belum disetujui')
                                <span class="badge bg-warning text-white">{{ $item->status }}</span>
                                @endif
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
    <script>
        let table = new DataTable('#barangsTable');

    </script>
</section>
@endsection
