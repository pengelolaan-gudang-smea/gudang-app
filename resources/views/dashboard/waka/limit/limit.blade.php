@extends('layouts.dashboard.dashboard')
@section('content')
    <section class="section">
        {{-- Sweetalert --}}
        @if (session('success'))
            <x-sweetalert :message="session('success')" />
        @endif
        <div class="card">
            <div class="card-body">
                <a href="{{ route('limit-anggaran.create') }}" class="my-3 btn btn-primary"> <i class="bi bi-coin"></i></i>
                   Atur Limit Anggaran</a>
                <!-- Default Table -->
                <div class="table-responsive">
                    <table class="table mt-2 table-hover table-bordered" id="limitAnggaranTable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Limit</th>
                                <th scope="col">Jurusan</th>
                                <th scope="col">Jenis</th>
                                <th scope="col">Tahun</th>
                                <th scope="col">Dibuat</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <td colspan="7" class="text-center">Tabel tidak memiliki data</td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
    let limitAnggaranTable
    $(document).ready(function() {
        $(function() {
            loadData();
        });

        function loadData() {
            if (limitAnggaranTable !== undefined) {
                limitAnggaranTable.destroy();
                limitAnggaranTable.clear().draw();
            }

            limitAnggaranTable = $('#limitAnggaranTable').DataTable({
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
                    url: "{{ route('limit-anggaran.data') }}",
                    method: "GET"
                },
                drawCallback: function(settings) {
                    $('table#limitAnggaranTable tr').on('click', '#ubah', function(e) {
                        e.preventDefault();
                        let url = $(this).data('url');
                        let data = limitAnggaranTable.row($(this).parents('tr')).data();
                        edit(data, url);
                    });

                    $('table#limitAnggaranTable tr').on('click', '#hapus', function(e) {
                        e.preventDefault();
                        let data = limitAnggaranTable.row($(this).parents('tr')).data();
                        let url = $(this).data('url');
                        destroy(data, url);
                    });
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', width: '1%', class: 'fixed-side text-center', orderable: true, searchable: true },
                    { data: 'limit', name: 'limit', orderable: false, searchable: false },
                    { data: 'jurusan', name: 'jurusan', orderable: false, searchable: false },
                    { data: 'jenis_anggaran', name: 'jenis_anggaran', orderable: false, searchable: false },
                    { data: 'tahun', name: 'tahun', orderable: true },
                    { data: 'created_at', name: 'created_at', orderable: true },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });

            limitAnggaranTable.on('draw', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });
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
                            limitAnggaranTable.ajax.reload(null, false)
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
