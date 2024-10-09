@extends('layouts.dashboard.dashboard')
@section('content')
<section class="section">
    {{-- Sweetalert --}}
    @if (session('success'))
    <x-sweetalert :message="session('success')" />
    @endif
    <div class="card">
        <div class="card-body">

            <a href="#" class="btn btn-primary my-3" id="btnAdd"> <i class="bi bi-plus"></i>
                Tambah Jurusan</a>

            <div class="table-responsive">
                <table class="table mt-2 table-hover table-bordered" id="jurusanTable">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Jurusan</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Waktu Dibuat</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td colspan="5" class="text-center">Tabel tidak memiliki data</td>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for Adding Jurusan -->
    <div class="modal fade" id="jurusanModal" tabindex="-1" aria-labelledby="jurusanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jurusanModalLabel">Tambah Jurusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="jurusanForm">
                        @csrf
                        <div class="mb-3">
                            <label for="jurusanName" class="form-label">Nama Jurusan:<span class="text-danger">*</span></label>
                            <input type="text" id="jurusanName" name="name" placeholder="Masukkan Nama Jurusan" class="form-control" required>
                            <div class="invalid-feedback">
                                Nama Jurusan tidak boleh kosong.
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Jurusan Modal -->
    <div class="modal fade" id="editJurusanModal" tabindex="-1" role="dialog" aria-labelledby="editJurusanModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editJurusanModalLabel">Edit Jurusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editJurusanForm" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editJurusanName" class="form-label">Nama Jurusan:<span class="text-danger">*</span></label>
                            <input type="text" id="editJurusanName" placeholder="Masukkan nama jurusan" class="form-control" name="name" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</section>
@endsection
@section('script')
<script>
    let jurusanTable
    $(document).ready(function() {
        $(function() {
            loadData();

            // add new jurusan
            $('#btnAdd').on('click', function(e) {
                e.preventDefault();
                $('#jurusanModal').modal('show');
            });

            // submit form new jurusan
            $('#jurusanForm').on('submit', function(e) {
                e.preventDefault();
                add();
            });
        });

        function loadData() {
            if (jurusanTable !== undefined) {
                jurusanTable.destroy();
                jurusanTable.clear().draw();
            }

            jurusanTable = $('#jurusanTable').DataTable({
                responsive: true
                , searching: true
                , autoWidth: false
                , ordering: true
                , processing: true
                , serverSide: true
                , aLengthMenu: [
                    [5, 10, 25, 50, 100, 250, 500, -1]
                    , [5, 10, 25, 50, 100, 250, 500, "All"]
                ]
                , pageLength: 10
                , ajax: {
                    url: "{{ route('data-master.jurusan.data') }}"
                    , method: "GET"
                }
                , drawCallback: function(settings) {
                    $('table#jurusanTable tr').on('click', '#ubah', function(e) {
                        e.preventDefault();
                        let url = $(this).data('url');
                        let data = jurusanTable.row($(this).parents('tr')).data();
                        edit(data, url);
                    });

                    $('table#jurusanTable tr').on('click', '#hapus', function(e) {
                        e.preventDefault();
                        let data = jurusanTable.row($(this).parents('tr')).data();
                        let url = $(this).data('url');
                        destroy(data, url);
                    });
                }
                , columns: [{
                        data: 'DT_RowIndex'
                        , name: 'DT_RowIndex'
                        , width: '1%'
                        , class: 'fixed-side text-center'
                        , orderable: true
                        , searchable: true
                    }
                    , {
                        data: 'name'
                        , name: 'name'
                        , orderable: true
                        , class: 'fixed-side text-center'
                    }
                    , {
                        data: 'slug'
                        , name: 'slug'
                        , orderable: false
                        , class: 'fixed-side text-center'
                    }
                    , {
                        data: 'created_at'
                        , name: 'created_at'
                        , orderable: true
                        , class: 'fixed-side text-center'
                    }
                    , {
                        data: 'action'
                        , name: 'action'
                        , orderable: false
                        , class: 'fixed-side text-center'
                    }
                , ]
            });

            jurusanTable.on('draw', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });
        }

        add = function() {
            let formData = $('#jurusanForm').serialize();
            let url = "{{ route('data-master.jurusan.store') }}";

            $.ajax({
                url: url
                , method: 'POST'
                , data: formData
                , success: function(response) {
                    $('#jurusanModal').modal('hide');
                    $('#jurusanForm')[0].reset();
                    if (response.status == 'success') {
                        Swal.fire({
                            icon: 'success'
                            , title: 'Berhasil'
                            , text: response.msg
                            , showConfirmButton: false
                            , timer: 1500
                        });
                    }
                    jurusanTable.ajax.reload(null, false);
                }
                , error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    if (errors.name) {
                        $('#jurusanName').addClass('is-invalid');
                        $('#jurusanName').siblings('.invalid-feedback').text(errors.name[0]);
                    }
                    Swal.fire({
                        icon: 'error'
                        , title: 'Gagal'
                        , text: err
                        , showConfirmButton: false
                        , timer: 1500
                    })
                }
            });
        }

        edit = function(data, url) {
            $('#editJurusanName').val(data.name);
            $('#editJurusanForm').attr('action', url);
            $('#editJurusanModal').modal('show');

            $('#editJurusanForm').on('submit', function(e) {
                e.preventDefault();
                let url = $(this).attr('action');
                let formData = $(this).serialize();

                $.ajax({
                    url: url
                    , method: 'POST'
                    , data: formData
                    , success: function(response) {
                        $('#editJurusanModal').modal('hide');
                        if (response.status == 'success') {
                            Swal.fire({
                                icon: 'success'
                                , title: 'Berhasil'
                                , text: response.msg
                                , showConfirmButton: false
                                , timer: 1500
                            });
                        }
                        jurusanTable.ajax.reload(null, false);
                    }
                    , error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        if (errors.name) {
                            $('#editJurusanName').addClass('is-invalid');
                            $('#editJurusanName').siblings('.invalid-feedback').text(errors.name[0]);
                        }
                        Swal.fire({
                            icon: 'error'
                            , title: 'Gagal'
                            , text: xhr.responseJSON.msg
                            , showConfirmButton: false
                            , timer: 1500
                        });
                    }
                });
            });
        };

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
                            jurusanTable.ajax.reload(null, false)
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
    })

</script>
@endsection
