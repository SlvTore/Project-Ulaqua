@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div class="row page-titles border-bottom mb-4">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4 class="mt-2 font-weight-bold text-primary">Form Stok Opname</h4>
                <p class="mb-0">Sinkronkan jumlah stok fisik yang ada di gudang Anda dengan jumlah di database.</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">Pastikan semua isian angka valid!</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('inventory.storeOpname') }}" method="POST">
                @csrf
                <div class="form-group mb-4 w-50">
                    <label class="text-primary font-weight-bold">Keterangan / Catatan Bersama (Opsional):</label>
                    <textarea name="notes" class="form-control" rows="2" placeholder="Contoh: Opname akhir bulan April, diawasi oleh Pak Budi."></textarea>
                </div>

                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-hover">
                        <thead class="bg-light text-center">
                            <tr>
                                <th>Kategori</th>
                                <th width="35%">Nama Barang (SKU)</th>
                                <th>Stok Sistem / Catatan</th>
                                <th width="20%" class="bg-warning text-dark">Stok Fisik Gudang Sekarang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td class="align-middle text-center"><span class="badge badge-light border">{{ $item->category->name }}</span></td>
                                <td class="align-middle"><strong>{{ $item->name }}</strong><br><small class="text-muted">SKU: {{ $item->sku ?? '-' }}</small></td>
                                <td class="align-middle text-center">
                                    <h4 class="mb-0 {{ $item->expected_stock <= $item->min_alert ? 'text-danger font-weight-bold' : '' }}">
                                        {{ $item->expected_stock }} <small class="fs-12 text-muted">{{ $item->unit->short_name }}</small>
                                    </h4>
                                </td>
                                <td>
                                    <!-- Di sinilah Array akan terbentuk: physical_stocks[ID_BARANG] = JUMLAH -->
                                    <div class="input-group">
                                        <input type="number" name="physical_stocks[{{ $item->id }}]" class="form-control text-center font-weight-bold" min="0" step="0.01" placeholder="{{ $item->expected_stock }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-white">{{ $item->unit->short_name }}</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-warning px-5 fw-bold btn-lg" onclick="return confirm('Apakah Anda yakin data stok fisik sudah final? Sistem akan otomatis mencatat selisihnya!')">Simpan Stok Opname & Sinkronisasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
