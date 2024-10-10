@extends('layouts.dashboard.dashboard')
@section('content')
    <section class="section">
        {{-- Sweetalert --}}
        @if (session('success'))
            <x-sweetalert :message="session('success')" />
        @endif
        <div class="card">
            <div class="card-body">
                <div class="row d-flex justify-content-between mt-5 mb-3">
                    <div class="col-md-6">
                        <div class="form-group row d-flex align-items-center">
                            <label class="col-2">Lab/ruang</label>
                            <label class="col-1 text-right">:</label>
                            <div class="col-md-6">
                                <select class="form-control" name="lab_ruang">
                                    <option selected disabled>-- Pilih lab/ruang --</option>
                                    <option value="all">All</option>
                                    @foreach (App\Models\BarangGudang::pluck('tujuan') as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row d-flex align-items-center justify-content-end">
                            <label class="col-2">Tahun</label>
                            <label class="col-1 ">:</label>
                            <div class="col-md-6">
                                <select class="form-control" name="tahun" disabled>
                                    <option selected disabled>-Pilih Tahun-</option>
                                <option value="all">All</option>

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <form id="export_Form" action="{{ route('laporan-export-ruang-lab') }}" method="POST">
                    @csrf
                    <input type="hidden" name="lab_ruang" id="exportLabRuang">
                    <input type="hidden" name="tahun" id="exportTahun">
                    <button class="btn btn-md btn-outline-success my-3" disabled name="export">Export Excel</button>
                </form>
                <div class="table-responsive" id="viewTable">
                    <table class="table mt-2" id="barangsTable">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col">No Inventaris</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Kuantitas (Qty)</th>
                                <th scope="col">Lokasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gudang as $item)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $item->no_inventaris }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->stock_awal }}</td>
                                    <td>{{ $item->tujuan ?? '-' }}</td>
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
            $(document).ready(function() {
                $('[data-bs-toggle="popover"]').popover();
                $('select[name=lab_ruang]').select2({
                    theme: "bootstrap-5"
                })
                 // Disable tombol Export saat pertama kali load
            let btnExport = $('button[name=export]');
            btnExport.prop('disabled', true);

                $('select[name=lab_ruang]').change(function() {
                    let lab_ruang = $(this).val();
                    $.ajax({
                        url: '{{ route('laporan-lab_ruang') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            lab_ruang: lab_ruang
                        },
                        success: function(data) {

                            const filterTahun = $('select[name=tahun]');

                            filterTahun.html('');
                            btnExport.prop('disabled', false);
                            if (data.length > 0) {
                                var options = '';
                                options += '<option selected disabled>-- Pilih Tahun --</option>';
                                options += '<option value="all">All</option>';
                                $.each(data, function(index, tahun) {
                                    options += '<option value="' + tahun + '">' + tahun +
                                        '</option>';
                                });
                                filterTahun.append(options);
                                filterTahun.attr('disabled', false);
                                filterTahun.select2({
                                    theme: "bootstrap-5"
                                });
                                filterTahun.change(function() {
                                    const selectedTahun = filterTahun.val();
                                    $('#exportTahun').val(filterTahun.val());
                                    updateTabel(lab_ruang, selectedTahun);
                                });
                            }
                            $('#exportLabRuang').val(lab_ruang);

                        }
                    });
                });
                function updateTabel(lab_ruang, selectedTahun) {
                    $("#viewTable").html(``)
                    $("#viewTable").html(`<table class="table mt-2" id="barangsTable">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">#</th>
                                                    <th scope="col">No Inventaris</th>
                                                    <th scope="col">Nama</th>
                                                    <th scope="col">Kuantitas (Qty)</th>
                                                    <th scope="col">Lokasi</th>
                                                </tr>
                                            </thead>
                                            </table>`);
                    $('#barangsTable').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        pageLength: 25,
                        "paging": true,
                        "order": [
                            [0, "asc"]
                        ],
                        ajax: {
                            "url": "{{ route('barang-lab_ruang') }}",
                            "type": "POST",
                            "data": {
                                "_token": "{{ csrf_token() }}",
                                "lab_ruang": lab_ruang,
                                "tahun": selectedTahun
                            },
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                orderable: false,
                                searchable: false,
                                width: "8%",
                                className: "text-center"
                            }, {
                                data: 'no inventaris',
                                className: "text-center"
                            }, {
                                data: 'nama',
                                className: "text-center"
                            }, {
                                data: 'kuantitas (Qty)',
                                className: "text-center"
                            },
                            {
                                data: 'lokasi',
                                className: "text-center"
                            },
                        ],
                        "language": {
                            "paginate": {
                                "previous": 'Previous',
                                "next": 'Next'
                            }
                        }
                    });
                }

                let table = new DataTable('#barangsTable');
            });
        </script>
    </section>
@endsection
