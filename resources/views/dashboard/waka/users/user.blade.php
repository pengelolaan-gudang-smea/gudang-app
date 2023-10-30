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
                <table class="table mt-2" id="usersTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->username }}</td>
                            <td>{{ $item->email }}</td>
                            <td>
                                @if ($item->hasRole('KKK'))
                                {{ $item->roles->pluck('name')->implode(', ') }} - {{ $item->jurusan->name }}
                                @else
                                {{ $item->roles->pluck('name')->implode(', ') }}
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-3">
                                    <div>
                                        <a href="{{ route('user.show', ['user' => $item->username]) }}" class="btn btn-sm bg-primary link-light">
                                            <i class="bi bi-universal-access"></i>
                                        </a>
                                    </div>
                                    <div>
                                        <a href="{{ route('user.edit', ['user' => $item->username]) }}" class="btn btn-sm bg-warning link-light">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-sm btn-danger link-light deleteUserBtn" data-username="{{ $item->username }}">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                        <form action="{{ route('user.destroy', ['user' => $item->username]) }}" method="post" hidden class="deleteUserForm" data-username="{{ $item->username }}">
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
        let table = new DataTable('#usersTable');

        $(document).ready(function() {
            $('.deleteUserBtn').click(function() {
                const username = $(this).data('username');

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
                        const deleteUserForm = $(`.deleteUserForm[data-username="${username}"]`);
                        deleteUserForm.submit();
                    }
                });
            });
        });

    </script>
</section>
@endsection
