@extends('be.master')
@section('sidebar')
    @include('be.sidebar')
@endsection

@section('navbar')
    @include('be.navbar')
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Pelanggan</h4>
                        <div class="text-muted small">Total Pelanggan: {{ $totalCustomers }}</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="customer-table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Email</th>
                                        <th>No. Telepon</th>
                                        <th>Alamat Utama</th>
                                        {{-- <th>Status</th> --}}
                                        <th>Bergabung Sejak</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pelanggans as $index => $pelanggan)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($pelanggan->foto)
                                                    <img src="{{ asset($pelanggan->foto) }}" alt="Foto" width="40" height="40" class="rounded-circle mr-2">
                                                @else
                                                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mr-2" style="width: 40px; height: 40px;">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                @endif
                                                <span>{{ $pelanggan->nama_pelanggan }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $pelanggan->email }}</td>
                                        <td>{{ $pelanggan->no_telp ?? '-' }}</td>
                                        <td>
                                            {{ $pelanggan->alamat1 ?? '-' }}
                                            @if($pelanggan->kota1)
                                                <br><small class="text-muted">{{ $pelanggan->kota1 }}, {{ $pelanggan->propinsi1 }}</small>
                                            @endif
                                        </td>
                                        {{-- <td>
                                            <span class="badge badge-success">Active</span>
                                        </td> --}}
                                        <td>{{ $pelanggan->created_at ? $pelanggan->created_at->format('d M Y') : '-' }}</td>
                                        <td>
                                            <a href="{{ route('admin.customers.show', $pelanggan->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
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
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#customer-table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "order": [[6, "desc"]]
        });
    });
</script>
@endsection