@extends('layouts.dashboard.dashboard')
@section('content')
<section class="section">
    <div class="card">
        <div class="card-body">
            <!-- Default Table -->
            <div class="table-responsive pt-3">
                <table class="table mt-3" id="loginTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Username</th>
                            <th scope="col">Tanggal Login</th>
                            <th scope="col">Jam Login</th>
                            <th scope="col">Tanggal Logout</th>
                            <th scope="col">Jam Logout</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($login as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->user->username }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->login)->format('d-m-y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->login)->format('H:i') }}</td>
                            <td>{{ $item->logout ? \Carbon\Carbon::parse($item->logout)->format('d-m-y') : '-'}}</td>
                            <td>{{ $item->logout ? \Carbon\Carbon::parse($item->logout)->format('H:i') : '-' }}</td>
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
          let table = new DataTable('#loginTable');

    </script>
</section>
@endsection
