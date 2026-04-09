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
            <h4 class="card-title">Edit Medicine</h4>
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
            
            <form action="{{ route('obat.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label>Medicine Name</label>
                    <input type="text" name="nama_obat" class="form-control" value="{{ old('nama_obat', $data->nama_obat) }}" required>
                </div>
                
                <div class="form-group">
                    <label>Medicine Type</label>
                    <select name="idjenis" class="form-control" required>
                        <option value="">Select Medicine Type</option>
                        @foreach($jenisObats as $jenis)
                            <option value="{{ $jenis->id }}" {{ $data->idjenis == $jenis->id ? 'selected' : '' }}>
                                {{ $jenis->jenis }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
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
                               value="{{ old('harga_jual', number_format($data->harga_jual, 0, ',', '.')) }}" 
                               autocomplete="off"
                               required>
                    </div>
                    <div id="harga_preview" class="mt-2 text-success" style="font-weight: bold; display: none;"></div>
                </div>
                
                <!-- ========== INPUT BERAT (TAMBAHKAN INI) ========== -->
                <div class="form-group">
                    <label>Weight (gram)</label>
                    <div class="input-group">
                        <input type="number" 
                               name="berat" 
                               class="form-control" 
                               value="{{ old('berat', $data->berat ?? 100) }}" 
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
                    <textarea name="deskripsi_obat" class="form-control" rows="3" required>{{ old('deskripsi_obat', $data->deskripsi_obat) }}</textarea>
                </div>
                
                <div class="row">
                    @for($i = 1; $i <= 3; $i++)
                        @php $field = 'foto'.$i; @endphp
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Photo {{ $i }}</label>
                                @if($data->$field)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/'.$data->$field) }}" width="100" class="img-thumbnail">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" name="keep_foto{{$i}}" value="1" checked>
                                            <label class="form-check-label">Keep this image</label>
                                        </div>
                                    </div>
                                @endif
                                <input type="file" name="foto{{$i}}" class="form-control">
                            </div>
                        </div>
                    @endfor
                </div>
                
                <div class="form-group">
                    <label>Stock</label>
                    <input type="number" name="stok" class="form-control" value="{{ old('stok', $data->stok) }}" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('obat.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Script untuk input harga di edit
    const hargaInput = $('#harga_jual');
    const hargaPreview = $('#harga_preview');
    
    function cleanToNumber(value) {
        let cleaned = value.replace(/\./g, '');
        if (cleaned === '') return '';
        return cleaned;
    }
    
    function formatToRupiah(angka) {
        if (!angka || angka === '') return '';
        return new Intl.NumberFormat('id-ID').format(parseInt(angka));
    }
    
    // Initial preview
    let initialValue = cleanToNumber(hargaInput.val());
    if (initialValue && initialValue !== '') {
        hargaPreview.html('💰 Preview: Rp ' + formatToRupiah(initialValue)).show();
    }
    
    hargaInput.on('keyup', function(e) {
        let rawValue = $(this).val();
        let numberOnly = cleanToNumber(rawValue);
        $(this).val(formatToRupiah(numberOnly));
        if (numberOnly && numberOnly !== '') {
            hargaPreview.html('💰 Preview: Rp ' + formatToRupiah(numberOnly)).show();
        } else {
            hargaPreview.hide();
        }
    });
});
</script>
@endpush
@endsection