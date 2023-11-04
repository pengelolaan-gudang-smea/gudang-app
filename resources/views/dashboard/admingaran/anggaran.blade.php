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
                                    <option selected disabled>- Pilih Jurusan -</option>
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
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive" id="viewTable">
                    <table class="table mt-2" id="barangsTable">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Harga (Satuan)</th>
                                <th scope="col">Kuantitas (Qty)</th>
                                <th scope="col">Sub total</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($barang as $item)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ 'Rp ' . number_format($item->harga, 0, ',', '.') }}</td>
                                    <td>{{ $item->satuan }}</td>
                                    <td class="sub-total">{{ 'Rp ' . number_format($item->sub_total, 0, ',', '.') }}</td>

                                    <td>{{ $item->status }}</td>
                                    <td>
                                        <div class="d-flex gap-3">
                                            <div>
                                                <form action="{{ route('barang-acc.update', ['acc' => $item->slug]) }}" method="POST"
                                                    >
                                                    @method('PUT')
                                                    @csrf
                                                    <input type="hidden" name="status" value="Disetujui">
                                                    <button class="bi bi-check fw-bold btn btn-sm bg-success link-light" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-title="Popover title"></button>
                                                </form>
                                            </div>
                                            <div>
                                                <form action="{{ route('barang-acc.update', ['acc' => $item->slug]) }}" method="POST"
                                                    class="">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="Ditolak">
                                                    <button class="bi bi-x fw-bold btn btn-sm bg-danger link-light"></button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>
                <!-- End Default Table Example -->
            </div>
        </div>
        </div>
        <script>
            $(document).ready(function() {
                $('select[name=jurusan]').select2()
                $('select[name=jurusan]').change(function() {
                    let jurusan = $(this).val();
                    $.ajax({
                        url: '{{ route('filter-jurusan') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            jurusan: jurusan
                        },
                        success: function (data) {
                            const filterTahun = $('select[name=tahun]');
                            filterTahun.html('');
                            if (data.length > 0) {
                                var options = '';
                                options += '<option selected disabled>- Pilih Tahun -</option>';
                                $.each(data, function (index, tahun) {
                                    options += '<option value="'+ tahun +'">'+ tahun +'</option>';
                                });
                                filterTahun.append(options);
                                filterTahun.attr('disabled', false);
                                filterTahun.select2();
                                filterTahun.change(function() {
                                    const selectedTahun = filterTahun.val();
                                    updateTabel(jurusan, selectedTahun);
                                    // if (selectedTahun) {
                                    //     $.ajax({
                                    //         url: '{{ route('filter-barang') }}',
                                    //         type: 'POST',
                                    //         data: {
                                    //             _token: '{{ csrf_token() }}',
                                    //             jurusan: jurusan,
                                    //             tahun: selectedTahun
                                    //         },
                                    //         success: function (barang) {
                                    //             console.log(barang);
                                    //             updateTabel(data);
                                    //         }
                                    //     });
                                    // }
                                });
                            }
                        }
                    });
                });

                function updateTabel(jurusan, selectedTahun)
                {
                    $("#viewTable").html(``)
                    $("#viewTable").html(`<table class="table mt-2" id="barangsTable">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">#</th>
                                                    <th scope="col">Nama</th>
                                                    <th scope="col">Harga (Satuan)</th>
                                                    <th scope="col">Kuantitas (Qty)</th>
                                                    <th scope="col">Sub total</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Action</th>
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
                            "url": "{{ route('filter-barang') }}",
                            "type": "POST",
                            "data": {
                                "_token": "{{ csrf_token() }}",
                                "jurusan": jurusan,
                                "tahun": selectedTahun
                            },
                        },
                        columns: [
                            {
                                data: 'DT_RowIndex',
                                orderable: false,
                                searchable: false,
                                width: "8%",
                                className: "text-center"
                            },
                            {
                                data: 'nama',
                                className: "text-center"
                            },
                            {
                                data: 'harga',
                                className: "text-center"
                            },
                            {
                                data: 'satuan',
                                className: "text-center"
                            },
                            {
                                data: 'sub_total',
                                className: "text-center"
                            },
                            {
                                data: 'status',
                                className: "text-center"
                            },
                            {
                                data: 'action',
                                render: function (data, type, row) {
                                    let slug = row.action;
                                    let buttons = '<div class="d-flex gap-3">';
                                    buttons += '<div>';
                                    buttons += '<form action="{{ route('barang-acc.update', '') }}/' + slug + '" method="POST">';
                                    buttons += '@method("PUT")';
                                    buttons += '@csrf';
                                    buttons += '<input type="hidden" name="status" value="Disetujui">';
                                    buttons += '<button class="bi bi-check fw-bold btn btn-sm bg-success link-light" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-title="Popover title"></button>';
                                    buttons += '</form>';
                                    buttons += '</div>';
                                    buttons += '<div>';
                                    buttons += '<form action="{{ route('barang-acc.update', '') }}/' + slug + '" method="POST">';
                                    buttons += '@csrf';
                                    buttons += '@method("PUT")';
                                    buttons += '<input type="hidden" name="status" value="Ditolak">';
                                    buttons += '<button class="bi bi-x fw-bold btn btn-sm bg-danger link-light"></button>';
                                    buttons += '</form>';
                                    buttons += '</div>';
                                    buttons += '</div>';

                                    return buttons;
                                }
                            }
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
