@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>Daftar Klien</h4>
                <span>Manajemen data klien/pelanggan Anda</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Klien</a></li>
            </ol>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="alert alert-success solid alert-dismissible fade show">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0 pb-0 flex-wrap">
                    <h4 class="card-title">Data Klien</h4>
                    <a href="{{ route('clients.create') }}" class="btn btn-primary rounded-square">
                        <i class="fas fa-plus me-2"></i> Tambah Klien Baru
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Kode Klien</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">No. Telepon</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($clients as $client)
                                <tr>
                                    <td>{{ $client->kode_client }}</td>
                                    <td>
                                        <!-- FOTO & NAMA & TAGS -->
                                        <div class="d-flex align-items-center">
                                            <!-- Tampilkan Foto atau Inisial Default -->
                                            @if($client->photo)
                                                <img src="{{ asset('storage/' . $client->photo) }}" class="rounded-circle me-3" width="50" height="50" style="object-fit: cover;">
                                            @else
                                                <div class="rounded-circle me-3 bg-primary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 20px;">
                                                    {{ strtoupper(substr($client->name, 0, 1)) }}
                                                </div>
                                            @endif

                                            <div>
                                                <a href="{{ route('clients.show', $client->id) }}" class="text-primary font-weight-bold fs-16 d-block mb-1">
                                                    {{ $client->name }}
                                                </a>
                                                <!-- Tag Status & Label dipindahkan ke bawah nama -->
                                                @if($client->status == 'active')
                                                    <span class="badge badge-xs light badge-success">Pelanggan Aktif</span>
                                                @else
                                                    <span class="badge badge-xs light badge-danger">Pelanggan Non-Aktif</span>
                                                @endif
                                                <span class="badge badge-xs light badge-info ms-1">{{ $client->tag }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $client->email ?? '-' }}</td>
                                    <td>{{ $client->phone ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <!-- Karena kolom dikurangi jadi 4, colspan juga menjadi 4 -->
                                    <td colspan="4" class="text-center">Belum ada data klien yang terdaftar.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer border-0 pt-0">
                    <!-- Pagination (Jika ada) -->
                    {{ $clients->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
