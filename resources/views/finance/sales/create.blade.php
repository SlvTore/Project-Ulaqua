@extends('layouts.default')

@section('content')
<div class="container-fluid">
    @if(session('error'))
        <div class="alert alert-danger solid alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
            <strong>Gagal Menyimpan!</strong> {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-primary">
            <h4 class="card-title text-white">Form Pencatatan Kas Masuk (Invoice Penjualan)</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('sales.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="font-weight-bold text-primary">Nama Client / Pembeli (Opsional):</label>
                        <select name="client_id" class="form-control form-control-lg default-select">
                            <option value="">-- Pilih Client (Walk-in Customer) --</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }} (#{{ $client->kode_client }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold text-primary">Tanggal Penjualan:</label>
                        <input type="date" name="sale_date" class="form-control form-control-lg" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold text-primary">Pilih Produk Untuk Dijual:</label>
                        <select name="item_id" class="form-control form-control-lg" id="item_id" required>
                            <option value="" disabled selected>-- Daftar Produk Jadi --</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}" data-price="{{ $item->default_price }}">
                                    {{ $item->name }} ({{ $item->category->name ?? 'Produk' }}) - Sisa Stok: {{ $item->expected_stock }} Unit
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Barang yang dipilih akan otomatis dikurangkan dari stok etalase/gudang.</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold text-success">Jumlah Dibeli Pembeli (Qty):</label>
                        <input type="number" name="quantity" class="form-control form-control-lg font-weight-bold text-success" id="quantity" value="{{ old('quantity') }}" min="1" step="0.01" placeholder="Masukkan jumlah..." required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold text-info">Harga Jual per Satuan (Rp):</label>
                        <input type="number" name="price_per_unit" class="form-control form-control-lg font-weight-bold text-info" id="price_per_unit" value="{{ old('price_per_unit') }}" min="0" placeholder="Rp ..." required>
                        <small class="text-danger">*Harga saran terisi otomatis dari HPP Master Barang. Anda bisa me-markup harga jual ini.</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold text-warning">Status Pembayaran:</label>
                        <select name="payment_status" class="form-control form-control-lg default-select" required>
                            <option value="Lunas" selected>✅ Lunas (Cash/Transfer)</option>
                            <option value="Belum Lunas">🕒 Belum Lunas</option>
                            <option value="Termin">📊 Termin (Cicilan)</option>
                            <option value="Jatuh Tempo">🚨 Jatuh Tempo</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold text-secondary">Status Pengiriman:</label>
                        <select name="delivery_status" class="form-control form-control-lg default-select" required>
                            <option value="Selesai" selected>📦 Selesai (Sudah Diterima)</option>
                            <option value="Diproses">⏳ Sedang Diproses</option>
                            <option value="Dikirim">🚚 Sedang Dikirim</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3 mt-2">
                        <label class="font-weight-bold">Catatan Invoice (Opsional):</label>
                        <textarea name="notes" class="form-control form-control-lg" rows="3" placeholder="Tuliskan keterangan detail pesanan, nama pelanggan, atau nomor surat jalan bila perlu...">{{ old('notes') }}</textarea>
                    </div>

                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                </div>

                <div class="mt-4 border-top pt-4 text-end">
                    <a href="{{ route('sales.index') }}" class="btn btn-light btn-rounded shadow-sm me-2 text-primary">Batal & Kembali</a>
                    <button type="submit" class="btn btn-primary btn-rounded shadow"><i class="flaticon-381-save"></i> Cetak Invoice & Catat Kas Masuk</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('item_id').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var price = selectedOption.getAttribute('data-price');
        document.getElementById('price_per_unit').value = price;
    });
</script>
@endpush

