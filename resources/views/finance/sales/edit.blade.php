@extends('layouts.default')

@section('content')
<div class="container-fluid">
    @if(session('error'))
        <div class="alert alert-danger solid alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
            <strong>Gagal Menurunkan Perubahan!</strong> {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-warning">
            <h4 class="card-title text-white">Mode Edit Invoice Penjualan: {{ $sale->reference_number }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('sales.update', $sale->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold text-primary">Tanggal Penjualan:</label>
                        <input type="date" name="sale_date" class="form-control form-control-lg" value="{{ date('Y-m-d', strtotime($sale->sale_date)) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold text-primary">Pilih Produk Untuk Dijual:</label>
                        <select name="item_id" class="form-control form-control-lg" id="item_id" required>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}" data-price="{{ $item->default_price }}" {{ $sale->item_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }} - Sisa Stok Riil: {{ $item->expected_stock }} Unit
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold text-success">Jumlah Dibeli Pembeli (Qty):</label>
                        <input type="number" name="quantity" class="form-control form-control-lg font-weight-bold text-success" id="quantity" value="{{ $sale->quantity }}" min="1" step="0.01" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold text-info">Harga Jual per Satuan (Rp):</label>
                        <input type="number" name="price_per_unit" class="form-control form-control-lg font-weight-bold text-info" id="price_per_unit" value="{{ $sale->price_per_unit }}" min="0" required>
                    </div>

                    <div class="col-md-12 mb-3 mt-2">
                        <label class="font-weight-bold">Catatan Invoice (Opsional):</label>
                        <textarea name="notes" class="form-control form-control-lg" rows="3">{{ $sale->notes }}</textarea>
                    </div>
                </div>

                <div class="mt-4 border-top pt-4 text-end">
                    <a href="{{ route('sales.index') }}" class="btn btn-light btn-rounded shadow-sm me-2">Batal</a>
                    <button type="submit" class="btn btn-warning btn-rounded shadow text-white"><i class="flaticon-381-edit"></i> Update Penjualan & Redo Stok</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

