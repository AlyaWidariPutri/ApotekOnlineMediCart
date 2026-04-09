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
                <h4 class="card-title" style="font-size: 1.25rem; font-weight: 530;">Data Distributor</h4>
                <div class="col-auto">
                    <a href="{{ route('distributor.create') }}" class="btn btn-primary justify-content-end">
                    <i class="fa-solid fa-plus text-right"></i> Add New Distributor</a>
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
                                <th>Distributor Name</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($distributors as $index => $distributor)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $distributor->nama_distributor }}</td>
                                <td>{{ $distributor->telepon }}</td>
                                <td>{{ Str::limit($distributor->alamat, 30) }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('distributor.show', $distributor->id) }}" 
                                           class="btn btn-sm mx-1 text-warning" 
                                           style="background-color: #FFF4E0;" 
                                           data-toggle="tooltip" 
                                           title="Detail">
                                           <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <a href="{{ route('distributor.edit', $distributor->id) }}" 
                                           class="btn btn-sm mx-1 text-white" 
                                           style="background-color: #FFA500;" 
                                           data-toggle="tooltip" 
                                           title="Edit">
                                           <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('distributor.destroy', $distributor->id) }}" method="POST" class="d-inline">
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