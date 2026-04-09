@extends('be.master')
@section('sidebar')
    @include('be.sidebar')
@endsection
@section('navbar')
    @include('be.navbar')
@endsection

@section('content')
<div style="margin-left: 260px; margin-top: 70px; padding: 20px;">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Add New Medicine</h4>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('obat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label>Medicine Name</label>
                    <input type="text" name="nama_obat" class="form-control" value="{{ old('nama_obat') }}" required>
                </div>
                
                <div class="form-group">
                    <label>Medicine Type</label>
                    <select name="idjenis" class="form-control" required>
                        <option value="">Select Medicine Type</option>
                        @foreach($jenisObats as $jenis)
                            <option value="{{ $jenis->id }}">{{ $jenis->jenis }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- INPUT HARGA -->
                <div class="form-group">
                    <label>Selling Price (Rp)</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="text" 
                               name="harga_jual" 
                               id="harga_jual" 
                               class="form-control" 
                               value="{{ old('harga_jual') }}" 
                               placeholder="Contoh: 2500"
                               autocomplete="off"
                               required>
                    </div>
                    <small class="form-text text-muted">Masukkan angka saja, tanpa titik atau koma. Contoh: 2500 (artinya Rp 2.500)</small>
                    <div id="harga_preview" class="mt-2 text-success" style="font-weight: bold; display: none;"></div>
                </div>
                
                <!-- ========== INPUT BERAT (TAMBAHKAN INI) ========== -->
                <div class="form-group">
                    <label>Weight (gram)</label>
                    <div class="input-group">
                        <input type="number" 
                               name="berat" 
                               class="form-control" 
                               value="{{ old('berat', 100) }}" 
                               placeholder="Contoh: 100"
                               min="1"
                               required>
                        <div class="input-group-append">
                            <span class="input-group-text">gram</span>
                        </div>
                    </div>
                    <small class="form-text text-muted">
                        <strong>Penting untuk perhitungan ongkir!</strong><br>
                        Contoh berat: 1 tablet = 5 gram, 1 strip = 10 gram, 1 botol = 200 gram
                    </small>
                </div>
                <!-- ========== END INPUT BERAT ========== -->
                
                <div class="form-group">
                    <label>Medicine Description</label>
                    <textarea name="deskripsi_obat" class="form-control" rows="3" required>{{ old('deskripsi_obat') }}</textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Photo 1</label>
                            <input type="file" name="foto1" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Photo 2</label>
                            <input type="file" name="foto2" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Photo 3</label>
                            <input type="file" name="foto3" class="form-control">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Stock</label>
                    <input type="number" name="stok" class="form-control" value="{{ old('stok') }}" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('obat.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Script untuk input harga (sudah ada)
    const hargaInput = $('#harga_jual');
    const hargaPreview = $('#harga_preview');
    
    function cleanToNumber(value) {
        let cleaned = value.replace(/[^0-9]/g, '');
        if (cleaned.length > 1 && cleaned.charAt(0) === '0') {
            cleaned = cleaned.replace(/^0+/, '');
        }
        if (cleaned === '') return '';
        return cleaned;
    }
    
    function formatToRupiah(angka) {
        if (!angka || angka === '') return '';
        return new Intl.NumberFormat('id-ID').format(parseInt(angka));
    }
    
    hargaInput.on('keyup', function(e) {
        let rawValue = $(this).val();
        let numberOnly = cleanToNumber(rawValue);
        $(this).val(numberOnly);
        if (numberOnly && numberOnly !== '') {
            hargaPreview.html('💰 Preview: Rp ' + formatToRupiah(numberOnly)).show();
        } else {
            hargaPreview.hide();
        }
    });
    
    hargaInput.on('blur', function() {
        let value = $(this).val();
        if (value && value !== '') {
            hargaPreview.html('💰 Preview: Rp ' + formatToRupiah(value)).show();
        } else {
            hargaPreview.hide();
        }
    });
    
    hargaInput.on('focus', function() {
        if ($(this).val() && $(this).val() !== '') {
            hargaPreview.html('💰 Preview: Rp ' + formatToRupiah($(this).val())).show();
        }
    });
    
    hargaInput.on('paste', function(e) {
        let pastedText = (e.originalEvent.clipboardData || window.clipboardData).getData('text');
        let numberOnly = cleanToNumber(pastedText);
        e.preventDefault();
        $(this).val(numberOnly);
        hargaInput.trigger('keyup');
    });
    
    hargaInput.on('keypress', function(e) {
        let charCode = e.which || e.keyCode;
        if (charCode >= 48 && charCode <= 57) {
            return true;
        }
        if (charCode === 8 || charCode === 9 || charCode === 13 || charCode === 27 || 
            charCode === 46 || (charCode >= 35 && charCode <= 40)) {
            return true;
        }
        e.preventDefault();
        return false;
    });
});
</script>
@endpush