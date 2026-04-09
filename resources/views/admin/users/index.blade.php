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
                <h4 class="card-title" style="font-size: 1.25rem; font-weight: 530;">User Management</h4>
                <div class="col-auto">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary justify-content-end">
                        <i class="fa fa-plus"></i> Add New User
                    </a>
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
                                <th>Action</th>
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
                                <td>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary mr-2">
                                        <i class="fa fa-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fa fa-trash"></i> Delete
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
</div>
@endsection