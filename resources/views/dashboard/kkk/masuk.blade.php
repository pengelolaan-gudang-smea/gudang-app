@extends('layouts.dashboard.dashboard')
@section('content')
<section class="section">
    {{-- Sweetalert --}}
    @if (session('success'))
    <x-sweetalert :message="session('success')" />
    @endif
    <div class="card">
        <div class="card-body">

            {{-- <div class="my-3 accordion" id="accordionFilter">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#filterTanggalAccordion" aria-expanded="true" aria-controls="filterTanggalAccordion">
                            <i class="bi bi-funnel-fill me-2"></i> <b>Filter Tanggal</b>
                        </button>
                    </h2>
                    <div id="filterTanggalAccordion" class="accordion-collapse collapse" data-bs-parent="#accordionFilter">
                        <div class="accordion-body">
                            <form action="{{ route('filter.date') }}" method="GET">
                                <div class="mb-2 d-flex justify-content-center">
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
            </div> --}}

            <!-- Default Table -->
            <div class="my-3 table-responsive">
                <table class="table mt-2 table-hover table-bordered" id="barangsTable">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Stok Awal</th>
                            <th scope="col">Jumlah Diambil</th>
                            <th scope="col">Lokasi</th>
                            <th scope="col">Penerima Barang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td colspan="7" class="text-center">Tabel tidak memiliki data</td>
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
    let barangsTable;

    $(document).ready(function() {
        $(function() {
            loadData();
        })

        function loadData() {
            if (barangsTable !== undefined) {
                barangsTable.destroy();
                barangsTable.clear().draw();
            }

            barangsTable = $('#barangsTable').DataTable({
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
                    url: "{{ route('barang.masuk.data') }}"
                    , method: "GET",
                    // data: function(d) {
                    //     d.startDate = startDate;
                    //     d.endDate = endDate;
                    // }
                }
                , columns: [{
                        data: 'DT_RowIndex'
                        , name: 'DT_RowIndex'
                        , width: '1%'
                        , orderable: true
                        , searchable: true
                    }
                    , {
                        data: 'name'
                        , name: 'name'
                        , orderable: false
                    }
                    , {
                        data: 'stock_awal'
                        , name: 'stock_awal'
                        , orderable: false
                    }
                    , {
                        data: 'jumlah_diambil'
                        , name: 'jumlah_diambil'
                        , orderable: false
                    }
                    , {
                        data: 'lokasi'
                        , name: 'lokasi'
                        , orderable: false
                    }
                    , {
                        data: 'penerima'
                        , name: 'penerima'
                        , orderable: false
                    },
                ]
            });
        }
    });

</script>
@endsection
