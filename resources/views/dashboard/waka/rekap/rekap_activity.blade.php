@extends('layouts.dashboard.dashboard')
@section('content')
<section class="section">
    <div class="card">
        <div class="card-body">
            <!-- Default Table -->
            <div class="table-responsive pt-3">
                <table class="table mt-3" id="activityTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Aktivitas</th>
                            <th scope="col">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activity as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->log_name }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->created_at->format('d F y, H:i') }} WIB</td>

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
          let table = new DataTable('#activityTable');

    </script>
</section>
@endsection
