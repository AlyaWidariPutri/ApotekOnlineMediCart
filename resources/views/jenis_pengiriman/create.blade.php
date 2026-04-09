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
            <div class="col-sm-6">
                <h4>Tambah Shipping Method</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Ongkir (Fake API)</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('jenis_pengiriman.store') }}" method="POST">
                            @csrf

                            {{-- KODE KURIR --}}
                            <div class="form-group">
                                <label>Kode Kurir</label>
                                <select name="kode_kurir" class="form-control" required>
                                    <option value="">-- Pilih Kurir --</option>
                                    <option value="jne">jne</option>
                                    <option value="jnt">j&t</option>
                                    <option value="sicepat">sicepat</option>
                                    <option value="tiki">tiki</option>
                                    <option value="pos">pos</option>
                                </select>
                            </div>

                            {{-- NAMA EKSPEDISI --}}
                            <div class="form-group">
                                <label>Nama Ekspedisi</label>
                                <input type="text" name="nama_ekspedisi" class="form-control" required>
                            </div>

                            {{-- LAYANAN --}}
                            <div class="form-group">
                                <label>Layanan (REG / YES / OKE)</label>
                                <input type="text" name="layanan" class="form-control" placeholder="Contoh: REG" required>
                            </div>

                            {{-- JENIS --}}
                            <div class="form-group">
                                <label>Jenis Kirim</label>
                                <select name="jenis_kirim" class="form-control" required>
                                    <option value="ekonomi">Ekonomi</option>
                                    <option value="kargo">Kargo</option>
                                    <option value="regular">Regular</option>
                                    <option value="same day">Same Day</option>
                                    <option value="standar">Standar</option>
                                </select>
                            </div>

                            {{-- HARGA --}}
                            <div class="form-group">
                                <label>Harga Dasar (Rp)</label>
                                <input type="number" name="harga" class="form-control" required>
                                <small class="text-muted">Harga sebelum zona</small>
                            </div>

                            {{-- STATUS --}}
                            <div class="form-group">
                                <label>Status</label>
                                <select name="is_active" class="form-control">
                                    <option value="1">Aktif</option>
                                    <option value="0">Nonaktif</option>
                                </select>
                            </div>

                            {{-- LOGO --}}
                            <div class="form-group">
                                <label>Logo Ekspedisi</label>
                                <input type="text" name="logo_ekspedisi" class="form-control">
                            </div>

                            <div class="text-end mt-3">
                                <a href="{{ route('jenis_pengiriman.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection