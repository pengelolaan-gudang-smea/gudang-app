@extends('layouts.dashboard.dashboard')
@section('content')
<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive pt-3">
                <form action="{{ route('filter.date') }}" method="GET">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="start_date"><small>Tanggal Awal :</small></label>
                                <input type="date" name="start_date" id="start_date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="start_date"><small>Tanggal Akhir :</small></label>
                                <input type="date" name="end_date" id="end_date" class="form-control">
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-warning btn-sm d-block"><i class="bi bi-funnel-fill"></i> Filter</button>
                            </div>
                        </div>
                    </div>
                </form>
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
                            <td>{{ \Carbon\Carbon::parse($item->logout)->format('H:i') }} WIB, {{ \Carbon\Carbon::parse($item->logout)->format('j M Y')  }}</td>
                            @else
                            <td>-</td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

    <script>
        let table = new DataTable('#loginTable');

    </script>
</section>
@endsection
