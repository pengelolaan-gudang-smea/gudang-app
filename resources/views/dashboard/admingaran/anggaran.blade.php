@extends('layouts.dashboard.dashboard')
@section('content')
    <section class="section">
        {{-- Sweetalert --}}
        @if (session('success'))
            <x-sweetalert :message="session('success')" />
        @endif
        <div class="card">
            <div class="card-body">
                <a href="{{ route('pengajuan-barang.create') }}" class="btn btn-primary my-3"> <i class="bi bi-box2-fill"></i>
                    Ajukan
                    barang</a>
                <!-- Default Table -->
                <div class="table-responsive">
                    <table class="table mt-2" id="barangsTable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Harga (Satuan)</th>
                                <th scope="col">Satuan</th>
                                <th scope="col">SubTotal</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barang as $item)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ 'Rp. ' . number_format($item->harga, 0, ',', '.') }}</td>
                                    <td>{{ $item->satuan }}</td>
                            <td class="sub-total">{{ 'Rp ' . number_format($item->sub_total, 0, ',', '.') }}</td>

                                    <td>{{ $item->status }}</td>
                                    <td>
                                        <div class="d-flex gap-3">
                                            <div>
                                                <form action="{{ route('barang-acc.update', ['acc' => $item->slug]) }}" method="POST"
                                                    >
                                                    @method('PUT')
                                                    @csrf
                                                    <input type="hidden" name="status" value="Disetujui">
                                                    <button class="bi bi-check fw-bold btn btn-sm bg-success link-light"></button>
                                                </form>
                                            </div>
                                            <div>
                                                <form action="{{ route('barang-acc.update', ['acc' => $item->slug]) }}" method="POST"
                                                    class="">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="Ditolak">
                                                    <button class="bi bi-x fw-bold btn btn-sm bg-danger link-light"></button>
                                                </form>
                                            </div>
                                            <div>
                                                <a href="{{ route('barang-acc.edit', ['acc' => $item->slug]) }}"
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
                                                    action="{{ route('pengajuan-barang.destroy', ['barang' => $item->slug]) }}"
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
        <script>
            let table = new DataTable('#barangsTable');

            $(document).ready(function() {
                $('.deleteBarangBtn').click(function() {
                    const barang = $(this).data('barang');

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
            });
        </script>
    </section>
@endsection
