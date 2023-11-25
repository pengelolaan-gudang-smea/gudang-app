@extends('layouts.dashboard.dashboard')
@section('content')
    <section class="section">
        {{-- Sweetalert --}}
        @if (session('success'))
            <x-sweetalert :message="session('success')" />
        @endif
        <div class="card">
            <div class="card-body">
                <a href="{{ route('anggaran.create') }}" class="btn btn-primary my-3"> <i class="bi bi-coin"></i></i>
                   Tambah Anggaran</a>
                <!-- Default Table -->
                <div class="table-responsive">
                    <table class="table mt-2" id="anggaransTable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Anggaran</th>
                                <th scope="col">Jenis</th>
                                <th scope="col">Tahun</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anggaran as $item)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ 'Rp ' . number_format($item->anggaran, 0, ',', '.') }}</td>
                                    <td>{{ $item->jenis }}</td>
                                    <td>{{ $item->tahun }}</td>
                                    <td>
                                        <div class="d-flex gap-3">

                                            <div>
                                                <a href="{{ route('anggaran.edit', ['anggaran' => $item->id]) }}"
                                                    class="btn btn-sm bg-warning link-light">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            </div>
                                            <div>
                                                <button type="button"
                                                    class="btn btn-sm btn-danger link-light deleteBarangBtn"
                                                    data-barang="{{ $item->anggaran }}">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                                <form
                                                    action="{{ route('anggaran.destroy', ['anggaran' => $item->id]) }}"
                                                    method="post" hidden class="deleteBarangForm"
                                                    data-barang="{{ $item->anggaran }}">
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
            let table = new DataTable('#anggaransTable');

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
