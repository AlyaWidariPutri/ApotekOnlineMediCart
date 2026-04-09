@extends('be.master')
@section('sidebar')
    @include('be.sidebar')
@endsection
@section('navbar')
    @include('be.navbar')
@endsection

@section('content')
<div style="margin-left: 235px; margin-top: 70px; padding: 20px;">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title" style="font-size: 1.25rem; font-weight: 530;">Type of Medicines</h4>
                <div class="col-auto">
                    <a href="{{ route('jenis_obat.create') }}" class="btn btn-primary justify-content-end">
                        <i class="fa-solid fa-plus text-right"></i> Add New Types of Medicine
                    </a>
                </div> 
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-responsive-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Type of Drug</th>
                                <th>Description</th>
                                <th>Picture</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jenisObats as $key => $jenis)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $jenis->jenis }}</td>
                                <td>
                                    @if($jenis->deskripsi_jenis)
                                        {{ Str::words(strip_tags($jenis->deskripsi_jenis), 5, '...') }}
                                    @else
                                        <span class="text-muted">No description</span>
                                    @endif
                                </td>
                                <td>
                                    @if($jenis->image_url)
                                        @php
                                            $fullPath = storage_path('app/public/'.$jenis->image_url);
                                            if(file_exists($fullPath)) {
                                                $imageData = base64_encode(file_get_contents($fullPath));
                                                $src = 'data:image/jpeg;base64,'.$imageData;
                                            } else {
                                                $src = '';
                                            }
                                        @endphp
                                        
                                        @if($src)
                                            <img src="{{ $src }}" 
                                                style="width: 80px; height: 80px; object-fit: cover;">
                                        @else
                                            <span class="badge bg-danger">File not found</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">No Image</span>
                                    @endif
                                </td>
                                <td>
                                    <span>
                                        <a href="{{ route('jenis_obat.edit', $jenis->id) }}" class="mr-4" data-toggle="tooltip"
                                            data-placement="top" title="Edit">
                                            <i class="fa fa-pencil color-muted"></i> 
                                        </a>
                                        <form action="{{ route('jenis_obat.destroy', $jenis->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link p-0" data-toggle="tooltip"
                                                data-placement="top" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus jenis obat ini?')">
                                                <i class="fa fa-close color-danger"></i>
                                            </button>
                                        </form>
                                    </span>
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