@extends('be.master')
@section('sidebar')
    @include('be.sidebar')
@endsection
@section('navbar')
    @include('be.navbar')
@endsection

@section('content')
<div style="margin-left: 230px; margin-top: 70px; padding: 20px;">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Medicine Data</h4>
            <a href="{{ route('obat.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Add Medicine
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Medicine Name</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Weight</th>
                            <th>Stock</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datas as $key => $obat)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $obat->nama_obat }}</td>
                            <td>{{ $obat->jenis->jenis }}</td>
                            <td>{{ $obat->formatted_harga }}</td>
                            <td>{{ $obat->berat ?? '-' }} gram</td>
                            <td>{{ $obat->stok }}</td>
                            <td>
                                <div class="d-flex flex-wrap gap-2">
                                    @for($i = 1; $i <= 3; $i++)
                                        @php $field = 'foto'.$i; @endphp
                                        @if($obat->$field)
                                            <div class="image-preview-container">
                                                @if(Storage::disk('public')->exists($obat->$field))
                                                    <img src="{{ asset('storage/'.$obat->$field) }}" 
                                                         class="img-thumbnail" 
                                                         style="width:80px; height:80px; object-fit:cover;"
                                                         title="Photo {{ $i }}">
                                                @else
                                                    <span class="badge bg-danger">File missing</span>
                                                @endif
                                                <small class="d-block text-center">Photo {{ $i }}</small>
                                            </div>
                                        @endif
                                    @endfor
                                    
                                    @if(!$obat->foto1 && !$obat->foto2 && !$obat->foto3)
                                        <span class="badge bg-secondary">No Images</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('obat.edit', $obat->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('obat.destroy', $obat->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection