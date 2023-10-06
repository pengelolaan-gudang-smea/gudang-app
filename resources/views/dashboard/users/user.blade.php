@extends('layouts.dashboard.dashboard')
@section('content')
    <section class="section">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('user.create') }}" class="btn btn-primary m-2 fs-6">Tambah User</a>

                <!-- Default Table -->
                <table class="table mt-2">
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
                                <td>{{ $item->roles->pluck('name')->implode(', ') }}</td>
                                <td>
                                    <div class="d-flex gap-3">
                                        <div>
                                            <a href="{{ route('user.show', ['user' => $item->username]) }}"
                                                class="bg-primary p-1 badge fs-6 link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
                                                <i class="bi bi-universal-access"></i>
                                            </a>
                                        </div>
                                        <div>
                                            <a href="{{ route('user.edit', ['user' => $item->username]) }}"
                                                class="bg-warning p-1 badge fs-6 link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        </div>
                                        <div>
                                            <form action="{{ route('user.destroy', ['user' => $item->username]) }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-danger p-1 badge fs-6 link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <!-- End Default Table Example -->
            </div>
        </div>
        </div>
    </section>
@endsection
