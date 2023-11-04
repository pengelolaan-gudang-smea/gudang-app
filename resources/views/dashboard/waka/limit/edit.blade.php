@extends('layouts.dashboard.dashboard')
@section('content')
    <section class="section">
        <div class="row">
            <div>
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">Form Edit Limit Anggaran</p>

                        <!-- General Form Elements -->
                        <form action="{{ route('limit-anggaran.update',['limit'=>$limit->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                          
                            <div class="row mb-3">
                                <label for="anggaran" class="col-sm-2 col-form-label">Nominal Limit Anggaran <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="number" id="anggaran"
                                        class="form-control @error('anggaran') is-invalid @enderror" name="limit" required value="{{ old('limit',$limit->limit) }}">
                                    @error('anggaran')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="Jenis" class="col-sm-2 col-form-label">Anggaran <span
                                        class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <select class="form-select" aria-label="Default select example" id="jenis"
                                                name="anggaran_id">
                                                <option  disabled>Pilih anggaran</option>
                                                @foreach ($anggaran as $item)
                                                <option value="{{ $item->id }}" {{ ($item->id == old('anggaran_id',$limit->anggaran->id)) ? 'selected' : '' }}>{{ 'Rp. ' . number_format($item->anggaran, 0, ',', '.') }} - {{ $item->tahun }}</option>
                                                    
                                                @endforeach
                                            </select>
                                        </div>
                            </div>

                            <div class="row mb-3">
                                <label for="Jenis" class="col-sm-2 col-form-label">Jurusan <span
                                        class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <select class="form-select" aria-label="Default select example" id="jenis"
                                                name="jurusan_id">
                                                <option  disabled>Pilih jurusan</option>
                                                @foreach ($jurusan as $item)
                                                <option value="{{ $item->id }}" {{ ($item->id == old('jurusan_id',$limit->jurusan->id)) ? 'selected' : ''}}>{{ $item->name}}</option>
            
                                                @endforeach
                                            </select>
                                        </div>
                            </div>
                            


                            <div class="row mb-3">
                                <small class="text-secondary"><span class="text-danger">* </span>Field wajid diisi</small>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-12 d-flex justify-content-end gap-2">
                                    <a href="{{ route('limit-anggaran.index') }}" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Simpan limit Anggaran</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
