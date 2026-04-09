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
                    <h4>Edit Shipping Method</h4>
                    <span class="ml-1">Update shipping method details</span>
                </div>
            </div>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-xl-6 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Shipping Method Form</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="{{ route('jenis_pengiriman.update',$jenisPengiriman->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>Shipping Type</label>
                                    <select class="form-control" name="jenis_kirim" required>
                                        <option value="ekonomi" {{ $jenisPengiriman->jenis_kirim == 'ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                                        <option value="kargo" {{ $jenisPengiriman->jenis_kirim == 'kargo' ? 'selected' : '' }}>Kargo</option>
                                        <option value="regular" {{ $jenisPengiriman->jenis_kirim == 'regular' ? 'selected' : '' }}>Regular</option>
                                        <option value="same day" {{ $jenisPengiriman->jenis_kirim == 'same day' ? 'selected' : '' }}>Same Day</option>
                                        <option value="standar" {{ $jenisPengiriman->jenis_kirim == 'standar' ? 'selected' : '' }}>Standar</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Expedition Name</label>
                                    <input type="text" class="form-control" name="nama_ekspedisi" 
                                           value="{{ $jenisPengiriman->nama_ekspedisi }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Harga (Rp)</label>
                                    <input type="number" name="harga" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Expedition Logo URL</label>
                                    <input type="text" class="form-control" name="logo_ekspedisi" 
                                           value="{{ $jenisPengiriman->logo_ekspedisi }}" required>
                                </div>
                                <div class="text-end">
                                    <a href="{{route('jenis_pengiriman.index')}}" class="btn btn-secondary">
                                        <i class="fas fa-window-close me-2"></i> Cancel</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i> Update Shipping Method
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection