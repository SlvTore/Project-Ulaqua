@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-warning">
            <h4 class="card-title text-white">Edit Rekapan Produksi: {{ $production->reference_number }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('productions.update', $production->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Cetak Menggunakan Resep (BOM):</label>
                        <select name="bom_id" class="form-control form-control-lg" required>
                            <option value="">-- Pilih Formula BOM --</option>
                            @foreach($boms as $bom)
                                <option value="{{ $bom->id }}" {{ $production->bom_id == $bom->id ? 'selected' : '' }}>
                                    {{ $bom->name }} (Output: {{ $bom->product->name }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Jumlah Barang Jadi Dihasilkan (Qty):</label>
                        <input type="number" name="quantity" class="form-control form-control-lg text-success font-weight-bold" required min="1" step="0.01" value="{{ $production->quantity }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Tanggal Proses Produksi:</label>
                        <input type="date" name="production_date" class="form-control" required value="{{ \Carbon\Carbon::parse($production->production_date)->format('Y-m-d') }}">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="font-weight-bold">Catatan Produksi (Opsional):</label>
                        <textarea name="notes" class="form-control" rows="3">{{ $production->notes }}</textarea>
                    </div>
                </div>

                <div class="border-top pt-3 mt-3 text-end">
                    <a href="{{ route('productions.index') }}" class="btn btn-light me-2">Batal</a>
                    <button type="submit" class="btn btn-warning text-white px-5 btn-lg shadow" onclick="return confirm('Aksi ini akan mereset persediaan gudang untuk mengikuti nominal ini. Simpan perubahan?')">
                        Simpan Perubahan Produksi (Auto-Rollback Stok)
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
