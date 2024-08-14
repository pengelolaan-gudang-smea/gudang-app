@extends('layouts.dashboard.dashboard')
@section('content')
<section class="section">
    <div class="card">
        <div class="card-body">
            <!-- Default Table -->
            <div class="table-responsive pt-3">
                <table class="table table-hover table-bordered mt-3" id="tableActivity">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Aktivitas</th>
                            <th scope="col">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td colspan="4" class="text-center">Tabel tidak memiliki data</td>
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
    let tableActivity
    $(document).ready(function() {
        loadData();

        function loadData() {
            if (tableActivity !== undefined) {
                tableActivity.destroy();
                tableActivity.clear().draw();
            }

            tableActivity = $('#tableActivity').DataTable({
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
                    url: "{{ route('rekap.activity.data') }}",
                    method: "GET",
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', width: '1%', class: 'fixed-side text-center', orderable: true, searchable: true },
                    { data: 'name', name: 'name', orderable: false },
                    { data: 'description', name: 'description', orderable: false },
                    { data: 'created_at', name: 'logicreated_atn' },
                ]
            });
        }
    });
    </script>
@endsection