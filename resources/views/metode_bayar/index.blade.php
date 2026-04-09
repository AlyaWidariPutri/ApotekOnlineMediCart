@extends('be.master')
@section('sidebar')
    @include('be.sidebar')
@endsection
@section('navbar')
    @include('be.navbar')
@endsection

@section('content')
<div style="margin-left: 240px; margin-top: 70px; padding: 20px; width: calc(100% - 250px);">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title" style="font-size: 1.25rem; font-weight: 530;">Payment Method</h4>
                <div class="col-auto">
                    <a href="{{ route('metode_bayar.create') }}" class="btn btn-primary justify-content-end">
                    <i class="fa-solid fa-money-check-dollar text-right"></i> Add New Payment Method</a>
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
                                <th>Payment Method</th>
                                <th>Payment Station</th>
                                <th>Account Number</th>
                                <th>Logo</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paymentMethods as $index => $method)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $method->metode_pembayaran }}</td>
                                <td>{{ $method->tempat_bayar }}</td>
                                <td>{{ $method->no_rekening ?? '-' }}</td>
                                <td>
                                    @if($method->url_logo)
                                        <img src="{{ $method->url_logo }}" width="50" alt="Logo">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('metode_bayar.show', $method->id) }}" 
                                        class="btn btn-sm mx-1 text-warning" 
                                        style="background-color: #FFF4E0;" 
                                        data-toggle="tooltip" 
                                        title="Detail">
                                        <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <a href="{{ route('metode_bayar.edit', $method->id) }}" 
                                        class="btn btn-sm mx-1 text-white" 
                                        style="background-color: #FFA500;" 
                                        data-toggle="tooltip" 
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('metode_bayar.destroy', $method->id) }}" method="POST" class="d-inline">
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