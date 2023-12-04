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
                            <th scope="col">Login</th>
                            <th scope="col">Logout</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($login as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->user->username }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->login)->format('H:i') }} WIB, {{ \Carbon\Carbon::parse($item->login)->format('j M Y') }}</td>
                            @if ($item->logout)
                            <td>{{  \Carbon\Carbon::parse($item->logout)->format('H:i') }} WIB, {{  \Carbon\Carbon::parse($item->logout)->format('j M Y')  }}</td>
                            @else
                            <td>-</td>
                            @endif
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
