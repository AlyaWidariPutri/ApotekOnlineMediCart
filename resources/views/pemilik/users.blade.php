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
                <h4 class="card-title" style="font-size: 1.25rem; font-weight: 530;">Data Users (Read Only)</h4>
                <div class="text-muted small">
                    <i class="fa fa-info-circle"></i> Pemilik hanya dapat melihat data, tidak dapat menambah/mengedit/menghapus
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="table-responsive">
                    <table class="table table-hover table-responsive-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Jabatan</th>
                                <th>Dibuat Pada</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge 
                                        @if($user->jabatan == 'admin') badge-primary
                                        @elseif($user->jabatan == 'apoteker') badge-success
                                        @elseif($user->jabatan == 'karyawan') badge-info
                                        @elseif($user->jabatan == 'kasir') badge-warning
                                        @elseif($user->jabatan == 'pemilik') badge-danger
                                        @endif">
                                        {{ ucfirst($user->jabatan) }}
                                    </span>
                                </td>
                                <td>{{ $user->created_at ? $user->created_at->format('d M Y H:i') : '-' }}</td>
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