@extends('be.master')

@section('sidebar')
    @include('be.sidebar')
@endsection

@section('navbar')
    @include('be.navbar')
@endsection

@section('content')
@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="container-fluid" style="margin-left: 230px; margin-top: 70px; padding: 20px;">
    <h4>Tambah Pembelian Baru</h4>
    
    <form action="{{ route('apoteker.pembelian.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label>Distributor</label>
            <select name="id_distributor" class="form-control" required>
                @foreach($distributors as $distributor)
                    <option value="{{ $distributor->id }}">{{ $distributor->nama_distributor }}</option>
                @endforeach
            </select>
        </div>

        <div id="items-container">
            <div class="item-row mb-3">
                <div class="row">
                    <div class="col-md-5">
                        <select name="items[0][id_obat]" class="form-control" required>
                            @foreach($obats as $obat)
                                <option value="{{ $obat->id }}">{{ $obat->nama_obat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="items[0][jumlah]" class="form-control" placeholder="Jumlah" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" 
                            name="items[0][harga_beli]" 
                            class="form-control" 
                            placeholder="Harga Beli per Unit" 
                            required
                            min="1000">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-remove">×</button>
                    </div>
                </div>
            </div>
        </div>

        <button type="button" id="add-item" class="btn btn-secondary mb-3">+ Tambah Obat</button>
        <button type="submit" class="btn btn-primary">Simpan Pembelian</button>
    </form>
</div>

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif
<script>
    // Dynamic form untuk tambah item obat
    document.getElementById('add-item').addEventListener('click', function() {
        const container = document.getElementById('items-container');
        const itemCount = container.querySelectorAll('.item-row').length;
        const newItem = container.querySelector('.item-row').cloneNode(true);
        
        // Update index
        newItem.innerHTML = newItem.innerHTML.replace(/items\[0\]/g, `items[${itemCount}]`);
        container.appendChild(newItem);
    });

    // Hapus item
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-remove')) {
            if (document.querySelectorAll('.item-row').length > 1) {
                e.target.closest('.item-row').remove();
            }
        }
    });
</script>
@endsection