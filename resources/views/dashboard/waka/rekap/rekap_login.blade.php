@extends('layouts.dashboard.dashboard')
@section('content')
<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="accordion my-3" id="accordionFilter">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#filterTanggalAccordion" aria-expanded="true" aria-controls="filterTanggalAccordion">
                            <b>Filter Tanggal</b>
                        </button>
                    </h2>
                    <div id="filterTanggalAccordion" class="accordion-collapse collapse show" data-bs-parent="#accordionFilter">
                        <div class="accordion-body">
                            <form action="{{ route('filter.date') }}" method="GET">
                                <div class="d-flex justify-content-center mb-2">
                                    <div class="row">
                                        <div class="input-group">
                                            <span class="input-group-text" id="filterDateInput"><i class="bi bi-calendar-range-fill"></i></span>
                                            <input type="text" name="filter_date" class="form-control" placeholder="Filter Tanggal" aria-describedby="filterDateInput">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive pt-3">
                <table class="table mt-3 table-hover table-bordered" id="tableLogin">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Username</th>
                            <th scope="col">Waktu Login</th>
                            <th scope="col">Waktu Logout</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td colspan="5" class="text-center">Tabel tidak memiliki data</td>
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
    let tableLogin
    $(document).ready(function() {
    let startDate = '';
    let endDate = '';

    $('input[name="filter_date"]').daterangepicker({
        ranges: {
            'Hari Ini': [moment(), moment()],
            'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
            '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
            'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
            'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        "locale": {
            "format": "DD/MM/YYYY",
            "separator": " - ",
            "applyLabel": "Filter",
            "cancelLabel": "Batal",
            "fromLabel": "From",
            "customRangeLabel": "Custom",
            "toLabel": "To",
            "weekLabel": "W",
            "daysOfWeek": ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
            "monthNames": ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
            "firstDay": 1
        },
        "autoUpdateInput": false,
        "alwaysShowCalendars": true,
        "opens": "right"
    });

    $('input[name="filter_date"]').on('apply.daterangepicker', function(ev, picker) {
        startDate = picker.startDate.format('YYYY-MM-DD');
        endDate = picker.endDate.format('YYYY-MM-DD');
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        loadData();
    });

    $('input[name="filter_date"]').on('cancel.daterangepicker', function(ev, picker) {
        startDate = '';
        endDate = '';
        $(this).val('');
        loadData();
    });

    loadData();

    function loadData() {
        if (tableLogin !== undefined) {
            tableLogin.destroy();
            tableLogin.clear().draw();
        }

        tableLogin = $('#tableLogin').DataTable({
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
                url: "{{ route('rekap.login.data') }}",
                method: "GET",
                data: function(d) {
                    d.startDate = startDate;
                    d.endDate = endDate;
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', width: '1%', class: 'fixed-side text-center', orderable: true, searchable: true },
                { data: 'name', name: 'name', orderable: false },
                { data: 'username', name: 'username', orderable: false },
                { data: 'login', name: 'login' },
                { data: 'logout', name: 'logout' }
            ]
        });
    }
});

</script>
@endsection
