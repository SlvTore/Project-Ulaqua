@extends('layouts.default')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary">
            <h4 class="card-title text-white">Form Pencatatan Hasil Produksi</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('productions.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Cetak Menggunakan Resep (BOM):</label>
                        <select name="bom_id" class="form-control form-control-lg" required>
                            <option value="">-- Pilih Formula BOM --</option>
                            @foreach($boms as $bom)
                                <option value="{{ $bom->id }}">
                                    {{ $bom->name }} (Output: {{ $bom->product->name }}) - HPP: Rp {{ number_format($bom->product->default_price, 0, ',', '.') }}/pcs
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Bahan baku di resep ini akan otomatis dikalkulasi dan dipotong dari stok gudang saat Anda menekan tombol simpan.</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Jumlah Barang Jadi Dihasilkan (Qty):</label>
                        <input type="number" name="quantity" class="form-control form-control-lg text-success font-weight-bold" required min="1" step="0.01" placeholder="Masukkan jumlah barang hasil produksi">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Tanggal Proses Produksi:</label>
                        <input type="date" name="production_date" class="form-control" required value="{{ date('Y-m-d') }}">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="font-weight-bold">Catatan Produksi (Opsional):</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Misal: Batch pagi, dikerjakan oleh Tim A. Terdapat 2 kardus ditarik namun basah."></textarea>
                    </div>
                </div>

                <div class="border-top pt-3 mt-3 text-end">
                    <a href="{{ route('productions.index') }}" class="btn btn-light me-2">Batal</a>
                    <button type="submit" class="btn btn-primary px-5 btn-lg shadow" onclick="return confirm('Yakin ingin eksekusi? \n\nAksi ini akan memotong stok bahan baku dan mencetak HPP uang kas Anda secara PERMANEN untuk batch manufaktur ini!')">
                        Proses Produksi Pabrik
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
