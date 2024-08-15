@extends('layouts.dashboard.dashboard')
@section('content')
<section class="section">
    {{-- Sweetalert --}}
    @if (session('success'))
    <x-sweetalert :message="session('success')" />
    @endif
    <div class="card">
        <div class="card-body">
            <a href="{{ route('user.create') }}" class="btn btn-primary my-3"><i class="bi bi-person-fill-add"></i> Tambah User</a>
            <!-- Default Table -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered mt-2" id="usersTable">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Name</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td colspan="6" class="text-center">Tabel tidak memiliki data</td>
                    </tbody>
                </table>
            </div>
            <!-- End Default Table Example -->
        </div>
    </div>
    </div>
</section>
@endsection
@section('script')
    <script>
    let usersTable
    $(document).ready(function() {
        $(function() {
            loadData();
        });

        function loadData() {
            if (usersTable !== undefined) {
                usersTable.destroy();
                usersTable.clear().draw();
            }

            usersTable = $('#usersTable').DataTable({
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
                    url: "{{ route('users.data') }}",
                    method: "GET"
                },
                drawCallback: function(settings) {
                    $('table#usersTable tr').on('click', '#detail', function(e) {
                        e.preventDefault();
                        let url = $(this).data('url');
                        let data = usersTable.row($(this).parents('tr')).data();
                        show(data, url);
                    });

                    $('table#usersTable tr').on('click', '#ubah', function(e) {
                        e.preventDefault();
                        let url = $(this).data('url');
                        let data = usersTable.row($(this).parents('tr')).data();
                        edit(data, url);
                    });

                    $('table#usersTable tr').on('click', '#hapus', function(e) {
                        e.preventDefault();
                        let data = usersTable.row($(this).parents('tr')).data();
                        let url = $(this).data('url');
                        destroy(data, url);
                    });
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', width: '1%', class: 'fixed-side text-center', orderable: true, searchable: true },
                    { data: 'name', name: 'name', orderable: false },
                    { data: 'username', name: 'username', orderable: false },
                    { data: 'email', name: 'email', orderable: false },
                    { data: 'role', name: 'role', orderable: false },
                    { data: 'action', name: 'action', orderable: false },
                ]
            });

            usersTable.on('draw', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });
        }

        show = function(data, url) {
            window.location.href = url
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
                            usersTable.ajax.reload(null, false)
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
