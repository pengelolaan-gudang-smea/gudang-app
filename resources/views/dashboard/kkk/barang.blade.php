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
                                <th scope="col">Status</th>
                                <th scope="col">Sub. Total</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barang as $item)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $item->name }}</td>
                                    <td class="harga">{{ 'Rp. ' . number_format($item->harga, 0, ',', '.') }}</td>
                                    <td class="satuan">{{ $item->satuan }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td class="sub-total">{{ $item->status }}</td>
                                    <td>
                                        <div class="d-flex gap-3">
                                            <div>
                                                <a href="{{ route('pengajuan-barang.show', ['barang' => $item->slug]) }}"
                                                    class="btn btn-sm bg-primary link-light">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="{{ route('pengajuan-barang.edit', ['barang' => $item->slug]) }}"
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

            const harga = document.querySelectorAll('.harga');
            const sub_total = document.querySelectorAll('.sub-total');
            
        </script>
    </section>
@endsection
