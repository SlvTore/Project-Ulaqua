@extends('layouts.default')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success solid alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
            <strong>Sukses!</strong> {{ session('success') }}
        </div>
    @endif

    <div class="d-flex mb-3 align-items-center justify-content-between">
        <h4 class="mb-0">Daftar Bill of Materials (Resep Produksi)</h4>
        <a href="{{ route('boms.create') }}" class="btn btn-primary btn-rounded">+ Buat Formula Baru</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID.</th>
                            <th>Nama Formula / Resep</th>
                            <th>Produk Jadi Target</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($boms as $bom)
                        <tr>
                            <td><strong>{{ $loop->iteration }}</strong></td>
                            <td class="font-w600 text-primary">{{ $bom->name }}</td>
                            <td><span class="badge badge-success light">{{ $bom->product->name }}</span></td>
                            <td>
                                <a href="{{ route('boms.edit', $bom->id) }}" class="btn btn-primary btn-xs sharp shadow me-1"><i class="fa fa-pencil-alt"></i></a>

                                <form action="{{ route('boms.destroy', $bom->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus resep ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs sharp shadow"><i class="fa fa-trash"></i></button>
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
