@extends('layouts.dashboard.dashboard')
@section('content')
<section class="section">
    {{-- Sweetalert --}}

    <div class="card">
        <div class="card-body">
            <form action="{{ route('filter-laporan') }}" method="POST" id="filterAnggaranForm">
                @csrf
                <div class="row d-flex justify-content-between mt-5 mb-3 p-2">
                    <div class="col-md-6">
                        <div class="form-group row d-flex align-items-center">
                            <label class="col-2">Jenis Anggaran</label>
                            <label class="col-1 text-right">:</label>
                            <div class="col-md-6">
                                <select class="form-control" name="jenis_anggaran">
                                    <option selected disabled>-- Pilih Jenis Anggaran --</option>
                                    <option value="">Semua anggaran</option>
                                    @foreach ($jenis_anggaran as $item )
                                    <option value="{{ $item->id }}" {{ session('jenis_anggaran')==$item->id ? 'selected'
                                        : '' }} >{{ $item->jenis_anggaran }} - {{ $item->tahun }}
                                    </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row d-flex align-items-center justify-content-end">
                            <label class="col-2">Saldo Awal</label>
                            <label class="col-1 ">:</label>
                            <div class="col-md-6">
                                <input class="form-control" name="saldo_awal" disabled value="Rp {{number_format($saldo_awal, 0, ',', '.') }} ">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row d-flex align-items-center">
                        <label class="col-2">Filter laporan</label>
                        <label class="col-1 text-right">:</label>
                        <div class="col-md-6">
                            <select class="form-control" name="jenis_laporan">
                                <option selected disabled>-- Pilih Laporan --</option>
                                <option value="semua" >Semua </option>
                                <option value="hari ini" >Hari ini </option>
                                <option value="minggu ini" >Minggu ini </option>
                                <option value="bulan ini" >Bulan ini </option>


                            </select>
                        </div>
                    </div>
                </div>
            </form>
            <div class="col-md-3 d-flex justify-content-center gap-3 mx-auto">
                <button class="btn btn-md btn-primary" id="filterAnggaran">Filter</button>
                <form action="{{ route('reset-anggaran') }}" method="post">
                    @csrf
                    <button class="btn btn-md btn-secondary">Reset</button>
                </form>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-2">
            @if(session('jenis_anggaran'))
            <div class="row d-flex justify-content-between  mb-3 p-2" id="saldo_masuk_akhir">
                <div class="col-md-6">
                    @if(isset($saldo_masuk->saldo_masuk))
                    <div class="form-group row d-flex align-items-center">
                        <label class="col-2">Saldo Masuk</label>
                        <label class="col-1 text-right">:</label>

                        <div class="col-md-6">
                            <input class="form-control" name="saldo_masuk" disabled
                                value="Rp {{number_format($saldo_masuk->saldo_masuk, 0, ',', '.') }}">

                        </div>
                        <label class="col-1 text-right"> <button class="btn btn-sm btn-warning link-light d-inline"
                            data-bs-toggle="modal" data-bs-target="#modal_edit_saldo_masuk" data-anggaran={{ $saldo_awal }} data-saldo_masuk="{{ $saldo_masuk->saldo_masuk }}" data-saldo="{{ $saldo_masuk->id }}"><i
                                class="bi bi-pencil-square"></i></button>
                    </label>

                    </div>
                    @else
                    <div>
                        <button class="btn btn-primary my-3 " data-bs-toggle="modal" data-bs-target="#modal_saldo_masuk"
                            data-anggaran={{ $saldo_awal }} ><i class="bi bi-coin"></i>
                            Masukkan Saldo Masuk</button>
                    </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="form-group row d-flex align-items-center justify-content-end">
                        <label class="col-2">Saldo Akhir</label>
                        <label class="col-1 ">:</label>
                        <div class="col-md-6">
                            <input class="form-control" name="saldo_akhir" disabled
                                value="Rp {{number_format($saldo_akhir, 0, ',', '.') }}">

                        </div>
                    </div>
                </div>
            </div>

            <hr>
            @endif
            <!-- Default Table -->
            <form id="export_Form" action="{{ route('laporan-persediaan') }}" method="POST">
                @csrf
                <input type="hidden" name="jenis_anggaran" value="{{ session('jenis_anggaran') }}">
                <input type="hidden" name="laporan" value="{{ session('laporan') }}">
                <input type="hidden" name="saldo_awal" value="{{ $saldo_awal }}">
                <input type="hidden" name="saldo_akhir" value="{{ $saldo_akhir }}">
                <button class="btn btn-md btn-outline-success my-3">Export Excel</button>
            </form>
            <div class="table-responsive" id="viewTable">
                <table class="table mt-2" id="barangsTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">kuantitas (Qty) awal </th>
                            <th scope="col">kuantitas (Qty) akhir</th>
                            <th scope="col">Saldo keluar</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gudang as $item)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->stock_awal }}
                            </td>
                            <td>{{ $item->stock_akhir }}</td>

                            <td> @if($item->saldo_keluar)
                                Rp {{ number_format($item->saldo_keluar,0,'.','.') }}
                                @else
                                <i class="bi bi-exclamation-circle-fill text-danger"></i>
                               Saldo belum di masukkan
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning link-light" data-bs-toggle="modal"
                                    data-bs-target="#modal_saldo_keluar" data-slug="{{ $item->slug }}"><i
                                        class="bi bi-pencil-square"></i></button>
                            </td>



                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <!-- End Default Table Example -->
        </div>
    </div>
    </div>

    <div class="modal fade" id="modal_saldo_masuk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Saldo Masuk</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="saldo_masuk_form" method="post">
                        @csrf
                        <label for="saldo_masuk" class="col-sm-4 col-form-label">Saldo Masuk<span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="number" id="saldo_masuk" placeholder="Masukan saldo yang diterima"
                                class="form-control @error('saldo_masuk') is-invalid @enderror" name="saldo_masuk"
                                required>
                            @error('saldo_masuk')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="saldo_masuk_btn">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_edit_saldo_masuk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Saldo Masuk</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit_saldo_masuk_form" method="post">
                        @csrf
                        <label for="saldo_masuk" class="col-sm-4 col-form-label">Saldo Masuk<span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="number" id="edit_saldo_masuk" placeholder="Masukan saldo yang diterima"
                                class="form-control @error('saldo_masuk') is-invalid @enderror" name="saldo_masuk"
                                required>
                            @error('saldo_masuk')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="saldo_masuk_btn">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_saldo_keluar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Saldo Keluar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="saldo_keluar_form" method="post">
                        @csrf
                        @method('PUT')
                        <label for="saldo_keluar" class="col-sm-4 col-form-label">Saldo Keluar<span
                                class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" id="saldo_keluar" placeholder="Masukan saldo yang di keluarkan"
                                class="form-control @error('saldo_keluar') is-invalid @enderror" name="saldo_keluar"
                                required>
                            @error('saldo_keluar')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="saldo_keluar_btn">Simpan</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        let table = new DataTable('#barangsTable');
        $(document).ready(function () {
            $('select[name=jenis_anggaran]').select2({
                    theme: "bootstrap-5"
                });
            $('select[name=jenis_laporan]').select2({
                    theme: "bootstrap-5"
                });

                $('#modal_saldo_masuk').on('show.bs.modal', function(event) {
                    const button = $(event.relatedTarget);
                    const form = $(this).find('form#saldo_masuk_form');
                    const anggaran = button.data('anggaran');
                    const actionUrl = `/dashboard/laporan/saldo-masuk/`;
                    form.attr('action', actionUrl);
                    $('#saldo_masuk').attr('max',anggaran);
                    $('#saldo_masuk').on('input', function() {
                        const anggaran = parseFloat($(this).attr('max'));
                        const nilaiInput = parseFloat($(this).val());

                        if (nilaiInput > anggaran) {
                            $(this).val(anggaran);
                        }
                    });
                });
                $('#saldo_masuk_btn').on('click', function() {
                    // Lakukan sesuatu jika tombol 'Simpan' diklik
                    $('#saldo_masuk_form').submit(); // Submit form
                });

                $('#modal_edit_saldo_masuk').on('show.bs.modal', function(event) {
                    const button = $(event.relatedTarget);
                    const form = $(this).find('form#edit_saldo_masuk_form');
                    const anggaran = button.data('anggaran');
                    console.log(anggaran);
                    const saldo = button.data('saldo');
                    console.log(saldo);
                    const saldoMasuk = button.data('saldo_masuk')
                    console.log(saldoMasuk);

                    const actionUrl = `/dashboard/laporan/saldo-masuk/update/${saldo}`;
                    form.attr('action', actionUrl);
                    $('#edit_saldo_masuk').val(saldoMasuk);
                    $('#edit_saldo_masuk').attr('max',anggaran);
                    $('#edit_saldo_masuk').on('input', function() {
                        const anggaran = parseFloat($(this).attr('max'));
                        const nilaiInput = parseFloat($(this).val());

                        if (nilaiInput > anggaran) {
                            $(this).val(anggaran);
                        }
                    });
                });
                $('#saldo_masuk_btn').on('click', function() {
                    // Lakukan sesuatu jika tombol 'Simpan' diklik
                    $('#saldo_masuk_form').submit(); // Submit form
                });

                $('#filterAnggaran').on('click',function(){
                    $('#filterAnggaranForm').submit();
                })
                $('#modal_saldo_keluar').on('show.bs.modal', function(e){
                    const button = $(e.relatedTarget);
                    const slug = button.data('slug');
                    const form = $(this).find('form#saldo_keluar_form');
                    const actionUrl = `/dashboard/laporan/saldo-keluar/${slug}`;
                    form.attr('action',actionUrl);
                })
                $('#saldo_keluar_btn').on('click',function(){
                    $('#saldo_keluar_form').submit();
                })
});
    </script>
</section>
@endsection
