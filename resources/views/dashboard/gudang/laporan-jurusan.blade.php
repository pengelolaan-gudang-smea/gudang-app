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
                            <label class="col-2">Jurusan</label>
                            <label class="col-1 text-right">:</label>
                            <div class="col-md-6">
                                <select class="form-control" name="jurusan">
                                    <option selected disabled>-- Pilih Jurusan --</option>
                                    <option value=" ">All</option>
                                    @foreach (App\Models\Jurusan::get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
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
                                    <option value="" >All</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>

                <div class="table-responsive" id="viewTable">
                    <table class="table mt-2" id="barangsTable">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col">No Inventaris</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Kuantitas (Qty)</th>
                                <th scope="col">Jurusan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gudang as $item)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $item->no_inventaris }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->stock_awal }}</td>
                                    <td>{{ $item->jurusan->name ?? '-'}}</td>
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
                $('select[name=jurusan]').select2({
                    theme: "bootstrap-5"
                })
                $('select[name=jurusan]').change(function() {
                    let jurusan = $(this).val();
                    $.ajax({
                        url: '{{ route('laporan-jurusan') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            jurusan: jurusan
                        },
                        success: function(data) {
                            const filterTahun = $('select[name=tahun]');
                            filterTahun.html('');
                            if (data.length > 0) {
                                var options = '';
                                options += '<option selected disabled>-- Pilih Tahun --</option>';
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
                                    updateTabel(jurusan, selectedTahun);
                                });
                            }
                        }
                    });
                });
                function updateTabel(jurusan, selectedTahun) {
                    $("#viewTable").html(``)
                    $("#viewTable").html(`<table class="table mt-2" id="barangsTable">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">#</th>
                                                    <th scope="col">No Inventaris</th>
                                                    <th scope="col">Nama</th>
                                                    <th scope="col">Kuantitas (Qty)</th>
                                                    <th scope="col">Jurusan</th>
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
                            "url": "{{ route('barang-jurusan') }}",
                            "type": "POST",
                            "data": {
                                "_token": "{{ csrf_token() }}",
                                "jurusan": jurusan,
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
                                data: 'jurusan',
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
