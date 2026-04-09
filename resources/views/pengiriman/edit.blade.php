@extends('be.master')
@section('sidebar')
    @include('be.sidebar')
@endsection
@section('navbar')
    @include('be.navbar')
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Edit Pengiriman</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('pengiriman.update', $pengiriman->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">No Invoice</label>
                                <div class="col-sm-9">
                                    <input type="text" name="no_invoice" class="form-control" 
                                           value="{{ $pengiriman->no_invoice }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nama Kurir</label>
                                <div class="col-sm-9">
                                    <input type="text" name="nama_kurir" class="form-control" 
                                           value="{{ $pengiriman->nama_kurir }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Telepon Kurir</label>
                                <div class="col-sm-9">
                                    <input type="text" name="telpon_kurir" class="form-control" 
                                           value="{{ $pengiriman->telpon_kurir }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tanggal Kirim</label>
                                <div class="col-sm-9">
                                    <input type="datetime-local" name="tgl_kirim" class="form-control" 
                                           value="{{ $pengiriman->tgl_kirim ? date('Y-m-d\TH:i', strtotime($pengiriman->tgl_kirim)) : '' }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Keterangan</label>
                                <div class="col-sm-9">
                                    <textarea name="keterangan" class="form-control" rows="3">{{ $pengiriman->keterangan }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ route('pengiriman.index') }}" class="btn btn-secondary">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection