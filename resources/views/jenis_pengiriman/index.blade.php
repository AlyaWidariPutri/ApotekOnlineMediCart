@extends('be.master')
@section('sidebar')
    @include('be.sidebar')
@endsection
@section('navbar')
    @include('be.navbar')
@endsection

@section('content')
<div style="margin-left: 260px; margin-top: 70px; padding: 20px; width: calc(100% - 250px);">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title" style="font-size: 1.25rem; font-weight: 530;">Shipping Method</h4>
                <div class="col-auto">
                    <a href="{{ route('jenis_pengiriman.create') }}" class="btn btn-primary justify-content-end">
                        <i class="fa-solid fa-plus text-right"></i> Add New Shipping Method
                    </a>
                </div> 
            </div>
            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-hover table-responsive-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Shipping Type</th>
                                <th>Expedition Name</th>
                                <th>Kurir</th>
                                <th>Layanan</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shippingMethods as $index => $method)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ ucfirst($method->jenis_kirim) }}</td>
                                <td>{{ $method->nama_ekspedisi }}</td>
                                <td>{{ strtoupper($method->kode_kurir ?? '-') }}</td>
                                <td>{{ $method->layanan ?? '-' }}</td>
                                <td>Rp {{ number_format($method->harga, 0) }}</td>
                                <td>
                                    @if($method->is_active)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('jenis_pengiriman.show', $method->id) }}" 
                                           class="btn btn-sm mx-1 text-warning" 
                                           style="background-color: #FFF4E0;" 
                                           data-toggle="tooltip" 
                                           title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <a href="{{ route('jenis_pengiriman.edit', $method->id) }}" 
                                           class="btn btn-sm mx-1 text-white" 
                                           style="background-color: #FFA500;" 
                                           data-toggle="tooltip" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('jenis_pengiriman.destroy', $method->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm mx-1 text-white" 
                                                    style="background-color: #FF6B6B;" 
                                                    data-toggle="tooltip" 
                                                    title="Hapus"
                                                    onclick="return confirm('Yakin ingin menghapus?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection