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
                    <h4>Tambah Pengiriman</h4>
                    <span>Input data pengiriman untuk pesanan yang sudah siap</span>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <a href="{{ route('pengiriman.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <!-- TAMPILAN ERROR VALIDASI -->
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal Menyimpan!</strong> Perbaiki kesalahan berikut:
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <!-- TAMPILAN SESSION ERROR -->
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <!-- TAMPILAN SESSION SUCCESS -->
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Pengiriman</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pengiriman.store') }}" method="POST" id="formPengiriman">
                            @csrf
                            
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Pilih Pesanan *</label>
                                <div class="col-sm-9">
                                    <select name="id_penjualan" class="form-control @error('id_penjualan') is-invalid @enderror" id="id_penjualan" required>
                                        <option value="">-- Pilih Pesanan --</option>
                                        @foreach($penjualan as $item)
                                            <option value="{{ $item->id }}" {{ ($selectedPenjualan && $selectedPenjualan->id == $item->id) ? 'selected' : '' }}>
                                                #{{ $item->id }} - {{ $item->pelanggan->nama_pelanggan ?? 'Pelanggan' }} - Rp {{ number_format($item->total_bayar, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_penjualan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if($penjualan->isEmpty())
                                        <small class="text-danger">⚠️ Tidak ada pesanan dengan status "Menunggu Kurir"</small>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">No Invoice *</label>
                                <div class="col-sm-9">
                                    <input type="text" name="no_invoice" class="form-control @error('no_invoice') is-invalid @enderror" 
                                           placeholder="Contoh: INV-2024-001" id="no_invoice" required>
                                    @error('no_invoice')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nama Kurir *</label>
                                <div class="col-sm-9">
                                    <input type="text" name="nama_kurir" class="form-control @error('nama_kurir') is-invalid @enderror" 
                                           placeholder="Contoh: Ahmad Subarjo" id="nama_kurir" required>
                                    @error('nama_kurir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Telepon Kurir *</label>
                                <div class="col-sm-9">
                                    <input type="text" name="telpon_kurir" class="form-control @error('telpon_kurir') is-invalid @enderror" 
                                           placeholder="Contoh: 081234567890" id="telpon_kurir" required>
                                    @error('telpon_kurir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tanggal Kirim</label>
                                <div class="col-sm-9">
                                    <input type="datetime-local" name="tgl_kirim" class="form-control" id="tgl_kirim">
                                    <small class="text-muted">Kosongkan jika belum dikirim</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tanggal Tiba</label>
                                <div class="col-sm-9">
                                    <input type="datetime-local" name="tgl_tiba" class="form-control" id="tgl_tiba">
                                    <small class="text-muted">Kosongkan jika belum sampai</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Keterangan</label>
                                <div class="col-sm-9">
                                    <textarea name="keterangan" class="form-control" rows="3" 
                                              placeholder="Catatan tambahan untuk pengiriman" id="keterangan"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                                        <i class="fas fa-save"></i> Simpan Pengiriman
                                    </button>
                                    <a href="{{ route('pengiriman.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Batal
                                    </a>
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

@push('scripts')
<script>
    // Validasi sebelum submit
    document.getElementById('formPengiriman').addEventListener('submit', function(e) {
        let pesanan = document.getElementById('id_penjualan').value;
        let noInvoice = document.getElementById('no_invoice').value;
        let namaKurir = document.getElementById('nama_kurir').value;
        let telponKurir = document.getElementById('telpon_kurir').value;
        
        let errors = [];
        
        if (!pesanan) {
            errors.push('Pilih pesanan terlebih dahulu');
        }
        if (!noInvoice) {
            errors.push('No Invoice tidak boleh kosong');
        }
        if (!namaKurir) {
            errors.push('Nama Kurir tidak boleh kosong');
        }
        if (!telponKurir) {
            errors.push('Telepon Kurir tidak boleh kosong');
        }
        
        if (errors.length > 0) {
            e.preventDefault();
            alert('❌ Gagal menyimpan!\n\n' + errors.join('\n'));
            return false;
        }
    });
</script>
@endpush